<?php
// api.php
header('Content-Type: application/json');
$host = '127.0.0.1';
$db   = 'hrms_kompensasi_db';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? '';

// --- 1. DASHBOARD & COMPA RATIO ---
if ($action === 'get_dashboard_data') {
    $stmt1 = $pdo->query("SELECT SUM(take_home_pay) AS total_payroll FROM Payroll_Sheet WHERE status_approval = 'Approved'");
    $totalPayroll = $stmt1->fetch()['total_payroll'] ?? 0;

    $stmt2 = $pdo->query("SELECT COUNT(*) AS total_karyawan FROM Karyawan");
    $totalKaryawan = $stmt2->fetch()['total_karyawan'] ?? 0;

    $stmt3 = $pdo->query("SELECT COUNT(*) AS total_pending FROM Payroll_Sheet WHERE status_approval = 'Draft'");
    $totalPending = $stmt3->fetch()['total_pending'] ?? 0;

    $sqlCompa = "SELECT k.id_karyawan, k.nik, k.nama_lengkap, j.nama_jabatan, sg.pay_grade_code, sg.midpoint_salary,
                        IFNULL(p.gaji_pokok, sg.midpoint_salary) AS gaji_aktual
                 FROM Karyawan k
                 JOIN Jabatan j ON k.id_jabatan = j.id_jabatan
                 JOIN Struktur_Gaji sg ON j.id_grade = sg.id_grade
                 LEFT JOIN Payroll_Sheet p ON k.id_karyawan = p.id_karyawan";
    $compaData = $pdo->query($sqlCompa)->fetchAll();

    foreach ($compaData as &$row) {
        $compa = $row['midpoint_salary'] > 0 ? round($row['gaji_aktual'] / $row['midpoint_salary'], 2) : 1;
        $row['compa_ratio'] = $compa;
        if ($compa < 0.85) {
            $row['status_compa'] = 'Green Circle (Underpaid)';
            $row['badge_class'] = 'badge-warning';
        } elseif ($compa > 1.15) {
            $row['status_compa'] = 'Red Circle (Overpaid)';
            $row['badge_class'] = 'badge-danger';
        } else {
            $row['status_compa'] = 'Normal Market';
            $row['badge_class'] = 'badge-success';
        }
        $row['gaji_aktual_fmt'] = 'Rp ' . number_format($row['gaji_aktual'], 0, ',', '.');
        $row['midpoint_fmt'] = 'Rp ' . number_format($row['midpoint_salary'], 0, ',', '.');
    }

    echo json_encode([
        'status' => 'success',
        'metrics' => [
            'total_payroll' => 'Rp ' . number_format($totalPayroll, 0, ',', '.'),
            'total_karyawan' => $totalKaryawan,
            'total_pending' => $totalPending . ' Draft'
        ],
        'compa_list' => $compaData
    ]);
    exit;
}

// --- 2. MASTER DATA FULL (READ) ---
if ($action === 'get_all_data') {
    $grades = $pdo->query("SELECT * FROM Struktur_Gaji ORDER BY id_grade ASC")->fetchAll();
    $jabatan = $pdo->query("SELECT j.*, sg.pay_grade_code FROM Jabatan j JOIN Struktur_Gaji sg ON j.id_grade = sg.id_grade")->fetchAll();
    $karyawan = $pdo->query("SELECT k.*, j.nama_jabatan, sg.pay_grade_code FROM Karyawan k JOIN Jabatan j ON k.id_jabatan = j.id_jabatan JOIN Struktur_Gaji sg ON j.id_grade = sg.id_grade")->fetchAll();
    $payroll = $pdo->query("SELECT p.*, k.nama_lengkap, k.nik FROM Payroll_Sheet p JOIN Karyawan k ON p.id_karyawan = k.id_karyawan ORDER BY p.id_payroll DESC")->fetchAll();
    $transaksi = $pdo->query("SELECT t.*, p.periode_payroll, k.nama_lengkap FROM Transaksi_Pembayaran t JOIN Payroll_Sheet p ON t.id_payroll = p.id_payroll JOIN Karyawan k ON p.id_karyawan = k.id_karyawan ORDER BY t.id_transaksi DESC")->fetchAll();

    echo json_encode([
        'status' => 'success',
        'grades' => $grades,
        'jabatan' => $jabatan,
        'karyawan' => $karyawan,
        'payroll' => $payroll,
        'transaksi' => $transaksi
    ]);
    exit;
}

// --- 3. CRUD: STRUKTUR GAJI ---
if ($action === 'save_grade' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id_grade'] ?? '';
    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE Struktur_Gaji SET pay_grade_code=?, min_salary=?, midpoint_salary=?, max_salary=? WHERE id_grade=?");
        $stmt->execute([$input['pay_grade_code'], $input['min_salary'], $input['midpoint_salary'], $input['max_salary'], $id]);
        $msg = "Pay Grade berhasil diperbarui!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Struktur_Gaji (pay_grade_code, min_salary, midpoint_salary, max_salary) VALUES (?, ?, ?, ?)");
        $stmt->execute([$input['pay_grade_code'], $input['min_salary'], $input['midpoint_salary'], $input['max_salary']]);
        $msg = "Pay Grade berhasil ditambahkan!";
    }
    echo json_encode(['status' => 'success', 'message' => $msg]);
    exit;
}

if ($action === 'delete_grade' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo->prepare("DELETE FROM Struktur_Gaji WHERE id_grade = ?")->execute([$input['id_grade']]);
    echo json_encode(['status' => 'success', 'message' => 'Pay Grade dihapus!']);
    exit;
}

// --- 4. CRUD: JABATAN ---
if ($action === 'save_jabatan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id_jabatan'] ?? '';
    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE Jabatan SET id_grade=?, nama_jabatan=?, kategori_jabatan=?, level_penjenjangan=? WHERE id_jabatan=?");
        $stmt->execute([$input['id_grade'], $input['nama_jabatan'], $input['kategori_jabatan'], $input['level_penjenjangan'], $id]);
        $msg = "Jabatan berhasil diperbarui!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Jabatan (id_grade, nama_jabatan, kategori_jabatan, level_penjenjangan) VALUES (?, ?, ?, ?)");
        $stmt->execute([$input['id_grade'], $input['nama_jabatan'], $input['kategori_jabatan'], $input['level_penjenjangan']]);
        $msg = "Jabatan berhasil ditambahkan!";
    }
    echo json_encode(['status' => 'success', 'message' => $msg]);
    exit;
}

if ($action === 'delete_jabatan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo->prepare("DELETE FROM Jabatan WHERE id_jabatan = ?")->execute([$input['id_jabatan']]);
    echo json_encode(['status' => 'success', 'message' => 'Jabatan dihapus!']);
    exit;
}

// --- 5. CRUD: KARYAWAN ---
if ($action === 'save_karyawan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id_karyawan'] ?? '';
    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE Karyawan SET id_jabatan=?, nik=?, nama_lengkap=?, alamat=?, tax_id=? WHERE id_karyawan=?");
        $stmt->execute([$input['id_jabatan'], $input['nik'], $input['nama_lengkap'], $input['alamat'], $input['tax_id'], $id]);
        $msg = "Karyawan berhasil diperbarui!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Karyawan (id_jabatan, nik, nama_lengkap, alamat, tax_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$input['id_jabatan'], $input['nik'], $input['nama_lengkap'], $input['alamat'], $input['tax_id']]);
        $msg = "Karyawan berhasil ditambahkan!";
    }
    echo json_encode(['status' => 'success', 'message' => $msg]);
    exit;
}

if ($action === 'delete_karyawan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo->prepare("DELETE FROM Karyawan WHERE id_karyawan = ?")->execute([$input['id_karyawan']]);
    echo json_encode(['status' => 'success', 'message' => 'Karyawan dihapus!']);
    exit;
}

// --- 6. CRUD: PAYROLL SHEET ---
if ($action === 'save_payroll' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id_payroll'] ?? '';
    
    $gaji_pokok = (float)$input['gaji_pokok'];
    $lembur     = (float)($input['lembur'] ?? 0);
    $bonus      = (float)($input['bonus'] ?? 0);
    $potongan   = (float)($input['potongan'] ?? 0);
    
    // Hitung ulang total Take-Home Pay secara akurat
    $thp = $gaji_pokok + $lembur + $bonus - $potongan;

    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE Payroll_Sheet SET id_karyawan=?, periode_payroll=?, gaji_pokok=?, lembur=?, bonus=?, potongan=?, take_home_pay=?, status_approval=? WHERE id_payroll=?");
        $stmt->execute([$input['id_karyawan'], $input['periode_payroll'], $gaji_pokok, $lembur, $bonus, $potongan, $thp, $input['status_approval'], $id]);
        $msg = "Payroll Sheet berhasil diperbarui!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Payroll_Sheet (id_karyawan, periode_payroll, gaji_pokok, lembur, bonus, potongan, take_home_pay, status_approval) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$input['id_karyawan'], $input['periode_payroll'], $gaji_pokok, $lembur, $bonus, $potongan, $thp, $input['status_approval']]);
        $msg = "Payroll Sheet berhasil dibuat!";
    }
    echo json_encode(['status' => 'success', 'message' => $msg]);
    exit;
}

// --- 7. CRUD: TRANSAKSI PEMBAYARAN ---
if ($action === 'save_transaksi' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id_transaksi'] ?? '';
        $id_payroll = $_POST['id_payroll'] ?? '';
        $nomor_referensi = $_POST['nomor_referensi'] ?? '';
        $status_transfer = $_POST['status_transfer'] ?? 'Pending';

        if (empty($id_payroll) || empty($nomor_referensi)) {
            echo json_encode(['status' => 'error', 'message' => 'ID Payroll dan Nomor Referensi wajib diisi!']);
            exit;
        }

        $file_path = null;

        // Proses Pengunggahan File Bukti Transfer
        if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['bukti_transfer']['tmp_name'];
            $fileName = $_FILES['bukti_transfer']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadFileDir = __DIR__ . '/uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                $newFileName = 'bukti_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $file_path = 'uploads/' . $newFileName;
                }
            }
        }

        if (!empty($id)) {
            if ($file_path) {
                $stmt = $pdo->prepare("UPDATE Transaksi_Pembayaran SET id_payroll=?, nomor_referensi=?, status_transfer=?, bukti_transfer=? WHERE id_transaksi=?");
                $stmt->execute([$id_payroll, $nomor_referensi, $status_transfer, $file_path, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE Transaksi_Pembayaran SET id_payroll=?, nomor_referensi=?, status_transfer=? WHERE id_transaksi=?");
                $stmt->execute([$id_payroll, $nomor_referensi, $status_transfer, $id]);
            }
            $msg = "Transaksi Pembayaran berhasil diperbarui!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO Transaksi_Pembayaran (id_payroll, nomor_referensi, status_transfer, bukti_transfer) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_payroll, $nomor_referensi, $status_transfer, $file_path]);
            $msg = "Transaksi Pembayaran berhasil dicatat!";
        }

        echo json_encode(['status' => 'success', 'message' => $msg]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan: ' . $e->getMessage()]);
    }
    exit;
}

// PERBAIKAN: DITAMBAHKAN ENDPOINT DELETE TRANSAKSI BANK
if ($action === 'delete_transaksi' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id_transaksi = $input['id_transaksi'] ?? '';

        if (!empty($id_transaksi)) {
            // Hapus file fisik dari folder uploads jika ada
            $stmtFetch = $pdo->prepare("SELECT bukti_transfer FROM Transaksi_Pembayaran WHERE id_transaksi = ?");
            $stmtFetch->execute([$id_transaksi]);
            $trans = $stmtFetch->fetch();
            if ($trans && !empty($trans['bukti_transfer']) && file_exists(__DIR__ . '/' . $trans['bukti_transfer'])) {
                unlink(__DIR__ . '/' . $trans['bukti_transfer']);
            }

            $stmt = $pdo->prepare("DELETE FROM Transaksi_Pembayaran WHERE id_transaksi = ?");
            $stmt->execute([$id_transaksi]);
            echo json_encode(['status' => 'success', 'message' => 'Transaksi Pembayaran berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID Transaksi tidak ditemukan!']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus: ' . $e->getMessage()]);
    }
    exit;
}
?>
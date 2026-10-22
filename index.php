<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS Kompensasi & Payroll - Enterprise Portal</title>
    <style>
        :root {
            --primary: #1F4E79;
            --primary-light: #EBF1F5;
            --accent: #0288D1;
            --success: #2ECC71;
            --warning: #F39C12;
            --danger: #E74C3C;
            --bg-body: #F4F7F6;
            --text-main: #2C3E50;
            --text-muted: #7F8C8D;
            --border-color: #DCDDE1;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }

        aside { width: 280px; background: #FFF; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: space-between; }
        .brand { padding: 24px; font-size: 18px; font-weight: bold; color: var(--primary); border-bottom: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center; }
        .brand span { background: var(--primary); color: #FFF; padding: 4px 8px; border-radius: 4px; font-size: 12px; }

        .menu { list-style: none; padding: 16px 0; }
        .menu li a { display: block; padding: 12px 24px; color: var(--text-main); text-decoration: none; font-size: 14px; font-weight: 500; border-left: 4px solid transparent; cursor: pointer; }
        .menu li a.active, .menu li a:hover { background-color: var(--primary-light); color: var(--primary); border-left-color: var(--primary); }

        main { flex-grow: 1; display: flex; flex-direction: column; overflow-y: auto; }
        header { background: #FFF; padding: 16px 32px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .header-title h1 { font-size: 20px; color: var(--primary); }
        .header-title p { font-size: 12px; color: var(--text-muted); }

        .content-body { padding: 24px 32px; display: flex; flex-direction: column; gap: 24px; }
        .view-section { display: none; flex-direction: column; gap: 24px; }
        .view-section.active { display: flex; }

        .metrics-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .card { background: #FFF; padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); }
        .card h4 { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; }
        .card .value { font-size: 22px; font-weight: bold; color: var(--primary); }

        .workspace-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 24px; }
        .panel { background: #FFF; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; }
        .panel h3 { font-size: 15px; color: var(--primary); margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }

        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13px; background: #FAFAFA; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .btn-submit { background: var(--primary); color: #FFF; border: none; padding: 10px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 8px; }
        .btn-submit:hover { background: #153659; }
        
        .btn-action { padding: 4px 8px; font-size: 11px; border-radius: 4px; border: none; cursor: pointer; color: #FFF; }
        .btn-edit { background: var(--warning); }
        .btn-delete { background: var(--danger); }
        .btn-print { background: var(--accent); }

        table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
        th { background: var(--primary-light); color: var(--primary); padding: 10px; border-bottom: 1px solid var(--border-color); }
        td { padding: 10px; border-bottom: 1px solid var(--border-color); }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #E8F8F5; color: var(--success); }
        .badge-warning { background: #FEF9E7; color: var(--warning); }
    </style>
</head>
<body>

    <!-- Sidebar Navigasi -->
    <aside>
        <div>
            <div class="brand">HRMS Core <span>COMP</span></div>
            <ul class="menu">
                <li><a onclick="switchTab('dashboard')" id="nav-dashboard" class="active">📊 Dashboard & Compa-Ratio</a></li>
                <li><a onclick="switchTab('grades')" id="nav-grades">📌 CRUD Pay Grade</a></li>
                <li><a onclick="switchTab('jabatan')" id="nav-jabatan">💼 CRUD Jabatan</a></li>
                <li><a onclick="switchTab('karyawan')" id="nav-karyawan">👥 CRUD Karyawan</a></li>
                <li><a onclick="switchTab('payroll')" id="nav-payroll">💵 CRUD Payroll Sheet</a></li>
                <li><a onclick="switchTab('transaksi')" id="nav-transaksi">🏦 CRUD Transaksi Bank</a></li>
            </ul>
        </div>
        <div style="padding:20px; font-size:11px; color:var(--text-muted); border-top:1px solid var(--border-color);">
            Sistem Kompensasi v2.6<br>© 2026 Enterprise Corp
        </div>
    </aside>

    <!-- Main Content Area -->
    <main>
        <header>
            <div class="header-title">
                <h1>Modul Manajemen Kompensasi & Gaji Mandiri</h1>
                <p>Pusat kendali operasional dan CRUD seluruh entitas sistem remunerasi perusahaan.</p>
            </div>
        </header>

        <div class="content-body">

            <!-- 1. VIEW DASHBOARD -->
            <section id="view-dashboard" class="view-section active">
                <div class="metrics-grid">
                    <div class="card"><h4>Total Pengeluaran Gaji</h4><div class="value" id="metric-total-payroll">Rp 0</div></div>
                    <div class="card"><h4>Total Karyawan Active</h4><div class="value" id="metric-total-karyawan">0</div></div>
                    <div class="card"><h4>Status Pending Payroll</h4><div class="value" id="metric-pending-payroll" style="color:var(--warning);">0 Draft</div></div>
                </div>
                <div class="panel">
                    <h3>Evaluasi Compa-Ratio & Status Out-of-Line</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Jabatan</th>
                                <th>Pay Grade</th>
                                <th>Gaji Aktual</th>
                                <th>Midpoint Pasar</th>
                                <th>Compa-Ratio</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-dashboard"></tbody>
                    </table>
                </div>
            </section>

            <!-- 2. VIEW CRUD PAY GRADE -->
            <section id="view-grades" class="view-section">
                <div class="workspace-grid">
                    <div class="panel">
                        <h3 id="grade-title">Tambah Pay Grade Baru</h3>
                        <form id="form-grade">
                            <input type="hidden" id="grade-id">
                            <div class="form-group"><label>Kode Grade</label><input type="text" class="form-control" id="grade-code" required></div>
                            <div class="form-row">
                                <div class="form-group"><label>Min Salary</label><input type="number" class="form-control" id="grade-min" required></div>
                                <div class="form-group"><label>Midpoint Salary</label><input type="number" class="form-control" id="grade-mid" required></div>
                            </div>
                            <div class="form-group"><label>Max Salary</label><input type="number" class="form-control" id="grade-max" required></div>
                            <button type="submit" class="btn-submit">Simpan Pay Grade</button>
                            <button type="button" class="btn-submit" style="background:#7F8C8D; margin-top:5px;" onclick="resetGrade()">Batal</button>
                        </form>
                    </div>
                    <div class="panel">
                        <h3>Daftar Pay Grade (Struktur_Gaji)</h3>
                        <table>
                            <thead><tr><th>Kode</th><th>Min</th><th>Midpoint</th><th>Max</th><th>Aksi</th></tr></thead>
                            <tbody id="tbody-grades"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- 3. VIEW CRUD JABATAN -->
            <section id="view-jabatan" class="view-section">
                <div class="workspace-grid">
                    <div class="panel">
                        <h3 id="jabatan-title">Tambah Jabatan Baru</h3>
                        <form id="form-jabatan">
                            <input type="hidden" id="jabatan-id">
                            <div class="form-group"><label>Nama Jabatan</label><input type="text" class="form-control" id="jabatan-nama" required></div>
                            <div class="form-group"><label>Pay Grade</label><select class="form-control" id="jabatan-grade-id" required></select></div>
                            <div class="form-row">
                                <div class="form-group"><label>Kategori</label><select class="form-control" id="jabatan-kategori"><option value="Profesional">Profesional</option><option value="Eksekutif">Eksekutif</option><option value="Staf">Staf</option></select></div>
                                <div class="form-group"><label>Level</label><select class="form-control" id="jabatan-level"><option value="Junior">Junior</option><option value="Middle">Middle</option><option value="Senior">Senior</option><option value="Lead">Lead</option><option value="Expert">Expert</option><option value="Top Management">Top Management</option></select></div>
                            </div>
                            <button type="submit" class="btn-submit">Simpan Jabatan</button>
                            <button type="button" class="btn-submit" style="background:#7F8C8D; margin-top:5px;" onclick="resetJabatan()">Batal</button>
                        </form>
                    </div>
                    <div class="panel">
                        <h3>Daftar Jabatan</h3>
                        <table>
                            <thead><tr><th>Jabatan</th><th>Grade</th><th>Kategori / Level</th><th>Aksi</th></tr></thead>
                            <tbody id="tbody-jabatan"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- 4. VIEW CRUD KARYAWAN -->
            <section id="view-karyawan" class="view-section">
                <div class="workspace-grid">
                    <div class="panel">
                        <h3 id="karyawan-title">Tambah Karyawan Baru</h3>
                        <form id="form-karyawan">
                            <input type="hidden" id="karyawan-id">
                            <div class="form-row">
                                <div class="form-group"><label>NIK</label><input type="text" class="form-control" id="karyawan-nik" required></div>
                                <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" id="karyawan-nama" required></div>
                            </div>
                            <div class="form-group"><label>Jabatan</label><select class="form-control" id="karyawan-jabatan-id" required></select></div>
                            <div class="form-group"><label>Alamat</label><textarea class="form-control" id="karyawan-alamat" rows="2" required></textarea></div>
                            <div class="form-group"><label>NPWP / Tax ID</label><input type="text" class="form-control" id="karyawan-tax"></div>
                            <button type="submit" class="btn-submit">Simpan Karyawan</button>
                            <button type="button" class="btn-submit" style="background:#7F8C8D; margin-top:5px;" onclick="resetKaryawan()">Batal</button>
                        </form>
                    </div>
                    <div class="panel">
                        <h3>Daftar Karyawan</h3>
                        <table>
                            <thead><tr><th>NIK & Nama</th><th>Jabatan</th><th>Grade</th><th>Aksi</th></tr></thead>
                            <tbody id="tbody-karyawan"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- 5. VIEW CRUD PAYROLL SHEET -->
            <section id="view-payroll" class="view-section">
                <div class="workspace-grid">
                    <div class="panel">
                        <h3 id="payroll-title">Buat / Kelola Payroll Sheet</h3>
                        <form id="form-payroll">
                            <input type="hidden" id="payroll-id">
                            <div class="form-group"><label>Pilih Karyawan</label><select class="form-control" id="payroll-karyawan-id" required></select></div>
                            <div class="form-row">
                                <div class="form-group"><label>Periode (YYYY-MM)</label><input type="text" class="form-control" id="payroll-periode" value="2026-10" required></div>
                                <div class="form-group"><label>Gaji Pokok</label><input type="number" class="form-control" id="payroll-gaji" required></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group"><label>Lembur</label><input type="number" class="form-control" id="payroll-lembur" value="0"></div>
                                <div class="form-group"><label>Bonus</label><input type="number" class="form-control" id="payroll-bonus" value="0"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group"><label>Potongan</label><input type="number" class="form-control" id="payroll-potongan" value="0"></div>
                                <div class="form-group"><label>Status Approval</label><select class="form-control" id="payroll-status"><option value="Draft">Draft</option><option value="Audited">Audited</option><option value="Approved">Approved</option><option value="Rejected">Rejected</option></select></div>
                            </div>
                            <button type="submit" class="btn-submit">Simpan Payroll Sheet</button>
                            <button type="button" class="btn-submit" style="background:#7F8C8D; margin-top:5px;" onclick="resetPayroll()">Batal</button>
                        </form>
                    </div>
                    <div class="panel">
                        <h3>Daftar Payroll Sheet</h3>
                        <table>
                            <thead><tr><th>Periode & Karyawan</th><th>Gaji Pokok</th><th>THP</th><th>Status</th><th>Aksi</th></tr></thead>
                            <tbody id="tbody-payroll"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- 6. VIEW CRUD TRANSAKSI PEMBAYARAN -->
            <section id="view-transaksi" class="view-section">
                <div class="workspace-grid">
                    <div class="panel">
                        <h3 id="transaksi-title">Catat Transaksi / Disbursement Bank</h3>
                        <!-- Form Transaksi Bank di View Section Transaksi -->
                        <form id="form-transaksi" enctype="multipart/form-data">
                        <input type="hidden" id="transaksi-id" name="id_transaksi">
                        
                        <div class="form-group">
                            <label>Pilih ID Payroll Sheet</label>
                            <select class="form-control" id="transaksi-payroll-id" name="id_payroll" required></select>
                        </div>
                        
                        <div class="form-group">
                            <label>Nomor Referensi Bank</label>
                            <input type="text" class="form-control" id="transaksi-ref" name="nomor_referensi" placeholder="REF-BCA-202610-001" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Status Transfer</label>
                            <select class="form-control" id="transaksi-status" name="status_transfer">
                                <option value="Pending">Pending</option>
                                <option value="Success">Success</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Upload Dokumen Bukti Transfer (PNG, JPG, PDF)</label>
                            <input type="file" class="form-control" id="transaksi-bukti" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        
                        <button type="submit" class="btn-submit">Simpan Transaksi</button>
                        <button type="button" class="btn-submit" style="background:#7F8C8D; margin-top:5px;" onclick="resetTransaksi()">Batal</button>
                    </form>
                    </div>
                    <div class="panel">
                        <h3>Log Transaksi Pembayaran</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Ref ID</th>
                                    <th>Periode / Pegawai</th>
                                    <th>Status Transfer</th>
                                    <th>Dokumen Bukti</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-transaksi"></tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- SCRIPT AJAX & CRUD & PRINT SLIP GAJI -->
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.menu li a').forEach(el => el.classList.remove('active'));
            document.getElementById('view-' + tabName).classList.add('active');
            document.getElementById('nav-' + tabName).classList.add('active');

            if (tabName === 'dashboard') loadDashboardData();
            else loadAllData();
        }

        function loadDashboardData() {
            fetch('api.php?action=get_dashboard_data')
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        document.getElementById('metric-total-payroll').innerText = res.metrics.total_payroll;
                        document.getElementById('metric-total-karyawan').innerText = res.metrics.total_karyawan;
                        document.getElementById('metric-pending-payroll').innerText = res.metrics.total_pending;

                        let rows = '';
                        res.compa_list.forEach(item => {
                            rows += `<tr>
                                <td>${item.nik}</td>
                                <td><b>${item.nama_lengkap}</b></td>
                                <td>${item.nama_jabatan}</td>
                                <td>${item.pay_grade_code}</td>
                                <td>${item.gaji_aktual_fmt}</td>
                                <td>${item.midpoint_fmt}</td>
                                <td><b>${item.compa_ratio}</b></td>
                                <td><span class="badge ${item.badge_class}">${item.status_compa}</span></td>
                            </tr>`;
                        });
                        document.getElementById('tbody-dashboard').innerHTML = rows;
                    }
                });
        }

        function loadAllData() {
            fetch('api.php?action=get_all_data')
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        // 1. Grades
                        let gRows = '', gOpt = '<option value="">-- Pilih Pay Grade --</option>';
                        res.grades.forEach(g => {
                            gRows += `<tr><td><b>${g.pay_grade_code}</b></td><td>Rp ${Number(g.min_salary).toLocaleString('id-ID')}</td><td>Rp ${Number(g.midpoint_salary).toLocaleString('id-ID')}</td><td>Rp ${Number(g.max_salary).toLocaleString('id-ID')}</td><td><button class="btn-action btn-edit" onclick='editGrade(${JSON.stringify(g)})'>Edit</button> <button class="btn-action btn-delete" onclick="deleteGrade(${g.id_grade})">Hapus</button></td></tr>`;
                            gOpt += `<option value="${g.id_grade}">${g.pay_grade_code}</option>`;
                        });
                        document.getElementById('tbody-grades').innerHTML = gRows;
                        document.getElementById('jabatan-grade-id').innerHTML = gOpt;

                        // 2. Jabatan
                        let jRows = '', jOpt = '<option value="">-- Pilih Jabatan --</option>';
                        res.jabatan.forEach(j => {
                            jRows += `<tr><td><b>${j.nama_jabatan}</b></td><td>${j.pay_grade_code}</td><td><small>${j.kategori_jabatan}/${j.level_penjenjangan}</small></td><td><button class="btn-action btn-edit" onclick='editJabatan(${JSON.stringify(j)})'>Edit</button> <button class="btn-action btn-delete" onclick="deleteJabatan(${j.id_jabatan})">Hapus</button></td></tr>`;
                            jOpt += `<option value="${j.id_jabatan}">${j.nama_jabatan} (${j.pay_grade_code})</option>`;
                        });
                        document.getElementById('tbody-jabatan').innerHTML = jRows;
                        document.getElementById('karyawan-jabatan-id').innerHTML = jOpt;

                        // 3. Karyawan
                        let kRows = '', kOpt = '<option value="">-- Pilih Karyawan --</option>';
                        res.karyawan.forEach(k => {
                            kRows += `<tr><td><b>${k.nama_lengkap}</b><br><small>${k.nik}</small></td><td>${k.nama_jabatan}</td><td>${k.pay_grade_code}</td><td><button class="btn-action btn-edit" onclick='editKaryawan(${JSON.stringify(k)})'>Edit</button> <button class="btn-action btn-delete" onclick="deleteKaryawan(${k.id_karyawan})">Hapus</button></td></tr>`;
                            kOpt += `<option value="${k.id_karyawan}">${k.nama_lengkap} - ${k.nik}</option>`;
                        });
                        document.getElementById('tbody-karyawan').innerHTML = kRows;
                        document.getElementById('payroll-karyawan-id').innerHTML = kOpt;

                        // 4. Payroll (Dilengkapi Tombol Cetak Slip Gaji)
                        let pRows = '', pOpt = '<option value="">-- Pilih Payroll Sheet --</option>';
                        res.payroll.forEach(p => {
                            let badge = p.status_approval === 'Approved' ? 'badge-success' : 'badge-warning';
                            pRows += `<tr>
                                <td><b>${p.periode_payroll}</b><br><small>${p.nama_lengkap}</small></td>
                                <td>Rp ${Number(p.gaji_pokok).toLocaleString('id-ID')}</td>
                                <td><b>Rp ${Number(p.take_home_pay).toLocaleString('id-ID')}</b></td>
                                <td><span class="badge ${badge}">${p.status_approval}</span></td>
                                <td>
                                    <button class="btn-action btn-edit" onclick='editPayroll(${JSON.stringify(p)})'>Edit</button>
                                    <button class="btn-action btn-delete" onclick="deletePayroll(${p.id_payroll})">Hapus</button>
                                    <button class="btn-action btn-print" onclick='printSlipGaji(${JSON.stringify(p)})'>Cetak Slip</button>
                                </td>
                            </tr>`;
                            pOpt += `<option value="${p.id_payroll}">ID:${p.id_payroll} - ${p.nama_lengkap} (${p.periode_payroll})</option>`;
                        });
                        document.getElementById('tbody-payroll').innerHTML = pRows;
                        document.getElementById('transaksi-payroll-id').innerHTML = pOpt;

                        // 5. Transaksi
                        // 5. Transaksi Pembayaran (dengan Tombol View Bukti)
                        let tRows = '';
                        res.transaksi.forEach(t => {
                            // Cek apakah ada file bukti transfer
                            let tombolViewBukti = '';
                            if (t.bukti_transfer && t.bukti_transfer.trim() !== '') {
                                tombolViewBukti = `<a href="${t.bukti_transfer}" target="_blank" class="btn-action btn-print" style="text-decoration: none; display: inline-block;">👁️ View Bukti</a>`;
                            } else {
                                tombolViewBukti = `<span style="font-size: 11px; color: var(--text-muted); italic;">Belum ada bukti</span>`;
                            }

                            let badgeClass = t.status_transfer === 'Success' ? 'badge-success' : (t.status_transfer === 'Failed' ? 'badge-danger' : 'badge-warning');

                            tRows += `<tr>
                                <td><b>${t.nomor_referensi}</b></td>
                                <td>${t.periode_payroll} - ${t.nama_lengkap}</td>
                                <td><span class="badge ${badgeClass}">${t.status_transfer}</span></td>
                                <td>${tombolViewBukti}</td>
                                <td>
                                    <button class="btn-action btn-edit" onclick='editTransaksi(${JSON.stringify(t)})'>Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteTransaksi(${t.id_transaksi})">Hapus</button>
                                </td>
                            </tr>`;
                        });
                        document.getElementById('tbody-transaksi').innerHTML = tRows;
                    }
                });
        }

        // --- FITUR CETAK SLIP GAJI ---
       // --- PERBAIKAN CETAK SLIP GAJI DENGAN RINCIAN KOMPONEN TERPISAH ---
        function printSlipGaji(p) {
            let gajiPokok = Number(p.gaji_pokok) || 0;
            let lembur    = Number(p.lembur) || 0;
            let bonus     = Number(p.bonus) || 0;
            let potongan  = Number(p.potongan) || 0;
            let thp       = Number(p.take_home_pay) || (gajiPokok + lembur + bonus - potongan);

            let printWindow = window.open('', '_blank', 'width=800,height=680');
            let html = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Slip Gaji - ${p.nama_lengkap}</title>
                    <style>
                        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 30px; color: #2C3E50; }
                        .header { text-align: center; border-bottom: 2px solid #1F4E79; padding-bottom: 12px; margin-bottom: 20px; }
                        .header h2 { color: #1F4E79; margin: 0; font-size: 20px; text-transform: uppercase; }
                        .header p { margin: 4px 0 0 0; font-size: 12px; color: #7F8C8D; }
                        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                        .info-table td { padding: 6px 0; font-size: 13px; }
                        .salary-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
                        .salary-table th, .salary-table td { border: 1px solid #DCDDE1; padding: 10px 12px; font-size: 13px; text-align: left; }
                        .salary-table th { background-color: #1F4E79; color: white; text-transform: uppercase; font-size: 12px; }
                        .text-right { text-align: right; }
                        .total-row { font-weight: bold; background-color: #EBF1F5; color: #1F4E79; font-size: 14px; }
                        .footer { margin-top: 40px; display: flex; justify-content: space-between; font-size: 12px; }
                        .signature-box { text-align: center; width: 200px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>PT ENTERPRISE REMUNERASI INDONESIA</h2>
                        <p>SLIP GAJI RESMI KARYAWAN — PERIODE: ${p.periode_payroll}</p>
                    </div>

                    <table class="info-table">
                        <tr>
                            <td><b>Nama Karyawan:</b> ${p.nama_lengkap}</td>
                            <td><b>ID Payroll:</b> #${p.id_payroll}</td>
                        </tr>
                        <tr>
                            <td><b>NIK:</b> ${p.nik}</td>
                            <td><b>Status Approval:</b> <span style="color:#2ECC71; font-weight:bold;">${p.status_approval}</span></td>
                        </tr>
                    </table>

                    <table class="salary-table">
                        <thead>
                            <tr>
                                <th>Rincian Komponen Gaji</th>
                                <th class="text-right">Jumlah (IDR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok (Base Salary)</td>
                                <td class="text-right">Rp ${gajiPokok.toLocaleString('id-ID')}</td>
                            </tr>
                            <tr>
                                <td>Lembur (+)</td>
                                <td class="text-right">Rp ${lembur.toLocaleString('id-ID')}</td>
                            </tr>
                            <tr>
                                <td>Bonus (+)</td>
                                <td class="text-right">Rp ${bonus.toLocaleString('id-ID')}</td>
                            </tr>
                            <tr>
                                <td>Potongan (PPh 21 / BPJS / Absensi) (-)</td>
                                <td class="text-right" style="color:#E74C3C;">(Rp ${potongan.toLocaleString('id-ID')})</td>
                            </tr>
                            <tr class="total-row">
                                <td>TOTAL TAKE-HOME PAY (THP)</td>
                                <td class="text-right">Rp ${thp.toLocaleString('id-ID')}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="footer">
                        <div>
                            <p><i>Dokumen ini dicetak otomatis dari Sistem HRMS Kompensasi.</i></p>
                        </div>
                        <div class="signature-box">
                            <p>Jakarta, ${new Date().toLocaleDateString('id-ID')}</p>
                            <br><br><br>
                            <p><b>( Departemen HR & Finance )</b></p>
                        </div>
                    </div>
                </body>
                </html>
            `;
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => { printWindow.print(); }, 500);
        }

        // --- SUBMIT HANDLERS ---
        document.getElementById('form-grade').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('api.php?action=save_grade', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_grade: document.getElementById('grade-id').value, pay_grade_code: document.getElementById('grade-code').value, min_salary: document.getElementById('grade-min').value, midpoint_salary: document.getElementById('grade-mid').value, max_salary: document.getElementById('grade-max').value})
            }).then(res => res.json()).then(res => { alert(res.message); resetGrade(); loadAllData(); });
        });
        function editGrade(g) { document.getElementById('grade-title').innerText = "Edit Pay Grade"; document.getElementById('grade-id').value = g.id_grade; document.getElementById('grade-code').value = g.pay_grade_code; document.getElementById('grade-min').value = g.min_salary; document.getElementById('grade-mid').value = g.midpoint_salary; document.getElementById('grade-max').value = g.max_salary; }
        function resetGrade() { document.getElementById('grade-title').innerText = "Tambah Pay Grade Baru"; document.getElementById('form-grade').reset(); document.getElementById('grade-id').value = ''; }
        function deleteGrade(id) { if(confirm('Hapus?')) fetch('api.php?action=delete_grade', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id_grade:id})}).then(r=>r.json()).then(res=>{alert(res.message);loadAllData();}); }

        document.getElementById('form-jabatan').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('api.php?action=save_jabatan', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_jabatan: document.getElementById('jabatan-id').value, id_grade: document.getElementById('jabatan-grade-id').value, nama_jabatan: document.getElementById('jabatan-nama').value, kategori_jabatan: document.getElementById('jabatan-kategori').value, level_penjenjangan: document.getElementById('jabatan-level').value})
            }).then(res => res.json()).then(res => { alert(res.message); resetJabatan(); loadAllData(); });
        });
        function editJabatan(j) { document.getElementById('jabatan-title').innerText = "Edit Jabatan"; document.getElementById('jabatan-id').value = j.id_jabatan; document.getElementById('jabatan-nama').value = j.nama_jabatan; document.getElementById('jabatan-grade-id').value = j.id_grade; document.getElementById('jabatan-kategori').value = j.kategori_jabatan; document.getElementById('jabatan-level').value = j.level_penjenjangan; }
        function resetJabatan() { document.getElementById('jabatan-title').innerText = "Tambah Jabatan Baru"; document.getElementById('form-jabatan').reset(); document.getElementById('jabatan-id').value = ''; }
        function deleteJabatan(id) { if(confirm('Hapus?')) fetch('api.php?action=delete_jabatan', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id_jabatan:id})}).then(r=>r.json()).then(res=>{alert(res.message);loadAllData();}); }

        document.getElementById('form-karyawan').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('api.php?action=save_karyawan', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_karyawan: document.getElementById('karyawan-id').value, id_jabatan: document.getElementById('karyawan-jabatan-id').value, nik: document.getElementById('karyawan-nik').value, nama_lengkap: document.getElementById('karyawan-nama').value, alamat: document.getElementById('karyawan-alamat').value, tax_id: document.getElementById('karyawan-tax').value})
            }).then(res => res.json()).then(res => { alert(res.message); resetKaryawan(); loadAllData(); });
        });
        function editKaryawan(k) { document.getElementById('karyawan-title').innerText = "Edit Karyawan"; document.getElementById('karyawan-id').value = k.id_karyawan; document.getElementById('karyawan-nik').value = k.nik; document.getElementById('karyawan-nama').value = k.nama_lengkap; document.getElementById('karyawan-jabatan-id').value = k.id_jabatan; document.getElementById('karyawan-alamat').value = k.alamat; document.getElementById('karyawan-tax').value = k.tax_id; }
        function resetKaryawan() { document.getElementById('karyawan-title').innerText = "Tambah Karyawan Baru"; document.getElementById('form-karyawan').reset(); document.getElementById('karyawan-id').value = ''; }
        function deleteKaryawan(id) { if(confirm('Hapus?')) fetch('api.php?action=delete_karyawan', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id_karyawan:id})}).then(r=>r.json()).then(res=>{alert(res.message);loadAllData();}); }

        document.getElementById('form-payroll').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('api.php?action=save_payroll', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id_payroll: document.getElementById('payroll-id').value, id_karyawan: document.getElementById('payroll-karyawan-id').value, periode_payroll: document.getElementById('payroll-periode').value, gaji_pokok: document.getElementById('payroll-gaji').value, lembur: document.getElementById('payroll-lembur').value, bonus: document.getElementById('payroll-bonus').value, potongan: document.getElementById('payroll-potongan').value, status_approval: document.getElementById('payroll-status').value})
            }).then(res => res.json()).then(res => { alert(res.message); resetPayroll(); loadAllData(); });
        });
       function editPayroll(p) {
    document.getElementById('payroll-title').innerText = "Edit Payroll Sheet";
    document.getElementById('payroll-id').value = p.id_payroll;
    document.getElementById('payroll-karyawan-id').value = p.id_karyawan;
    document.getElementById('payroll-periode').value = p.periode_payroll;
    document.getElementById('payroll-gaji').value = p.gaji_pokok;
    
    // PERBAIKAN: Masukkan kembali nilai lembur, bonus, dan potongan ke form input
    document.getElementById('payroll-lembur').value = p.lembur || 0;
    document.getElementById('payroll-bonus').value = p.bonus || 0;
    document.getElementById('payroll-potongan').value = p.potongan || 0;
    
    document.getElementById('payroll-status').value = p.status_approval;
}
        function resetPayroll() { 
        document.getElementById('payroll-title').innerText = "Buat / Kelola Payroll Sheet"; 
        document.getElementById('form-payroll').reset(); 
        document.getElementById('payroll-id').value = ''; 
        }
        function deletePayroll(id) { if(confirm('Hapus?')) fetch('api.php?action=delete_payroll', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id_payroll:id})}).then(r=>r.json()).then(res=>{alert(res.message);loadAllData();}); }

// Submit Handler Transaksi Pembayaran
        document.getElementById('form-transaksi').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            fetch('api.php?action=save_transaksi', {
                method: 'POST',
                body: formData // Jangan berikan Header Content-Type, biarkan browser mengaturnya secara otomatis untuk multipart/form-data
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    alert(res.message);
                    resetTransaksi();
                    loadAllData();
                } else {
                    alert("Error: " + res.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan jaringan atau server.");
            });
        });
        function editTransaksi(t) { document.getElementById('transaksi-title').innerText = "Edit Transaksi Bank"; document.getElementById('transaksi-id').value = t.id_transaksi; document.getElementById('transaksi-payroll-id').value = t.id_payroll; document.getElementById('transaksi-ref').value = t.nomor_referensi; document.getElementById('transaksi-status').value = t.status_transfer; }
        function resetTransaksi() { document.getElementById('transaksi-title').innerText = "Catat Transaksi / Disbursement Bank"; document.getElementById('form-transaksi').reset(); document.getElementById('transaksi-id').value = ''; }
        function deleteTransaksi(id) { if(confirm('Hapus?')) fetch('api.php?action=delete_transaksi', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id_transaksi:id})}).then(r=>r.json()).then(res=>{alert(res.message);loadAllData();}); }

        document.addEventListener('DOMContentLoaded', () => { loadDashboardData(); });
    </script>
</body>
</html>
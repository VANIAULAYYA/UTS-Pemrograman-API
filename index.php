<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Hub - Hospital API</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 2rem; color: #333; }
        .header p { color: #777; margin-top: 5px; }
        .stats { display: flex; gap: 20px; justify-content: center; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px 40px; border-radius: 10px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-card h2 { font-size: 2rem; color: #333; }
        .stat-card p { color: #777; font-size: 0.9rem; }
        .section { background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section h2 { margin-bottom: 20px; color: #333; }
        .endpoint { display: flex; align-items: center; gap: 15px; padding: 12px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 10px; }
        .method { padding: 4px 10px; border-radius: 5px; font-size: 0.8rem; font-weight: bold; color: white; min-width: 60px; text-align: center; }
        .get { background: #61affe; }
        .post { background: #49cc90; }
        .put { background: #fca130; }
        .delete { background: #f93e3e; }
        .url { flex: 1; font-family: monospace; color: #555; font-size: 0.9rem; }
        .desc { color: #888; font-size: 0.85rem; min-width: 200px; }
        .copy-btn { padding: 5px 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 0.8rem; }
        .copy-btn:hover { background: #45a049; }
        .group-title { font-weight: bold; color: #555; margin: 20px 0 10px; font-size: 0.95rem; }
    </style>
</head>
<body>

<div class="header">
    <h1>🏥 API Hub</h1>
    <p>Dokumentasi API lengkap dengan endpoint yang siap digunakan</p>
</div>

<div class="stats">
    <div class="stat-card">
        <h2>12</h2>
        <p>Total Endpoints</p>
    </div>
    <div class="stat-card">
        <h2>4</h2>
        <p>HTTP Methods</p>
    </div>
    <div class="stat-card">
        <h2>3</h2>
        <p>Total Resources</p>
    </div>
</div>

<div class="section">
    <h2>🔌 API Endpoints</h2>

    <!-- Patients -->
    <div class="group-title">👤 Patients</div>

    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/patients/index.php</span>
        <span class="desc">Ambil semua pasien</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/patients/detail.php?id=1</span>
        <span class="desc">Ambil pasien by ID</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method post">POST</span>
        <span class="url">http://localhost:8080/hospital-api/patients/index.php</span>
        <span class="desc">Tambah pasien baru</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method put">PUT</span>
        <span class="url">http://localhost:8080/hospital-api/patients/detail.php?id=1</span>
        <span class="desc">Update data pasien</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method delete">DELETE</span>
        <span class="url">http://localhost:8080/hospital-api/patients/detail.php?id=1</span>
        <span class="desc">Hapus pasien</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/patients/index.php?search=nama</span>
        <span class="desc">Search pasien by nama/NIK/alamat</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>

    <!-- Doctors -->
    <div class="group-title">👨‍⚕️ Doctors</div>

    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/doctors/index.php</span>
        <span class="desc">Ambil semua dokter</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/doctors/detail.php?id=1</span>
        <span class="desc">Ambil dokter by ID</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method post">POST</span>
        <span class="url">http://localhost:8080/hospital-api/doctors/index.php</span>
        <span class="desc">Tambah dokter baru</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>

    <!-- Appointments -->
    <div class="group-title">📅 Appointments</div>

    <div class="endpoint">
        <span class="method get">GET</span>
        <span class="url">http://localhost:8080/hospital-api/appointments/index.php</span>
        <span class="desc">Ambil semua appointments</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method post">POST</span>
        <span class="url">http://localhost:8080/hospital-api/appointments/index.php</span>
        <span class="desc">Buat appointment baru</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>
    <div class="endpoint">
        <span class="method put">PUT</span>
        <span class="url">http://localhost:8080/hospital-api/appointments/detail.php?id=1</span>
        <span class="desc">Update status appointment</span>
        <button class="copy-btn" onclick="copyUrl(this)">Copy</button>
    </div>

</div>

<script>
    function copyUrl(btn) {
        const url = btn.previousElementSibling.previousElementSibling.textContent;
        navigator.clipboard.writeText(url);
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    }
</script>

<script>
    async function loadStats() {
        try {
            const res  = await fetch('http://localhost:8080/hospital-api/api-info.php');
            const data = await res.json();

            document.querySelector('.stat-card:nth-child(1) h2').textContent = data.data.total_endpoints;
            document.querySelector('.stat-card:nth-child(2) h2').textContent = data.data.http_methods;
            document.querySelector('.stat-card:nth-child(3) h2').textContent = data.data.total_resources;
        } catch (err) {
            console.error('Gagal load stats:', err);
        }
    }

    loadStats();
</script>

</body>
</html>

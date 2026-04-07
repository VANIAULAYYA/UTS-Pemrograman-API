<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Hospital Management System - API Hub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1a73e8, #0d5bbf);
            padding: 15px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            color: white;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .user-info span {
            color: white;
        }

        .role-badge {
            background: rgba(255,255,255,0.25);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .login-btn, .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid white;
            padding: 6px 16px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 13px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .login-btn:hover, .logout-btn:hover {
            background: white;
            color: #1a73e8;
        }

        /* Tab Navigation */
        .tab-container {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 24px;
            background: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .tab-btn:hover {
            background: #e8f0fe;
            color: #1a73e8;
        }

        .tab-btn.active {
            background: #1a73e8;
            color: white;
            box-shadow: 0 4px 12px rgba(26,115,232,0.3);
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .stat-card h2 {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #777;
            font-size: 0.8rem;
        }

        /* Warna berbeda tiap stat card */
        .stat-card.patients { border-top: 4px solid #1a73e8; }
        .stat-card.patients h2 { color: #1a73e8; }
        
        .stat-card.doctors { border-top: 4px solid #e36209; }
        .stat-card.doctors h2 { color: #e36209; }
        
        .stat-card.endpoints { border-top: 4px solid #2da44e; }
        .stat-card.endpoints h2 { color: #2da44e; }
        
        .stat-card.methods { border-top: 4px solid #cf222e; }
        .stat-card.methods h2 { color: #cf222e; }
        
        .stat-card.resources { border-top: 4px solid #6e40c9; }
        .stat-card.resources h2 { color: #6e40c9; }

        /* Main Section */
        .section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .section-title {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.3rem;
            padding-bottom: 10px;
            border-bottom: 2px solid #eef2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Search Box */
        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-box input {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 13px;
            width: 220px;
            outline: none;
            transition: 0.2s;
        }

        .search-box input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26,115,232,0.2);
        }

        .search-box button, .refresh-btn {
            padding: 8px 16px;
            background: #eef2f6;
            color: #333;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: 0.2s;
        }

        .search-box button:hover, .refresh-btn:hover {
            background: #1a73e8;
            color: white;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 14px 16px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e0e4e8;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.85rem;
            color: #333;
        }

        tr:hover {
            background: #f5f9ff;
        }

        /* Badge */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-male {
            background: #e3f2fd;
            color: #1a73e8;
        }

        .badge-female {
            background: #fce4ec;
            color: #e91e63;
        }

        /* Loading & Empty */
        .loading, .empty {
            text-align: center;
            padding: 40px;
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Endpoint Card */
        .endpoints-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .endpoint-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #fafbfc;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            transition: all 0.2s;
        }

        .endpoint-card:hover {
            background: white;
            border-color: #d0d7de;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .method {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: white;
            min-width: 65px;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .method.get { background: #2da44e; }
        .method.post { background: #cf222e; }
        .method.put { background: #e36209; }
        .method.delete { background: #6e40c9; }

        .url {
            flex: 1;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.75rem;
            color: #57606a;
            word-break: break-all;
        }

        .desc {
            color: #6e7781;
            font-size: 0.7rem;
            min-width: 140px;
        }

        .copy-btn, .try-btn {
            padding: 5px 12px;
            background: #eef2f6;
            color: #1f2328;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 500;
            transition: 0.2s;
        }

        .copy-btn:hover {
            background: #1a73e8;
            color: white;
        }

        .try-btn:hover {
            background: #e36209;
            color: white;
        }

        .resource-group {
            margin-bottom: 35px;
        }

        .resource-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e4e8;
            flex-wrap: wrap;
        }

        .resource-icon {
            font-size: 28px;
        }

        .resource-header h3 {
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .resource-count {
            background: #e8f0fe;
            color: #1a73e8;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Try It Out Panel */
        .tryit-panel {
            background: #fafbfc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #eef2f6;
        }

        .tryit-panel h4 {
            margin-bottom: 15px;
            color: #1a73e8;
        }

        .tryit-row {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .tryit-row select, .tryit-row input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.8rem;
        }

        .tryit-row select {
            background: white;
            cursor: pointer;
        }

        .tryit-url {
            flex: 1;
            min-width: 250px;
        }

        .json-editor {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.75rem;
            resize: vertical;
            min-height: 150px;
            background: #1e1e1e;
            color: #d4d4d4;
        }

        .response-viewer {
            margin-top: 20px;
            border-top: 1px solid #eef2f6;
            padding-top: 20px;
        }

        .response-status {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .response-status.success {
            background: #d4edda;
            color: #155724;
        }

        .response-status.error {
            background: #f8d7da;
            color: #721c24;
        }

        .response-body {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.75rem;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 400px;
            overflow-y: auto;
        }

        .send-btn {
            padding: 10px 20px;
            background: #2da44e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .send-btn:hover {
            background: #22863a;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #1a73e8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Quick Examples */
        .examples-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        .example-btn {
            padding: 6px 14px;
            background: #eef2f6;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .example-btn:hover {
            background: #1a73e8;
            color: white;
        }

        /* Ringkasan Methods */
        .methods-summary {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
            align-items: center;
        }

        .method-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .method-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: white;
        }

        .method-badge.get { background: #2da44e; }
        .method-badge.post { background: #cf222e; }
        .method-badge.put { background: #e36209; }
        .method-badge.delete { background: #6e40c9; }

        .total-info {
            margin-left: auto;
            font-size: 13px;
            background: white;
            padding: 6px 15px;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 420px;
            max-width: 90%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-content h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #1a73e8;
        }

        .modal-content input, .modal-content select {
            width: 100%;
            padding: 12px 14px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
        }

        .modal-content button {
            width: 100%;
            padding: 12px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            margin-top: 10px;
        }

        .error-msg {
            color: #cf222e;
            font-size: 12px;
            text-align: center;
            margin-top: 12px;
        }

        .success-msg {
            color: #2da44e;
            font-size: 12px;
            text-align: center;
            margin-top: 12px;
        }

        .switch-form {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #666;
        }

        .switch-form a {
            color: #1a73e8;
            text-decoration: none;
            cursor: pointer;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #888;
            font-size: 12px;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Hide stats by default */
        .tab-stats {
            display: none;
        }

        .tab-stats.active {
            display: grid;
        }

        @media (max-width: 768px) {
            body {
                padding: 12px;
            }
            
            .navbar {
                flex-direction: column;
                text-align: center;
            }
            
            .endpoint-card {
                flex-wrap: wrap;
            }
            
            .method {
                min-width: 55px;
            }
            
            .desc {
                width: 100%;
                margin-left: 77px;
            }
            
            .copy-btn, .try-btn {
                margin-left: auto;
            }
            
            .tryit-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .methods-summary {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .total-info {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🏥 Hospital Management System</h1>
    <div class="user-info" id="userInfo">
        <span id="userNameDisplay" style="display: none;">👤 <span id="username"></span></span>
        <span id="userRoleDisplay" style="display: none;" class="role-badge"></span>
        <a href="javascript:void(0)" id="loginBtn" class="login-btn" onclick="showLoginModal()">🔐 Login / Daftar</a>
        <a href="javascript:void(0)" id="logoutBtn" class="logout-btn" onclick="logout()" style="display: none;">🚪 Logout</a>
    </div>
</div>

<!-- Stats Container yang akan berubah per tab -->
<div id="stats-container"></div>

<!-- Tab Navigation -->
<div class="tab-container">
    <button class="tab-btn active" onclick="showTab('patients')">👤 Data Pasien</button>
    <button class="tab-btn" onclick="showTab('doctors')">👨‍⚕️ Data Dokter</button>
    <button class="tab-btn" onclick="showTab('api')">🔌 API Documentation</button>
    <button class="tab-btn" onclick="showTab('tryit')">🔥 Try It Out</button>
</div>

<!-- Tab: Data Pasien -->
<div id="tab-patients" class="tab-content active">
    <div class="section">
        <div class="section-title">
            <span>👤 Daftar Pasien</span>
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Cari nama / NIK..." onkeyup="searchPatient()">
                <button onclick="loadPatients()">🔄 Refresh</button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th>Gender</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody id="patients-table">
                    <tr><td colspan="7" class="loading">Memuat data...</td</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab: Data Dokter -->
<div id="tab-doctors" class="tab-content">
    <div class="section">
        <div class="section-title">
            <span>👨‍⚕️ Daftar Dokter</span>
            <div class="search-box">
                <input type="text" id="search-doctor-input" placeholder="Cari nama / spesialisasi..." onkeyup="searchDoctor()">
                <button onclick="loadDoctors()">🔄 Refresh</button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody id="doctors-table">
                    <tr><td colspan="4" class="loading">Memuat data...</td</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab: API Documentation -->
<div id="tab-api" class="tab-content">
    <div class="section">
        <h2 class="section-title">📡 API Endpoints</h2>
        
        <!-- Ringkasan Methods yang Tersedia -->
        <div class="methods-summary">
            <div class="method-item">
                <span class="method-badge get">GET</span>
                <span style="font-size: 13px; color: #555;">Mengambil data</span>
            </div>
            <div class="method-item">
                <span class="method-badge post">POST</span>
                <span style="font-size: 13px; color: #555;">Menambah data</span>
            </div>
            <div class="method-item">
                <span class="method-badge put">PUT</span>
                <span style="font-size: 13px; color: #555;">Mengupdate data</span>
            </div>
            <div class="method-item">
                <span class="method-badge delete">DELETE</span>
                <span style="font-size: 13px; color: #555;">Menghapus data</span>
            </div>
            <div class="total-info">
                📊 <strong>12 Endpoints</strong> | 4 Methods | 3 Resources
            </div>
        </div>

        <!-- Patients API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">👤</span>
                <h3>Patients</h3>
                <span class="resource-count">6 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 3, POST: 1, PUT: 1, DELETE: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/patients/index.php</span>
                    <span class="desc">Ambil semua pasien</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
                    <span class="desc">Ambil pasien by ID</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/detail.php', 'id=1')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/patients/index.php?search=nama</span>
                    <span class="desc">Search pasien</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/index.php?search=nama">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/index.php', 'search=nama')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/hospital_api/patients/index.php</span>
                    <span class="desc">Tambah pasien baru</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/hospital_api/patients/index.php', null, '{\n    "name": "Pasien Baru",\n    "nik": "1234567890123456",\n    "birth_date": "1995-05-15",\n    "gender": "Laki-laki",\n    "phone": "08123456789",\n    "address": "Jl. Contoh No. 123"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method put">PUT</span>
                    <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
                    <span class="desc">Update data pasien</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('PUT', 'http://localhost/hospital_api/patients/detail.php', 'id=1', '{\n    "name": "Nama Update",\n    "phone": "08987654321",\n    "address": "Alamat Baru"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method delete">DELETE</span>
                    <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
                    <span class="desc">Hapus pasien</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('DELETE', 'http://localhost/hospital_api/patients/detail.php', 'id=1')">🔥 Try</button>
                </div>
            </div>
        </div>

        <!-- Doctors API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">👨‍⚕️</span>
                <h3>Doctors</h3>
                <span class="resource-count">3 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 2, POST: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/doctors/index.php</span>
                    <span class="desc">Ambil semua dokter</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/doctors/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/doctors/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/doctors/detail.php?id=1</span>
                    <span class="desc">Ambil dokter by ID</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/doctors/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/doctors/detail.php', 'id=1')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/hospital_api/doctors/index.php</span>
                    <span class="desc">Tambah dokter baru</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/doctors/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/hospital_api/doctors/index.php', null, '{\n    "name": "dr. Budi Santoso",\n    "specialization": "Umum",\n    "phone": "08123456789"\n}')">🔥 Try</button>
                </div>
            </div>
        </div>

        <!-- Appointments API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">📅</span>
                <h3>Appointments</h3>
                <span class="resource-count">3 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 1, POST: 1, PUT: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/hospital_api/appointments/index.php</span>
                    <span class="desc">Ambil semua appointments</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/appointments/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/appointments/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/hospital_api/appointments/index.php</span>
                    <span class="desc">Buat appointment baru</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/appointments/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/hospital_api/appointments/index.php', null, '{\n    "patient_id": 1,\n    "doctor_id": 1,\n    "appointment_date": "2024-12-25 10:00:00",\n    "complaint": "Demam dan batuk",\n    "status": "pending"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method put">PUT</span>
                    <span class="url">http://localhost/hospital_api/appointments/detail.php?id=1</span>
                    <span class="desc">Update status appointment</span>
                    <button class="copy-btn" data-url="http://localhost/hospital_api/appointments/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('PUT', 'http://localhost/hospital_api/appointments/detail.php', 'id=1', '{\n    "status": "done"\n}')">🔥 Try</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab: Try It Out -->
<div id="tab-tryit" class="tab-content">
    <div class="section">
        <h2 class="section-title">🔥 Try It Out</h2>
        
        <!-- Stats ringkas di Try It Out -->
        <div class="methods-summary" style="margin-bottom: 20px;">
            <div class="method-item">
                <span class="method-badge get">GET</span>
                <span style="font-size: 13px; color: #555;">Mengambil data</span>
            </div>
            <div class="method-item">
                <span class="method-badge post">POST</span>
                <span style="font-size: 13px; color: #555;">Menambah data</span>
            </div>
            <div class="method-item">
                <span class="method-badge put">PUT</span>
                <span style="font-size: 13px; color: #555;">Mengupdate data</span>
            </div>
            <div class="method-item">
                <span class="method-badge delete">DELETE</span>
                <span style="font-size: 13px; color: #555;">Menghapus data</span>
            </div>
            <div class="total-info">
                📊 <strong>12 Endpoints</strong> | 4 Methods | 3 Resources
            </div>
        </div>
        
        <p style="margin-bottom: 20px; color: #666;">Pilih endpoint, isi parameter, dan kirim request untuk melihat response API secara langsung!</p>
        
        <div class="tryit-panel">
            <h4>⚡ Request Builder</h4>
            <div class="tryit-row">
                <select id="try-method" style="min-width: 100px;">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="DELETE">DELETE</option>
                </select>
                <input type="text" id="try-url" class="tryit-url" placeholder="URL Endpoint" value="http://localhost/hospital_api/patients/index.php">
            </div>
            <div class="tryit-row">
                <input type="text" id="try-params" placeholder="Query Parameters (contoh: id=1&search=nama)" style="width: 100%;">
            </div>
            <div>
                <textarea id="try-body" class="json-editor" placeholder='Body JSON untuk POST/PUT request (contoh):
{
    "name": "Nama Baru",
    "specialization": "Spesialisasi"
}'></textarea>
            </div>
            <div style="margin-top: 15px;">
                <button class="send-btn" onclick="sendRequest()">🚀 Send Request</button>
            </div>
        </div>

        <div id="response-area" style="display: none;">
            <div class="tryit-panel">
                <h4>📬 Response</h4>
                <div id="response-status" class="response-status"></div>
                <div id="response-body" class="response-body"></div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h4>📋 Quick Examples</h4>
            <div class="examples-container">
                <button class="example-btn" onclick="setExample('patients')">👤 GET All Patients</button>
                <button class="example-btn" onclick="setExample('patients_detail')">👤 GET Patient by ID</button>
                <button class="example-btn" onclick="setExample('doctors')">👨‍⚕️ GET All Doctors</button>
                <button class="example-btn" onclick="setExample('appointments')">📅 GET All Appointments</button>
                <button class="example-btn" onclick="setExample('post_patient')">➕ POST New Patient</button>
                <button class="example-btn" onclick="setExample('post_doctor')">➕ POST New Doctor</button>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>Hospital Management System - API Documentation & Data Management © 2024</p>
</div>

<!-- Modal Login / Register -->
<div id="authModal" class="modal">
    <div class="modal-content">
        <div id="loginForm">
            <h2>🔐 Login</h2>
            <input type="text" id="loginUsername" placeholder="Username">
            <input type="password" id="loginPassword" placeholder="Password">
            <button onclick="doLogin()">Login</button>
            <div class="switch-form">
                Belum punya akun? <a onclick="showRegisterForm()">Daftar disini</a>
            </div>
            <div id="loginError" class="error-msg"></div>
        </div>
        <div id="registerForm" style="display: none;">
            <h2>📝 Daftar Akun Baru</h2>
            <input type="text" id="regFullname" placeholder="Nama Lengkap">
            <input type="text" id="regUsername" placeholder="Username">
            <input type="password" id="regPassword" placeholder="Password (min. 4 karakter)">
            <select id="regRole">
                <option value="staff">📋 Staff</option>
                <option value="doctor">👨‍⚕️ Dokter</option>
            </select>
            <button onclick="doRegister()">Daftar</button>
            <button class="secondary" onclick="showLoginForm()">← Kembali</button>
            <div id="registerError" class="error-msg"></div>
            <div id="registerSuccess" class="success-msg"></div>
        </div>
    </div>
</div>

<script>
    const BASE_URL = 'http://localhost/hospital_api';

    // ============= RENDER STATS CARD BERDASARKAN TAB =============
    function renderStats(tabName) {
        const statsContainer = document.getElementById('stats-container');
        
        if (tabName === 'patients') {
            // Hanya menampilkan Total Pasien
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card patients">
                        <h2 id="total-patients">-</h2>
                        <p>👤 Total Pasien</p>
                    </div>
                </div>
            `;
            loadPatients();
        } 
        else if (tabName === 'doctors') {
            // Hanya menampilkan Total Dokter
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card doctors">
                        <h2 id="total-doctors">-</h2>
                        <p>👨‍⚕️ Total Dokter</p>
                    </div>
                </div>
            `;
            loadDoctors();
        }
        else {
            // Untuk tab API Documentation dan Try It Out: tampilkan stats endpoint, methods, resources
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card endpoints">
                        <h2>12</h2>
                        <p>🔌 Total Endpoints</p>
                    </div>
                    <div class="stat-card methods">
                        <h2>4</h2>
                        <p>⚡ HTTP Methods</p>
                    </div>
                    <div class="stat-card resources">
                        <h2>3</h2>
                        <p>📦 Total Resources</p>
                    </div>
                </div>
            `;
        }
    }

    // ============= TAB NAVIGATION =============
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
        document.getElementById(`tab-${tabName}`).classList.add('active');
        event.target.classList.add('active');
        
        // Render stats berdasarkan tab yang aktif
        renderStats(tabName);
    }

    // ============= TRY IT OUT FUNCTIONS =============
    function tryThisEndpoint(method, url, params, body) {
        showTab('tryit');
        document.getElementById('try-method').value = method;
        document.getElementById('try-url').value = url;
        document.getElementById('try-params').value = params || '';
        document.getElementById('try-body').value = body ? JSON.stringify(JSON.parse(body), null, 2) : '';
        document.getElementById('response-area').style.display = 'none';
        
        setTimeout(() => {
            document.getElementById('try-body').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    async function sendRequest() {
        let url = document.getElementById('try-url').value;
        const method = document.getElementById('try-method').value;
        const params = document.getElementById('try-params').value;
        let jsonBody = document.getElementById('try-body').value;
        
        if (params) {
            url += (url.includes('?') ? '&' : '?') + params;
        }
        
        const options = {
            method: method,
            headers: { 'Content-Type': 'application/json' }
        };
        
        if (method !== 'GET' && jsonBody && jsonBody.trim()) {
            try {
                options.body = JSON.stringify(JSON.parse(jsonBody));
            } catch (e) {
                options.body = jsonBody;
            }
        }
        
        const responseArea = document.getElementById('response-area');
        const statusDiv = document.getElementById('response-status');
        const bodyDiv = document.getElementById('response-body');
        
        responseArea.style.display = 'block';
        statusDiv.innerHTML = '<span class="loading-spinner"></span> Mengirim request...';
        statusDiv.className = 'response-status';
        bodyDiv.textContent = '';
        
        try {
            const startTime = Date.now();
            const response = await fetch(url, options);
            const endTime = Date.now();
            const responseTime = endTime - startTime;
            
            const responseText = await response.text();
            let formattedResponse;
            try {
                const json = JSON.parse(responseText);
                formattedResponse = JSON.stringify(json, null, 2);
            } catch (e) {
                formattedResponse = responseText;
            }
            
            if (response.ok) {
                statusDiv.innerHTML = `✅ ${response.status} ${response.statusText} - ⏱️ ${responseTime}ms`;
                statusDiv.className = 'response-status success';
            } else {
                statusDiv.innerHTML = `❌ ${response.status} ${response.statusText} - ⏱️ ${responseTime}ms`;
                statusDiv.className = 'response-status error';
            }
            
            bodyDiv.textContent = formattedResponse;
        } catch (error) {
            statusDiv.innerHTML = `❌ Error: ${error.message}`;
            statusDiv.className = 'response-status error';
            bodyDiv.textContent = 'Gagal mengirim request. Periksa koneksi atau URL.';
        }
    }

    function setExample(type) {
        const examples = {
            patients: { method: 'GET', url: `${BASE_URL}/patients/index.php`, params: '', body: '' },
            patients_detail: { method: 'GET', url: `${BASE_URL}/patients/detail.php`, params: 'id=1', body: '' },
            doctors: { method: 'GET', url: `${BASE_URL}/doctors/index.php`, params: '', body: '' },
            appointments: { method: 'GET', url: `${BASE_URL}/appointments/index.php`, params: '', body: '' },
            post_patient: { method: 'POST', url: `${BASE_URL}/patients/index.php`, params: '', body: '{\n    "name": "Pasien Baru",\n    "nik": "1234567890123456",\n    "birth_date": "1995-05-15",\n    "gender": "Laki-laki",\n    "phone": "08123456789",\n    "address": "Jl. Contoh No. 123"\n}' },
            post_doctor: { method: 'POST', url: `${BASE_URL}/doctors/index.php`, params: '', body: '{\n    "name": "dr. Ahmad Fauzi",\n    "specialization": "Anak",\n    "phone": "08987654321"\n}' }
        };
        
        const ex = examples[type];
        if (ex) {
            document.getElementById('try-method').value = ex.method;
            document.getElementById('try-url').value = ex.url;
            document.getElementById('try-params').value = ex.params;
            document.getElementById('try-body').value = ex.body;
            document.getElementById('response-area').style.display = 'none';
            showTab('tryit');
        }
    }

    // ============= LOAD PATIENTS =============
    async function loadPatients(search = '') {
        const tbody = document.getElementById('patients-table');
        tbody.innerHTML = '<tr><td colspan="7" class="loading">Memuat data...</td</tr>';
        try {
            let url = `${BASE_URL}/patients/index.php`;
            if (search) url += `?search=${encodeURIComponent(search)}`;
            const res = await fetch(url);
            const data = await res.json();
            
            const totalPatientsElem = document.getElementById('total-patients');
            if (totalPatientsElem) {
                totalPatientsElem.textContent = data.data?.length || 0;
            }
            
            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="empty">Tidak ada data pasien</td</tr>';
                return;
            }
            tbody.innerHTML = data.data.map((p, i) => `
                <tr>
                    <td>${i+1}</td>
                    <td><b>${escapeHtml(p.name)}</b></td>
                    <td>${escapeHtml(p.nik)}</td>
                    <td>${escapeHtml(p.birth_date)}</td>
                    <td><span class="badge ${p.gender === 'Laki-laki' ? 'badge-male' : 'badge-female'}">${escapeHtml(p.gender)}</span></td>
                    <td>${escapeHtml(p.phone) || '-'}</td>
                    <td>${escapeHtml(p.address) || '-'}</td>
                </tr>
            `).join('');
        } catch(err) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty">Gagal memuat data!</td</tr>';
        }
    }

    // ============= LOAD DOCTORS =============
    async function loadDoctors(search = '') {
        const tbody = document.getElementById('doctors-table');
        tbody.innerHTML = '<tr><td colspan="4" class="loading">Memuat data...</td</tr>';
        try {
            let url = `${BASE_URL}/doctors/index.php`;
            if (search) url += `?search=${encodeURIComponent(search)}`;
            const res = await fetch(url);
            const data = await res.json();
            
            const totalDoctorsElem = document.getElementById('total-doctors');
            if (totalDoctorsElem) {
                totalDoctorsElem.textContent = data.data?.length || 0;
            }
            
            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="empty">Tidak ada data dokter</td</tr>';
                return;
            }
            tbody.innerHTML = data.data.map((d, i) => `
                <tr>
                    <td>${i+1}</td>
                    <td><b>${escapeHtml(d.name)}</b></td>
                    <td>${escapeHtml(d.specialization)}</td>
                    <td>${escapeHtml(d.phone) || '-'}</td>
                </tr>
            `).join('');
        } catch(err) {
            tbody.innerHTML = '<tr><td colspan="4" class="empty">Gagal memuat data!</td</tr>';
        }
    }

    // Search functions
    let searchTimeout, searchDoctorTimeout;
    function searchPatient() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadPatients(document.getElementById('search-input').value), 400);
    }
    function searchDoctor() {
        clearTimeout(searchDoctorTimeout);
        searchDoctorTimeout = setTimeout(() => loadDoctors(document.getElementById('search-doctor-input').value), 400);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ============= LOGIN SYSTEM =============
    function checkLoginStatus() {
        const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
        const currentUser = localStorage.getItem('currentUser');
        const userFullname = localStorage.getItem('userFullname');
        const userRole = localStorage.getItem('userRole');
        if (isLoggedIn && currentUser) {
            document.getElementById('userNameDisplay').style.display = 'inline';
            document.getElementById('username').textContent = userFullname || currentUser;
            document.getElementById('userRoleDisplay').style.display = 'inline';
            document.getElementById('userRoleDisplay').textContent = userRole === 'doctor' ? 'Dokter' : (userRole === 'admin' ? 'Admin' : 'Staff');
            document.getElementById('loginBtn').style.display = 'none';
            document.getElementById('logoutBtn').style.display = 'inline';
        } else {
            document.getElementById('userNameDisplay').style.display = 'none';
            document.getElementById('userRoleDisplay').style.display = 'none';
            document.getElementById('loginBtn').style.display = 'inline';
            document.getElementById('logoutBtn').style.display = 'none';
        }
    }

    function showLoginModal() {
        document.getElementById('authModal').style.display = 'flex';
        showLoginForm();
    }

    function showLoginForm() {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('loginError').textContent = '';
    }

    function showRegisterForm() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
        document.getElementById('registerError').textContent = '';
        document.getElementById('registerSuccess').textContent = '';
    }

    function closeAuthModal() {
        document.getElementById('authModal').style.display = 'none';
    }

    async function doLogin() {
        const username = document.getElementById('loginUsername').value.trim();
        const password = document.getElementById('loginPassword').value;
        if (!username || !password) {
            document.getElementById('loginError').textContent = 'Username dan password harus diisi!';
            return;
        }
        try {
            const response = await fetch('login_api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'login', username, password })
            });
            const result = await response.json();
            if (result.success) {
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('currentUser', result.user.username);
                localStorage.setItem('userRole', result.user.role);
                localStorage.setItem('userFullname', result.user.fullname);
                closeAuthModal();
                checkLoginStatus();
                showToast('✅ Login berhasil!');
            } else {
                document.getElementById('loginError').textContent = result.message;
            }
        } catch(err) {
            document.getElementById('loginError').textContent = 'Terjadi kesalahan';
        }
    }

    async function doRegister() {
        const fullname = document.getElementById('regFullname').value.trim();
        const username = document.getElementById('regUsername').value.trim();
        const password = document.getElementById('regPassword').value;
        const role = document.getElementById('regRole').value;
        if (!fullname || !username || !password) {
            document.getElementById('registerError').textContent = 'Semua field harus diisi!';
            return;
        }
        if (password.length < 4) {
            document.getElementById('registerError').textContent = 'Password minimal 4 karakter!';
            return;
        }
        try {
            const response = await fetch('login_api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'register', fullname, username, password, role })
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById('registerSuccess').textContent = result.message;
                setTimeout(() => showLoginForm(), 2000);
            } else {
                document.getElementById('registerError').textContent = result.message;
            }
        } catch(err) {
            document.getElementById('registerError').textContent = 'Terjadi kesalahan';
        }
    }

    function logout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            localStorage.clear();
            checkLoginStatus();
            showToast('👋 Logout berhasil!');
        }
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText = 'position:fixed;bottom:20px;right:20px;padding:12px 24px;background:#1a73e8;color:white;border-radius:12px;z-index:9999';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function handleCopy(btn) {
        const url = btn.getAttribute('data-url');
        navigator.clipboard.writeText(url);
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    }

    // Attach copy event
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() { handleCopy(this); });
    });

    window.onclick = (e) => { if (e.target === document.getElementById('authModal')) closeAuthModal(); };
    
    // Initial load - default tab patients
    renderStats('patients');
    loadPatients();
    loadDoctors();
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="description"
        content="Platform API untuk mengelola data pasien, dokter, dan appointment secara real-time">
    <title>Hospital Management System - API Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navbar" id="main-navbar" style="display: none;">
        <h1>🏥 Hospital Management System</h1>
    </div>

    <!-- 🎯 LANDING PAGE  -->
<div id="landingPage">
    <div class="landing-inner">
        <span class="landing-emoji">🏥</span>
        <h1>Hospital Management System <span>API Hub</span></h1>
        <p class="landing-subtitle">Platform API untuk mengelola data pasien, dokter, appointment, dan user secara
            real-time</p>
        <p class="landing-desc">Gunakan berbagai endpoint API untuk melakukan operasi CRUD dengan mudah. Untuk
            mengakses API, silakan login atau daftar terlebih dahulu untuk mendapatkan API KEY.</p>

        <!-- 4 Info Cards -->
        <div class="landing-cards">
            <div class="landing-card">
                <span class="card-icon">📊</span>
                <h3 id="landing-total-endpoints">Memuat...</h3>
                <p>Endpoint lengkap untuk semua resource</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">⚡</span>
                <h3 id="landing-http-methods">Memuat...</h3>
                <p>Mendukung semua metode HTTP</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">🔐</span>
                <h3>Secure API Key</h3>
                <p>Autentikasi aman dengan API Key</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">📡</span>
                <h3 id="landing-total-resources">Memuat...</h3>
                <p>Database real-time</p>
            </div>
        </div>

        <!-- Access Box -->
        <div class="landing-access-box">
            🔑 <strong>Anda harus login terlebih dahulu untuk mendapatkan API KEY.</strong><br>
            API KEY digunakan untuk mengakses semua endpoint dalam sistem ini.
        </div>

        <!-- CTA Buttons -->
        <div class="landing-cta">
            <button class="cta-login" onclick="showLoginModal()">🔐 Login</button>
            <button class="cta-register" onclick="openRegisterDirectly()">📝 Daftar</button>
        </div>

        <!-- API Preview -->
        <div class="landing-preview">
            <h4>📋 Preview Endpoints</h4>
            <div class="preview-line">
                <span class="preview-method get">GET</span>
                <span class="preview-path">/patients</span>
            </div>
            <div class="preview-line">
                <span class="preview-method post">POST</span>
                <span class="preview-path">/doctors</span>
            </div>
            <div class="preview-line">
                <span class="preview-method put">PUT</span>
                <span class="preview-path">/appointments</span>
            </div>
            <div class="preview-line">
                <span class="preview-method delete">DELETE</span>
                <span class="preview-path">/patients/{id}</span>
            </div>
            <div class="preview-line">
                <span class="preview-method get">GET</span>
                <span class="preview-path">/users</span>
            </div>
        </div>
    </div>
</div>

    <!-- OLD landing page (hidden, kept for backward compatibility) -->
    <div id="landing-page" style="display:none;"></div>

    <!-- Stats Container yang akan berubah per tab -->
    <div id="dashboard-container" style="display: none;">

       <!-- User Profile Header terpisah dari Navbar -->
<div class="user-dashboard-header" id="userDashboardHeader">
    <div class="user-dashboard-profile">
        <div class="user-avatar" onclick="showProfile()">👤</div>
        <div class="user-details">
            <div class="user-greeting">Selamat datang, <span id="username"></span>!</div>
            <div class="user-meta">
                        <span id="userRoleDisplay" class="role-badge"></span>
                    </div>
        </div>
    </div>
    <div class="user-dashboard-actions">
        <a href="javascript:void(0)" onclick="logout()" class="logout-btn-new">🚪 Logout</a>
    </div>
</div>

<!-- Modal Profil User -->
<div id="profileModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 550px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1a73e8;">👤 Profil Saya</h2>
            <span onclick="closeProfileModal()" style="cursor: pointer; font-size: 24px; color: #888; font-weight: bold; transition: 0.2s;">&times;</span>
        </div>
        
        <!-- Avatar -->
        <div class="profile-avatar">
            <div class="profile-avatar-circle">
                👤
            </div>
        </div>
        
        <!-- Biodata -->
        <div class="profile-info">
            <div class="profile-row">
                <div class="profile-label">Username</div>
                <div class="profile-value" id="profileUsername">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Nama Lengkap</div>
                <div class="profile-value" id="profileFullname">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Email</div>
                <div class="profile-value" id="profileEmail">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Nomor Telepon</div>
                <div class="profile-value" id="profilePhone">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Jenis Kelamin</div>
                <div class="profile-value" id="profileGender">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Role</div>
                <div class="profile-value" id="profileRole">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Status Akun</div>
                <div class="profile-value" id="profileStatus">-</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Tanggal Daftar</div>
                <div class="profile-value" id="profileCreatedAt">-</div>
            </div>
        </div>
        
        <!-- API Key -->
        <div class="api-key-container">
            <span class="api-key-label">🔑 API Key</span>
            <span class="api-key-value" id="profileApiKey">-</span>
            <button onclick="copyProfileApiKey()" class="btn-copy-api">📋 Copy</button>
        </div>
        
        <!-- Tombol Tutup -->
        <div style="margin-top: 25px; text-align: center;">
            <button onclick="closeProfileModal()" class="btn-close-modal">Tutup</button>
        </div>
    </div>
</div>

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
                            <tr>
                                <td colspan="7" class="loading">Memuat data...</td>
                            </tr>
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
                        <input type="text" id="search-doctor-input" placeholder="Cari nama / spesialisasi..."
                            onkeyup="searchDoctor()">
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
                            <tr>
                                <td colspan="4" class="loading">Memuat data...</td>
                            </tr>
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
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/index.php', null, null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
            <span class="desc">Ambil pasien by ID</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/detail.php', 'id=1', null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/patients/index.php?search=nama</span>
            <span class="desc">Search pasien</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/patients/index.php?search=nama">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/patients/index.php', 'search=nama', null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method post">POST</span>
            <span class="url">http://localhost/hospital_api/patients/index.php</span>
            <span class="desc">Tambah pasien baru</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/patients/index.php">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("POST", "http://localhost/hospital_api/patients/index.php", null, `{
    "name": "Masukkan name",
    "nik": "Masukkan nik",
    "birth_date": "masukkan birth_date",
    "gender": "Ketik salah satu (Laki-laki/Perempuan)",
    "phone": "Masukkan phone",
    "address": "Masukkan address"
}`)'>🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method put">PUT</span>
            <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
            <span class="desc">Update data pasien</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("PUT", "http://localhost/hospital_api/patients/detail.php", "id=1", `{
    "name": "Masukkan name baru",
    "nik": "Masukkan nik baru",
    "birth_date": "masukkan birth_date baru",
    "gender": "Ketik salah satu (Laki-laki/Perempuan)",
    "phone": "Masukkan phone baru",
    "address": "Masukkan address baru"
}`)'>🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method delete">DELETE</span>
            <span class="url">http://localhost/hospital_api/patients/detail.php?id=1</span>
            <span class="desc">Hapus pasien</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/patients/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('DELETE', 'http://localhost/hospital_api/patients/detail.php', 'id=1', null)">🔥 Try</button>
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
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/doctors/index.php', null, null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/doctors/detail.php?id=1</span>
            <span class="desc">Ambil dokter by ID</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/doctors/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/doctors/detail.php', 'id=1', null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method post">POST</span>
            <span class="url">http://localhost/hospital_api/doctors/index.php</span>
            <span class="desc">Tambah dokter baru</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/doctors/index.php">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("POST", "http://localhost/hospital_api/doctors/index.php", null, `{
    "name": "Masukkan name",
    "specialization": "Masukkan specialization",
    "phone": "Masukkan phone"
}`)'>🔥 Try</button>
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
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/appointments/index.php', null, null)">🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method post">POST</span>
            <span class="url">http://localhost/hospital_api/appointments/index.php</span>
            <span class="desc">Buat appointment baru</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/appointments/index.php">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("POST", "http://localhost/hospital_api/appointments/index.php", null, `{
    "patient_id": "Masukkan patient_id",
    "doctor_id": "Masukkan doctor_id",
    "appointment_date": "Masukkan appointment_date",
    "complaint": "Masukkan complain",
    "status": "Masukkan status"
}`)'>🔥 Try</button>
        </div>
        <div class="endpoint-card">
            <span class="method put">PUT</span>
            <span class="url">http://localhost/hospital_api/appointments/detail.php?id=1</span>
            <span class="desc">Update status appointment</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/appointments/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("PUT", "http://localhost/hospital_api/appointments/detail.php", "id=1", `{
    "patient_id": "Masukkan patient_id baru",
    "doctor_id": "Masukkan doctor_id baru",
    "appointment_date": "Masukkan appointment_date baru",
    "complaint": "Masukkan complain baru",
    "status": "Masukkan status baru"
}`)'>🔥 Try</button>
        </div>
    </div>
</div>

                 <!-- Users API -->
<div class="resource-group">
    <div class="resource-header">
        <span class="resource-icon">👥</span>
        <h3>Users</h3>
        <span class="resource-count">6 endpoints</span>
        <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 3, POST: 1, PUT: 1, DELETE: 1)</span>
    </div>
    <div class="endpoints-container">
        <!-- GET All Users -->
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/users/index.php</span>
            <span class="desc">Ambil semua user</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/index.php">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/users/index.php', null, null)">🔥 Try</button>
        </div>
        
        <!-- GET User by ID -->
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/users/detail.php?id=1</span>
            <span class="desc">Ambil user by ID</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/users/detail.php', 'id=1', null)">🔥 Try</button>
        </div>
        
        <!-- GET Search User -->
        <div class="endpoint-card">
            <span class="method get">GET</span>
            <span class="url">http://localhost/hospital_api/users/index.php?search=username</span>
            <span class="desc">Search user</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/index.php?search=username">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/hospital_api/users/index.php', 'search=username', null)">🔥 Try</button>
        </div>
        
        <!-- POST Create New User -->
        <div class="endpoint-card">
            <span class="method post">POST</span>
            <span class="url">http://localhost/hospital_api/users/index.php</span>
            <span class="desc">Tambah user baru</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/index.php">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("POST", "http://localhost/hospital_api/users/index.php", null, `{
    "username": "Masukkan username",
    "fullname": "Masukkan fullname",
    "email": "Masukkan email",
    "phone": "Masukkan phone",
    "gender": "Ketik salah satu (Laki-laki/Perempuan)",
    "password": "Masukkan password",
    "role": "Ketik salah satu (admin/staff/doctor)"
}`)'>🔥 Try</button>
        </div>
        
        <!-- PUT Update User -->
        <div class="endpoint-card">
            <span class="method put">PUT</span>
            <span class="url">http://localhost/hospital_api/users/detail.php?id=1</span>
            <span class="desc">Update user</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick='tryThisEndpoint("PUT", "http://localhost/hospital_api/users/detail.php", "id=1", `{
    "fullname": "Masukkan nama lengkap baru",
    "email": "Masukkan email baru",
    "phone": "Masukkan nomor telepon baru",
    "gender": "Laki-laki/Perempuan",
    "role": "admin/staff/doctor",
    "is_active": 1,
    "password": "Masukkan password baru"
}`)'>🔥 Try</button>
        </div>
        
        <!-- DELETE User -->
        <div class="endpoint-card">
            <span class="method delete">DELETE</span>
            <span class="url">http://localhost/hospital_api/users/detail.php?id=1</span>
            <span class="desc">Hapus user</span>
            <button class="copy-btn" data-url="http://localhost/hospital_api/users/detail.php?id=1">Copy</button>
            <button class="try-btn" onclick="tryThisEndpoint('DELETE', 'http://localhost/hospital_api/users/detail.php', 'id=1', null)">🔥 Try</button>
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
                        📊 <strong>18 Endpoints</strong> | 4 Methods | 4 Resources
                    </div>
                </div>

                <p style="margin-bottom: 20px; color: #666;">Pilih endpoint, isi parameter, dan kirim request untuk
                    melihat response API secara langsung!</p>

                <div class="tryit-panel">
                    <h4>⚡ Request Builder</h4>
                    <div class="tryit-row">
                        <select id="try-method" style="min-width: 100px;">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="DELETE">DELETE</option>
                        </select>
                        <input type="text" id="try-url" class="tryit-url" placeholder="URL Endpoint"
                            value="http://localhost/hospital_api/patients/index.php">
                    </div>
                    <div class="tryit-row">
                        <input type="text" id="try-params" placeholder="Query Parameters (contoh: id=1&search=nama)"
                            style="width: 100%;">
                    </div>
                    <div>
                        <textarea id="try-body" class="json-editor" placeholder='Body JSON untuk POST/PUT '></textarea>
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
                        <button class="example-btn" onclick="setExample('patients_detail')">👤 GET Patient by
                            ID</button>
                        <button class="example-btn" onclick="setExample('doctors')">👨‍⚕️ GET All Doctors</button>
                        <button class="example-btn" onclick="setExample('appointments')">📅 GET All
                            Appointments</button>
                        <button class="example-btn" onclick="setExample('post_patient')">➕ POST New Patient</button>
                        <button class="example-btn" onclick="setExample('post_doctor')">➕ POST New Doctor</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Hospital Management System - API Documentation & Data Management © 2026</p>
    </div>

    <!-- Modal Login / Register -->
    <div id="authModal" class="modal">
        <div class="modal-content">
            <div id="loginForm">
                <h2>🔐 Login</h2>
                <input type="text" id="loginUsername" placeholder="Username">
                <div class="password-wrapper">
                    <input type="password" id="loginPassword" placeholder="Password">
                    <span class="password-toggle" onclick="togglePassword('loginPassword', this)">👁️</span>
                </div>
                <button onclick="doLogin()">Login</button>
                <div class="switch-form">
                    Belum punya akun? <a onclick="showRegisterForm()">Daftar disini</a>
                </div>
                <div id="loginError" class="error-msg"></div>
            </div>
            <div id="registerForm" style="display: none;">
                <h2>📝 Daftar Akun Baru</h2>

                <input type="text" id="regFullname" placeholder="Nama Lengkap *" required>

                <input type="email" id="regEmail" placeholder="Email *" required>

                <input type="tel" id="regPhone" placeholder="Nomor Telepon (contoh: 08123456789)">

                <select id="regGender">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">👨 Laki-laki</option>
                    <option value="Perempuan">👩 Perempuan</option>
                </select>

                <input type="text" id="regUsername" placeholder="Username *" required>

                <div class="password-wrapper">
                    <input type="password" id="regPassword" placeholder="Password (min. 4 karakter) *" required>
                    <span class="password-toggle" onclick="togglePassword('regPassword', this)">👁️</span>
                </div>

                <select id="regRole">
                    <option value="staff">📋 Staff</option>
                    <option value="doctor">👨‍⚕️ Dokter</option>
                </select>

                <button onclick="doRegister()">Daftar</button>
                <button class="secondary" onclick="showLoginForm()">← Kembali ke Login</button>
                <div id="registerError" class="error-msg"></div>
                <div id="registerSuccess" class="success-msg"></div>
            </div>
        </div>
    </div>

    <script src="app.js"></script>
</body>

</html>
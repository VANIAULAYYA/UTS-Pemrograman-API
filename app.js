const BASE_URL = 'http://localhost/hospital_api';

// ============= UTILITY: ESCAPE HTML =============
function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// ============= UPDATE LANDING PAGE STATS =============
async function updateLandingStats() {
    try {
        const response = await fetch('api-info.php');
        const result = await response.json();

        if (result.success) {
            const totalEndpoints = result.data.total_endpoints;
            const httpMethods = result.data.http_methods;
            const totalResources = result.data.total_resources;
            const methodsList = result.data.methods_list.join(', ');

            const endpointsElem = document.getElementById('landing-total-endpoints');
            if (endpointsElem) endpointsElem.innerHTML = `${totalEndpoints} API Endpoints`;

            const methodsElem = document.getElementById('landing-http-methods');
            if (methodsElem) methodsElem.innerHTML = methodsList;

            const resourcesElem = document.getElementById('landing-total-resources');
            if (resourcesElem) resourcesElem.innerHTML = `${totalResources} Resources + Real-time`;

            console.log('✅ Landing page stats updated:', { totalEndpoints, httpMethods, totalResources });
        }
    } catch (err) {
        console.error('❌ Gagal update landing stats:', err);
    }
}

// ============= LOAD API STATS OTOMATIS DARI BACKEND =============
async function loadApiStats() {
    try {
        const response = await fetch('api-info.php');
        const result = await response.json();

        if (result.success) {
            const totalEndpoints = result.data.total_endpoints;
            const httpMethods = result.data.http_methods;
            const totalResources = result.data.total_resources;

            // Update stats cards di API Documentation & Try It Out
            const statsContainer = document.getElementById('stats-container');
            const currentTab = document.querySelector('.tab-content.active')?.id;

            if (currentTab === 'tab-api' || currentTab === 'tab-tryit') {
                if (statsContainer) {
                    statsContainer.innerHTML = `
                        <div class="stats">
                            <div class="stat-card endpoints">
                                <h2>${totalEndpoints}</h2>
                                <p>🔌 Total Endpoints</p>
                            </div>
                            <div class="stat-card methods">
                                <h2>${httpMethods}</h2>
                                <p>⚡ HTTP Methods</p>
                            </div>
                            <div class="stat-card resources">
                                <h2>${totalResources}</h2>
                                <p>📦 Total Resources</p>
                            </div>
                        </div>
                    `;
                }
            }

            // Update teks total-info di API Documentation tab
            const apiTotalInfo = document.querySelector('#tab-api .total-info');
            if (apiTotalInfo) {
                apiTotalInfo.innerHTML = `📊 <strong>${totalEndpoints} Endpoints</strong> | ${httpMethods} Methods | ${totalResources} Resources`;
            }

            // Update teks total-info di Try It Out tab
            const tryitTotalInfo = document.querySelector('#tab-tryit .total-info');
            if (tryitTotalInfo) {
                tryitTotalInfo.innerHTML = `📊 <strong>${totalEndpoints} Endpoints</strong> | ${httpMethods} Methods | ${totalResources} Resources`;
            }

            console.log('✅ API Stats loaded:', { totalEndpoints, httpMethods, totalResources });
        }
    } catch (err) {
        console.error('❌ Gagal load API stats:', err);
    }
}

// ============================================================
// SATU FUNGSI UTAMA: checkLoginStatus()
// ============================================================
function checkLoginStatus() {
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const landingPage = document.getElementById('landingPage');
    const dashboardContainer = document.getElementById('dashboard-container');
    const mainNavbar = document.getElementById('main-navbar');
    const apiKeyDisplay = document.getElementById('apiKeyDisplay');
    const userRoleDisplay = document.getElementById('userRoleDisplay');

    if (isLoggedIn && !localStorage.getItem('apiKey')) {
        localStorage.clear();
        location.reload();
        return;
    }

    if (isLoggedIn) {
        if (landingPage) landingPage.style.display = 'none';
        if (dashboardContainer) dashboardContainer.style.display = 'block';
        if (mainNavbar) mainNavbar.style.display = 'flex';

        const currentUser = localStorage.getItem('currentUser');
        const role = localStorage.getItem('userRole');
        const fullname = localStorage.getItem('userFullname');

        if (document.getElementById('username')) {
            document.getElementById('username').textContent = fullname || currentUser;
        }
        if (userRoleDisplay) {
            userRoleDisplay.textContent = role === 'doctor' ? '👨‍⚕️ Dokter' : (role === 'admin' ? '🛡️ Admin' : '📋 Staff');
        }

        loadPatients();
    } else {
        if (landingPage) landingPage.style.display = 'flex';
        if (dashboardContainer) dashboardContainer.style.display = 'none';
        if (mainNavbar) mainNavbar.style.display = 'none';
    }

    // ✅ TAMPILKAN API KEY DI BADGE (jika ada)
    if (apiKeyDisplay) {
        const currentKey = localStorage.getItem('apiKey');
        if (currentKey) {
            apiKeyDisplay.innerHTML = `🔑 ${currentKey.substring(0, 20)}... <span>📋</span>`;
        } else {
            apiKeyDisplay.innerHTML = `🔑 Belum ada API Key`;
        }
    }
}

function copyApiKey() {
    const apiKey = localStorage.getItem('apiKey');
    if (apiKey) {
        navigator.clipboard.writeText(apiKey).then(() => {
            showToast('✅ API Key berhasil disalin!');
        }).catch(() => {
            showToast('❌ Gagal menyalin API Key');
        });
    } else {
        showToast('Belum ada API Key, silakan login ulang');
    }
}

// ============= RENDER STATS CARD BERDASARKAN TAB =============
function renderStats(tabName) {
    const statsContainer = document.getElementById('stats-container');
    if (!statsContainer) return;

    if (tabName === 'patients') {
        statsContainer.innerHTML = `<div class="stats"><div class="stat-card patients"><h2 id="total-patients">-</h2><p>👤 Total Pasien</p></div></div>`;
        loadPatients();
    } else if (tabName === 'doctors') {
        statsContainer.innerHTML = `<div class="stats"><div class="stat-card doctors"><h2 id="total-doctors">-</h2><p>👨‍⚕️ Total Dokter</p></div></div>`;
        loadDoctors();
    } else {
        loadApiStats();
    }
}

// ============= TAB NAVIGATION =============
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    document.getElementById(`tab-${tabName}`).classList.add('active');
    event.target.classList.add('active');

    // 🔥 TAMBAHKAN INI - Panggil fungsi sesuai tab yang aktif
    if (tabName === 'patients') {
        loadPatients();
    } else if (tabName === 'doctors') {
        loadDoctors();
    }

    renderStats(tabName);
}

// ============= TRY IT OUT FUNCTIONS =============
function tryThisEndpoint(method, url, params, body) {
    // Pindah ke tab Try It Out
    showTab('tryit');

    // Set method
    document.getElementById('try-method').value = method;

    // Set URL (bersihkan dari params)
    let cleanUrl = url;
    if (params && (method === 'GET' || method === 'DELETE')) {
        // Hapus params dari URL jika ada (karena akan ditampung di kolom params terpisah)
        cleanUrl = url.split('?')[0];
    }
    document.getElementById('try-url').value = cleanUrl;

    // Set params
    document.getElementById('try-params').value = params || '';

    // Set body (format JSON biar rapi)
    if (body && body !== 'null') {
        try {
            // Jika body sudah dalam bentuk string, parse dulu
            let parsedBody = typeof body === 'string' ? JSON.parse(body) : body;
            document.getElementById('try-body').value = JSON.stringify(parsedBody, null, 2);
        } catch (e) {
            // Jika parse gagal, langsung tampilkan sebagai string
            document.getElementById('try-body').value = body;
        }
    } else {
        document.getElementById('try-body').value = '';
    }

    // Reset response area
    document.getElementById('response-area').style.display = 'none';

    // Scroll ke form
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
        headers: {
            'Content-Type': 'application/json'
        }
    };

    const apiKey = localStorage.getItem('apiKey');
    if (apiKey) {
        options.headers['x-api-key'] = apiKey;
    }

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

// ============= UTILITY: HIGHLIGHT =============
function highlightText(text, search) {
    if (text === null || text === undefined || text === '') return '-';
    const str = String(text);
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    let escapedText = str.replace(/[&<>"']/g, m => map[m]);

    if (!search) return escapedText;

    const escSearch = String(search).replace(/[&<>"']/g, m => map[m]).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escSearch})`, 'gi');
    return escapedText.replace(regex, '<mark class="highlight-search">$1</mark>');
}

// ============= LOAD PATIENTS =============
async function loadPatients(search = '') {
    const tbody = document.getElementById('patients-table');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7" class="loading">Memuat数据...</td</tr>';

    try {
        let url = `${BASE_URL}/patients/index.php`;
        if (search) url += `?search=${encodeURIComponent(search)}`;

        const headers = {};
        const apiKey = localStorage.getItem('apiKey');
        if (apiKey) headers['x-api-key'] = apiKey;

        const res = await fetch(url, { headers });
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
                <td>${i + 1}</td>
                <td><b>${highlightText(p.name, search)}</b></td>
                <td>${highlightText(p.nik, search)}</td>
                <td>${highlightText(p.birth_date, search)}</td>
                <td><span class="badge ${p.gender === 'Laki-laki' ? 'badge-male' : 'badge-female'}">${highlightText(p.gender, search)}</span></td>
                <td>${highlightText(p.phone, search) || '-'}</td>
                <td>${highlightText(p.address, search) || '-'}</td>
            </tr>
        `).join('');
    } catch (err) {
        console.error(err);
        tbody.innerHTML = '<tr><td colspan="7" class="empty">Gagal memuat data! Pastikan server berjalan.</td</tr>';
    }
}

// ============= LOAD DOCTORS =============
// ============= LOAD DOCTORS =============
async function loadDoctors(search = '') {
    const tbody = document.getElementById('doctors-table');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="4" class="loading">Memuat data...</td</tr>';

    try {
        let url = `${BASE_URL}/doctors/index.php`;
        if (search) url += `?search=${encodeURIComponent(search)}`;

        const headers = {};
        const apiKey = localStorage.getItem('apiKey');
        if (apiKey) headers['x-api-key'] = apiKey;

        const res = await fetch(url, { headers });
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
                <td>${i + 1}</td>
                <td><b>${escapeHtml(d.name)}</b></td>
                <td>${escapeHtml(d.specialization)}</td>
                <td>${escapeHtml(d.phone) || '-'}</td>
            </tr>
        `).join('');
    } catch (err) {
        console.error('Error loadDoctors:', err);
        tbody.innerHTML = '<tr><td colspan="4" class="empty">Gagal memuat data! Pastikan server berjalan.</td</tr>';
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

// ============= LOGIN SYSTEM =============
function showLoginModal() {
    document.getElementById('authModal').style.display = 'flex';
    showLoginForm();
}

function openRegisterDirectly() {
    document.getElementById('authModal').style.display = 'flex';
    showRegisterForm();
}

function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁️';
    }
}

function showLoginForm() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginError').textContent = '';
    document.getElementById('loginUsername').value = '';
    document.getElementById('loginPassword').value = '';
}

function showRegisterForm() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
    document.getElementById('registerError').textContent = '';
    document.getElementById('registerSuccess').textContent = '';
    document.getElementById('regFullname').value = '';
    document.getElementById('regEmail').value = '';
    document.getElementById('regPhone').value = '';
    document.getElementById('regGender').value = '';
    document.getElementById('regUsername').value = '';
    document.getElementById('regPassword').value = '';
}

function closeAuthModal() {
    document.getElementById('authModal').style.display = 'none';
    document.body.style.overflow = '';
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
            // ✅ PASTIKAN INI ADA SEMUA
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('currentUser', result.user.username);
            localStorage.setItem('userRole', result.user.role);
            localStorage.setItem('userFullname', result.user.fullname);
            localStorage.setItem('apiKey', result.user.api_key);     // ← INI PENTING
            localStorage.setItem('userId', result.user.id);         // ← INI PENTING

            // ✅ CEK DI CONSOLE
            console.log('API Key saved:', result.user.api_key);
            console.log('User ID saved:', result.user.id);

            closeAuthModal();
            checkLoginStatus();
            renderStats('patients');
            showToast('✅ Login berhasil!');
        } else {
            document.getElementById('loginError').textContent = result.message;
        }
    } catch (err) {
        console.error(err);
        document.getElementById('loginError').textContent = 'Terjadi kesalahan koneksi';
    }
}

async function doRegister() {
    const fullname = document.getElementById('regFullname').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const phone = document.getElementById('regPhone').value.trim();
    const gender = document.getElementById('regGender').value;
    const username = document.getElementById('regUsername').value.trim();
    const password = document.getElementById('regPassword').value;
    const role = document.getElementById('regRole').value;

    document.getElementById('registerError').textContent = '';
    document.getElementById('registerSuccess').textContent = '';

    if (!fullname || !email || !username || !password) {
        document.getElementById('registerError').textContent = 'Nama lengkap, email, username, dan password harus diisi!';
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('registerError').textContent = 'Format email tidak valid! Contoh: nama@domain.com';
        return;
    }

    if (password.length < 4) {
        document.getElementById('registerError').textContent = 'Password minimal 4 karakter!';
        return;
    }

    if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
        document.getElementById('registerError').textContent = 'Nomor telepon hanya boleh berisi angka, +, -, dan spasi!';
        return;
    }

    try {
        const response = await fetch('login_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'register',
                fullname: fullname,
                email: email,
                phone: phone,
                gender: gender,
                username: username,
                password: password,
                role: role
            })
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('registerSuccess').textContent = result.message;
            document.getElementById('loginUsername').value = username;

            document.getElementById('regFullname').value = '';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPhone').value = '';
            document.getElementById('regGender').value = '';
            document.getElementById('regUsername').value = '';
            document.getElementById('regPassword').value = '';

            setTimeout(() => {
                showLoginForm();
                document.getElementById('loginError').textContent = '✅ Akun berhasil dibuat! Silakan login.';
            }, 2000);
        } else {
            document.getElementById('registerError').textContent = result.message;
        }
    } catch (err) {
        console.error(err);
        document.getElementById('registerError').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
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
    btn.addEventListener('click', function () { handleCopy(this); });
});

window.onclick = (e) => { if (e.target === document.getElementById('authModal')) closeAuthModal(); };

// ==========================================
// INITIALIZE
// ==========================================
window.onload = () => {
    checkLoginStatus();
    if (localStorage.getItem('isLoggedIn') === 'true') {
        renderStats('patients');
    }
    loadApiStats();
    updateLandingStats();
};

// ============= PROFIL USER =============
async function showProfile() {
    const apiKey = localStorage.getItem('apiKey');
    const userId = localStorage.getItem('userId');

    if (!apiKey || !userId) {
        showToast('Silakan login terlebih dahulu');
        return;
    }

    try {
        const response = await fetch(`${BASE_URL}/users/detail.php?id=${userId}`, {
            headers: { 'x-api-key': apiKey }
        });
        const result = await response.json();

        if (result.success && result.data) {
            const user = result.data;

            document.getElementById('profileUsername').textContent = user.username || '-';
            document.getElementById('profileFullname').textContent = user.fullname || '-';
            document.getElementById('profileEmail').textContent = user.email || '-';
            document.getElementById('profilePhone').textContent = user.phone || '-';
            document.getElementById('profileGender').textContent = user.gender || '-';

            // Role dengan badge
            let roleText = user.role || 'staff';
            let roleBadge = '';
            if (roleText === 'admin') roleBadge = '<span class="profile-role-badge">🛡️ Admin</span>';
            else if (roleText === 'doctor') roleBadge = '<span class="profile-role-badge">👨‍⚕️ Dokter</span>';
            else roleBadge = '<span class="profile-role-badge">📋 Staff</span>';
            document.getElementById('profileRole').innerHTML = roleBadge;

            // Status dengan badge
            let statusBadge = user.is_active == 1
                ? '<span class="profile-status-badge">✅ Aktif</span>'
                : '<span class="profile-status-badge" style="background:#f8d7da; color:#721c24;">❌ Nonaktif</span>';
            document.getElementById('profileStatus').innerHTML = statusBadge;

            // Tanggal daftar
            if (user.created_at) {
                let date = new Date(user.created_at);
                document.getElementById('profileCreatedAt').textContent = date.toLocaleDateString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
                });
            } else {
                document.getElementById('profileCreatedAt').textContent = '-';
            }

            // API Key
            const apiKeyFull = user.api_key || 'Belum ada API Key';
            document.getElementById('profileApiKey').innerHTML = apiKeyFull;

            document.getElementById('profileModal').style.display = 'flex';
        } else {
            showToast('Gagal mengambil data profil');
        }
    } catch (err) {
        console.error(err);
        showToast('Terjadi kesalahan saat mengambil data profil');
    }
}

// ============= COPY API KEY DARI MODAL PROFIL =============
function copyProfileApiKey() {
    const apiKeyElement = document.getElementById('profileApiKey');
    if (apiKeyElement) {
        const apiKey = apiKeyElement.textContent;
        if (apiKey && apiKey !== 'Belum ada API Key') {
            navigator.clipboard.writeText(apiKey).then(() => {
                showToast('✅ API Key berhasil disalin!');
            }).catch(() => {
                showToast('❌ Gagal menyalin API Key');
            });
        } else {
            showToast('Tidak ada API Key untuk disalin');
        }
    }
}

// ============= TUTUP MODAL PROFIL =============
function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
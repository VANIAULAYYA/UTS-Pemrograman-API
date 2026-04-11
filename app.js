        const BASE_URL = 'http://localhost:3000';

        // ============================================================
        // SATU FUNGSI UTAMA: checkLoginStatus()
        // Mengatur Landing vs Dashboard, Navbar, dan info user
        // ============================================================
        function checkLoginStatus() {
            const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
            const landingPage = document.getElementById('landingPage');
            const dashboardContainer = document.getElementById('dashboard-container');
            const mainNavbar = document.getElementById('main-navbar');
            const apiKeyDisplay = document.getElementById('apiKeyDisplay');
            const userRoleDisplay = document.getElementById('userRoleDisplay');
            const userNameDisplay = document.getElementById('userNameDisplay');
            const loginBtn = document.getElementById('loginBtn');
            const logoutBtn = document.getElementById('logoutBtn');

            // Pastikan body selalu bisa di-scroll
            document.body.style.overflow = '';

            // Auto logout jika terdeteksi isLoggedIn tapi apiKey tidak ada (menyebabkan bug 401)
            if (isLoggedIn && !localStorage.getItem('apiKey')) {
                localStorage.clear();
                isLoggedIn = false;
            }

            if (isLoggedIn) {
                // === TAMPILAN DASHBOARD ===
                if (landingPage) landingPage.style.display = 'none';
                if (dashboardContainer) dashboardContainer.style.display = 'block';
                if (mainNavbar) mainNavbar.style.display = 'flex';

                // Info user di Profile Header
                const currentUser = localStorage.getItem('currentUser');
                const role = localStorage.getItem('userRole');
                const fullname = localStorage.getItem('userFullname');

                if (document.getElementById('username')) {
                    document.getElementById('username').textContent = fullname || currentUser;
                }
                if (userRoleDisplay) {
                    userRoleDisplay.textContent = role === 'doctor' ? '👨‍⚕️ Dokter' : (role === 'admin' ? '🛡️ Admin' : '📋 Staff');
                }

                // Load data pasien saat pertama kali
                loadPatients();
            } else {
                // === TAMPILAN LANDING PAGE ===
                if (landingPage) landingPage.style.display = 'flex';
                if (dashboardContainer) dashboardContainer.style.display = 'none';
                if (mainNavbar) mainNavbar.style.display = 'none';
            }

            // API Key display (with copy emoji)
            if (apiKeyDisplay) {
                const currentKey = localStorage.getItem('apiKey');
                if (currentKey) {
                    apiKeyDisplay.innerHTML = `🔑 ${currentKey} <span>📋</span>`;
                } else {
                    apiKeyDisplay.textContent = 'API KEY: -';
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
            }
        }

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
                headers: {
                    'Content-Type': 'application/json',
                    'x-api-key': localStorage.getItem('apiKey')
                }
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

        // ============= UTILITY: HIGHLIGHT KEREN =============
        function highlightText(text, search) {
            if (text === null || text === undefined || text === '') return '-';
            const str = String(text);

            // Escape basic HTML untuk mencegah XSS
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
            tbody.innerHTML = '<tr><td colspan="7" class="loading">Memuat data...</td></tr>';
            try {
                let url = `${BASE_URL}/patients/index.php`;
                if (search) url += `?search=${encodeURIComponent(search)}`;
                const res = await fetch(url, {
                    headers: {
                        'x-api-key': localStorage.getItem('apiKey')
                    }
                });
                const data = await res.json();

                const totalPatientsElem = document.getElementById('total-patients');
                if (totalPatientsElem) {
                    totalPatientsElem.textContent = data.data?.length || 0;
                }

                if (!data.data || data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="empty">Tidak ada data pasien</td></tr>';
                    return;
                }
                tbody.innerHTML = data.data.map((p, i) => `
                <tr>
                    <td>${i + 1}</td>
                    <td><b>${highlightText(p.name, search)}</b></td>
                    <td>${highlightText(p.nik, search)}</td>
                    <td>${highlightText(p.birth_date, search)}</td>
                    <td><span class="badge ${p.gender === 'Laki-laki' ? 'badge-male' : 'badge-female'}">${highlightText(p.gender, search)}</span></td>
                    <td>${highlightText(p.phone, search)}</td>
                    <td>${highlightText(p.address, search)}</td>
                </tr>
            `).join('');
            } catch (err) {
                tbody.innerHTML = '<tr><td colspan="7" class="empty">Gagal memuat data!</td></tr>';
            }
        }

        // ============= LOAD DOCTORS =============
        async function loadDoctors(search = '') {
            const tbody = document.getElementById('doctors-table');
            tbody.innerHTML = '<tr><td colspan="4" class="loading">Memuat data...</td></tr>';
            try {
                let url = `${BASE_URL}/doctors/index.php`;
                if (search) url += `?search=${encodeURIComponent(search)}`;
                const res = await fetch(url, {
                    headers: {
                        'x-api-key': localStorage.getItem('apiKey')
                    }
                });
                const data = await res.json();

                const totalDoctorsElem = document.getElementById('total-doctors');
                if (totalDoctorsElem) {
                    totalDoctorsElem.textContent = data.data?.length || 0;
                }

                if (!data.data || data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="empty">Tidak ada data dokter</td></tr>';
                    return;
                }
                tbody.innerHTML = data.data.map((d, i) => `
                <tr>
                    <td>${i + 1}</td>
                    <td><b>${highlightText(d.name, search)}</b></td>
                    <td>${highlightText(d.specialization, search)}</td>
                    <td>${highlightText(d.phone, search)}</td>
                </tr>
            `).join('');
            } catch (err) {
                tbody.innerHTML = '<tr><td colspan="4" class="empty">Gagal memuat data!</td></tr>';
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
            return str.replace(/[&<>"]/g, function (m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // ============= LOGIN SYSTEM =============

        // Buka modal + tampil form LOGIN
        function showLoginModal() {
            document.getElementById('authModal').style.display = 'flex';
            showLoginForm();
        }

        // Buka modal + tampil form REGISTER (langsung, tanpa lewat login)
        function showRegisterModal() {
            document.getElementById('authModal').style.display = 'flex';
            showRegisterForm();
        }

        // Alias: fungsi tunggal untuk tombol Daftar di Landing Page
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
        }

        function showRegisterForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('registerError').textContent = '';
            document.getElementById('registerSuccess').textContent = '';
            // Reset semua field
            document.getElementById('regFullname').value = '';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPhone').value = '';
            document.getElementById('regGender').value = '';
            document.getElementById('regUsername').value = '';
            document.getElementById('regPassword').value = '';
        }

        function closeAuthModal() {
            document.getElementById('authModal').style.display = 'none';
            // Pastikan scroll kembali normal
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
                    headers: {
                        'Content-Type': 'application/json',
                        'x-api-key': localStorage.getItem('apiKey')
                    },
                    body: JSON.stringify({ action: 'login', username, password })
                });
                const result = await response.json();
                if (result.success) {
                    localStorage.setItem('isLoggedIn', 'true');
                    localStorage.setItem('currentUser', result.user.username);
                    localStorage.setItem('userRole', result.user.role);
                    localStorage.setItem('userFullname', result.user.fullname);
                    localStorage.setItem('apiKey', result.user.api_key);
                    console.log("API KEY:", result.user.api_key);
                    closeAuthModal();
                    checkLoginStatus();
                    renderStats('patients');
                    showToast('✅ Login berhasil!');
                } else {
                    document.getElementById('loginError').textContent = result.message;
                }
            } catch (err) {
                document.getElementById('loginError').textContent = 'Terjadi kesalahan';
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

            // Reset error dan success
            document.getElementById('registerError').textContent = '';
            document.getElementById('registerSuccess').textContent = '';

            // Validasi field wajib
            if (!fullname || !email || !username || !password) {
                document.getElementById('registerError').textContent = 'Nama lengkap, email, username, dan password harus diisi!';
                return;
            }

            // Validasi email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('registerError').textContent = 'Format email tidak valid! Contoh: nama@domain.com';
                return;
            }

            if (password.length < 4) {
                document.getElementById('registerError').textContent = 'Password minimal 4 karakter!';
                return;
            }

            // Validasi nomor telepon (opsional, tapi jika diisi harus angka)
            if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
                document.getElementById('registerError').textContent = 'Nomor telepon hanya boleh berisi angka, +, -, dan spasi!';
                return;
            }

            try {
                const response = await fetch('login_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'x-api-key': localStorage.getItem('apiKey')
                    },
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
                    // Auto-fill ke form login
                    document.getElementById('loginUsername').value = username;
                    // Reset form register
                    document.getElementById('regFullname').value = '';
                    document.getElementById('regEmail').value = '';
                    document.getElementById('regPhone').value = '';
                    document.getElementById('regGender').value = '';
                    document.getElementById('regUsername').value = '';
                    document.getElementById('regPassword').value = '';
                    // Kembali ke form login setelah 2 detik
                    setTimeout(() => {
                        showLoginForm();
                        document.getElementById('loginError').textContent = '✅ Akun berhasil dibuat! Silakan login.';
                    }, 2000);
                } else {
                    document.getElementById('registerError').textContent = result.message;
                }
            } catch (err) {
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

        // Klik di luar modal untuk menutup
        window.onclick = (e) => { if (e.target === document.getElementById('authModal')) closeAuthModal(); };

        // ==========================================
        // JALANKAN SAAT HALAMAN DIBUKA (INITIALIZE)
        // ==========================================
        window.onload = () => {
            // 1. Cek status login (atur tampilan Landing/Dashboard/Navbar)
            checkLoginStatus();

            // 2. Jika sudah login, tampilkan statistik awal
            if (localStorage.getItem('isLoggedIn') === 'true') {
                renderStats('patients');
            }
        };
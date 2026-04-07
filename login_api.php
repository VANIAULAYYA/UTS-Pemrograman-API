<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    
    $action = $body['action'] ?? '';
    
    // ============ LOGIN ============
    if ($action === 'login') {
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Username dan password harus diisi!']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user' => [
                        'username' => $user['username'],
                        'fullname' => $user['fullname'],
                        'email' => $user['email'],
                        'phone' => $user['phone'],
                        'gender' => $user['gender'],
                        'role' => $user['role']
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Username atau password salah!']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem']);
        }
    }
    
    // ============ REGISTER ============
    elseif ($action === 'register') {
        $fullname = trim($body['fullname'] ?? '');
        $email = trim($body['email'] ?? '');
        $phone = trim($body['phone'] ?? '');
        $gender = $body['gender'] ?? '';
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';
        $role = $body['role'] ?? 'staff';
        
        // Validasi
        if (empty($fullname) || empty($email) || empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Nama lengkap, email, username, dan password harus diisi!']);
            exit();
        }
        
        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Format email tidak valid!']);
            exit();
        }
        
        // Validasi gender
        if (!in_array($gender, ['Laki-laki', 'Perempuan'])) {
            $gender = null;
        }
        
        if (strlen($password) < 4) {
            echo json_encode(['success' => false, 'message' => 'Password minimal 4 karakter!']);
            exit();
        }
        
        // Validasi role
        if (!in_array($role, ['admin', 'staff', 'doctor'])) {
            $role = 'staff';
        }
        
        try {
            // Cek apakah username sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Username sudah digunakan! Silakan pilih username lain.']);
                exit();
            }
            
            // Cek apakah email sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar! Silakan gunakan email lain.']);
                exit();
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, gender, username, password, role, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
            $stmt->execute([$fullname, $email, $phone, $gender, $username, $hashedPassword, $role]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.'
            ]);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    else {
        echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
}
?>
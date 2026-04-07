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
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';
        $role = $body['role'] ?? 'staff';
        
        // Validasi
        if (empty($fullname) || empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
            exit();
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
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, role, is_active) VALUES (?, ?, ?, ?, 1)");
            $stmt->execute([$fullname, $username, $hashedPassword, $role]);
            
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
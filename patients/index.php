<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, x-api-key, api_key, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../config/database.php';

// Validasi API Key (semua user bisa akses)
$provided_key = '';
if (function_exists('getallheaders')) {
    foreach (getallheaders() as $key => $value) {
        if (strtolower($key) === 'x-api-key') {
            $provided_key = $value;
            break;
        }
    }
}
if (!$provided_key) {
    $provided_key = $_SERVER['HTTP_X_API_KEY'] ?? $_GET['api_key'] ?? '';
}

if (!$provided_key) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Akses ditolak! API Key diperlukan.']);
    exit();
}

$stmt = $pdo->prepare("SELECT id, role, username FROM users WHERE api_key = ? AND is_active = 1");
$stmt->execute([$provided_key]);
$currentUser = $stmt->fetch();
if (!$currentUser) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'API Key tidak valid atau tidak aktif!']);
    exit();
}

// ✅ Semua user bisa akses (tanpa batasan role)

$method = $_SERVER['REQUEST_METHOD'];

// GET semua pasien / search pasien
if ($method === 'GET') {
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE name LIKE ? OR nik LIKE ? OR phone LIKE ? OR address LIKE ? ORDER BY name ASC");
        $term = "%$search%";
        $stmt->execute([$term, $term, $term, $term]);
    } else {
        $stmt = $pdo->query("SELECT * FROM patients ORDER BY name ASC");
    }

    $patients = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'total' => count($patients),
        'data' => $patients
    ]);
}

// POST tambah pasien baru
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    $name = $body['name'] ?? '';
    $nik = $body['nik'] ?? '';
    $birth_date = $body['birth_date'] ?? '';
    $gender = $body['gender'] ?? '';
    $phone = $body['phone'] ?? '';
    $address = $body['address'] ?? '';

    // Validasi wajib
    if (!$name || !$nik || !$birth_date || !$gender) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Field name, nik, birth_date, gender wajib diisi!']);
        exit();
    }

    // Validasi gender
    if (!in_array($gender, ['Laki-laki', 'Perempuan'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Gender harus Laki-laki atau Perempuan']);
        exit();
    }

    // Cek NIK sudah ada
    $stmt = $pdo->prepare("SELECT id FROM patients WHERE nik = ?");
    $stmt->execute([$nik]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'NIK sudah terdaftar!']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO patients (name, nik, birth_date, gender, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $nik, $birth_date, $gender, $phone, $address]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Pasien berhasil ditambahkan',
        'data' => [
            'id' => $pdo->lastInsertId(),
            'name' => $name,
            'nik' => $nik,
            'birth_date' => $birth_date,
            'gender' => $gender,
            'phone' => $phone,
            'address' => $address
        ]
    ]);
}

else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
}
?>

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

// ✅ Semua user bisa akses

$method = $_SERVER['REQUEST_METHOD'];

// GET semua dokter / search dokter
if ($method === 'GET') {
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE name LIKE ? OR specialization LIKE ? OR phone LIKE ? ORDER BY name ASC");
        $term = "%$search%";
        $stmt->execute([$term, $term, $term]);
    } else {
        $stmt = $pdo->query("SELECT * FROM doctors ORDER BY name ASC");
    }

    $doctors = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'total' => count($doctors),
        'data' => $doctors
    ]);
}

// POST tambah dokter
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    $name = $body['name'] ?? '';
    $specialization = $body['specialization'] ?? '';
    $phone = $body['phone'] ?? '';

    if (!$name || !$specialization) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Field name dan specialization wajib diisi!']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO doctors (name, specialization, phone) VALUES (?, ?, ?)");
    $stmt->execute([$name, $specialization, $phone]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Dokter berhasil ditambahkan',
        'data' => [
            'id' => $pdo->lastInsertId(),
            'name' => $name,
            'specialization' => $specialization,
            'phone' => $phone
        ]
    ]);
}

else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
}
?>

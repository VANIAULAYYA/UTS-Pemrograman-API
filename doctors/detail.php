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
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
    exit();
}

// GET dokter by ID
if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->execute([$id]);
    $doctor = $stmt->fetch();

    if (!$doctor) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Dokter tidak ditemukan']);
        exit();
    }

    echo json_encode(['success' => true, 'data' => $doctor]);
}

// PUT update dokter
elseif ($method === 'PUT') {
    $body = json_decode(file_get_contents('php://input'), true);

    $name = $body['name'] ?? null;
    $specialization = $body['specialization'] ?? null;
    $phone = $body['phone'] ?? null;

    if ($name === null && $specialization === null && $phone === null) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Tidak ada data yang diupdate']);
        exit();
    }

    $updates = [];
    $params = [];

    if ($name !== null) {
        $updates[] = "name = ?";
        $params[] = $name;
    }
    if ($specialization !== null) {
        $updates[] = "specialization = ?";
        $params[] = $specialization;
    }
    if ($phone !== null) {
        $updates[] = "phone = ?";
        $params[] = $phone;
    }

    $params[] = $id;
    $sql = "UPDATE doctors SET " . implode(", ", $updates) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['success' => true, 'message' => 'Dokter berhasil diupdate']);
}

// DELETE dokter
elseif ($method === 'DELETE') {
    $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Dokter berhasil dihapus']);
}

else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
}
?>

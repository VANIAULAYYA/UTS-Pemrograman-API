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

// --- VALIDASI API KEY (Tangguh/Robust) ---
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
$stmt = $pdo->prepare("SELECT id FROM users WHERE api_key = ? AND is_active = 1");
$stmt->execute([$provided_key]);
$user_exists = $stmt->fetch();
if (!$user_exists) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'API Key tidak valid atau tidak aktif!']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
    exit();
}

// PUT update status appointment
if ($method === 'PUT') {
    $body   = json_decode(file_get_contents('php://input'), true);
    $status = $body['status'] ?? null;

    if (!in_array($status, ['pending', 'done', 'cancelled'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Status tidak valid! Gunakan: pending, done, cancelled']);
        exit();
    }

    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo json_encode(['success' => true, 'message' => 'Status appointment berhasil diupdate']);
}
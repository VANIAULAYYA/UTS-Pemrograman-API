<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

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
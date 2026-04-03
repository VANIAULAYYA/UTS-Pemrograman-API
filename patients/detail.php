<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
    exit();
}

// GET pasien by ID
if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->execute([$id]);
    $patient = $stmt->fetch();

    if (!$patient) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Pasien tidak ditemukan']);
        exit();
    }

    echo json_encode(['success' => true, 'data' => $patient]);
}

// PUT update pasien
elseif ($method === 'PUT') {
    $body    = json_decode(file_get_contents('php://input'), true);

    $name       = $body['name'] ?? null;
    $phone      = $body['phone'] ?? null;
    $address    = $body['address'] ?? null;

    $stmt = $pdo->prepare("UPDATE patients SET name=?, phone=?, address=? WHERE id=?");
    $stmt->execute([$name, $phone, $address, $id]);

    echo json_encode(['success' => true, 'message' => 'Data pasien berhasil diupdate']);
}

// DELETE pasien
elseif ($method === 'DELETE') {
    $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Pasien berhasil dihapus']);
}
<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET semua dokter
if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM doctors");
    $doctors = $stmt->fetchAll();

    echo json_encode(['success' => true, 'data' => $doctors]);
}

// POST tambah dokter
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    $name           = $body['name'] ?? '';
    $specialization = $body['specialization'] ?? '';
    $phone          = $body['phone'] ?? '';

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
        'data'    => [
            'id'             => $pdo->lastInsertId(),
            'name'           => $name,
            'specialization' => $specialization,
            'phone'          => $phone,
        ]
    ]);
}
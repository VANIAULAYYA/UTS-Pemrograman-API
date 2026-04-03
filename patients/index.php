<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET semua pasien / search pasien
if ($method === 'GET') {
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM patients 
            WHERE name LIKE ? 
            OR nik LIKE ? 
            OR address LIKE ?");
        $stmt->execute(["%$search%", "%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM patients");
    }

    $patients = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'total'   => count($patients),
        'data'    => $patients
    ]);
}

// POST tambah pasien baru
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    $name       = $body['name'] ?? '';
    $nik        = $body['nik'] ?? '';
    $birth_date = $body['birth_date'] ?? '';
    $gender     = $body['gender'] ?? '';
    $phone      = $body['phone'] ?? '';
    $address    = $body['address'] ?? '';

    // Validasi sederhana
    if (!$name || !$nik || !$birth_date || !$gender) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Field name, nik, birth_date, gender wajib diisi!'
        ]);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO patients 
        (name, nik, birth_date, gender, phone, address) 
        VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->execute([$name, $nik, $birth_date, $gender, $phone, $address]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Pasien berhasil didaftarkan',
        'data'    => [
            'id'         => $pdo->lastInsertId(),
            'name'       => $name,
            'nik'        => $nik,
            'birth_date' => $birth_date,
            'gender'     => $gender,
            'phone'      => $phone,
            'address'    => $address,
        ]
    ]);
}
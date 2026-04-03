<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET semua appointments
if ($method === 'GET') {
    $stmt = $pdo->query("
        SELECT 
            a.id,
            p.name AS patient_name,
            d.name AS doctor_name,
            d.specialization,
            a.appointment_date,
            a.complaint,
            a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        JOIN doctors  d ON a.doctor_id  = d.id
    ");
    $appointments = $stmt->fetchAll();

    echo json_encode(['success' => true, 'data' => $appointments]);
}

// POST buat appointment baru
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    $patient_id       = $body['patient_id'] ?? '';
    $doctor_id        = $body['doctor_id'] ?? '';
    $appointment_date = $body['appointment_date'] ?? '';
    $complaint        = $body['complaint'] ?? '';
    $status           = $body['status'] ?? 'pending';

    if (!$patient_id || !$doctor_id || !$appointment_date) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Field patient_id, doctor_id, appointment_date wajib diisi!']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO appointments 
        (patient_id, doctor_id, appointment_date, complaint, status) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$patient_id, $doctor_id, $appointment_date, $complaint, $status]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Appointment berhasil dibuat',
        'data'    => ['id' => $pdo->lastInsertId()]
    ]);
}
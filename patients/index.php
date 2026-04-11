<?php
header("Content-Type: application/json");
include "../middleware.php"; 
include "../database.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE name LIKE ? OR nik LIKE ? OR phone LIKE ? OR address LIKE ? OR gender LIKE ? OR DATE_FORMAT(birth_date, '%Y-%m-%d') LIKE ?");
        $term = "%$search%";
        $stmt->execute([$term, $term, $term, $term, $term, $term]);
    } else {
        $stmt = $pdo->query("SELECT * FROM patients");
    }

    echo json_encode(["data"=>$stmt->fetchAll()]);
}

elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO patients (name,nik,birth_date,gender,phone,address) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $data['name'],
        $data['nik'],
        $data['birth_date'],
        $data['gender'],
        $data['phone'],
        $data['address']
    ]);

    echo json_encode(["message"=>"Pasien berhasil ditambahkan"]);
}
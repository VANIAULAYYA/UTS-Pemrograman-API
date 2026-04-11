<?php
header("Content-Type: application/json");
include "../middleware.php";
include "../database.php";

$id = $_GET['id'] ?? 0;
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch());
}

elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("UPDATE patients SET name=?, phone=?, address=? WHERE id=?");
    $stmt->execute([
        $data['name'],
        $data['phone'],
        $data['address'],
        $id
    ]);

    echo json_encode(["message"=>"Update berhasil"]);
}

elseif ($method === 'DELETE') {
    $stmt = $pdo->prepare("DELETE FROM patients WHERE id=?");
    $stmt->execute([$id]);

    echo json_encode(["message"=>"Data dihapus"]);
}
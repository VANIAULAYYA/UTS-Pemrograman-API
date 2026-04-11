<?php

$host     = 'localhost';
$db_name  = 'hospital_api';
$username = 'root';
<<<<<<< HEAD
$password = '110505'; // sesuaikan dengan password MySQL kamu
=======
$password = ''; // sesuaikan dengan password MySQL kamu
>>>>>>> aa3acdfd6e5f89490c261902a108835311ace018

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal: ' . $e->getMessage()
    ]);
    exit();
}
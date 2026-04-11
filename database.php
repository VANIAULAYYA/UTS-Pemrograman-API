<?php
$host     = 'localhost';
$db_name  = 'hospital_api';  // nama database di MySQL
$username = 'root';
<<<<<<< HEAD
$password = '110505'; // kosongkan jika tidak ada password
=======
$password = 'stlcf.l1ans'; // kosongkan jika tidak ada password
>>>>>>> aa3acdfd6e5f89490c261902a108835311ace018

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
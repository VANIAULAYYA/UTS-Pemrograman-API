<?php
header("Content-Type: application/json");
include "database.php";

$data = json_decode(file_get_contents("php://input"), true);

$action = $data['action'] ?? '';

if ($action === 'register') {
    $fullname = $data['fullname'];
    $email = $data['email'];
    $phone = $data['phone'];
    $gender = $data['gender'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $data['role'];

    // cek username
    $check = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $check->execute([$username]);
    if ($check->rowCount() > 0) {
        echo json_encode(["success"=>false,"message"=>"Username sudah digunakan"]);
        exit;
    }

    // generate API KEY
    $api_key = bin2hex(random_bytes(32));

    $stmt = $pdo->prepare("INSERT INTO users (fullname,email,phone,gender,username,password,role,api_key) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([$fullname,$email,$phone,$gender,$username,$password,$role,$api_key]);

    echo json_encode([
        "success"=>true,
        "message"=>"Register berhasil, silakan login"
    ]);
}

elseif ($action === 'login') {
    $username = $data['username'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success"=>true,
            "user"=>[
                "username"=>$user['username'],
                "fullname"=>$user['fullname'],
                "role"=>$user['role'],
                "api_key"=>$user['api_key']
            ]
        ]);
    } else {
        echo json_encode(["success"=>false,"message"=>"Login gagal"]);
    }
}
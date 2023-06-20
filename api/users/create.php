<?php
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];

$db = DB::connect();
$stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$obj = $stmt->fetch(PDO::FETCH_OBJ);

if ($obj) {
    echo json_encode(["message" => "User already exists!"]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$stmt = $db->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
$exec = $stmt->execute();

if ($exec) {
    echo json_encode(["message" => "User created!"]);
} else {
    echo json_encode(["message" => "Some error occurred and the user hasn't been created!"]);
}

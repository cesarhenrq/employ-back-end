<?php
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);
} else {
    echo json_encode(["message" => "Authorization header missing"]);
    exit;
}

$id = $param;

try {
    $decodedToken = JWT::decode($token, $secretJWT);
    $user_id = $decodedToken->id;

    $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $exec = $stmt->execute();

    if ($exec) {
        echo json_encode(["message" => "Task deleted!"]);
    } else {
        echo json_encode(["message" => "Some error occurred and the task hasn't been deleted!"]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Invalid token"]);
    exit;
}
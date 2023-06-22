<?php
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);
} else {
    echo json_encode(["message" => "Authorization header missing"]);
    exit;
}

try {
    $decodedToken = JWT::decode($token, $secretJWT);
    $user_id = $decodedToken->id;

    echo json_encode(["message"] => "Passou aqui"]);
    $stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    echo json_encode(["message"] => "Passou aqui"]);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    echo json_encode(["message"] => "Passou aqui"]);
    $stmt->execute();
    echo json_encode(["message"] => "Passou aqui"]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["message"] => "Passou aqui"]);

    if ($tasks) {
        echo json_encode(["data" => $tasks]);
    } else {
        echo json_encode(["data" => "No tasks found for this user!"]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Invalid token"]);
    exit;
}

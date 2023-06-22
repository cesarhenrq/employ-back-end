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

    echo json_encode(["id" => $user_id]);

    $currentPage = $_GET['page'] ?? 1;
    $pageSize = $_GET['size'] ?? 10;

    $stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = :user_id LIMIT :limit OFFSET :offset");
    echo json_encode(["message" => "passou 1"]);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    echo json_encode(["message" => "passou 2"]);
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    echo json_encode(["message" => "passou 3"]);
    $stmt->bindValue(':offset', ($currentPage - 1) * $pageSize, PDO::PARAM_INT);
    echo json_encode(["message" => "passou 4"]);
    $stmt->execute();
    echo json_encode(["message" => "passou 5"]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["message" => "passou 6"]);

    if ($tasks) {
        echo json_encode(["data" => $tasks]);
    } else {
        echo json_encode(["data" => "No tasks found for this user!"]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Invalid token"]);
    exit;
}

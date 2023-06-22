<?php
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);
} else {
    echo json_encode(["message" => "Authorization header missing"]);
    exit;
}

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

if($data) {
    $title = $data['title'];
    $description = $data['description'];
    $status = $data['status'];
    $id = $param;

    try {
        $decodedToken = JWT::decode($token, $secretJWT);
        $user_id = $decodedToken->id;

        $db = DB::connect();

        $stmt = $db->prepare("UPDATE tasks SET title = :title, description = :description, status = :status WHERE id = :id AND user_id = :user_id");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $exec = $stmt->execute();

        if ($exec) {
            echo json_encode(["message" => "Task updated!"]);
        } else {
            echo json_encode(["message" => "Some error occurred and the task hasn't been updated!"]);
        }
    } catch (Exception $e) {
        echo json_encode(["message" => "Invalid token"]);
        exit;
    }
} else {
    echo json_encode(["message" => "Further information required!"]);
    exit;
}

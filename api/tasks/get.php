<?php
$user_id = JWT::decode($headers['authorization'], $secretJWT)->id;

$db = DB::connect();
$stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($tasks) {
  echo json_encode(["data" => $tasks]);
} else {
  echo json_encode(["data"  => "No tasks found for this user!"]);
}
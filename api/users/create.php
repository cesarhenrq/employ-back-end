<?php
$sql = "INSERT INTO users (";

$count = 1;
foreach (array_keys($_POST) as $key) {
    if (count($_POST) > $count) {
        $sql .= "{$key},";
    } else {
        $sql .= "{$key}";
    }
    $count++;
}

$sql .= ") VALUES (";

$count = 1;
foreach (array_values($_POST) as $value) {
    if (count($_POST) > $count) {
        $sql .= "'{$value}',";
    } else {
        $sql .= "'{$value}'";
    }
    $count++;
}

$sql .= ")";

$db = DB::connect();
$stmt = $db->prepare($sql);
$exec = $stmt->execute();

if ($exec) {
    echo json_encode(["message" => "User created!"]);
} else {
    echo json_encode(["message" => "Some error occurred and the user hasn't been created!"]);
}
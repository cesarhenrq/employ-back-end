<?php
  $db = DB::connect();
  $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
  $stmt->bindValue(':email', $param, PDO::PARAM_STR);
  $stmt->execute();
  $obj = $stmt->fetch(PDO::FETCH_OBJ);

  if ($obj) {
    echo json_encode(["data" => $obj]);
  } else {
    echo json_encode(["data"  => "User doesn't exist!"]);
  }
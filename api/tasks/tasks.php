<?php
   if ($api == 'tasks') {
    if (Users::verify()) {
        if ($method == 'GET' && $action == 'get') {
            include_once 'get.php';
        } elseif ($method == 'POST' && $action == 'create') {
            include_once 'create.php';
        } elseif ($method == 'POST' && $action == 'update') {
            include_once 'update.php';
        } elseif ($method == 'POST' && $action == 'delete' && $param) {
            include_once 'delete.php';
        } else {
            echo json_encode(["message" => "Invalid request"]);
        }
    }
    
}
?>
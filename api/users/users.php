<?php
 if ($api == 'users') {
    if ($method == 'GET' && $action == 'get' && $param) {
       include_once "get.php";
    } elseif ($method == 'POST' && $action == 'create') {
       include_once "create.php";
    } elseif ($method == 'POST' && $action == 'login') {
       include_once "login.php";
    } else {
        echo "Path doesn't exist!";
    }
}
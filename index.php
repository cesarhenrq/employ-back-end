<?php
header('Acess-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('America/Sao_Paulo');

if (isset($_GET['path'])) { $path = explode('/', $_GET['path']);} else {echo "caminho não existe"; exit;}

if(isset($path[0])) { $api = $path[0]; } else { echo "caminho não existe"; exit;}

if(isset($path[1])) { $action = $path[1]; } else { $action=''; }

if(isset($path[2])) { $param = $path[2]; } else { $param=''; }

$method = $_SERVER['REQUEST_METHOD'];

include_once "classes/db.class.php";
include_once "api/users/users.php";
include_once "api/tasks/tasks.php";

?>
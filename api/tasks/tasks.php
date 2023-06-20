<?php
   if ($api == 'tasks') {
    if (Users::verify()) {
        if ($method == 'GET' && $action == 'get') {
            include_once 'get.php';
        }
    }
    
}
?>
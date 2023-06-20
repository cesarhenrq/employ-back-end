<?php
 if ($api == 'users') {
    if ($method == 'GET') {
        var_dump("it works!");
        $rs = $db->prepare("SELECT * FROM users ORDER BY name");
    }
}
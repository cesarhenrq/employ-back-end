<?php
class DB
{
    public static function connect()
    {
        $host = 'containers-us-west-160.railway.app';
        $user = 'root';
        $password = 'gNEyS1NjVZ5PMRhiet32';
        $db_name = 'railway';
        $port = '6852';

        return new PDO("mysql:host={$host};port={$port};dbname={$db_name};charset=UTF8;", $user, $password);
    }
}
?>
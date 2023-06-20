<?php

class Users
{
    public function login()
    {
        if ($_POST) {
            if (!$_POST['email'] OR !$_POST['password']) {
                echo json_encode(['ERROR' => 'Futher information required!']); exit; 
            } else {
                $email = addslashes(htmlspecialchars($_POST['email'])) ?? '';
                $password = addslashes(htmlspecialchars($_POST['password'])) ?? '';
                $secretJWT = $GLOBALS['secretJWT'];

                $db = DB::connect();
                $rs = $db->prepare("SELECT * FROM users WHERE email = '{$email}'");
                $exec = $rs->execute();
                $obj = $rs->fetchObject();
                $rows = $rs->rowCount();

                if ($rows > 0) {
                    $idDB          = $obj->id;
                    $nameDB        = $obj->name;
                    $passDB        = $obj->password;
                    $validUsername = true; 
                    $validPassword = password_verify($password, $passDB) ? true : false;
                } else {
                    $validUsername = false;
                    $validPassword = false;
                }

                if ($validUsername and $validPassword) {
                    //$nextWeek = time() + (7 * 24 * 60 * 60);
                    $expire_in = time() + 60000;
                    $token     = JWT::encode([
                        'id'         => $idDB,
                        'name'       => $nameDB,
                        'expires_in' => $expire_in,
                    ], $GLOBALS['secretJWT']);

                    echo json_encode(['token' => $token, 'data' => JWT::decode($token, $secretJWT)]);
                } else {
                    if (!$validPassword) {
                        echo json_encode(['ERROR', 'invalid password!']);
                    }
                }
            }
        } else {
            echo json_encode(['ERROR' => 'Futher information required!']); exit; 
        }

    }

    public function verify()
    {
        $headers = apache_request_headers();
        if (isset($headers['authorization'])) {
            $token = str_replace("Bearer ", "", $headers['authorization']);
        } else {
            echo json_encode(['ERROR' => 'You are not authorized!']);
            exit;
        }

        $secretJWT = $GLOBALS['secretJWT'];

        if ($token) :          
            $decodedJWT = JWT::decode($token, $secretJWT);
            if ($decodedJWT->expires_in > time()) {
                return true;
            } else {
                return false;
            }
        else :
            return false;
        endif;
    }
}

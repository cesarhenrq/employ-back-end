<?php
class Users
{
    public static function login()
    {
        $requestBody = file_get_contents('php://input');
        $data = json_decode($requestBody, true);
        
        if ($data) {
            if (!isset($data['email']) || !isset($data['password'])) {
                echo json_encode(['ERROR' => 'Further information required!']);
                exit;
            } else {
                $email = $data['email'];
                $password = $data['password'];
                $secretJWT = $GLOBALS['secretJWT'];

                $db = DB::connect();
                $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $obj = $stmt->fetchObject();
                $rows = $stmt->rowCount();

                if ($rows > 0) {
                    $idDB = $obj->id;
                    $nameDB = $obj->name;
                    $passDB = $obj->password;
                    $validUsername = true;
                    $validPassword = password_verify($password, $passDB);
                } else {
                    $validUsername = false;
                    $validPassword = false;
                }

                if ($validUsername && $validPassword) {
                    $expire_in = time() + 60000;
                    $token = JWT::encode([
                        'id' => $idDB,
                        'name' => $nameDB,
                        'expires_in' => $expire_in,
                    ], $secretJWT);

                    echo json_encode(['token' => $token, 'data' => JWT::decode($token, $secretJWT)]);
                } else {
                    if (!$validPassword) {
                        echo json_encode(['ERROR' => 'Invalid password!']);
                    }
                }
            }
        } else {
            echo json_encode(['ERROR' => 'Further information required!']);
            exit;
        }
    }

    public static function verify()
    {
        $headers = getallheaders();
        if (isset($headers['authorization'])) {
            $token = str_replace("Bearer ", "", $headers['authorization']);
        } else {
            echo json_encode(['ERROR' => 'You are not authorized!']);
            exit;
        }

        $secretJWT = $GLOBALS['secretJWT'];

        if ($token) {
            $decodedJWT = JWT::decode($token, $secretJWT);
            if ($decodedJWT->expires_in > time()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

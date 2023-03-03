<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/config/Database.php');
require_once($root . '/class/User.php');
require_once($root . '/api/SimpleRest.php');
require($root . '/vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserRestHandler extends SimpleRest
{
    public function encode_json($res_data)
    {
        $json_res = json_encode($res_data);
        return $json_res;
    }

    public function getAllUsers()
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            $rawData = $user->getAllUsers();
            if (empty($rawData)) {
                $statusCode = 404;
                $rawData = array('error' => 'No users found!');
            } else {
                $statusCode = 200;
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to get user!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }

    public function getUser($username)
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            if (empty($username)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing username!');
            } else {
                $rawData = $user->getSingleUser($username);
                if (empty($rawData)) {
                    $statusCode = 404;
                    $rawData = array('error' => 'No user found!');
                } else {
                    $statusCode = 200;
                }
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to get user!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }

    public function deleteUser($username)
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            if (empty($username)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing username!');
            } else {
                $rawData = $user->deleteUser($username);
                $statusCode = 200;
                $rawData = array('success' => 'User deleted successfully!');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to delete user!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }

    public function updateUser($username, $userEmail)
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            if (empty($username)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing username!');
            } else if (empty($userEmail)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing email!');
            } else {
                $rawData = $user->updateUser($username, $userEmail);
                $statusCode = 200;
                $rawData = array('success' => 'User updated successfully!');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to update user!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }

    public function createUser($username, $userPassword, $userEmail)
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            if (empty($username)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing username!');
            } else if (empty($userPassword)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing password!');
            } else if (empty($userEmail)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing email!');
            } else {
                $rawData = $user->createUser($username, $userPassword, $userEmail);
                $statusCode = 201;
                $rawData = array('success' => 'User created successfully!');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to create user!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }

    public function login($username, $password)
    {
        try {
            $db = new Database();
            $user = new User($db->getConnection());
            if (empty($username)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing username!');
            } else if (empty($password)) {
                $statusCode = 400;
                $rawData = array('error' => 'Missing password!');
            } else {
                $rawData = $user->getAdmin2($username, $password);
                if (empty($rawData)) {
                    $statusCode = 404;
                    $rawData = array('error' => 'Login Failed!');
                } else {
                    $statusCode = 200;
                }
            }
            $token = $rawData;
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json(array(
                "message" => "Successful login.",
                "token" => $token
            ));
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Login Failed!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }
    public function validateToken($token, $secret_key)
    {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS512'));
        $decoded_array = (array) $decoded;
        return $decoded_array;
    }
    public function protectedAPI($token, $secret_key)
    {
        try {
            $rawData = $this->validateToken($token, $secret_key);
            if (empty($rawData)) {
                $statusCode = 401;
                $rawData = array('error' => 'Unauthorized!');
            } else {
                $statusCode = 200;
                $rawData = array('success' => 'Authorized!');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        } catch (Exception $e) {
            $statusCode = 400;
            $rawData = array('error' => 'Fail to validate token!');
            $this->setHttpHeaders($statusCode, $method);
            $response = $this->encode_json($rawData);
            echo $response;
        }
    }
}

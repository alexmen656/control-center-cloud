<?php
require_once 'DB.php';

class User {
    private $users = [];

    public function __construct() {
       /* $this->users = [
            ['username' => 'admin', 'password' => 'admin123', 'role' => 'admin'],
            ['username' => 'user', 'password' => 'user123', 'role' => 'user'],
        ];*/
    }

    public function listUsers() {
        $db = new Database();
        $sql = "SELECT username, role FROM control_cloud_users";
        return $db->fetchAll($sql);
    }

    public function generateJWT($username, $role) {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode(['username' => $username, 'role' => $role, 'iat' => time()]));
        $signature = hash_hmac('sha256', "$header.$payload", 'secret_key', true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    public function verifyJWT($token) {
        list($header, $payload, $signature) = explode('.', $token);
        $expectedSignature = base64_encode(hash_hmac('sha256', "$header.$payload", 'secret_key', true));
        return hash_equals($expectedSignature, $signature);
    }

    public function decodeJWT($token) {
        list($header, $payload, $signature) = explode('.', $token);
        return json_decode(base64_decode($payload), true);
    }

    public function authenticate($username, $password) {
      $db = new Database();
      $username = $db->escape($username);
      $password = $db->escape($password);

        $sql = "SELECT * FROM control_cloud_users WHERE username = '$username' AND password = '$password'";
        $user = $db->fetchOne($sql);

        if ($user) {
            return $this->generateJWT($user['username'], $user['role']);
        }
        return false;
    }

    public function register($username, $password, $role = 'user') {
        $db = new Database();
        $username = $db->escape($username);
        $password = $db->escape($password);
        $role = $db->escape($role);

        $sql = "INSERT INTO control_cloud_users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($db->query($sql)) {
            return true;
        }
        return false;
    }
}
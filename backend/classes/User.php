<?php
require_once 'DB.php';

class User
{
    private $users = [];

    public function __construct()
    {
        /* $this->users = [
             ['username' => 'admin', 'password' => 'admin123', 'role' => 'admin'],
             ['username' => 'user', 'password' => 'user123', 'role' => 'user'],
         ];*/
    }

    public function listUsers()
    {
        $db = new Database();
        $sql = "SELECT id, full_name, username, email, role FROM control_cloud_users";
        return $db->fetchAll($sql);
    }

    public function generateJWT($username, $role)
    {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode(['username' => $username, 'role' => $role, 'iat' => time()]));
        $signature = hash_hmac('sha256', "$header.$payload", 'secret_key', true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    public function verifyJWT($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        $expectedSignature = base64_encode(hash_hmac('sha256', "$header.$payload", 'secret_key', true));
        return hash_equals($expectedSignature, $signature);
    }

    public function decodeJWT($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        return json_decode(base64_decode($payload), true);
    }

    public function authenticate($username, $password)
    {
        $db = new Database();
        $username = $db->escape($username);
        $password = $db->escape($password);

        // Allow login with either username or email
        $sql = "SELECT * FROM control_cloud_users WHERE (username = '$username' OR email = '$username') AND password = '$password'";
        $user = $db->fetchOne($sql);

        if ($user) {
            return $this->generateJWT($user['username'], $user['role']);
        }
        return false;
    }

    public function register($username, $email, $password, $fullName = '', $role = 'user')
    {
        $db = new Database();
        $username = $db->escape($username);
        $email = $db->escape($email);
        $password = $db->escape($password);
        $fullName = $db->escape($fullName);
        $role = $db->escape($role);

        $checkSql = "SELECT id FROM control_cloud_users WHERE username = '$username' OR email = '$email'";
        $existing = $db->fetchOne($checkSql);

        if ($existing) {
            return false;
        }

        $sql = "INSERT INTO control_cloud_users (full_name, username, email, password, role) VALUES ('$fullName', '$username', '$email', '$password', '$role')";
        if ($db->query($sql)) {
            return true;
        }
        return false;
    }

    public function findByEmail($email)
    {
        $db = new Database();
        $email = $db->escape($email);
        $sql = "SELECT * FROM control_cloud_users WHERE email = '$email'";
        return $db->fetchOne($sql);
    }

    public function registerGoogleUser($email, $name, $googleId)
    {
        $db = new Database();
        $email = $db->escape($email);
        $name = $db->escape($name);
        $googleId = $db->escape($googleId);

        $existingUser = $this->findByEmail($email);
        if ($existingUser) {
            if (empty($existingUser['google_id']) && !empty($googleId)) {
                $userId = $existingUser['id'];
                $updateSql = "UPDATE control_cloud_users SET google_id = '$googleId' WHERE id = $userId";
                $db->query($updateSql);
            }
            return $this->generateJWT($existingUser['username'], $existingUser['role']);
        }

        $username = explode('@', $email)[0];

        $originalUsername = $username;
        $counter = 1;
        $checkSql = "SELECT id FROM control_cloud_users WHERE username = '$username'";
        while ($db->fetchOne($checkSql)) {
            $username = $originalUsername . $counter;
            $counter++;
            $checkSql = "SELECT id FROM control_cloud_users WHERE username = '$username'";
        }

        $sql = "INSERT INTO control_cloud_users (full_name, username, email, password, role, google_id) VALUES ('$name', '$username', '$email', '', 'user', '$googleId')";
        if ($db->query($sql)) {
            return $this->generateJWT($username, 'user');
        }
        return false;
    }

    public function authenticateGoogle($email)
    {
        $user = $this->findByEmail($email);
        if ($user) {
            return $this->generateJWT($user['username'], $user['role']);
        }
        return false;
    }
}
<?php

class User {
    private $users = [];

    public function __construct() {
        $this->users = [
            ['username' => 'admin', 'password' => 'admin123', 'role' => 'admin'],
            ['username' => 'user', 'password' => 'user123', 'role' => 'user'],
        ];
    }

    public function listUsers() {
        return array_map(function($user) {
            return ['username' => $user['username'], 'role' => $user['role']];
        }, $this->users);
    }

    public function generateJWT($username, $role) {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode(['username' => $username, 'role' => $role, 'iat' => time()]));
        $signature = hash_hmac('sha256', "$header.$payload", 'secret_key', true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    public function authenticate($username, $password) {
        foreach ($this->users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                return $this->generateJWT($username, $user['role']);
            }
        }
        return false;
    }
}
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

include_once 'classes/User.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
} elseif ($method === 'GET') {
    $user = new User();
    echo json_encode($user->listUsers());
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action']) && $data['action'] === 'login' && isset($data['username']) && isset($data['password']) && $data['password'] !== '') {
        $user = new User();
        $jwt = $user->authenticate($data['username'], $data['password']);
        if ($jwt) {
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    } elseif (isset($data['action']) && $data['action'] === 'google-login' && isset($data['email'])) {
        $user = new User();
        $name = isset($data['name']) ? $data['name'] : $data['email'];
        $googleId = isset($data['googleId']) ? $data['googleId'] : '';
        $jwt = $user->registerGoogleUser($data['email'], $name, $googleId);
        if ($jwt) {
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Google login failed']);
        }
    } elseif (isset($data['action']) && $data['action'] === 'register' && isset($data['email']) && isset($data['password']) && isset($data['fullName'])) {
        $user = new User();
        $username = isset($data['username']) ? $data['username'] : explode('@', $data['email'])[0];
        $fullName = isset($data['fullName']) ? $data['fullName'] : '';
        $success = $user->register($username, $data['email'], $data['password'], $fullName, 'user');
        if ($success) {
            echo json_encode(['message' => 'User registered successfully']);
        } else {
            http_response_code(409);
            echo json_encode(['message' => 'User with this email or username already exists']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Required fields are missing']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
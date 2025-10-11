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
    if (isset($data['action']) && $data['action'] === 'login' && isset($data['username']) && isset($data['password'])) {
        $user = new User();
        $jwt = $user->authenticate($data['username'], $data['password']);
        if ($jwt) {
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    } elseif (isset($data['action']) && $data['action'] === 'register' && isset($data['username']) && isset($data['password'])) {
        $user = new User();
        $success = $user->register($data['username'], $data['password'], 'user');
        if ($success) {
            echo json_encode(['message' => 'User registered successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Registration failed']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Username and password are required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
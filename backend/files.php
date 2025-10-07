<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

include_once 'classes/FileManager.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
} elseif ($method === 'GET') {
    $fileManager = new FileManager(__DIR__ . '/uploads');
    //echo json_encode($fileManager->listFiles());
    echo json_encode($fileManager->listFilesRecursive());
} elseif ($method === 'POST' && isset($_FILES['file'])) {
    $fileManager = new FileManager(__DIR__ . '/uploads');
    if ($fileManager->uploadFile($_FILES['file'])) {
        http_response_code(201);
        echo json_encode(['message' => 'File uploaded successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'File upload failed']);
    }
} elseif ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    if (isset($deleteVars['filename'])) {
        $fileManager = new FileManager(__DIR__ . '/uploads');
        if ($fileManager->deleteFile($deleteVars['filename'])) {
            echo json_encode(['message' => 'File deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'File not found']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Filename is required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
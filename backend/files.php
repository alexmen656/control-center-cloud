<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

include_once 'classes/FileManager.php';
include_once 'classes/User.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
} elseif ($method === 'GET') {
    if($_GET['action'] === 'get_drive' && isset($_GET['drive'])){
        $user = new User();
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            if($user->verifyJWT($token)){
                $decoded = $user->decodeJWT($token);
                $username = $decoded['username'];
                $drive = $_GET['drive'] ?? 'default';

                //echo __DIR__ . '/uploads'.'/'.$username;
                $fileManager = new FileManager(__DIR__ . '/uploads'.'/'.$username .'/'.$drive);
                echo json_encode($fileManager->listFilesRecursive());
            }else{
                http_response_code(401);
                echo json_encode(['message' => 'Invalid token']);
            }   
        }else{
            http_response_code(401);
            echo json_encode(['message' => 'Authorization header missing']);
        }
    }elseif($_GET['action'] === 'get_file_contents' && isset($_GET['drive']) && isset($_GET['file'])){
        $user = new User();
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            if($user->verifyJWT($token)){
                $decoded = $user->decodeJWT($token);
                $username = $decoded['username'];
                $drive = $_GET['drive'] ?? 'default';
                $file = $_GET['file'];
                //echo __DIR__ . '/uploads'.'/'.$username;
                $fileManager = new FileManager(__DIR__ . '/uploads'.'/'.$username .'/'.$drive);
                $content = $fileManager->getFileContents($file);
                
                if($content !== false){
                    $filePath = __DIR__ . '/uploads'.'/'.$username .'/'.$drive.'/'.$file;
                    $mimeType = mime_content_type($filePath);
                    
                    echo json_encode([
                        'content' => base64_encode($content),
                        'mime_type' => $mimeType,
                        'filename' => basename($file),
                        'size' => filesize($filePath)
                    ]);
                }else{
                    http_response_code(404);
                    echo json_encode(['message' => 'File not found']);
                }
            }else{
                http_response_code(401);
                echo json_encode(['message' => 'Invalid token']);
            }
        }else{
            http_response_code(401);
            echo json_encode(['message' => 'Authorization header missing']);
        }
    }else{
   $fileManager = new FileManager(__DIR__ . '/uploads');
    //echo json_encode($fileManager->listFiles());
    echo json_encode($fileManager->listFilesRecursive());
    }
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
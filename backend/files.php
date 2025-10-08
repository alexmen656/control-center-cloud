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
    if($_GET['action'] === 'get_drives'){
        $user = new User();
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            if($user->verifyJWT($token)){
                $decoded = $user->decodeJWT($token);
                $username = $decoded['username'];
                
                $userDir = __DIR__ . '/uploads/'.$username;
                if(!is_dir($userDir)){
                    mkdir($userDir, 0777, true);
                    mkdir($userDir . '/default', 0777, true);
                }
                
                $drives = [];
                $items = scandir($userDir);
                foreach($items as $item){
                    if($item != '.' && $item != '..' && is_dir($userDir . '/' . $item)){
                        $drives[] = $item;
                    }
                }
                
                if(empty($drives)){
                    $drives = ['default'];
                    mkdir($userDir . '/default', 0777, true);
                }
                
                echo json_encode($drives);
            }else{
                http_response_code(401);
                echo json_encode(['message' => 'Invalid token']);
            }   
        }else{
            http_response_code(401);
            echo json_encode(['message' => 'Authorization header missing']);
        }
    }elseif($_GET['action'] === 'get_drive' && isset($_GET['drive'])){
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
} elseif ($method === 'POST') {
    $user = new User();
    $headers = getallheaders();
    
    if(!isset($headers['Authorization'])){
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header missing']);
        exit;
    }
    
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    if(!$user->verifyJWT($token)){
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        exit;
    }
    
    $decoded = $user->decodeJWT($token);
    $username = $decoded['username'];
    
    // Handle file upload
    if(isset($_FILES['file'])) {
        $fileManager = new FileManager(__DIR__ . '/uploads');
        if ($fileManager->uploadFile($_FILES['file'])) {
            http_response_code(201);
            echo json_encode(['message' => 'File uploaded successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'File upload failed']);
        }
    } else {
        // Handle create drive
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data['action']) && $data['action'] === 'create_drive' && isset($data['drive_name'])){
            $driveName = preg_replace('/[^a-zA-Z0-9_-]/', '', $data['drive_name']);
            
            if(empty($driveName)){
                http_response_code(400);
                echo json_encode(['message' => 'Invalid drive name']);
                exit;
            }
            
            $userDir = __DIR__ . '/uploads/'.$username;
            
            // Check number of existing drives
            $drives = [];
            if(is_dir($userDir)){
                $items = scandir($userDir);
                foreach($items as $item){
                    if($item != '.' && $item != '..' && is_dir($userDir . '/' . $item)){
                        $drives[] = $item;
                    }
                }
            }
            
            if(count($drives) >= 3){
                http_response_code(400);
                echo json_encode(['message' => 'Maximum of 3 drives allowed']);
                exit;
            }
            
            $driveDir = $userDir . '/' . $driveName;
            
            if(is_dir($driveDir)){
                http_response_code(400);
                echo json_encode(['message' => 'Drive already exists']);
                exit;
            }
            
            if(mkdir($driveDir, 0777, true)){
                http_response_code(201);
                echo json_encode(['message' => 'Drive created successfully', 'drive_name' => $driveName]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to create drive']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid request']);
        }
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
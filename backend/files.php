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
                $files = $fileManager->listFilesRecursive();
                
                // Load starred files
                $starredFile = __DIR__ . '/uploads/'.$username.'/starred.json';
                $starredMap = [];
                if(file_exists($starredFile)){
                    $starred = json_decode(file_get_contents($starredFile), true);
                    if(is_array($starred)){
                        foreach($starred as $item){
                            if($item['drive'] === $drive){
                                $starredMap[$item['file_path']] = true;
                            }
                        }
                    }
                }
                
                // Add starred status to files
                foreach($files as &$file){
                    $filePath = $file['path'] ?? $file['name'];
                    $file['starred'] = isset($starredMap[$filePath]);
                }
                
                echo json_encode($files);
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
    }elseif($_GET['action'] === 'get_starred'){
        $user = new User();
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            if($user->verifyJWT($token)){
                $decoded = $user->decodeJWT($token);
                $username = $decoded['username'];
                
                $starredFile = __DIR__ . '/uploads/'.$username.'/starred.json';
                if(file_exists($starredFile)){
                    $starred = json_decode(file_get_contents($starredFile), true);
                    $starredFiles = [];
                    
                    foreach($starred as $item){
                        $drive = $item['drive'];
                        $filePath = $item['file_path'];
                        $fullPath = __DIR__ . '/uploads/'.$username.'/'.$drive.'/'.$filePath;
                        
                        if(file_exists($fullPath)){
                            $fileManager = new FileManager(__DIR__ . '/uploads/'.$username.'/'.$drive);
                            $files = $fileManager->listFilesRecursive();
                            
                            foreach($files as $file){
                                if(($file['path'] ?? $file['name']) === $filePath){
                                    $file['drive'] = $drive;
                                    $file['starred'] = true;
                                    $starredFiles[] = $file;
                                    break;
                                }
                            }
                        }
                    }
                    
                    echo json_encode($starredFiles);
                }else{
                    echo json_encode([]);
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
        // Handle create drive and other actions
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data['action']) && $data['action'] === 'toggle_star'){
            $drive = $data['drive'] ?? 'default';
            $filePath = $data['file_path'];
            
            $userDir = __DIR__ . '/uploads/'.$username;
            $starredFile = $userDir . '/starred.json';
            
            // Load existing starred files
            $starred = [];
            if(file_exists($starredFile)){
                $starred = json_decode(file_get_contents($starredFile), true);
                if(!is_array($starred)) $starred = [];
            }
            
            // Check if file is already starred
            $isStarred = false;
            $keyToRemove = -1;
            foreach($starred as $key => $item){
                if($item['drive'] === $drive && $item['file_path'] === $filePath){
                    $isStarred = true;
                    $keyToRemove = $key;
                    break;
                }
            }
            
            // Toggle star
            if($isStarred){
                // Remove from starred
                array_splice($starred, $keyToRemove, 1);
            }else{
                // Add to starred
                $starred[] = [
                    'drive' => $drive,
                    'file_path' => $filePath,
                    'starred_at' => date('Y-m-d H:i:s')
                ];
            }
            
            // Save starred files
            if(!is_dir($userDir)){
                mkdir($userDir, 0777, true);
            }
            file_put_contents($starredFile, json_encode($starred, JSON_PRETTY_PRINT));
            
            http_response_code(200);
            echo json_encode([
                'message' => $isStarred ? 'Unstarred' : 'Starred',
                'starred' => !$isStarred
            ]);
        }elseif(isset($data['action']) && $data['action'] === 'create_drive' && isset($data['drive_name'])){
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
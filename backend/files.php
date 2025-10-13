<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

include_once 'classes/FileManager.php';
include_once 'classes/User.php';
include_once 'classes/DB.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
} else {
    $user = new User();
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header missing']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    if (!$user->verifyJWT($token)) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        exit;
    }

    $decoded = $user->decodeJWT($token);
    $username = $decoded['username'];

    if ($method === 'GET') {
        if ($_GET['action'] === 'get_drives') {
            $userDir = __DIR__ . '/uploads/' . $username;
            if (!is_dir($userDir)) {
                mkdir($userDir, 0777, true);
                mkdir($userDir . '/default', 0777, true);
            }

            $drives = [];
            $items = scandir($userDir);
            foreach ($items as $item) {
                if ($item != '.' && $item != '..' && is_dir($userDir . '/' . $item)) {
                    $drives[] = $item;
                }
            }

            if (empty($drives)) {
                $drives = ['default'];
                mkdir($userDir . '/default', 0777, true);
            }

            echo json_encode($drives);
        } elseif ($_GET['action'] === 'get_drive_storage' && isset($_GET['drive'])) {
            $drive = $_GET['drive'] ?? 'default';
            $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $username . '/' . $drive);
            $totalSize = $fileManager->getDirectorySize('/');

            echo json_encode([
                'used' => $totalSize,
                'limit' => 1024 * 1024 * 1024
            ]);
        } elseif ($_GET['action'] === 'get_drive' && isset($_GET['drive'])) {
            $drive = $_GET['drive'] ?? 'default';
            $folder = $_GET['folder'] ?? '';
            $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $username . '/' . $drive);

            if ($folder) {
                $files = $fileManager->listFilesInFolder($folder);
            } else {
                $files = $fileManager->listFilesRecursive();
            }

            $starredFile = __DIR__ . '/uploads/' . $username . '/starred.json';
            $starredMap = [];

            if (file_exists($starredFile)) {
                $starred = json_decode(file_get_contents($starredFile), true);
                if (is_array($starred)) {
                    foreach ($starred as $item) {
                        if ($item['drive'] === $drive) {
                            $starredMap[$item['file_path']] = true;
                        }
                    }
                }
            }

            foreach ($files as &$file) {
                $filePath = $file['path'] ?? $file['name'];
                $file['starred'] = isset($starredMap[$filePath]);
            }

            echo json_encode($files);
        } elseif ($_GET['action'] === 'get_file_contents' && isset($_GET['drive']) && isset($_GET['file'])) {
            $drive = $_GET['drive'] ?? 'default';
            $file = $_GET['file'];
            $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $username . '/' . $drive);
            $content = $fileManager->getFileContents($file);

            if ($content !== false) {
                $filePath = __DIR__ . '/uploads' . '/' . $username . '/' . $drive . '/' . $file;
                $mimeType = mime_content_type($filePath);

                $userDir = __DIR__ . '/uploads/' . $username;
                $recentFile = $userDir . '/recent.json';

                $recent = [];
                if (file_exists($recentFile)) {
                    $recent = json_decode(file_get_contents($recentFile), true);
                    if (!is_array($recent))
                        $recent = [];
                }

                $recent = array_filter($recent, function ($item) use ($drive, $file) {
                    return !($item['drive'] === $drive && $item['file_path'] === $file);
                });

                array_unshift($recent, [
                    'drive' => $drive,
                    'file_path' => $file,
                    'file_name' => basename($file),
                    'file_size' => filesize($filePath),
                    'file_type' => $mimeType,
                    'accessed_at' => date('Y-m-d H:i:s')
                ]);

                $recent = array_slice($recent, 0, 500);

                if (!is_dir($userDir)) {
                    mkdir($userDir, 0777, true);
                }
                file_put_contents($recentFile, json_encode($recent, JSON_PRETTY_PRINT));

                echo json_encode([
                    'content' => base64_encode($content),
                    'mime_type' => $mimeType,
                    'filename' => basename($file),
                    'size' => filesize($filePath)
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'File not found']);
            }
        } elseif ($_GET['action'] === 'get_recent_files') {
            $recentFile = __DIR__ . '/uploads/' . $username . '/recent.json';

            if (file_exists($recentFile)) {
                $recent = json_decode(file_get_contents($recentFile), true);
                $recentFiles = [];

                if (is_array($recent)) {
                    foreach ($recent as $item) {
                        $drive = $item['drive'];
                        $filePath = $item['file_path'];
                        $fullPath = __DIR__ . '/uploads/' . $username . '/' . $drive . '/' . $filePath;

                        if (file_exists($fullPath)) {
                            $fileManager = new FileManager(__DIR__ . '/uploads/' . $username . '/' . $drive);
                            $files = $fileManager->listFilesRecursive();

                            foreach ($files as $file) {
                                if (($file['path'] ?? $file['name']) === $filePath) {
                                    $file['drive'] = $drive;
                                    $file['accessed_at'] = $item['accessed_at'];
                                    $recentFiles[] = $file;
                                    break;
                                }
                            }
                        }
                    }
                }

                echo json_encode($recentFiles);
            } else {
                echo json_encode([]);
            }
        } elseif ($_GET['action'] === 'get_shared_files') {
            $db = new Database();
            echo json_encode($db->fetchAll("SELECT * FROM control_cloud_shared_files WHERE share_with = '$username'"));
        } elseif ($_GET['action'] === 'get_shared_file_contents' && isset($_GET['drive']) && isset($_GET['file']) && isset($_GET['owner'])) {
            $drive = $_GET['drive'];
            $file = $_GET['file'];
            $owner = $_GET['owner'];

            $db = new Database();
            $shared = $db->fetchAll("SELECT * FROM control_cloud_shared_files WHERE owner = '$owner' AND drive = '$drive' AND file_path = '$file' AND share_with = '$username'");

            if (empty($shared)) {
                http_response_code(403);
                echo json_encode(['message' => 'Access denied']);
                exit;
            }

            $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $owner . '/' . $drive);
            $content = $fileManager->getFileContents($file);

            if ($content !== false) {
                $filePath = __DIR__ . '/uploads' . '/' . $owner . '/' . $drive . '/' . $file;
                $mimeType = mime_content_type($filePath);

                echo json_encode([
                    'content' => base64_encode($content),
                    'mime_type' => $mimeType,
                    'filename' => basename($file),
                    'size' => filesize($filePath)
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'File not found']);
            }
        } elseif ($_GET['action'] === 'get_starred_shared') {
            $starredFile = __DIR__ . '/uploads/' . $username . '/starred_shared.json';
            if (file_exists($starredFile)) {
                $starred = json_decode(file_get_contents($starredFile), true);
                echo json_encode(is_array($starred) ? $starred : []);
            } else {
                echo json_encode([]);
            }
        } elseif ($_GET['action'] === 'get_starred') {
            $starredFile = __DIR__ . '/uploads/' . $username . '/starred.json';
            $starredSharedFile = __DIR__ . '/uploads/' . $username . '/starred_shared.json';
            $starredFiles = [];

            if (file_exists($starredFile)) {
                $starred = json_decode(file_get_contents($starredFile), true);

                if (is_array($starred)) {
                    foreach ($starred as $item) {
                        $drive = $item['drive'];
                        $filePath = $item['file_path'];
                        $owner = $username;
                        $fullPath = __DIR__ . '/uploads/' . $owner . '/' . $drive . '/' . $filePath;

                        if (file_exists($fullPath)) {
                            $fileManager = new FileManager(__DIR__ . '/uploads/' . $owner . '/' . $drive);
                            $files = $fileManager->listFilesRecursive();

                            foreach ($files as $file) {
                                if (($file['path'] ?? $file['name']) === $filePath) {
                                    $file['drive'] = $drive;
                                    $file['starred'] = true;
                                    $starredFiles[] = $file;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if (file_exists($starredSharedFile)) {
                $starredShared = json_decode(file_get_contents($starredSharedFile), true);

                if (is_array($starredShared)) {
                    foreach ($starredShared as $item) {
                        $owner = $item['owner'];
                        $drive = $item['drive'];
                        $filePath = $item['file_path'];
                        $fullPath = __DIR__ . '/uploads/' . $owner . '/' . $drive . '/' . $filePath;

                        if (file_exists($fullPath)) {
                            $fileManager = new FileManager(__DIR__ . '/uploads/' . $owner . '/' . $drive);
                            $files = $fileManager->listFilesRecursive();

                            foreach ($files as $file) {
                                if (($file['path'] ?? $file['name']) === $filePath) {
                                    $file['drive'] = $drive;
                                    $file['starred'] = true;
                                    $file['owner'] = $owner;
                                    $starredFiles[] = $file;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            echo json_encode($starredFiles);
        } elseif ($_GET['action'] === 'get_trash') {
            $trashFile = __DIR__ . '/uploads/' . $username . '/trash.json';
            if (file_exists($trashFile)) {
                $trash = json_decode(file_get_contents($trashFile), true);
                echo json_encode(is_array($trash) ? $trash : []);
            } else {
                echo json_encode([]);
            }
        } else {
            $fileManager = new FileManager(__DIR__ . '/uploads');
            //echo json_encode($fileManager->listFiles());
            echo json_encode($fileManager->listFilesRecursive());
        }
    } elseif ($method === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'upload' && isset($_FILES['file']) && isset($_POST['drive'])) {
            $drive = $_POST['drive'] ?? 'default';
            $folder = $_POST['folder'] ?? '';
            $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $username . '/' . $drive);

            if ($fileManager->uploadFile($_FILES['file'], $folder)) {
                http_response_code(201);
                echo json_encode(['message' => 'File uploaded successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'File upload failed']);
            }
        } else if (isset($_GET['action']) && $_GET['action'] === 'share') {

            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['file_path']) && isset($data['drive']) && isset($data['share_with'])) {
                $db = new Database();
                $filePath = $db->escape($data['file_path']);
                $drive = $db->escape($data['drive'] ?? 'default');
                $shareWith = $db->escape($data['share_with']);

                if (
                    $db->query(
                        "INSERT INTO control_cloud_shared_files (owner, drive, file_path, share_with, shared_at)
     VALUES ('$username', '$drive', '$filePath', '$shareWith', NOW())"
                    )
                ) {
                    http_response_code(201);
                    echo json_encode(['message' => 'File shared successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to share file']);
                }


            }

        } else {
            // print_R('here');
            //print_r($_POST);
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['action']) && $data['action'] === 'toggle_star') {
                $drive = $data['drive'] ?? 'default';
                $filePath = $data['file_path'];

                $userDir = __DIR__ . '/uploads/' . $username;
                $starredFile = $userDir . '/starred.json';

                $starred = [];
                if (file_exists($starredFile)) {
                    $starred = json_decode(file_get_contents($starredFile), true);
                    if (!is_array($starred))
                        $starred = [];
                }

                $isStarred = false;
                $keyToRemove = -1;
                foreach ($starred as $key => $item) {
                    if ($item['drive'] === $drive && $item['file_path'] === $filePath) {
                        $isStarred = true;
                        $keyToRemove = $key;
                        break;
                    }
                }

                if ($isStarred) {
                    array_splice($starred, $keyToRemove, 1);
                } else {
                    $starred[] = [
                        'drive' => $drive,
                        'file_path' => $filePath,
                        'starred_at' => date('Y-m-d H:i:s')
                    ];
                }

                if (!is_dir($userDir)) {
                    mkdir($userDir, 0777, true);
                }
                file_put_contents($starredFile, json_encode($starred, JSON_PRETTY_PRINT));

                http_response_code(200);
                echo json_encode(['message' => 'File star toggled successfully']);
            } elseif (isset($data['action']) && $data['action'] === 'toggle_star_shared') {
                $owner = $data['owner'];
                $drive = $data['drive'];
                $filePath = $data['file_path'];

                $userDir = __DIR__ . '/uploads/' . $username;
                $starredFile = $userDir . '/starred_shared.json';

                $starred = [];
                if (file_exists($starredFile)) {
                    $starred = json_decode(file_get_contents($starredFile), true);
                    if (!is_array($starred))
                        $starred = [];
                }

                $isStarred = false;
                $keyToRemove = -1;
                foreach ($starred as $key => $item) {
                    if ($item['owner'] === $owner && $item['drive'] === $drive && $item['file_path'] === $filePath) {
                        $isStarred = true;
                        $keyToRemove = $key;
                        break;
                    }
                }

                if ($isStarred) {
                    array_splice($starred, $keyToRemove, 1);
                } else {
                    $starred[] = [
                        'owner' => $owner,
                        'drive' => $drive,
                        'file_path' => $filePath,
                        'starred_at' => date('Y-m-d H:i:s')
                    ];
                }

                if (!is_dir($userDir)) {
                    mkdir($userDir, 0777, true);
                }
                file_put_contents($starredFile, json_encode($starred, JSON_PRETTY_PRINT));

                http_response_code(200);
                echo json_encode(['message' => 'Shared file star toggled successfully']);
                echo json_encode([
                    'message' => $isStarred ? 'Unstarred' : 'Starred',
                    'starred' => !$isStarred
                ]);
            } elseif (isset($data['action']) && $data['action'] === 'create_folder' && isset($data['drive']) && isset($data['folder'])) {
                $drive = $data['drive'] ?? 'default';
                $folderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $data['folder']);

                if (empty($folderName)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid folder name']);
                    exit;
                }

                $fileManager = new FileManager(__DIR__ . '/uploads' . '/' . $username . '/' . $drive);
                if ($fileManager->createDirectory($folderName)) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Folder created successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to create folder']);
                }
            } elseif (isset($data['action']) && $data['action'] === 'restore_file') {
                $drive = $data['drive'] ?? 'default';
                $filePath = $data['file_path'];
                $fileId = $data['file_id'];

                $userDir = __DIR__ . '/uploads/' . $username;
                $trashFile = $userDir . '/trash.json';

                $trash = [];
                if (file_exists($trashFile)) {
                    $trash = json_decode(file_get_contents($trashFile), true);
                    if (!is_array($trash))
                        $trash = [];
                }

                $keyToRemove = -1;
                foreach ($trash as $key => $item) {
                    if ($item['id'] == $fileId) {
                        $keyToRemove = $key;
                        break;
                    }
                }

                if ($keyToRemove !== -1) {
                    array_splice($trash, $keyToRemove, 1);
                    file_put_contents($trashFile, json_encode($trash, JSON_PRETTY_PRINT));

                    http_response_code(200);
                    echo json_encode(['message' => 'File restored successfully']);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'File not found in trash']);
                }
            } elseif (isset($data['action']) && $data['action'] === 'delete_permanently') {
                $drive = $data['drive'] ?? 'default';
                $filePath = $data['file_path'];
                $fileId = $data['file_id'];

                $userDir = __DIR__ . '/uploads/' . $username;
                $trashFile = $userDir . '/trash.json';

                $trash = [];
                if (file_exists($trashFile)) {
                    $trash = json_decode(file_get_contents($trashFile), true);
                    if (!is_array($trash))
                        $trash = [];
                }

                $keyToRemove = -1;
                foreach ($trash as $key => $item) {
                    if ($item['id'] == $fileId) {
                        $keyToRemove = $key;
                        break;
                    }
                }

                if ($keyToRemove !== -1) {
                    array_splice($trash, $keyToRemove, 1);
                    file_put_contents($trashFile, json_encode($trash, JSON_PRETTY_PRINT));

                    http_response_code(200);
                    echo json_encode(['message' => 'File deleted permanently']);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'File not found in trash']);
                }
            } elseif (isset($data['action']) && $data['action'] === 'empty_trash') {
                $userDir = __DIR__ . '/uploads/' . $username;
                $trashFile = $userDir . '/trash.json';

                if (file_exists($trashFile)) {
                    file_put_contents($trashFile, json_encode([], JSON_PRETTY_PRINT));
                }

                http_response_code(200);
                echo json_encode(['message' => 'Trash emptied successfully']);
            } elseif (isset($data['action']) && $data['action'] === 'move_to_trash') {
                $drive = $data['drive'] ?? 'default';
                $filePath = $data['file_path'];
                $fileId = $data['file_id'];

                $userDir = __DIR__ . '/uploads/' . $username;
                $trashFile = $userDir . '/trash.json';

                $trash = [];
                if (file_exists($trashFile)) {
                    $trash = json_decode(file_get_contents($trashFile), true);
                    if (!is_array($trash))
                        $trash = [];
                }

                $trash[] = [
                    'id' => $fileId,
                    'name' => $data['file_name'],
                    'path' => $filePath,
                    'type' => $data['file_type'],
                    'drive' => $drive,
                    'size' => $data['file_size'],
                    'owner' => $data['file_owner'] ?? 'me',
                    'modified' => $data['file_modified'],
                    'deleted' => date('d M Y')
                ];

                if (!is_dir($userDir)) {
                    mkdir($userDir, 0777, true);
                }
                file_put_contents($trashFile, json_encode($trash, JSON_PRETTY_PRINT));

                http_response_code(200);
                echo json_encode(['message' => 'File moved to trash']);
            } elseif (isset($data['action']) && $data['action'] === 'create_drive' && isset($data['drive_name'])) {
                $driveName = preg_replace('/[^a-zA-Z0-9_-]/', '', $data['drive_name']);

                if (empty($driveName)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid drive name']);
                    exit;
                }

                $userDir = __DIR__ . '/uploads/' . $username;

                $drives = [];
                if (is_dir($userDir)) {
                    $items = scandir($userDir);
                    foreach ($items as $item) {
                        if ($item != '.' && $item != '..' && is_dir($userDir . '/' . $item)) {
                            $drives[] = $item;
                        }
                    }
                }

                if (count($drives) >= 3) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Maximum of 3 drives allowed']);
                    exit;
                }

                $driveDir = $userDir . '/' . $driveName;

                if (is_dir($driveDir)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Drive already exists']);
                    exit;
                }

                if (mkdir($driveDir, 0777, true)) {
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
}
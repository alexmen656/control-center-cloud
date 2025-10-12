<?php
class FileManager
{
    private $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = rtrim($baseDir, '/') . '/';
        if (!is_dir($this->baseDir)) {
            mkdir($this->baseDir, 0755, true);
        }
    }

    public function listFiles()
    {
        $files = array_diff(scandir($this->baseDir), array('.', '..'));
        return array_values($files);
    }

    public function listFilesRecursive()
    {
        //echo "Base Dir: " . $this->baseDir . "\n"; // Debug line to check base directory
        $rii = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->baseDir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $files = [];
        $id = 1;
        foreach ($rii as $file) {
            if (!$file->isDir()) {
                $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
                $relativePath = str_replace($this->baseDir, '', $file->getPathname());
                $files[] = [
                    "id" => $id++,
                    "name" => basename($file->getFilename()),
                    "path" => $relativePath,
                    "type" => $ext ?: 'file',
                    "owner" => 'me',
                    "modified" => date('d M Y', $file->getMTime()),
                    "size" => filesize($file) . ' bytes'
                ];
            } else {
                $relativePath = str_replace($this->baseDir, '', $file->getPathname());
                if ($relativePath !== '.' && $relativePath !== '..') {
                    $files[] = [
                        "id" => $id++,
                        "name" => basename($file->getPathname()),
                        "path" => $relativePath,
                        "type" => 'folder',
                        "owner" => 'me',
                        "modified" => date('d M Y', $file->getMTime()),
                        "size" => '—'
                    ];
                }
            }
        }
        return $files;
    }

    public function listFilesInFolder($folder)
    {
        $folderPath = $this->baseDir . $folder;
        if (!is_dir($folderPath)) {
            return [];
        }

        $files = [];
        $id = 1;
        $items = scandir($folderPath);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $itemPath = $folderPath . '/' . $item;
            $relativePath = str_replace($this->baseDir, '', $itemPath);

            if (is_dir($itemPath)) {
                $files[] = [
                    "id" => $id++,
                    "name" => $item,
                    "path" => $relativePath,
                    "type" => 'folder',
                    "owner" => 'me',
                    "modified" => date('d M Y', filemtime($itemPath)),
                    "size" => '—'
                ];
            } else {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                $files[] = [
                    "id" => $id++,
                    "name" => $item,
                    "path" => $relativePath,
                    "type" => $ext ?: 'file',
                    "owner" => 'me',
                    "modified" => date('d M Y', filemtime($itemPath)),
                    "size" => filesize($itemPath) . ' bytes'
                ];
            }
        }

        return $files;
    }

    public function uploadFile($file, $folder = '')
    {
        $targetDir = $this->baseDir;
        if ($folder) {
            $targetDir .= rtrim($folder, '/') . '/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
        }

        $targetPath = $targetDir . basename($file['name']);
        echo 'Uploading to: ' . $targetPath . '';
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return true;
        }
        return false;
    }

    public function deleteFile($filename)
    {
        $filePath = $this->baseDir . basename($filename);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function createDirectory($dirname)
    {
        $dirPath = $this->baseDir . $dirname;
        if (!is_dir($dirPath)) {
            return mkdir($dirPath, 0755, true);
        }
        return false;
    }

    public function renameFile($oldName, $newName)
    {
        $oldPath = $this->baseDir . basename($oldName);
        $newPath = $this->baseDir . basename($newName);
        if (file_exists($oldPath)) {
            return rename($oldPath, $newPath);
        }
        return false;
    }

    public function moveFile($filename, $newDir)
    {
        $filePath = $this->baseDir . basename($filename);
        $newDirPath = rtrim($this->baseDir . basename($newDir), '/') . '/';
        if (!is_dir($newDirPath)) {
            mkdir($newDirPath, 0755, true);
        }
        if (file_exists($filePath)) {
            return rename($filePath, $newDirPath . basename($filename));
        }
        return false;
    }

    public function getDirectorySize($dirname)
    {
        $dirPath = $this->baseDir . basename($dirname);
        if (is_dir($dirPath)) {
            $size = 0;
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirPath));
            foreach ($rii as $file) {
                if (!$file->isDir()) {
                    $size += filesize($file);
                }
            }
            return $size;
        }
        return false;
    }

    public function getFileContents($filename)
    {
        $filePath = $this->baseDir . basename($filename);
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }
        return false;
    }
}
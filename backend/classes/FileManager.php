<?php
class FileManager {
    private $baseDir;

    public function __construct($baseDir) {
        $this->baseDir = rtrim($baseDir, '/') . '/';
        if (!is_dir($this->baseDir)) {
            mkdir($this->baseDir, 0755, true);
        }
    }

    public function listFiles() {
        $files = array_diff(scandir($this->baseDir), array('.', '..'));
        return array_values($files);
    }

    public function listFilesRecursive() {
        //echo "Base Dir: " . $this->baseDir . "\n"; // Debug line to check base directory
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->baseDir));
        $files = [];
        foreach ($rii as $file) {
            if (!$file->isDir()) {
                $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
                $files[] = [
                    "id" => 1,
                    "name" => str_replace($this->baseDir, '', $file->getPathname()),
                    "type" => $ext ?: 'file',
                    "owner" => 'me',
                    "modified" => date('d M Y', $file->getMTime()),
                    "size" => filesize($file) . ' bytes'
                ];
            } else {
                $files[] = [
                    "id" => 1,
                    "name" => str_replace($this->baseDir, '', $file->getPathname()),
                    "type" => 'folder',
                    "owner" => 'me',
                    "modified" => date('d M Y', $file->getMTime()),
                    "size" => '—'
                ];
            }
        }
        return $files;
    }

    public function uploadFile($file) {
        $targetPath = $this->baseDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return true;
        }
        return false;
    }

    public function deleteFile($filename) {
        $filePath = $this->baseDir . basename($filename);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function createDirectory($dirname) {
        $dirPath = $this->baseDir . basename($dirname);
        if (!is_dir($dirPath)) {
            return mkdir($dirPath, 0755, true);
        }
        return false;
    }

    public function renameFile($oldName, $newName) {
        $oldPath = $this->baseDir . basename($oldName);
        $newPath = $this->baseDir . basename($newName);
        if (file_exists($oldPath)) {
            return rename($oldPath, $newPath);
        }
        return false;
    }

    public function moveFile($filename, $newDir) {
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

    public function getFileContents($filename) {
        $filePath = $this->baseDir . basename($filename);
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }
        return false;
    }
}
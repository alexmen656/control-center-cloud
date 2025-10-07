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
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->baseDir));
        $files = [];
        foreach ($rii as $file) {
            if (!$file->isDir()) {
                $files[] = str_replace($this->baseDir, '', $file->getPathname());
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
}
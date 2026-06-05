<?php
/**
 * Upload Handler Helper
 * Menangani upload file gambar untuk lapangan
 */

class UploadHandler {
    private $upload_dir = '../assets/uploads/';
    private $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private $max_file_size = 5242880; // 5MB
    
    public function __construct() {
        // Pastikan folder upload ada
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }
    
    /**
     * Validasi file upload
     */
    public function validateFile($file) {
        if (!isset($file['tmp_name']) || !isset($file['size']) || !isset($file['type'])) {
            return ['success' => false, 'message' => 'File tidak valid'];
        }
        
        if ($file['size'] > $this->max_file_size) {
            return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
        }
        
        if (!in_array($file['type'], $this->allowed_types)) {
            return ['success' => false, 'message' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, WebP, atau GIF'];
        }
        
        return ['success' => true];
    }
    
    /**
     * Upload single file
     */
    public function uploadFile($file, $prefix = 'lapangan') {
        // Validasi
        $validation = $this->validateFile($file);
        if (!$validation['success']) {
            return $validation;
        }
        
        // Generate nama file unik
        $ext = $this->getFileExtension($file['type']);
        $filename = $prefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $filepath = $this->upload_dir . $filename;
        
        // Move file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => true,
                'message' => 'File berhasil diupload',
                'filename' => $filename,
                'filepath' => $filepath,
                'url' => 'assets/uploads/' . $filename
            ];
        } else {
            return ['success' => false, 'message' => 'Gagal mengupload file'];
        }
    }
    
    /**
     * Upload multiple files
     */
    public function uploadMultiple($files_array, $prefix = 'gallery') {
        $results = [];
        
        if (is_array($files_array['name'])) {
            // Multiple files
            for ($i = 0; $i < count($files_array['name']); $i++) {
                $file = [
                    'name' => $files_array['name'][$i],
                    'type' => $files_array['type'][$i],
                    'tmp_name' => $files_array['tmp_name'][$i],
                    'error' => $files_array['error'][$i],
                    'size' => $files_array['size'][$i]
                ];
                
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $results[] = $this->uploadFile($file, $prefix);
                }
            }
        } else {
            // Single file dalam format multiple
            $results[] = $this->uploadFile($files_array, $prefix);
        }
        
        return $results;
    }
    
    /**
     * Dapatkan extension dari MIME type
     */
    private function getFileExtension($mime_type) {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif'
        ];
        return $extensions[$mime_type] ?? 'jpg';
    }
    
    /**
     * Hapus file
     */
    public function deleteFile($filename) {
        $filepath = $this->upload_dir . $filename;
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }
}
?>

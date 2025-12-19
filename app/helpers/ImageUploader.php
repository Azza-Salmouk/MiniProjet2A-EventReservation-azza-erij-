<?php

/**
 * ImageUploader Helper
 * Gère l'upload sécurisé d'images
 */
class ImageUploader {
    
    private $uploadDir;
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    private $maxFileSize = 5242880; // 5MB
    private $error = null;
    
    public function __construct($uploadDir = null) {
        $this->uploadDir = $uploadDir ?? ROOT . '/public/uploads/';
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    /**
     * Upload une image depuis $_FILES
     * @param array $file - $_FILES['image']
     * @return string|false - Nom du fichier uploadé ou false
     */
    public function upload($file) {
        // Vérifier qu'un fichier a été uploadé
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null; // Pas de fichier = pas d'erreur
        }
        
        // Vérifier les erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->error = $this->getUploadErrorMessage($file['error']);
            return false;
        }
        
        // Vérifier la taille
        if ($file['size'] > $this->maxFileSize) {
            $this->error = "File size exceeds maximum allowed (5MB).";
            return false;
        }
        
        // Vérifier l'extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            $this->error = "Invalid file type. Allowed: " . implode(', ', $this->allowedExtensions);
            return false;
        }
        
        // Vérifier que c'est vraiment une image (MIME type) - sauf pour SVG
        if ($extension !== 'svg') {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
            
            // Special case: if MIME type detection fails but extension is valid, still accept it
            // This handles cases where valid images are detected as application/octet-stream
            if ($mimeType === 'application/octet-stream' && in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                // Allow it - extension is valid even if MIME detection failed
            } else if (!in_array($mimeType, $allowedMimes)) {
                $this->error = "File is not a valid image. Detected type: " . $mimeType;
                return false;
            }
        }
        
        // Générer un nom unique
        $filename = $this->generateUniqueFilename($extension);
        $destination = $this->uploadDir . $filename;
        
        // Déplacer le fichier
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
        
        // Debug information for failed uploads
        $this->error = "Failed to upload file. ";
        $this->error .= "Temp file exists: " . (file_exists($file['tmp_name']) ? 'YES' : 'NO') . ". ";
        $this->error .= "Destination dir writable: " . (is_writable(dirname($destination)) ? 'YES' : 'NO') . ". ";
        $this->error .= "Destination: " . $destination;
        
        return false;
    }
    
    /**
     * Supprime une image
     */
    public function delete($filename) {
        if (empty($filename)) {
            return true;
        }
        
        $filepath = $this->uploadDir . $filename;
        
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        
        return true;
    }
    
    /**
     * Génère un nom de fichier unique
     */
    private function generateUniqueFilename($extension) {
        return uniqid('event_', true) . '.' . $extension;
    }
    
    /**
     * Retourne le message d'erreur d'upload
     */
    private function getUploadErrorMessage($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];
        
        return $errors[$errorCode] ?? 'Unknown upload error.';
    }
    
    /**
     * Retourne l'erreur
     */
    public function getError() {
        return $this->error;
    }
    
    /**
     * Vérifie si une erreur est survenue
     */
    public function hasError() {
        return $this->error !== null;
    }
}
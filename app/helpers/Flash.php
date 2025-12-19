<?php

/**
 * Flash Messages Helper
 * Gère les messages de notification entre requêtes via sessions
 */
class Flash {
    
    /**
     * Définir un message flash
     */
    public static function set($type, $message) {
        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
        
        $_SESSION['flash_messages'][] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Messages rapides
     */
    public static function success($message) {
        self::set('success', $message);
    }
    
    public static function error($message) {
        self::set('error', $message);
    }
    
    public static function warning($message) {
        self::set('warning', $message);
    }
    
    public static function info($message) {
        self::set('info', $message);
    }
    
    /**
     * Récupérer tous les messages (et les supprimer)
     */
    public static function get() {
        if (!isset($_SESSION['flash_messages'])) {
            return [];
        }
        
        $messages = $_SESSION['flash_messages'];
        unset($_SESSION['flash_messages']);
        
        return $messages;
    }
    
    /**
     * Vérifier s'il y a des messages
     */
    public static function has() {
        return isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages']);
    }
}

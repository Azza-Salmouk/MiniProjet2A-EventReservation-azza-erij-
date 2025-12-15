<?php

/**
 * Validator Helper
 * Gère la validation des données côté serveur
 */
class Validator {
    
    private $errors = [];
    
    /**
     * Vérifie si un champ est vide
     */
    public function required($field, $value, $fieldName = null) {
        if (empty(trim($value))) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " is required.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie la validité d'un email
     */
    public function email($field, $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Invalid email format.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie la longueur minimale
     */
    public function minLength($field, $value, $min, $fieldName = null) {
        if (strlen($value) < $min) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " must be at least {$min} characters.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie la longueur maximale
     */
    public function maxLength($field, $value, $max, $fieldName = null) {
        if (strlen($value) > $max) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " must not exceed {$max} characters.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie qu'une valeur est numérique
     */
    public function numeric($field, $value, $fieldName = null) {
        if (!is_numeric($value)) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " must be a number.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie qu'une valeur est >= 0
     */
    public function positive($field, $value, $fieldName = null) {
        if ($value < 0) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " must be a positive number.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie la validité d'une date
     */
    public function date($field, $value, $fieldName = null) {
        $timestamp = strtotime($value);
        if ($timestamp === false) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " is not a valid date.";
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie qu'une date est dans le futur
     */
    public function futureDate($field, $value, $fieldName = null) {
        $timestamp = strtotime($value);
        if ($timestamp < time()) {
            $this->errors[$field] = ($fieldName ?? ucfirst($field)) . " must be a future date.";
            return false;
        }
        return true;
    }
    
    /**
     * Retourne toutes les erreurs
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Vérifie s'il y a des erreurs
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * Nettoie les données (prévention XSS basique)
     */
    public static function clean($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}

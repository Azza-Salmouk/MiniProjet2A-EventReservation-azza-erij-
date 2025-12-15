<?php
session_start();

// chemin racine ABSOLU et fiable
define('ROOT', realpath(__DIR__ . '/..'));

// test sécurité
if (!file_exists(ROOT . '/config/database.php')) {
    die('database.php NOT FOUND: ' . ROOT . '/config/database.php');
}

require_once ROOT . '/config/database.php';

// Charger les helpers
require_once ROOT . '/app/helpers/Validator.php';
require_once ROOT . '/app/helpers/ImageUploader.php';
require_once ROOT . '/app/helpers/Flash.php';

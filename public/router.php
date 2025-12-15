<?php
// Router for PHP built-in server
// Serves static files directly, routes everything else to index.php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// If file exists, serve it directly
if (file_exists(__DIR__ . $path) && is_file(__DIR__ . $path)) {
    return false; // Let PHP server handle static files
}

// Otherwise, route to index.php for MVC handling
require_once __DIR__ . '/index.php';
<?php

function db() {
    static $pdo = null;

    if ($pdo === null) {
        $host = "localhost";
        $dbname = "mini_event";
        $user = "root";
        $pass = "";

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

<?php
require_once "../config/database.php";

try {
    db();
    echo "Connexion DB OK";
} catch (Exception $e) {
    echo "Erreur DB";
}

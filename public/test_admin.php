<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once ROOT . '/app/models/Admin.php';

echo "<h1>TEST ADMIN MODEL</h1>";

// Test 1: Login avec mauvais identifiants
echo "<h2>1. Test login() - Mauvais identifiants</h2>";
$admin = Admin::login("wronguser", "wrongpass");
if ($admin === false) {
    echo "<p>✅ Connexion refusée correctement (mauvais identifiants)</p>";
} else {
    echo "<p>❌ ERREUR: Connexion acceptée avec mauvais identifiants!</p>";
}

// Test 2: Login avec bons identifiants
echo "<h2>2. Test login() - Bons identifiants</h2>";
echo "<p><em>Assurez-vous d'avoir exécuté seed_admin.php d'abord!</em></p>";

$admin = Admin::login("admin", "admin123");
if ($admin && is_array($admin)) {
    echo "<p>✅ Connexion réussie!</p>";
    echo "<p>Admin ID: {$admin['id']}</p>";
    echo "<p>Username: {$admin['username']}</p>";
    echo "<pre>";
    print_r($admin);
    echo "</pre>";
} else {
    echo "<p>❌ Connexion échouée. Avez-vous lancé seed_admin.php?</p>";
}

// Test 3: Vérifier le hash
echo "<h2>3. Test password_hash</h2>";
$testPassword = "admin123";
$hash = password_hash($testPassword, PASSWORD_DEFAULT);
echo "<p>Password: <code>{$testPassword}</code></p>";
echo "<p>Hash: <code>{$hash}</code></p>";
$verified = password_verify($testPassword, $hash);
echo "<p>Vérification: " . ($verified ? "✅ OK" : "❌ FAIL") . "</p>";

echo "<hr><p><strong>Tests terminés!</strong></p>";

<?php
require_once __DIR__ . '/../config/bootstrap.php';

echo "<h1>SEED ADMIN USER</h1>";

// Vérifier si un admin existe déjà
$stmt = db()->query("SELECT COUNT(*) FROM admin");
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo "<p>⚠️ Un administrateur existe déjà. Suppression...</p>";
    db()->exec("DELETE FROM admin");
}

// Créer admin par défaut
$username = "admin";
$password = "admin123";
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = db()->prepare("INSERT INTO admin (username, password_hash) VALUES (?, ?)");
$result = $stmt->execute([$username, $passwordHash]);

if ($result) {
    echo "<p>✅ Administrateur créé avec succès!</p>";
    echo "<div style='background:#f0f0f0; padding:15px; margin:10px 0; border-left:4px solid #4CAF50;'>";
    echo "<strong>Identifiants de connexion:</strong><br>";
    echo "Username: <code>{$username}</code><br>";
    echo "Password: <code>{$password}</code>";
    echo "</div>";
    echo "<p><strong>⚠️ IMPORTANT:</strong> Changez ce mot de passe en production!</p>";
} else {
    echo "<p>❌ Erreur lors de la création de l'admin.</p>";
}

echo "<hr><p><a href='index.php'>← Retour à l'accueil</a> | <a href='/admin/login'>Se connecter</a></p>";

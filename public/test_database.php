<?php
echo "<h1>DATABASE CONNECTION TEST</h1>";

try {
    $host = "localhost";
    $dbname = "mini_event";
    $user = "root";
    $pass = "";
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color:green;'>✅ <strong>DATABASE CONNECTION: OK</strong></p>";
    echo "<p>Database: <strong>{$dbname}</strong></p>";
    echo "<p>Host: <strong>{$host}</strong></p>";
    
    // Vérifier les tables
    echo "<hr><h2>Tables existantes:</h2>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p style='color:red;'>❌ <strong>AUCUNE TABLE TROUVÉE!</strong></p>";
        echo "<p>La base de données existe mais les tables ne sont pas créées.</p>";
        echo "<hr>";
        echo "<h2>📋 SQL à exécuter dans phpMyAdmin ou MySQL:</h2>";
        echo "<pre style='background:#f0f0f0; padding:15px;'>";
        echo htmlspecialchars("
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    seats INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
");
        echo "</pre>";
    } else {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li style='color:green;'>✅ <strong>{$table}</strong>";
            
            // Compter les lignes
            $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
            echo " ({$count} rows)</li>";
        }
        echo "</ul>";
        
        // Vérifier la structure
        echo "<hr><h2>Structure des tables:</h2>";
        foreach ($tables as $table) {
            echo "<h3>{$table}</h3>";
            $cols = $pdo->query("DESCRIBE `{$table}`")->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            foreach ($cols as $col) {
                echo "<tr>";
                echo "<td>{$col['Field']}</td>";
                echo "<td>{$col['Type']}</td>";
                echo "<td>{$col['Null']}</td>";
                echo "<td>{$col['Key']}</td>";
                echo "<td>{$col['Default']}</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ <strong>DATABASE ERROR:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    
    if (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "<hr>";
        echo "<h2>🔧 SOLUTION: Créer la base de données</h2>";
        echo "<p>1. Ouvrir phpMyAdmin (http://localhost/phpmyadmin)</p>";
        echo "<p>2. Créer une nouvelle base de données nommée: <strong>mini_event</strong></p>";
        echo "<p>3. Sélectionner le charset: <strong>utf8mb4_unicode_ci</strong></p>";
        echo "<p>4. Puis exécuter le SQL des tables (voir ci-dessus)</p>";
    }
}

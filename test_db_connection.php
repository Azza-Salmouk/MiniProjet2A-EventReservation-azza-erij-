<?php
// Test database connection
require_once 'config/database.php';

echo "Testing database connection...\n";

try {
    $pdo = db();
    echo "✅ Database connection successful!\n";
    echo "PDO DSN: " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}
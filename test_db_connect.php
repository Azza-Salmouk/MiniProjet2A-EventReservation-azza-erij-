<?php
// Simple database connection test script
require_once __DIR__ . '/config/bootstrap.php';

echo "Testing database connection...\n";

try {
    $pdo = db();
    echo "✅ Database connection successful!\n";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "MySQL Version: " . $result['version'] . "\n";
    
    echo "✅ Database is ready for use!\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
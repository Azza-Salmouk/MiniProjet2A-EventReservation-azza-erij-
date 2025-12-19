<?php
require_once 'config/bootstrap.php';

try {
    $stmt = db()->query('SELECT COUNT(*) FROM events');
    $count = $stmt->fetchColumn();
    echo "Events count: " . $count . "\n";
    
    $stmt = db()->query('SELECT COUNT(*) FROM admin');
    $count = $stmt->fetchColumn();
    echo "Admin count: " . $count . "\n";
    
    $stmt = db()->query('SELECT COUNT(*) FROM reservations');
    $count = $stmt->fetchColumn();
    echo "Reservations count: " . $count . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
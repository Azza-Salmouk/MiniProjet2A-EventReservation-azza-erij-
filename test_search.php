<?php
// Test search functionality
require_once 'config/bootstrap.php';
require_once 'app/models/Reservation.php';

echo "Testing search functionality...\n";

try {
    // Test search method
    $results = Reservation::searchAll('Tech');
    
    echo "✅ Search method executed successfully!\n";
    echo "Found " . count($results) . " results for 'Tech'\n";
    
    // Test search by event
    $results = Reservation::searchByEvent(1, 'John');
    
    echo "✅ Search by event method executed successfully!\n";
    echo "Found " . count($results) . " results for 'John' in event 1\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
<?php
// Test event creation
require_once 'config/bootstrap.php';
require_once 'app/models/Event.php';

echo "Testing event creation...\n";

try {
    // Test data
    $testData = [
        'title' => 'Test Event',
        'description' => 'This is a test event for verification',
        'event_date' => '2024-12-25 10:00:00',
        'location' => 'Test Location',
        'seats' => 50,
        'image' => 'test.jpg'
    ];
    
    // Create event
    $result = Event::create($testData);
    
    if ($result) {
        echo "✅ Event created successfully!\n";
        
        // Verify it was inserted
        $stmt = db()->query("SELECT * FROM events WHERE title = 'Test Event'");
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($event) {
            echo "✅ Event found in database:\n";
            echo "   ID: " . $event['id'] . "\n";
            echo "   Title: " . $event['title'] . "\n";
            echo "   Date: " . $event['event_date'] . "\n";
            
            // Clean up - delete the test event
            Event::delete($event['id']);
            echo "✅ Test event cleaned up\n";
        } else {
            echo "❌ Event not found in database\n";
        }
    } else {
        echo "❌ Failed to create event\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
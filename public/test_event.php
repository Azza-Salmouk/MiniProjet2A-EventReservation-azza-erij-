<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once ROOT . '/app/models/Event.php';

echo "<h1>TEST EVENT MODEL</h1>";

// Test 1: Get All Events
echo "<h2>1. Test getAll()</h2>";
$events = Event::getAll();
echo "<p>Nombre d'événements: " . count($events) . "</p>";
echo "<pre>";
print_r($events);
echo "</pre>";

// Test 2: Get Event by ID
echo "<h2>2. Test getById(1)</h2>";
$event = Event::getById(1);
if ($event) {
    echo "<p>✅ Événement trouvé: {$event['title']}</p>";
    echo "<pre>";
    print_r($event);
    echo "</pre>";
} else {
    echo "<p>❌ Aucun événement avec ID=1</p>";
}

// Test 3: Create Event
echo "<h2>3. Test create()</h2>";
$newEvent = [
    'title' => 'Test Event ' . time(),
    'description' => 'Description de test',
    'event_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
    'location' => 'Sousse, Tunisia',
    'seats' => 50,
    'image' => null
];

try {
    $created = Event::create($newEvent);
    if ($created) {
        echo "<p>✅ Événement créé avec succès!</p>";
        $lastId = db()->lastInsertId();
        echo "<p>ID du nouvel événement: {$lastId}</p>";
        
        // Test 4: Update Event
        echo "<h2>4. Test update()</h2>";
        $updated = Event::update($lastId, [
            'title' => 'Test Event UPDATED',
            'description' => 'Description MISE À JOUR',
            'event_date' => $newEvent['event_date'],
            'location' => $newEvent['location'],
            'seats' => 100,
            'image' => null
        ]);
        
        if ($updated) {
            echo "<p>✅ Événement mis à jour!</p>";
            $eventUpdated = Event::getById($lastId);
            echo "<pre>";
            print_r($eventUpdated);
            echo "</pre>";
        }
        
        // Test 5: Delete Event
        echo "<h2>5. Test delete()</h2>";
        $deleted = Event::delete($lastId);
        if ($deleted) {
            echo "<p>✅ Événement supprimé!</p>";
        }
    }
} catch (Exception $e) {
    echo "<p>❌ Erreur: " . $e->getMessage() . "</p>";
}

echo "<hr><p><strong>Tests terminés!</strong></p>";

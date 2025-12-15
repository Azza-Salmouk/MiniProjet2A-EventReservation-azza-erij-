<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once ROOT . '/app/models/Reservation.php';
require_once ROOT . '/app/models/Event.php';

echo "<h1>TEST RESERVATION MODEL</h1>";

// Test 1: Get reservations for event_id=1
echo "<h2>1. Test getByEvent(1)</h2>";
$reservations = Reservation::getByEvent(1);
echo "<p>Nombre de réservations: " . count($reservations) . "</p>";
echo "<pre>";
print_r($reservations);
echo "</pre>";

// Test 2: Create a reservation
echo "<h2>2. Test create()</h2>";

// Vérifier qu'on a au moins 1 événement
$events = Event::getAll();
if (count($events) > 0) {
    $eventId = $events[0]['id'];
    
    $newReservation = [
        'event_id' => $eventId,
        'name' => 'Test User ' . time(),
        'email' => 'test' . time() . '@example.com',
        'phone' => '+216 12345678'
    ];
    
    try {
        $created = Reservation::create($newReservation);
        if ($created) {
            echo "<p>✅ Réservation créée avec succès!</p>";
            echo "<p>ID: " . db()->lastInsertId() . "</p>";
            
            // Re-fetch reservations
            echo "<h3>Réservations pour l'événement {$eventId}:</h3>";
            $updatedReservations = Reservation::getByEvent($eventId);
            echo "<pre>";
            print_r($updatedReservations);
            echo "</pre>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Erreur: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>❌ Aucun événement disponible. Créez d'abord un événement!</p>";
}

echo "<hr><p><strong>Tests terminés!</strong></p>";

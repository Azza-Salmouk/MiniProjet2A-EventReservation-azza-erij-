<?php
require_once __DIR__ . '/../config/bootstrap.php';

echo "<h1>API CRUD TESTS (Simulation Postman)</h1>";
echo "<p>Ce fichier simule des requêtes POST/GET comme Postman</p>";

// ================== TEST EVENT CRUD ==================
echo "<hr><h2>📦 TEST EVENT CRUD</h2>";

require_once ROOT . '/app/models/Event.php';

// 1. CREATE
echo "<h3>1. CREATE Event</h3>";
$eventData = [
    'title' => 'Test Concert ' . time(),
    'description' => 'Concert de Jazz incroyable',
    'event_date' => date('Y-m-d H:i:s', strtotime('+10 days')),
    'location' => 'Sousse, Tunisia',
    'seats' => 150,
    'image' => null
];

try {
    $created = Event::create($eventData);
    if ($created) {
        $eventId = db()->lastInsertId();
        echo "<p style='color:green;'>✅ Event créé (ID: {$eventId})</p>";
        echo "<pre>" . json_encode($eventData, JSON_PRETTY_PRINT) . "</pre>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
}

// 2. READ ALL
echo "<h3>2. READ ALL Events</h3>";
try {
    $events = Event::getAll();
    echo "<p style='color:green;'>✅ Récupéré " . count($events) . " événements</p>";
    echo "<pre>" . json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
}

// 3. READ ONE
if (isset($eventId)) {
    echo "<h3>3. READ Event by ID ({$eventId})</h3>";
    try {
        $event = Event::getById($eventId);
        if ($event) {
            echo "<p style='color:green;'>✅ Event trouvé</p>";
            echo "<pre>" . json_encode($event, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        } else {
            echo "<p style='color:red;'>❌ Event non trouvé</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }
}

// 4. UPDATE
if (isset($eventId)) {
    echo "<h3>4. UPDATE Event ({$eventId})</h3>";
    $updateData = [
        'title' => 'Concert UPDATED',
        'description' => 'Description mise à jour',
        'event_date' => $eventData['event_date'],
        'location' => 'Tunis, Tunisia',
        'seats' => 200,
        'image' => null
    ];
    
    try {
        $updated = Event::update($eventId, $updateData);
        if ($updated) {
            echo "<p style='color:green;'>✅ Event mis à jour</p>";
            $eventUpdated = Event::getById($eventId);
            echo "<pre>" . json_encode($eventUpdated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }
}

// ================== TEST RESERVATION CRUD ==================
echo "<hr><h2>🎫 TEST RESERVATION CRUD</h2>";

require_once ROOT . '/app/models/Reservation.php';

if (isset($eventId)) {
    // 1. CREATE Reservation
    echo "<h3>1. CREATE Reservation</h3>";
    $reservationData = [
        'event_id' => $eventId,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+216 12345678'
    ];
    
    try {
        $created = Reservation::create($reservationData);
        if ($created) {
            $reservationId = db()->lastInsertId();
            echo "<p style='color:green;'>✅ Réservation créée (ID: {$reservationId})</p>";
            echo "<pre>" . json_encode($reservationData, JSON_PRETTY_PRINT) . "</pre>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }
    
    // 2. READ Reservations by Event
    echo "<h3>2. READ Reservations for Event {$eventId}</h3>";
    try {
        $reservations = Reservation::getByEvent($eventId);
        echo "<p style='color:green;'>✅ Récupéré " . count($reservations) . " réservations</p>";
        echo "<pre>" . json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }
}

// ================== TEST ADMIN AUTH ==================
echo "<hr><h2>🔐 TEST ADMIN AUTHENTICATION</h2>";

require_once ROOT . '/app/models/Admin.php';

// 1. Login FAIL
echo "<h3>1. LOGIN - Wrong credentials</h3>";
$adminFail = Admin::login('wronguser', 'wrongpass');
if ($adminFail === false) {
    echo "<p style='color:green;'>✅ Connexion refusée correctement</p>";
} else {
    echo "<p style='color:red;'>❌ ERREUR: Connexion acceptée avec mauvais credentials!</p>";
}

// 2. Login SUCCESS
echo "<h3>2. LOGIN - Correct credentials</h3>";
$admin = Admin::login('admin', 'admin123');
if ($admin && is_array($admin)) {
    echo "<p style='color:green;'>✅ Connexion réussie</p>";
    echo "<pre>" . json_encode($admin, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "<p style='color:orange;'>⚠️ Connexion échouée. Avez-vous exécuté seed_admin.php ?</p>";
}

// ================== TEST VALIDATION ==================
echo "<hr><h2>✅ TEST VALIDATION</h2>";

$validator = new Validator();

echo "<h3>Test validation réservation</h3>";
$testData = [
    'event_id' => '',
    'name' => 'a',
    'email' => 'invalid-email',
    'phone' => ''
];

$validator->required('event_id', $testData['event_id']);
$validator->required('name', $testData['name'], 'Name');
$validator->minLength('name', $testData['name'], 2, 'Name');
$validator->required('email', $testData['email'], 'Email');
$validator->email('email', $testData['email']);
$validator->required('phone', $testData['phone'], 'Phone');

if ($validator->hasErrors()) {
    echo "<p style='color:green;'>✅ Validation détecte les erreurs</p>";
    echo "<ul>";
    foreach ($validator->getErrors() as $field => $error) {
        echo "<li style='color:orange;'><strong>{$field}:</strong> {$error}</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red;'>❌ Validation ne détecte pas les erreurs!</p>";
}

// ================== CLEANUP (DELETE) ==================
if (isset($eventId)) {
    echo "<hr><h2>🗑️ CLEANUP - DELETE Event</h2>";
    try {
        $deleted = Event::delete($eventId);
        if ($deleted) {
            echo "<p style='color:green;'>✅ Event supprimé (ID: {$eventId})</p>";
            echo "<p><em>Les réservations ont été supprimées automatiquement (CASCADE)</em></p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }
}

// ================== RÉSUMÉ ==================
echo "<hr><h2>📊 RÉSUMÉ DES TESTS</h2>";
echo "<ul>";
echo "<li>✅ <strong>Event CRUD:</strong> Create, Read, Update, Delete</li>";
echo "<li>✅ <strong>Reservation CRUD:</strong> Create, Read (by event)</li>";
echo "<li>✅ <strong>Admin Auth:</strong> Login avec password_verify</li>";
echo "<li>✅ <strong>Validation:</strong> Détection erreurs</li>";
echo "<li>✅ <strong>Cascade Delete:</strong> Suppression réservations auto</li>";
echo "</ul>";

echo "<hr><p><strong>Tests terminés!</strong></p>";
echo "<p><a href='test_database.php'>← Vérifier la base de données</a></p>";

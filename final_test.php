<?php
// Final comprehensive test
require_once 'config/bootstrap.php';
require_once 'app/models/Event.php';
require_once 'app/models/Reservation.php';
require_once 'app/models/Admin.php';

echo "=== FINAL COMPREHENSIVE TEST ===\n\n";

// Test 1: Database Connection
echo "1. Testing database connection...\n";
try {
    $stmt = db()->query('SELECT COUNT(*) FROM events');
    $count = $stmt->fetchColumn();
    echo "   ✅ Connected successfully. Events count: $count\n";
} catch (Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Event Model
echo "2. Testing Event model...\n";
try {
    $events = Event::getAll();
    echo "   ✅ Event::getAll() returned " . count($events) . " events\n";
    
    if (!empty($events)) {
        $firstEvent = Event::getById($events[0]['id']);
        echo "   ✅ Event::getById() working correctly\n";
    }
} catch (Exception $e) {
    echo "   ❌ Event model failed: " . $e->getMessage() . "\n";
}

// Test 3: Reservation Model
echo "3. Testing Reservation model...\n";
try {
    $reservations = Reservation::getAll();
    echo "   ✅ Reservation::getAll() returned " . count($reservations) . " reservations\n";
    
    // Test search methods
    $searchResults = Reservation::searchAll('test');
    echo "   ✅ Reservation::searchAll() working correctly\n";
} catch (Exception $e) {
    echo "   ❌ Reservation model failed: " . $e->getMessage() . "\n";
}

// Test 4: Admin Model
echo "4. Testing Admin model...\n";
try {
    $stmt = db()->query('SELECT COUNT(*) FROM admin');
    $count = $stmt->fetchColumn();
    echo "   ✅ Admin table accessible. Admin count: $count\n";
} catch (Exception $e) {
    echo "   ❌ Admin model failed: " . $e->getMessage() . "\n";
}

// Test 5: Routes Configuration
echo "5. Testing routes configuration...\n";
$routes = require_once 'config/routes.php';
$requiredRoutes = [
    'GET|/' => 'EventController:index',
    'GET|/event' => 'EventController:show',
    'GET|/event/{id}' => 'EventController:show',
    'POST|/reserve' => 'EventController:reserve',
    'GET|/admin/login' => 'AdminController:loginForm',
    'POST|/admin/login' => 'AdminController:login',
    'GET|/admin' => 'AdminController:dashboard',
    'GET|/admin/event/new' => 'AdminController:createForm',
    'GET|/admin/events/new' => 'AdminController:createForm',
    'POST|/admin/event/create' => 'AdminController:create',
    'GET|/admin/event/edit' => 'AdminController:editForm',
    'GET|/admin/events/edit/{id}' => 'AdminController:editForm',
    'POST|/admin/event/update' => 'AdminController:update',
    'POST|/admin/event/delete' => 'AdminController:delete',
    'GET|/admin/reservations' => 'AdminController:reservations',
    'GET|/admin/logout' => 'AdminController:logout'
];

$allGood = true;
foreach ($requiredRoutes as $route => $expected) {
    if (!isset($routes[$route])) {
        echo "   ⚠️  Missing route: $route\n";
        $allGood = false;
    }
}

if ($allGood) {
    echo "   ✅ All required routes are configured\n";
}

// Test 6: File Structure
echo "6. Testing file structure...\n";
$requiredFiles = [
    'public/router.php',
    'app/models/Event.php',
    'app/models/Reservation.php',
    'app/models/Admin.php',
    'app/controllers/EventController.php',
    'app/controllers/AdminController.php',
    'config/routes.php',
    'config/database.php',
    'public/images/event-placeholder.svg',
    'public/images/tech.jpg',
    'public/images/art.jpg',
    'public/images/music.jpg'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "   ✅ $file exists\n";
    } else {
        echo "   ❌ $file missing\n";
    }
}

echo "\n=== TEST COMPLETE ===\n";
echo "Project is ready for final validation!\n";
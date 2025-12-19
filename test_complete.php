<?php
// Complete test script for MiniEvent Reservation System
require_once 'config/bootstrap.php';

echo "=== MiniEvent Reservation System Test ===\n\n";

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

// Test 2: Admin User
echo "2. Testing admin user...\n";
try {
    $stmt = db()->query('SELECT COUNT(*) FROM admin');
    $count = $stmt->fetchColumn();
    echo "   ✅ Admin table accessible. Admin count: $count\n";
    
    if ($count == 0) {
        echo "   ⚠️  No admin user found. You may need to run seed_admin.php\n";
    }
} catch (Exception $e) {
    echo "   ❌ Admin table access failed: " . $e->getMessage() . "\n";
}

// Test 3: Reservations Table
echo "3. Testing reservations table...\n";
try {
    $stmt = db()->query('SELECT COUNT(*) FROM reservations');
    $count = $stmt->fetchColumn();
    echo "   ✅ Reservations table accessible. Reservations count: $count\n";
} catch (Exception $e) {
    echo "   ❌ Reservations table access failed: " . $e->getMessage() . "\n";
}

// Test 4: Image Files
echo "4. Testing image files...\n";
$imageFiles = [
    'public/images/tech.jpg',
    'public/images/art.jpg', 
    'public/images/music.jpg',
    'public/images/event-placeholder.svg'
];

foreach ($imageFiles as $imageFile) {
    if (file_exists($imageFile)) {
        echo "   ✅ $imageFile exists\n";
    } else {
        echo "   ❌ $imageFile missing\n";
    }
}

// Test 5: Router File
echo "5. Testing router file...\n";
if (file_exists('public/router.php')) {
    echo "   ✅ Router file exists\n";
} else {
    echo "   ❌ Router file missing\n";
}

echo "\n=== Test Complete ===\n";
echo "To test the full application:\n";
echo "1. Start the server: php -S localhost:8000 -t public public/router.php\n";
echo "2. Visit http://localhost:8000/ in your browser\n";
echo "3. Test admin login with admin/admin123\n";
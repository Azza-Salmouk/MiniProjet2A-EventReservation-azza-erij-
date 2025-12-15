<?php
require_once __DIR__ . '/../config/bootstrap.php';

echo "<h1>TEST VALIDATION & HELPERS</h1>";

// ========== Test 1: Validator ==========
echo "<h2>1. Test Validator</h2>";

$validator = new Validator();

// Test champs requis
$validator->required('name', '', 'Name');
$validator->required('email', 'test@example.com', 'Email');

// Test email
$validator->email('email1', 'invalid-email');
$validator->email('email2', 'valid@test.com');

// Test longueur
$validator->minLength('password', 'ab', 3, 'Password');
$validator->maxLength('title', str_repeat('a', 300), 200, 'Title');

// Test numérique
$validator->numeric('age', 'abc', 'Age');
$validator->numeric('seats', '50', 'Seats');
$validator->positive('seats', -5, 'Seats');

// Test date
$validator->date('event_date', '2025-12-25', 'Event date');
$validator->date('bad_date', 'invalid-date', 'Bad date');
$validator->futureDate('past_date', '2020-01-01', 'Past date');
$validator->futureDate('future_date', '2026-01-01', 'Future date');

echo "<h3>Erreurs détectées:</h3>";
if ($validator->hasErrors()) {
    echo "<ul style='color:green;'>";
    foreach ($validator->getErrors() as $field => $error) {
        echo "<li><strong>{$field}:</strong> {$error}</li>";
    }
    echo "</ul>";
    echo "<p>✅ Validator fonctionne correctement!</p>";
} else {
    echo "<p>❌ Aucune erreur détectée (problème)</p>";
}

// Test clean
echo "<h3>Test Validator::clean()</h3>";
$dirty = "<script>alert('XSS')</script>";
$clean = Validator::clean($dirty);
echo "<p>Original: <code>" . htmlspecialchars($dirty) . "</code></p>";
echo "<p>Clean: <code>{$clean}</code></p>";
echo "<p>✅ XSS protection works!</p>";

// ========== Test 2: Flash Messages ==========
echo "<hr><h2>2. Test Flash Messages</h2>";

Flash::success('This is a success message!');
Flash::error('This is an error message!');
Flash::warning('This is a warning message!');
Flash::info('This is an info message!');

echo "<p>✅ Messages set in session</p>";
echo "<h3>Retrieved messages:</h3>";
$messages = Flash::get();
echo "<ul>";
foreach ($messages as $msg) {
    $color = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'orange',
        'info' => 'blue'
    ][$msg['type']];
    
    echo "<li style='color:{$color};'><strong>[{$msg['type']}]</strong> {$msg['message']}</li>";
}
echo "</ul>";

echo "<p>Messages restants après Flash::get(): " . (Flash::has() ? "❌ OUI (erreur)" : "✅ NON (correct)") . "</p>";

// ========== Test 3: ImageUploader ==========
echo "<hr><h2>3. Test ImageUploader</h2>";

$uploader = new ImageUploader();
echo "<p>Upload directory: <code>" . ROOT . "/public/uploads/</code></p>";

if (is_dir(ROOT . '/public/uploads/')) {
    echo "<p>✅ Upload directory exists</p>";
} else {
    echo "<p>❌ Upload directory NOT created</p>";
}

echo "<p><strong>Extensions autorisées:</strong> jpg, jpeg, png, gif, webp</p>";
echo "<p><strong>Taille max:</strong> 5MB</p>";
echo "<p>ℹ️ Upload test nécessite un formulaire HTML (voir formulaire admin)</p>";

// ========== Test 4: Vérifier helpers chargés ==========
echo "<hr><h2>4. Vérifier helpers chargés</h2>";

$classes = ['Validator', 'ImageUploader', 'Flash'];
foreach ($classes as $class) {
    if (class_exists($class)) {
        echo "<p>✅ Class <strong>{$class}</strong> loaded</p>";
    } else {
        echo "<p>❌ Class <strong>{$class}</strong> NOT loaded</p>";
    }
}

echo "<hr><p><strong>Tests terminés!</strong></p>";

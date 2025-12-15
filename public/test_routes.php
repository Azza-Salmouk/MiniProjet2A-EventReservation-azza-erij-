<?php
require_once __DIR__ . '/../config/bootstrap.php';

echo "<h1>TEST ROUTING SYSTEM</h1>";

// Charger les routes
$routes = require_once ROOT . '/config/routes.php';

echo "<h2>Routes définies:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse:collapse; width:100%;'>";
echo "<tr style='background:#f0f0f0;'><th>Method</th><th>Path</th><th>Controller</th><th>Action</th><th>Test</th></tr>";

foreach ($routes as $key => $route) {
    list($method, $path) = explode('|', $key);
    $controller = $route['controller'];
    $action = $route['action'];
    
    // Générer URL de test
    $testUrl = "http://localhost:8000" . $path;
    
    // Couleur selon type
    $color = ($method === 'GET') ? '#e8f5e9' : '#fff3e0';
    
    echo "<tr style='background:{$color};'>";
    echo "<td><strong>{$method}</strong></td>";
    echo "<td><code>{$path}</code></td>";
    echo "<td>{$controller}</td>";
    echo "<td>{$action}</td>";
    
    if ($method === 'GET') {
        echo "<td><a href='{$testUrl}' target='_blank'>Tester →</a></td>";
    } else {
        echo "<td><em>POST (formulaire requis)</em></td>";
    }
    
    echo "</tr>";
}

echo "</table>";

echo "<hr>";
echo "<h2>Tests rapides:</h2>";
echo "<ul>";
echo "<li><a href='http://localhost:8000/' target='_blank'>✅ Page d'accueil (GET /)</a></li>";
echo "<li><a href='http://localhost:8000/admin/login' target='_blank'>✅ Login admin (GET /admin/login)</a></li>";
echo "<li><a href='http://localhost:8000/admin' target='_blank'>⚠️ Dashboard admin (GET /admin) - Nécessite login</a></li>";
echo "<li><a href='http://localhost:8000/invalid-route' target='_blank'>❌ Route invalide (404 test)</a></li>";
echo "</ul>";

echo "<p><strong>Total routes:</strong> " . count($routes) . "</p>";

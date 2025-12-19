<?php
require_once __DIR__ . '/../config/bootstrap.php';

// Charger les routes
$routes = require_once ROOT . '/config/routes.php';

// Récupérer la méthode HTTP et le chemin
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Créer la clé de route
$routeKey = $method . '|' . $path;

// Chercher la route correspondante
if (isset($routes[$routeKey])) {
    $route = $routes[$routeKey];
    $controllerName = $route['controller'];
    $action = $route['action'];
    
    // Charger le fichier du contrôleur
    $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        // Instancier le contrôleur et appeler l'action
        $controller = new $controllerName();
        
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            http_response_code(500);
            die("Action '{$action}' not found in controller '{$controllerName}'");
        }
    } else {
        http_response_code(500);
        die("Controller file not found: {$controllerFile}");
    }
} else {
    // Route non trouvée - 404
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>Route: <code>{$routeKey}</code> not found.</p>";
    echo "<p><a href='/'>← Return to homepage</a></p>";
}

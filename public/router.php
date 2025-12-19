<?php
// ✅ IMPORTANT: allow PHP built-in server to serve static files (CSS/JS/Images)
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (is_file($path)) {
        return false; // let the server handle the static file
    }
}

require_once __DIR__ . '/../config/bootstrap.php';

// Charger les routes
$routes = require_once ROOT . '/config/routes.php';

// Récupérer la méthode HTTP et le chemin
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

// Chercher la route correspondante
foreach ($routes as $pattern => $routeData) {
    // Extract the method and path from pattern (format: METHOD|PATH)
    $patternParts = explode('|', $pattern, 2);
    if (count($patternParts) != 2) {
        continue;
    }
    
    $patternMethod = $patternParts[0];
    $patternPath = $patternParts[1];
    
    // Skip if method doesn't match
    if ($patternMethod !== $method) {
        continue;
    }
    
    // Normalize pattern path
    $normalizedPatternPath = rtrim($patternPath, '/') ?: '/';
    
    // Extract parameter names and convert to regex
    $paramNames = [];
    $regexPattern = preg_replace_callback('#\{(\w+)\}#', function($m) use (&$paramNames) {
        $paramNames[] = $m[1];
        return '([^/]+)';
    }, $normalizedPatternPath);
    
    $regexPattern = '#^' . rtrim($regexPattern, '/') . '$#';
    
    // Check if URI matches pattern
    if (preg_match($regexPattern, $uri, $matches)) {
        // Remove full match
        array_shift($matches);
        
        // Extract parameters and add to $_GET
        foreach ($paramNames as $i => $name) {
            $_GET[$name] = $matches[$i] ?? null;
        }
        
        // Dispatch handler (controller/action)
        $controllerName = $routeData['controller'];
        $action = $routeData['action'];
        
        // Charger le fichier du contrôleur
        $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Instancier le contrôleur et appeler l'action
            $controller = new $controllerName();
            
            if (method_exists($controller, $action)) {
                $controller->$action();
                exit;
            } else {
                http_response_code(500);
                die("Action '{$action}' not found in controller '{$controllerName}'");
            }
        } else {
            http_response_code(500);
            die("Controller file not found: {$controllerFile}");
        }
    }
}

// 404
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
echo "<p>Route: {$method} | {$uri} not found.</p>";
echo "<p><a href='/'>← Return to homepage</a></p>";
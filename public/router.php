<?php
// ✅ IMPORTANT: allow PHP built-in server to serve static files (CSS/JS/Images)
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? '/';
    $requestedFile = __DIR__ . $path;
    if ($path !== '/' && file_exists($requestedFile)) {
        return false; // laisse PHP server servir css/js/images
    }
}

require_once __DIR__ . '/../config/bootstrap.php';

// Charger les routes
$routes = require_once ROOT . '/config/routes.php';

// Normalize function
$normalize = function($p) {
    $p = rtrim($p, '/');
    return $p === '' ? '/' : $p;
};

// Récupérer la méthode HTTP et le chemin
$path = $normalize(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$method = $_SERVER['REQUEST_METHOD'];

// Check for exact match first
$routeKey = $method . '|' . $path;
if (isset($routes[$routeKey])) {
    $routeData = $routes[$routeKey];
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

// Chercher la route correspondante (for parameterized routes)
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
    $normalizedPatternPath = $normalize($patternPath);
    
    // Extract parameter names and convert to regex
    $paramNames = [];
    $regexPattern = preg_replace_callback('#\{(\w+)\}#', function($m) use (&$paramNames) {
        $paramNames[] = $m[1];
        return '([^/]+)';
    }, $normalizedPatternPath);
    
    $regexPattern = '#^' . rtrim($regexPattern, '/') . '$#';
    
    // Check if path matches pattern
    if (preg_match($regexPattern, $path, $matches)) {
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
echo "<p>Route: {$method} | {$path} not found.</p>";
echo "<p><a href='/'>← Return to homepage</a></p>";
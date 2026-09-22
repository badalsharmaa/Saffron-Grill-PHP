<?php
/**
 * Saffron Grill - Universal Routing Gateway & API Dispatcher
 * Adheres to Enterprise PHP Production Server Deployment Guide.
 * Routes clean URLs, API endpoints, admin portal, and error boundary.
 */

// Error handling settings for production runtime
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

$rootDir = dirname(__DIR__);

// Handle request path
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = urldecode($uri ?: '/');
$trimmed = trim($uri, '/');

// Check if explicit path parameter provided
$pathParam = trim($_GET['path'] ?? '', '/');

try {
    // 1. Static Assets fallback if routed here
    if (str_starts_with($trimmed, 'assets/')) {
        $filePath = $rootDir . '/' . $trimmed;
        if (file_exists($filePath) && is_file($filePath)) {
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimes = [
                'css'   => 'text/css',
                'js'    => 'application/javascript',
                'png'   => 'image/png',
                'jpg'   => 'image/jpeg',
                'jpeg'  => 'image/jpeg',
                'gif'   => 'image/gif',
                'svg'   => 'image/svg+xml',
                'webp'  => 'image/webp',
                'woff'  => 'font/woff',
                'woff2' => 'font/woff2',
                'ttf'   => 'font/ttf',
                'json'  => 'application/json',
            ];
            $contentType = $mimes[$ext] ?? mime_content_type($filePath) ?? 'application/octet-stream';
            header('Content-Type: ' . $contentType);
            readfile($filePath);
            exit;
        }
    }

    // 2. Direct API Endpoints (e.g. /api/... or ?path=...)
    $isApiRoute = str_starts_with($trimmed, 'api') || !empty($pathParam);
    if ($isApiRoute) {
        header('Content-Type: application/json; charset=UTF-8');
        require_once $rootDir . '/config/config.php';

        $apiSub = $pathParam;
        if (empty($apiSub)) {
            $apiSub = trim(preg_replace('#^api/?#', '', $trimmed), '/');
        }

        switch ($apiSub) {
            case 'menu':
            case 'dishes':
                require_once __DIR__ . '/menu.php';
                exit;

            case 'reserve':
            case 'reservation':
                require_once __DIR__ . '/reservation.php';
                exit;

            case 'catering':
                require_once __DIR__ . '/catering.php';
                exit;

            case 'status':
            case 'health':
                echo json_encode([
                    'status' => 'healthy',
                    'app' => defined('APP_NAME') ? APP_NAME : 'Saffron Grill',
                    'time' => date('c'),
                    'restaurant_status' => function_exists('get_restaurant_status') ? get_restaurant_status() : null
                ]);
                exit;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint not found', 'path' => $apiSub]);
                exit;
        }
    }

    // 3. Root Homepage
    if ($trimmed === '' || $trimmed === 'index' || $trimmed === 'index.php') {
        require $rootDir . '/index.php';
        exit;
    }

    // 4. Admin Routing
    if ($trimmed === 'admin') {
        header('Location: /admin/');
        exit;
    }
    if ($trimmed === 'admin/') {
        require $rootDir . '/admin/index.php';
        exit;
    }
    if (str_starts_with($trimmed, 'admin/')) {
        $adminSub = substr($trimmed, 6);
        $adminFile = $rootDir . '/admin/' . $adminSub;

        if (file_exists($adminFile) && is_file($adminFile) && str_ends_with($adminFile, '.php')) {
            require $adminFile;
            exit;
        }
        if (file_exists($adminFile . '.php') && is_file($adminFile . '.php')) {
            require $adminFile . '.php';
            exit;
        }
    }

    // Buffet redirect to menu
    if ($trimmed === 'buffet' || $trimmed === 'buffet.php') {
        header('Location: /menu', true, 301);
        exit;
    }

    // Sitemap clean URL redirect
    if ($trimmed === 'sitemap') {
        header('Location: /sitemap.xml', true, 301);
        exit;
    }

    // 5. Clean URLs for Public Pages (e.g. /menu, /catering, /contact, /reserve, /story, /privacy-policy, /terms, /consent-sync, /send-mail)
    $directPhp = $rootDir . '/' . $trimmed . '.php';
    if (file_exists($directPhp) && is_file($directPhp)) {
        require $directPhp;
        exit;
    }

    // 6. Direct PHP files
    $exactFile = $rootDir . '/' . $trimmed;
    if (file_exists($exactFile) && is_file($exactFile) && str_ends_with($exactFile, '.php')) {
        require $exactFile;
        exit;
    }

    // 7. Static Root Text / Metadata Files
    $staticTextFiles = [
        'robots.txt' => 'text/plain; charset=UTF-8',
        'sitemap.xml' => 'application/xml; charset=UTF-8',
        'llms.txt' => 'text/plain; charset=UTF-8',
        'llms-full.txt' => 'text/plain; charset=UTF-8',
        'restaurant-facts.json' => 'application/json; charset=UTF-8',
    ];
    if (isset($staticTextFiles[$trimmed]) && file_exists($rootDir . '/' . $trimmed)) {
        header('Content-Type: ' . $staticTextFiles[$trimmed]);
        readfile($rootDir . '/' . $trimmed);
        exit;
    }

    // 8. 404 Fallback
    http_response_code(404);
    if (file_exists($rootDir . '/404.php')) {
        require $rootDir . '/404.php';
    } else {
        echo "404 Not Found";
    }
    exit;

} catch (\Throwable $e) {
    error_log("Unhandled exception in Universal Routing Gateway: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    if (file_exists($rootDir . '/404.php')) {
        require $rootDir . '/404.php';
    } else {
        echo "500 Internal Server Error";
    }
    exit;
}

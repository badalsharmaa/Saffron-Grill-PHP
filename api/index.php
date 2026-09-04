<?php
/**
 * Saffron Grill - Universal API Gateway
 */
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/config.php';

$path = trim($_GET['path'] ?? '', '/');
if (empty($path)) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = trim(str_replace('/api', '', $uri), '/');
}

switch ($path) {
    case 'menu':
    case 'dishes':
        require_once __DIR__ . '/menu.php';
        break;

    case 'reserve':
    case 'reservation':
        require_once __DIR__ . '/reservation.php';
        break;

    case 'catering':
        require_once __DIR__ . '/catering.php';
        break;

    case 'status':
    case 'health':
        echo json_encode([
            'status' => 'healthy',
            'app' => APP_NAME,
            'time' => date('c'),
            'restaurant_status' => get_restaurant_status()
        ]);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found', 'path' => $path]);
        break;
}

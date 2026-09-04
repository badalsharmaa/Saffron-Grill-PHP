<?php
/**
 * Local Development CLI Router for PHP Built-in Server
 * (Emulates Apache .htaccess clean URL rewriting)
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = __DIR__ . $uri;

// 1. Security check - Block sensitive files
if (preg_match('/(^|\/)\.(env|git|htaccess)/i', $uri) || preg_match('/\.(env|db|sqlite|log|ini|git|htaccess)/i', $uri) || strpos($uri, '/private') === 0 || strpos($uri, '/admin/data') === 0) {
    http_response_code(403);
    echo "403 Forbidden";
    exit;
}

// 2. Direct Static File (images, css, js, etc.)
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false; // Built-in server handles static assets and php files directly
}

// 3. Admin Directory Root (e.g. /admin or /admin/)
if ($uri === '/admin' || $uri === '/admin/') {
    require __DIR__ . '/admin/index.php';
    exit;
}

// 4. Directory index resolution (e.g. /dir/ -> /dir/index.php)
if (is_dir($filePath) && file_exists($filePath . '/index.php')) {
    require $filePath . '/index.php';
    exit;
}

// 5. Clean URL without extension (e.g. /story -> story.php, /admin/login -> admin/login.php)
$cleanPhp = __DIR__ . rtrim($uri, '/') . '.php';
if ($uri !== '/' && file_exists($cleanPhp)) {
    require $cleanPhp;
    exit;
}

// 6. API Gateway Routing (e.g. /api/health -> api/index.php)
if (strpos($uri, '/api') === 0) {
    require __DIR__ . '/api/index.php';
    exit;
}

// 7. Default Homepage
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    exit;
}

// 8. 404 Handler
http_response_code(404);
if (file_exists(__DIR__ . '/404.php')) {
    require __DIR__ . '/404.php';
} else {
    echo "404 Not Found";
}
exit;


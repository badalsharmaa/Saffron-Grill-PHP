<?php
/**
 * Test: Endpoint Health, Status Codes & Content Verification
 */

echo "=== Running HTTP Endpoint Verification ===\n";

$baseUrl = 'http://127.0.0.1:8088';

$endpoints = [
    '/' => 200,
    '/index' => 200,
    '/story' => 200,
    '/buffet' => 200,
    '/menu' => 200,
    '/catering' => 200,
    '/contact' => 200,
    '/reserve' => 200,
    '/privacy-policy' => 200,
    '/terms' => 200,
    '/admin/login.php' => 200,
    '/admin/login' => 200,
    '/admin/data/saffron_crm.db' => 403,
    '/.env' => 403,
    '/api/health' => 200,
    '/api/menu' => 200,
    '/sitemap.xml' => 200,
    '/robots.txt' => 200,
    '/llms.txt' => 200,
    '/llms-full.txt' => 200,
    '/restaurant-facts.json' => 200,
    '/non-existent-page' => 404,
];

$passed = 0;
$failed = 0;

foreach ($endpoints as $path => $expectedCode) {
    $url = $baseUrl . $path;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === $expectedCode) {
        echo "✓ {$path} -> HTTP {$httpCode}\n";
        $passed++;
    } else {
        echo "✗ {$path} -> Got HTTP {$httpCode}, expected {$expectedCode}\n";
        $failed++;
    }
}

echo "\nEndpoint Summary: {$passed} passed, {$failed} failed.\n";
if ($failed > 0) {
    exit(1);
}
echo ">>> ALL ENDPOINT TESTS PASSED! <<<\n";

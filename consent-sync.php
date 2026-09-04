<?php
/**
 * Saffron Grill - Consent Mode v2 Sync Endpoint
 */
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? [];
$consent = trim($input['consent'] ?? 'denied');
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

try {
    $pdo = get_db();
    $stmt = $pdo->prepare("INSERT INTO consent_logs (visitor_id, consent_status, ad_storage, analytics_storage, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
    $visitorId = hash('sha256', $ip . $ua);
    $stmt->execute([
        $visitorId,
        $consent,
        $consent === 'granted' ? 'granted' : 'denied',
        $consent === 'granted' ? 'granted' : 'denied',
        $ip,
        substr($ua, 0, 255)
    ]);
    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    echo json_encode(['success' => false]);
}

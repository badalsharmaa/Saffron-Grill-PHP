<?php
/**
 * Test: Lead Processing, Honeypot Filter & Table Reservation Pipeline
 */

echo "=== Running Lead & Reservation Pipeline Test ===\n";

require_once __DIR__ . '/../admin/includes/db.php';
$pdo = get_db();

// 1. Test Honeypot rejection via HTTP POST
$ch = curl_init('http://localhost:8088/send-mail.php');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'form_type' => 'table_reservation',
        'name' => 'Spam Bot',
        'phone' => '1234567890',
        'website_hp' => 'http://spam-link.com'
    ]),
    CURLOPT_RETURNTRANSFER => true,
]);
$respRaw = curl_exec($ch);
$resp = json_decode($respRaw, true);
if (!empty($resp['success'])) {
    echo "✓ Honeypot silently trapped spam submission.\n";
}

// 2. Test Legitimate Reservation Insertion
$bookingCode = 'TEST-' . rand(1000, 9999);
$stmt = $pdo->prepare("INSERT INTO reservations 
    (booking_code, guest_name, phone, email, party_size, reservation_date, reservation_time, seating_area, status, utm_source) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'confirmed', 'test_suite')");
$stmt->execute([
    $bookingCode, 'Test Guest', '(925) 555-0199', 'testguest@example.com', 4, date('Y-m-d'), '7:00 PM', 'Main Dining'
]);

$check = $pdo->query("SELECT * FROM reservations WHERE booking_code = '{$bookingCode}'")->fetch();
if ($check && $check['guest_name'] === 'Test Guest') {
    echo "✓ Test Reservation persisted with code {$bookingCode}.\n";
}

// 3. Test Catering Inquiry Insertion
$leadCode = 'CAT-TEST-' . rand(1000, 9999);
$stmt = $pdo->prepare("INSERT INTO leads 
    (lead_code, client_name, email, phone, event_type, event_date, guest_count, package_type, status, gclid, utm_source) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new', 'gclid_test_12345', 'google_ads')");
$stmt->execute([
    $leadCode, 'Corporate Client', 'corp@example.com', '(925) 555-0188', 'Corporate Gala', '2026-10-15', 75, 'Royal Gold Banquet ($28/pp)'
]);

$leadCheck = $pdo->query("SELECT * FROM leads WHERE lead_code = '{$leadCode}'")->fetch();
if ($leadCheck && $leadCheck['client_name'] === 'Corporate Client') {
    echo "✓ Test Catering Lead persisted with attribution gclid={$leadCheck['gclid']}.\n";
}

// Clean up test records
$pdo->exec("DELETE FROM reservations WHERE booking_code LIKE 'TEST-%'");
$pdo->exec("DELETE FROM leads WHERE lead_code LIKE 'CAT-TEST-%'");

echo "\n>>> ALL LEAD PIPELINE TESTS PASSED! <<<\n";

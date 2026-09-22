<?php
/**
 * Saffron Grill - Unified Form Handler, Lead Recorder & Notification Dispatcher
 * Adheres strictly to Enterprise Production Deployment Guide
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/config/config.php';

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || 
          (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// 1. Honeypot Spam Check
$honeypot = trim($_POST['website_hp'] ?? '');
if (!empty($honeypot)) {
    // Silently return success to waste bot resources without persisting spam
    echo json_encode(['success' => true, 'message' => 'Inquiry received. Thank you!']);
    exit;
}

// 2. Identify Form Type
$formType = trim($_POST['form_type'] ?? 'table_reservation');
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

$pdo = get_db();

if ($formType === 'table_reservation') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $partySize = (int)($_POST['party_size'] ?? 2);
    $resDate = trim($_POST['reservation_date'] ?? date('Y-m-d'));
    $resTime = trim($_POST['reservation_time'] ?? '5:00 PM');
    $seating = trim($_POST['seating_area'] ?? 'Main Dining');
    $specialRequests = trim($_POST['special_requests'] ?? '');

    $gclid = trim($_POST['gclid'] ?? '');
    $utmSource = trim($_POST['utm_source'] ?? '');
    $utmMedium = trim($_POST['utm_medium'] ?? '');
    $utmCampaign = trim($_POST['utm_campaign'] ?? '');

    if (empty($name) || empty($phone) || empty($resDate) || empty($resTime)) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Phone, Date, and Time).']);
        exit;
    }

    $bookingCode = 'SG-' . strtoupper(substr(uniqid(), -6));

    try {
        $stmt = $pdo->prepare("INSERT INTO reservations 
            (booking_code, guest_name, phone, email, party_size, reservation_date, reservation_time, seating_area, special_requests, status, gclid, utm_source, utm_medium, utm_campaign, ip_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'confirmed', ?, ?, ?, ?, ?)");
        $stmt->execute([
            $bookingCode, $name, $phone, $email, $partySize, $resDate, $resTime, $seating, $specialRequests,
            $gclid, $utmSource, $utmMedium, $utmCampaign, $ip
        ]);

        // Email Notification to Restaurant
        $adminEmail = get_setting('contact_email', 'gosaffrongrill@gmail.com');
        $subject = "🍽️ New Table Reservation: {$bookingCode} ({$name} - Party of {$partySize})";
        $body = "New Table Reservation at Saffron Grill San Ramon:\n\n" .
                "Booking Code: {$bookingCode}\n" .
                "Guest Name: {$name}\n" .
                "Phone: {$phone}\n" .
                "Email: {$email}\n" .
                "Date: {$resDate}\n" .
                "Time: {$resTime}\n" .
                "Party Size: {$partySize}\n" .
                "Seating: {$seating}\n" .
                "Special Requests: {$specialRequests}\n" .
                "Source: " . ($utmSource ?: 'Direct') . "\n";

        @mail($adminEmail, $subject, $body, "From: no-reply@saffrongrillrestaurant.com\r\nReply-To: " . ($email ?: $adminEmail));

        echo json_encode([
            'success' => true,
            'booking_code' => $bookingCode,
            'message' => 'Your reservation is confirmed! Reference: ' . $bookingCode
        ]);
        exit;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Could not save reservation. Error: ' . $e->getMessage()]);
        exit;
    }
} elseif ($formType === 'catering_inquiry') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $eventType = trim($_POST['event_type'] ?? 'Catering');
    $eventDate = trim($_POST['event_date'] ?? '');
    $guestCount = (int)($_POST['guest_count'] ?? 50);
    $packageType = trim($_POST['package_type'] ?? 'Royal Gold Banquet ($28/pp)');
    $venueLocation = trim($_POST['venue_location'] ?? 'San Ramon / Tri-Valley');
    $notes = trim($_POST['message'] ?? '');

    $gclid = trim($_POST['gclid'] ?? '');
    $gbraid = trim($_POST['gbraid'] ?? '');
    $wbraid = trim($_POST['wbraid'] ?? '');
    $utmSource = trim($_POST['utm_source'] ?? '');
    $utmMedium = trim($_POST['utm_medium'] ?? '');
    $utmCampaign = trim($_POST['utm_campaign'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($eventDate)) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Please provide Name, Email, Phone, and Event Date.']);
        exit;
    }

    $minGuests = (int)get_setting('min_catering_guests', 10);
    if ($guestCount < $minGuests) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => "Event catering packages require a minimum of {$minGuests} guests."]);
        exit;
    }

    $leadCode = 'CAT-' . strtoupper(substr(uniqid(), -6));

    try {
        $stmt = $pdo->prepare("INSERT INTO leads 
            (lead_code, client_name, email, phone, event_type, event_date, guest_count, package_type, venue_location, special_notes, status, gclid, gbraid, wbraid, utm_source, utm_medium, utm_campaign, ip_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $leadCode, $name, $email, $phone, $eventType, $eventDate, $guestCount, $packageType, $venueLocation, $notes,
            $gclid, $gbraid, $wbraid, $utmSource, $utmMedium, $utmCampaign, $ip
        ]);

        // Email Notification to Catering Team
        $adminEmail = get_setting('contact_email', 'gosaffrongrill@gmail.com');
        $subject = "🎉 New Catering Proposal Request: {$leadCode} ({$name} - {$guestCount} Guests)";
        $body = "New Catering Inquiry for Saffron Grill:\n\n" .
                "Inquiry Code: {$leadCode}\n" .
                "Client Name: {$name}\n" .
                "Phone: {$phone}\n" .
                "Email: {$email}\n" .
                "Event Date: {$eventDate}\n" .
                "Guest Count: {$guestCount}\n" .
                "Event Type: {$eventType}\n" .
                "Package: {$packageType}\n" .
                "Notes: {$notes}\n" .
                "Campaign: " . ($utmCampaign ?: 'Direct') . "\n";

        @mail($adminEmail, $subject, $body, "From: no-reply@saffrongrillrestaurant.com\r\nReply-To: " . $email);

        echo json_encode([
            'success' => true,
            'lead_code' => $leadCode,
            'message' => 'Your catering inquiry has been received! Reference: ' . $leadCode
        ]);
        exit;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Could not save catering request: ' . $e->getMessage()]);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Unknown form type']);
    exit;
}

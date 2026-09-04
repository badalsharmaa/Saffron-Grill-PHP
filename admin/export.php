<?php
/**
 * Saffron Grill Admin - CSV Data Exporter
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$type = $_GET['type'] ?? 'reservations';
$pdo = get_db();

if ($type === 'leads') {
    $filename = 'saffron_catering_leads_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Lead Code', 'Client Name', 'Email', 'Phone', 'Event Type', 'Event Date', 'Guests', 'Package', 'Status', 'GCLID', 'Source', 'Created At']);

    $rows = $pdo->query("SELECT * FROM leads ORDER BY id DESC")->fetchAll();
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['id'], $r['lead_code'], $r['client_name'], $r['email'], $r['phone'],
            $r['event_type'], $r['event_date'], $r['guest_count'], $r['package_type'],
            $r['status'], $r['gclid'], $r['utm_source'], $r['created_at']
        ]);
    }
    fclose($out);
    exit;
} else {
    $filename = 'saffron_reservations_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Booking Code', 'Guest Name', 'Phone', 'Email', 'Party Size', 'Date', 'Time', 'Seating', 'Requests', 'Status', 'GCLID', 'Source', 'Created At']);

    $rows = $pdo->query("SELECT * FROM reservations ORDER BY id DESC")->fetchAll();
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['id'], $r['booking_code'], $r['guest_name'], $r['phone'], $r['email'],
            $r['party_size'], $r['reservation_date'], $r['reservation_time'], $r['seating_area'],
            $r['special_requests'], $r['status'], $r['gclid'], $r['utm_source'], $r['created_at']
        ]);
    }
    fclose($out);
    exit;
}

<?php
/**
 * CLI Worker: Hourly Google Ads Offline Conversion Exporter
 * Runs via crontab:
 * 0 * * * * /usr/bin/php /path/to/cli/export_conversions.php >> /path/to/private/logs/conversions.log 2>&1
 */

require_once __DIR__ . '/../admin/includes/db.php';

$pdo = get_db();
$now = date('Y-m-d H:i:s');
echo "[{$now}] Starting Google Ads conversion export worker...\n";

// Fetch unexported leads with valid GCLID or Google attribution
$stmt = $pdo->prepare("SELECT id, lead_code, client_name, email, phone, created_at, gclid, gbraid, wbraid 
    FROM leads 
    WHERE (gclid IS NOT NULL AND gclid != '') 
    ORDER BY id ASC LIMIT 50");
$stmt->execute();
$conversions = $stmt->fetchAll();

$count = count($conversions);
echo "[{$now}] Found {$count} qualifying offline conversions.\n";

if ($count > 0) {
    $exportFile = dirname(__DIR__) . '/private/logs/gads_conversions_' . date('Ymd_H') . '.csv';
    $fp = fopen($exportFile, 'w');
    fputcsv($fp, ['Google Click ID', 'Conversion Name', 'Conversion Time', 'Conversion Value', 'Currency']);

    foreach ($conversions as $c) {
        $convTime = date('Y-m-d H:i:s O', strtotime($c['created_at']));
        fputcsv($fp, [
            $c['gclid'],
            'Catering Lead Submission',
            $convTime,
            '250.00',
            'USD'
        ]);
    }
    fclose($fp);
    echo "[{$now}] Exported {$count} records to {$exportFile}\n";
}

echo "[{$now}] Conversion worker finished successfully.\n";

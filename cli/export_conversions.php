<?php
/**
 * CLI Worker: Hourly Google Ads Offline Conversion Exporter
 * Runs via crontab:
 * 0 * * * * /usr/bin/php /home/u603392249/domains/saffrongrillrestaurant.com/cli/export_conversions.php >> /home/u603392249/domains/saffrongrillrestaurant.com/private/logs/conversions.log 2>&1
 */

// Dual-path resolution for db.php (works both when cli/ is in repo root or outside public_html)
$dbPath = file_exists(__DIR__ . '/../admin/includes/db.php')
    ? __DIR__ . '/../admin/includes/db.php'
    : (file_exists(__DIR__ . '/../public_html/admin/includes/db.php')
        ? __DIR__ . '/../public_html/admin/includes/db.php'
        : dirname(__DIR__) . '/public_html/admin/includes/db.php');

require_once $dbPath;

$rootDir = dirname(__DIR__);
$privateDir = file_exists($rootDir . '/private') ? $rootDir . '/private' : (file_exists($rootDir . '/public_html/private') ? $rootDir . '/public_html/private' : $rootDir . '/private');
$logsDir = $privateDir . '/logs';
if (!is_dir($logsDir)) {
    @mkdir($logsDir, 0775, true);
}

$now = date('Y-m-d H:i:s');
echo "[{$now}] Starting Google Ads conversion export worker...\n";

$pdo = get_db();

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
    $exportFile = $logsDir . '/gads_conversions_' . date('Ymd_H') . '.csv';
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

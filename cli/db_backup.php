<?php
/**
 * CLI Worker: Scheduled Database Backup Runner
 * Runs via crontab:
 * 0 2 * * * /usr/bin/php /home/u603392249/domains/saffrongrillrestaurant.com/cli/db_backup.php >> /home/u603392249/domains/saffrongrillrestaurant.com/private/logs/backup.log 2>&1
 */

$dbPath = file_exists(__DIR__ . '/../admin/includes/db.php')
    ? __DIR__ . '/../admin/includes/db.php'
    : (file_exists(__DIR__ . '/../public_html/admin/includes/db.php')
        ? __DIR__ . '/../public_html/admin/includes/db.php'
        : dirname(__DIR__) . '/public_html/admin/includes/db.php');

require_once $dbPath;

$now = date('Y-m-d_His');
$rootDir = dirname(__DIR__);
$privateDir = file_exists($rootDir . '/private') ? $rootDir . '/private' : (file_exists($rootDir . '/public_html/private') ? $rootDir . '/public_html/private' : $rootDir . '/private');
$backupDir = $privateDir . '/backups';
if (!is_dir($backupDir)) {
    @mkdir($backupDir, 0775, true);
}

$driver = getenv('DB_DRIVER') ?: 'sqlite';

if ($driver === 'sqlite') {
    $relPath = getenv('DB_SQLITE_PATH') ?: 'admin/data/saffron_crm.db';
    if (str_starts_with($relPath, '/')) {
        $sourceDb = $relPath;
    } else {
        $sourceDb = file_exists($rootDir . '/' . ltrim($relPath, '/'))
            ? $rootDir . '/' . ltrim($relPath, '/')
            : (file_exists($rootDir . '/public_html/' . ltrim($relPath, '/'))
                ? $rootDir . '/public_html/' . ltrim($relPath, '/')
                : $rootDir . '/' . ltrim($relPath, '/'));
    }

    if (file_exists($sourceDb)) {
        $dest = "{$backupDir}/saffron_crm_{$now}.db";
        copy($sourceDb, $dest);
        echo "[{$now}] SQLite backup created: {$dest}\n";
    } else {
        echo "[{$now}] Warning: SQLite source database not found at {$sourceDb}\n";
    }
} else {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $db = getenv('DB_NAME') ?: 'saffron_grill';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASSWORD') ?: '';
    $dest = "{$backupDir}/saffron_mysql_{$now}.sql.gz";
    
    $cmd = "mysqldump -h {$host} -u {$user} " . ($pass ? "-p'{$pass}' " : '') . "{$db} | gzip > {$dest}";
    @exec($cmd, $output, $returnCode);
    echo "[{$now}] MySQL dump status: {$returnCode}\n";
}

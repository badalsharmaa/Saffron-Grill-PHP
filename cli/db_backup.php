<?php
/**
 * CLI Worker: Scheduled Database Backup Runner
 * Runs via crontab:
 * 0 2 * * * /usr/bin/php /path/to/cli/db_backup.php >> /path/to/private/logs/backup.log 2>&1
 */

require_once __DIR__ . '/../admin/includes/db.php';

$now = date('Y-m-d_His');
$backupDir = dirname(__DIR__) . '/private/backups';
if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);

$driver = getenv('DB_DRIVER') ?: 'sqlite';

if ($driver === 'sqlite') {
    $dbPath = dirname(__DIR__) . '/' . (getenv('DB_SQLITE_PATH') ?: 'admin/data/saffron_crm.db');
    if (file_exists($dbPath)) {
        $dest = "{$backupDir}/saffron_crm_{$now}.db";
        copy($dbPath, $dest);
        echo "[{$now}] SQLite backup created: {$dest}\n";
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

<?php
/**
 * Saffron Grill - Multi-Driver PDO Database Connector & Migration Runner
 * Supports SQLite (Local/Dev/Production Default) and MySQL (Production Enterprise)
 */

if (!function_exists('load_env')) {
    function load_env($filePath = null) {
        if ($filePath === null) {
            $candidates = [
                dirname(dirname(__DIR__)) . '/.env',
                dirname(dirname(__DIR__)) . '/.env.production',
                dirname(dirname(dirname(__DIR__))) . '/.env',
                dirname(dirname(dirname(__DIR__))) . '/.env.production',
            ];
            foreach ($candidates as $c) {
                if (file_exists($c)) {
                    $filePath = $c;
                    break;
                }
            }
        }
        if (!$filePath || !file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                // Strip surrounding quotes
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}

if (!function_exists('get_db')) {
    function get_db(): PDO {
        static $pdo = null;
        if ($pdo !== null) return $pdo;

        load_env();
        $driver = getenv('DB_DRIVER') ?: 'sqlite';
        $appEnv = getenv('APP_ENV') ?: 'development';

        if ($driver === 'mysql') {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_NAME') ?: 'saffron_grill';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: '';
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';
            $dsn  = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } else {
            $relPath = getenv('DB_SQLITE_PATH') ?: 'admin/data/saffron_crm.db';
            if (str_starts_with($relPath, '/')) {
                $dbFile = $relPath;
            } else {
                $dbFile = dirname(dirname(__DIR__)) . '/' . ltrim($relPath, '/');
            }
            $dbDir = dirname($dbFile);
            if (!is_dir($dbDir)) {
                @mkdir($dbDir, 0775, true);
            }
            $dsn = 'sqlite:' . $dbFile;
            $pdo = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            $pdo->exec('PRAGMA journal_mode = WAL;');
            $pdo->exec('PRAGMA foreign_keys = ON;');
        }

        // Run automatic schema migration if needed
        require_once __DIR__ . '/schema.php';
        migrate_schema_if_needed($pdo, $driver);

        return $pdo;
    }
}

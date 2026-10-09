<?php
/**
 * Saffron Grill — Custom CMS Configuration
 */

if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', __DIR__);
}

// Session security configuration
if (!defined('CMS_SESSION_NAME')) {
    define('CMS_SESSION_NAME', 'saffron_admin_session');
}
if (!defined('CMS_SESSION_LIFETIME')) {
    define('CMS_SESSION_LIFETIME', 7200); // 2 hours
}

// Database storage path
$preferredPrivate = dirname(__DIR__, 2) . '/private';
$localPrivate = dirname(__DIR__) . '/private';
$privateDir = (is_dir($preferredPrivate) && is_writable($preferredPrivate)) ? $preferredPrivate : $localPrivate;
if (!is_dir($privateDir)) {
    @mkdir($privateDir, 0755, true);
}

$dbPath = (is_dir($privateDir) && is_writable($privateDir))
    ? $privateDir . '/cms.db'
    : dirname(__DIR__) . '/admin/data/cms.db';

define('CMS_DB_PATH', $dbPath);

// Basic escape helper
if (!function_exists('e')) {
    function e(?string $string): string {
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
    }
}

// Redirect helper
if (!function_exists('cms_redirect')) {
    function cms_redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }
}

// Flash message helpers
if (!function_exists('cms_set_flash')) {
    function cms_set_flash(string $type, string $message): void {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $_SESSION['cms_flash'] = ['type' => $type, 'message' => $message];
    }
}

if (!function_exists('cms_get_flash')) {
    function cms_get_flash(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (isset($_SESSION['cms_flash'])) {
            $flash = $_SESSION['cms_flash'];
            unset($_SESSION['cms_flash']);
            return $flash;
        }
        return null;
    }
}

// CSRF Helpers
if (!function_exists('cms_generate_csrf')) {
    function cms_generate_csrf(): string {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (empty($_SESSION['cms_csrf_token'])) {
            $_SESSION['cms_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['cms_csrf_token'];
    }
}

if (!function_exists('cms_verify_csrf')) {
    function cms_verify_csrf(?string $token): bool {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (empty($token) || empty($_SESSION['cms_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['cms_csrf_token'], $token);
    }
}

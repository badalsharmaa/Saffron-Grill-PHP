<?php
/**
 * Saffron Grill - Global Application Configuration & Dynamic Settings
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$siteData = require __DIR__ . '/restaurant_data.php';

// Bootstrap Database
$dbPath = __DIR__ . '/../admin/includes/db.php';
if (file_exists($dbPath)) {
    require_once $dbPath;
}

// Function to fetch dynamic settings with caching
function get_setting(string $key, $default = null) {
    static $settingsCache = null;
    if ($settingsCache === null) {
        $settingsCache = [];
        try {
            if (function_exists('get_db')) {
                $pdo = get_db();
                $rows = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll();
                foreach ($rows as $r) {
                    $settingsCache[$r['setting_key']] = $r['setting_value'];
                }
            }
        } catch (Throwable $e) {
            // Database might be initializing or unreachable
        }
    }
    return $settingsCache[$key] ?? $default;
}

// Define Global Dynamic Constants
if (!defined('APP_NAME')) {
    define('APP_NAME', get_setting('site_name', $siteData['name']));
    define('APP_TAGLINE', get_setting('site_tagline', $siteData['tagline']));
    define('PHONE_PRIMARY', get_setting('contact_phone', $siteData['contact']['phone_primary']));
    define('PHONE_ALT', get_setting('contact_phone_alt', $siteData['contact']['phone_secondary']));
    define('PHONE_TEL', '+1' . preg_replace('/[^0-9]/', '', PHONE_PRIMARY));
    define('CONTACT_EMAIL', get_setting('contact_email', $siteData['contact']['email']));
    define('RESTAURANT_ADDRESS', get_setting('address_street', $siteData['contact']['address_street']) . ', ' . 
                                get_setting('address_city', $siteData['contact']['address_locality']) . ', ' . 
                                get_setting('address_state', $siteData['contact']['address_region']) . ' ' . 
                                get_setting('address_zip', $siteData['contact']['address_postal']));
    define('GEO_LAT', get_setting('geo_lat', $siteData['contact']['geo']['latitude']));
    define('GEO_LNG', get_setting('geo_lng', $siteData['contact']['geo']['longitude']));
    define('BUFFET_WEEKDAY_PRICE', get_setting('buffet_weekday_price', $siteData['hours']['lunch_weekday']['price']));
    define('BUFFET_WEEKEND_PRICE', get_setting('buffet_weekend_price', $siteData['hours']['lunch_weekend']['price']));
    define('GTM_CONTAINER_ID', get_setting('gtm_container_id', getenv('GTM_CONTAINER_ID') ?: ''));
    define('GA_MEASUREMENT_ID', get_setting('ga_measurement_id', getenv('GA_MEASUREMENT_ID') ?: 'G-B5FSX73C4M'));
    define('ORDER_ONLINE_URL', get_setting('order_online_url', 'https://order.boons.io/site/saffron-grill/390/y'));
}

// Base URL detection
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $base = rtrim($protocol . $host . $scriptDir, '/\\');
    define('BASE_URL', $base);
}

// Asset helper with automatic cache-busting
if (!function_exists('asset')) {
    function asset($path) {
        $clean = ltrim($path, '/');
        $fullPath = __DIR__ . '/../assets/' . $clean;
        if (!file_exists($fullPath)) {
            $fullPath = __DIR__ . '/../' . $clean;
        }
        $v = file_exists($fullPath) ? filemtime($fullPath) : '1.0';
        return '/assets/' . $clean . '?v=' . $v;
    }
}

// HTML XSS Escaping helper
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

// CSRF Token Management
if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token(?string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

// Dynamic Restaurant Open/Close State Helper (Pacific Time)
if (!function_exists('get_restaurant_status')) {
    function get_restaurant_status(): array {
        try {
            $tz = new DateTimeZone('America/Los_Angeles');
            $now = new DateTime('now', $tz);
            $dayOfWeek = (int)$now->format('w'); // 0 = Sun, 6 = Sat
            $currentMinutes = ((int)$now->format('G') * 60) + (int)$now->format('i');

            $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6);
            $lunchStart = $isWeekend ? (12 * 60) : (11 * 60 + 30);
            $lunchEnd = $isWeekend ? (15 * 60 + 30) : (15 * 60);
            $dinnerStart = 17 * 60;
            $dinnerEnd = 22 * 60;

            if ($currentMinutes >= $lunchStart && $currentMinutes < $lunchEnd) {
                return [
                    'is_open' => true,
                    'status_text' => 'Open Now · Lunch Buffet until ' . ($isWeekend ? '3:30 PM' : '3:00 PM'),
                    'type' => 'lunch_buffet'
                ];
            } elseif ($currentMinutes >= $dinnerStart && $currentMinutes < $dinnerEnd) {
                return [
                    'is_open' => true,
                    'status_text' => 'Open Now · Dinner Service until 10:00 PM',
                    'type' => 'dinner'
                ];
            } else {
                if ($currentMinutes < $lunchStart) {
                    $opensAt = $isWeekend ? '12:00 PM' : '11:30 AM';
                    return ['is_open' => false, 'status_text' => "Closed · Lunch Buffet opens at $opensAt", 'type' => 'closed'];
                } elseif ($currentMinutes < $dinnerStart) {
                    return ['is_open' => false, 'status_text' => 'Closed · Dinner opens at 5:00 PM', 'type' => 'closed'];
                } else {
                    return ['is_open' => false, 'status_text' => 'Closed for the night · Opens tomorrow at 11:30 AM', 'type' => 'closed'];
                }
            }
        } catch (Throwable $e) {
            return ['is_open' => true, 'status_text' => 'Open Today · Lunch & Dinner', 'type' => 'fallback'];
        }
    }
}

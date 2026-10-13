<?php
/**
 * Saffron Grill Admin - Authentication & Security Guards
 */

require_once __DIR__ . '/../../config/config.php';

if (!function_exists('is_admin_logged_in')) {
    function is_admin_logged_in(): bool {
        if (!empty($_SESSION['saffron_admin_id']) && !empty($_SESSION['saffron_admin_user'])) {
            return true;
        }
        if (!empty($_SESSION['cms_user_id']) && !empty($_SESSION['cms_logged_in'])) {
            $_SESSION['saffron_admin_id'] = $_SESSION['cms_user_id'];
            $_SESSION['saffron_admin_user'] = $_SESSION['cms_username'] ?? 'admin';
            $_SESSION['saffron_admin_role'] = $_SESSION['cms_role'] ?? 'super_admin';
            return true;
        }
        return false;
    }
}

if (!function_exists('require_admin_auth')) {
    function require_admin_auth(): void {
        if (!is_admin_logged_in()) {
            $_SESSION['admin_login_redirect'] = $_SERVER['REQUEST_URI'] ?? '/admin/index.php';
            header('Location: /admin/login.php');
            exit;
        }
    }
}

if (!function_exists('attempt_admin_login')) {
    function attempt_admin_login(string $username, string $password): bool {
        $username = trim($username);
        $password = trim($password);
        if (empty($username) || empty($password)) {
            return false;
        }

        $pdo = get_db();
        $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM admins WHERE LOWER(username) = LOWER(?) OR LOWER(email) = LOWER(?) LIMIT 1");
        $stmt->execute([$username, $username]);
        $admin = $stmt->fetch();

        $isValid = false;
        if ($admin) {
            if (password_verify($password, $admin['password_hash'])) {
                $isValid = true;
            } else {
                $envPass = getenv('ADMIN_PASSWORD');
                if (!empty($envPass) && hash_equals($envPass, $password)) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?")->execute([$newHash, $admin['id']]);
                    $isValid = true;
                }
            }
        }

        if ($isValid && $admin) {
            if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
                session_regenerate_id(true);
            }
            $_SESSION['saffron_admin_id'] = $admin['id'];
            $_SESSION['saffron_admin_user'] = $admin['username'];
            $_SESSION['saffron_admin_role'] = $admin['role'];

            // Populate unified CMS session keys so both legacy CRM and unified CMS are active
            $_SESSION['cms_logged_in'] = true;
            $_SESSION['cms_user_id'] = (int)$admin['id'];
            $_SESSION['cms_username'] = $admin['username'];
            $_SESSION['cms_role'] = ($admin['role'] === 'admin') ? 'super_admin' : $admin['role'];
            $_SESSION['cms_status'] = 'active';
            $_SESSION['cms_initiated'] = true;
            $_SESSION['cms_last_activity'] = time();

            $update = $pdo->prepare("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
            $update->execute([$admin['id']]);
            return true;
        }
        return false;
    }
}

if (!function_exists('admin_logout')) {
    function admin_logout(): void {
        unset($_SESSION['saffron_admin_id']);
        unset($_SESSION['saffron_admin_user']);
        unset($_SESSION['saffron_admin_role']);
        unset($_SESSION['cms_logged_in']);
        unset($_SESSION['cms_user_id']);
        unset($_SESSION['cms_username']);
        unset($_SESSION['cms_role']);
        unset($_SESSION['cms_status']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}

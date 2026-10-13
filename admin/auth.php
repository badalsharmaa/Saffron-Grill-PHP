<?php
/**
 * Saffron Grill — CMS Authentication & Security
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class CMSAuth {
    public static function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_name(CMS_SESSION_NAME);
                
                $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
                session_set_cookie_params([
                    'lifetime' => CMS_SESSION_LIFETIME,
                    'path' => '/',
                    'domain' => '',
                    'secure' => $isHttps,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }

            @session_start();

            // Session hijacking prevention
            if (!headers_sent() && !isset($_SESSION['cms_initiated'])) {
                if (empty($_SESSION['cms_user_id']) && empty($_SESSION['saffron_admin_id'])) {
                    @session_regenerate_id(true);
                }
                $_SESSION['cms_initiated'] = true;
            }

            // Check session timeout
            if (isset($_SESSION['cms_last_activity']) && (time() - $_SESSION['cms_last_activity'] > CMS_SESSION_LIFETIME)) {
                self::logout();
            }

            $_SESSION['cms_last_activity'] = time();
        }
    }

    public static function check(): bool {
        self::startSession();
        if (!empty($_SESSION['cms_user_id']) && !empty($_SESSION['cms_logged_in'])) {
            return true;
        }
        if (!empty($_SESSION['saffron_admin_id']) && !empty($_SESSION['saffron_admin_user'])) {
            // Synchronize unified session keys
            $_SESSION['cms_logged_in'] = true;
            $_SESSION['cms_user_id'] = (int)$_SESSION['saffron_admin_id'];
            $_SESSION['cms_username'] = $_SESSION['saffron_admin_user'];
            $_SESSION['cms_role'] = ($_SESSION['saffron_admin_role'] ?? 'staff') === 'admin' ? 'super_admin' : ($_SESSION['saffron_admin_role'] ?? 'super_admin');
            $_SESSION['cms_status'] = 'active';
            return true;
        }
        return false;
    }

    public static function user(): ?array {
        self::startSession();
        if (!self::check()) {
            return null;
        }

        return [
            'id' => (int)$_SESSION['cms_user_id'],
            'username' => $_SESSION['cms_username'] ?? 'admin',
            'name' => $_SESSION['cms_name'] ?? 'Saffron Grill Admin',
            'email' => $_SESSION['cms_email'] ?? 'gosaffrongrill@gmail.com',
            'role' => $_SESSION['cms_role'] ?? 'staff',
            'status' => $_SESSION['cms_status'] ?? 'active'
        ];
    }

    public static function isSuperAdmin(): bool {
        $u = self::user();
        return $u !== null && (($u['role'] ?? '') === 'super_admin' || (int)$u['id'] === 1);
    }

    public static function requireLogin(): void {
        if (!self::check()) {
            cms_set_flash('error', 'Please log in to access the CMS.');
            cms_redirect('/admin/');
        }
    }

    public static function requireSuperAdmin(): void {
        self::requireLogin();
        if (!self::isSuperAdmin()) {
            cms_set_flash('error', 'Access denied. Super Administrator permission is required.');
            cms_redirect('/admin/?page=dashboard');
        }
    }

    public static function requireGuest(): void {
        if (self::check()) {
            cms_redirect('/admin/?page=dashboard');
        }
    }

    public static function attemptLogin(string $username, string $password): array {
        self::startSession();
        $pdo = CMSDatabase::getConnection();

        $loginInput = trim($username);
        $normalized = strtolower(str_replace(['_', ' ', '-'], '', $loginInput));

        $stmt = $pdo->prepare("
            SELECT * FROM cms_users 
            WHERE LOWER(username) = LOWER(?) 
               OR LOWER(email) = LOWER(?)
               OR REPLACE(REPLACE(REPLACE(LOWER(username), '_', ''), ' ', ''), '-', '') = ?
            LIMIT 1
        ");
        $stmt->execute([$loginInput, $loginInput, $normalized]);
        $user = $stmt->fetch();

        if (!$user) {
            return ['success' => false, 'error' => 'No account found matching this username or email.'];
        }

        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Incorrect password entered. Please try again.'];
        }

        $status = strtolower($user['status'] ?? 'active');
        if ($status === 'pending') {
            return [
                'success' => false,
                'error' => 'Your account registration is currently pending Super Admin review. Please contact management.'
            ];
        }
        if ($status === 'suspended') {
            return [
                'success' => false,
                'error' => 'This account has been suspended by administration. Access is denied.'
            ];
        }

        // Establish session
        @session_regenerate_id(true);
        $_SESSION['cms_logged_in'] = true;
        $_SESSION['cms_user_id'] = (int)$user['id'];
        $_SESSION['cms_username'] = $user['username'];
        $_SESSION['cms_name'] = $user['name'];
        $_SESSION['cms_email'] = $user['email'];
        $_SESSION['cms_role'] = $user['role'] ?? 'staff';
        $_SESSION['cms_status'] = $user['status'] ?? 'active';
        $_SESSION['cms_last_activity'] = time();

        return ['success' => true];
    }

    public static function register(string $name, string $email, string $username, string $password): array {
        self::startSession();
        $pdo = CMSDatabase::getConnection();

        $name = trim($name);
        $email = trim($email);
        $username = trim($username);

        if (strlen($name) < 2) {
            return ['success' => false, 'error' => 'Full name must be at least 2 characters.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Please provide a valid email address.'];
        }
        if (strlen($username) < 3) {
            return ['success' => false, 'error' => 'Username must be at least 3 characters.'];
        }
        if (strlen($password) < 6) {
            return ['success' => false, 'error' => 'Password must be at least 6 characters.'];
        }

        // Check uniqueness
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cms_users WHERE LOWER(username) = LOWER(?) OR LOWER(email) = LOWER(?)");
        $stmt->execute([$username, $email]);
        if ((int)$stmt->fetchColumn() > 0) {
            return ['success' => false, 'error' => 'An account with this username or email already exists.'];
        }

        // Check if first user
        $count = (int)$pdo->query("SELECT COUNT(*) FROM cms_users")->fetchColumn();
        $role = ($count === 0) ? 'super_admin' : 'staff';
        $status = ($count === 0) ? 'active' : 'pending';

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $now = date('Y-m-d H:i:s');

        $ins = $pdo->prepare("INSERT INTO cms_users (username, password_hash, name, email, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $ok = $ins->execute([$username, $hash, $name, $email, $role, $status, $now, $now]);

        if ($ok) {
            $msg = ($status === 'active')
                ? 'Account created successfully! You may now sign in.'
                : 'Registration submitted successfully! Your account is pending Super Administrator approval.';
            return ['success' => true, 'message' => $msg];
        }

        return ['success' => false, 'error' => 'Database error creating account.'];
    }

    public static function logout(): void {
        self::startSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        @session_destroy();
        cms_redirect('/admin/');
    }

    public static function updateProfile(int $id, string $name, string $email, ?string $username = null, ?string $newPassword = null): array {
        self::startSession();
        $pdo = CMSDatabase::getConnection();

        $name = trim($name);
        $email = trim($email);

        if (strlen($name) < 2) {
            return ['success' => false, 'error' => 'Name cannot be empty.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email address.'];
        }

        $now = date('Y-m-d H:i:s');

        // Check uniqueness for email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cms_users WHERE LOWER(email) = LOWER(?) AND id != ?");
        $stmt->execute([$email, $id]);
        if ((int)$stmt->fetchColumn() > 0) {
            return ['success' => false, 'error' => 'Another account is already using that email address.'];
        }

        if ($username !== null && trim($username) !== '') {
            $username = trim($username);
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM cms_users WHERE LOWER(username) = LOWER(?) AND id != ?");
            $stmt->execute([$username, $id]);
            if ((int)$stmt->fetchColumn() > 0) {
                return ['success' => false, 'error' => 'Another account is already using that username.'];
            }
        }

        if ($newPassword !== null && trim($newPassword) !== '') {
            $hash = password_hash(trim($newPassword), PASSWORD_BCRYPT);
            if ($username !== null && trim($username) !== '') {
                $upd = $pdo->prepare("UPDATE cms_users SET name = ?, email = ?, username = ?, password_hash = ?, updated_at = ? WHERE id = ?");
                $upd->execute([$name, $email, $username, $hash, $now, $id]);
            } else {
                $upd = $pdo->prepare("UPDATE cms_users SET name = ?, email = ?, password_hash = ?, updated_at = ? WHERE id = ?");
                $upd->execute([$name, $email, $hash, $now, $id]);
            }
        } else {
            if ($username !== null && trim($username) !== '') {
                $upd = $pdo->prepare("UPDATE cms_users SET name = ?, email = ?, username = ?, updated_at = ? WHERE id = ?");
                $upd->execute([$name, $email, $username, $now, $id]);
            } else {
                $upd = $pdo->prepare("UPDATE cms_users SET name = ?, email = ?, updated_at = ? WHERE id = ?");
                $upd->execute([$name, $email, $now, $id]);
            }
        }

        // Update active session
        $_SESSION['cms_name'] = $name;
        $_SESSION['cms_email'] = $email;
        if ($username) {
            $_SESSION['cms_username'] = $username;
        }

        return ['success' => true];
    }

    public static function getAllUsers(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            return $pdo->query("SELECT id, username, name, email, role, status, created_at, updated_at FROM cms_users ORDER BY (role = 'super_admin') DESC, id ASC")->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public static function updateUserStatus(int $id, string $status): array {
        if (!self::isSuperAdmin()) {
            return ['success' => false, 'error' => 'Permission denied.'];
        }
        $validStatuses = ['active', 'pending', 'suspended'];
        if (!in_array($status, $validStatuses, true)) {
            return ['success' => false, 'error' => 'Invalid status.'];
        }

        $user = self::user();
        if ($user && (int)$user['id'] === $id && $status !== 'active') {
            return ['success' => false, 'error' => 'You cannot deactivate or suspend your own account.'];
        }

        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("UPDATE cms_users SET status = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$status, $now, $id]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function updateUserRole(int $id, string $role): array {
        if (!self::isSuperAdmin()) {
            return ['success' => false, 'error' => 'Permission denied.'];
        }
        $validRoles = ['super_admin', 'staff'];
        if (!in_array($role, $validRoles, true)) {
            return ['success' => false, 'error' => 'Invalid role specified.'];
        }

        $user = self::user();
        if ($user && (int)$user['id'] === $id && $role !== 'super_admin') {
            return ['success' => false, 'error' => 'You cannot demote yourself from Super Administrator.'];
        }

        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("UPDATE cms_users SET role = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$role, $now, $id]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function resetUserPassword(int $id, string $newPassword): array {
        if (!self::isSuperAdmin()) {
            return ['success' => false, 'error' => 'Permission denied.'];
        }
        if (strlen($newPassword) < 6) {
            return ['success' => false, 'error' => 'Password must be at least 6 characters long.'];
        }

        try {
            $pdo = CMSDatabase::getConnection();
            $hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("UPDATE cms_users SET password_hash = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$hash, $now, $id]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function deleteUser(int $id): array {
        if (!self::isSuperAdmin()) {
            return ['success' => false, 'error' => 'Permission denied.'];
        }
        $user = self::user();
        if ($user && (int)$user['id'] === $id) {
            return ['success' => false, 'error' => 'You cannot delete your own account.'];
        }
        if ($id === 1) {
            return ['success' => false, 'error' => 'The root primary administrator cannot be deleted.'];
        }

        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("DELETE FROM cms_users WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function createUser(string $name, string $email, string $username, string $password, string $role = 'staff', string $status = 'active'): array {
        if (!self::isSuperAdmin()) {
            return ['success' => false, 'error' => 'Permission denied.'];
        }

        $name = trim($name);
        $email = trim($email);
        $username = trim($username);

        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($username) < 3 || strlen($password) < 6) {
            return ['success' => false, 'error' => 'Invalid details provided for new team member.'];
        }

        $pdo = CMSDatabase::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cms_users WHERE LOWER(username) = LOWER(?) OR LOWER(email) = LOWER(?)");
        $stmt->execute([$username, $email]);
        if ((int)$stmt->fetchColumn() > 0) {
            return ['success' => false, 'error' => 'User with this username or email already exists.'];
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $now = date('Y-m-d H:i:s');
        $ins = $pdo->prepare("INSERT INTO cms_users (username, password_hash, name, email, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $ok = $ins->execute([$username, $hash, $name, $email, $role, $status, $now, $now]);
        $newId = $ok ? (int)$pdo->lastInsertId() : 0;
        return ['success' => $ok, 'id' => $newId, 'error' => $ok ? null : 'Failed to create user.'];
    }
}

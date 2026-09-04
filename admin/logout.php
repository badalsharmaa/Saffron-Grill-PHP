<?php
/**
 * Saffron Grill Admin - Logout
 */
require_once __DIR__ . '/includes/auth.php';
admin_logout();
header('Location: /admin/login.php');
exit;

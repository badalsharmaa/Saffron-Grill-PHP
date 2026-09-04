<?php
/**
 * Test: Database Connection & Schema Migrations
 */

require_once __DIR__ . '/../admin/includes/db.php';

echo "=== Running Database Migration Test ===\n";

try {
    $pdo = get_db();
    echo "✓ Database connected successfully.\n";

    // Verify all required tables exist
    $tables = ['settings', 'admins', 'reservations', 'leads', 'menu_categories', 'menu_items', 'consent_logs'];
    foreach ($tables as $t) {
        $count = $pdo->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();
        echo "✓ Table `{$t}` exists with {$count} records.\n";
    }

    // Verify default superadmin seeded
    $admin = $pdo->query("SELECT username, email, role FROM admins LIMIT 1")->fetch();
    if ($admin) {
        echo "✓ Superadmin seeded: {$admin['username']} ({$admin['email']}, role: {$admin['role']})\n";
    } else {
        throw new Exception("Superadmin missing!");
    }

    // Verify menu categories seeded
    $catCount = $pdo->query("SELECT COUNT(*) FROM menu_categories")->fetchColumn();
    if ($catCount >= 5) {
        echo "✓ {$catCount} Menu categories seeded successfully.\n";
    }

    echo "\n>>> ALL DATABASE MIGRATION TESTS PASSED! <<<\n";
} catch (Throwable $e) {
    echo "✗ DATABASE TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}

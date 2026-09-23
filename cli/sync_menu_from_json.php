<?php
/**
 * CLI Tool: Synchronize SQLite Database from data/menu.json
 * Compatible with local dev and remote Hostinger directory layout.
 * Usage: php cli/sync_menu_from_json.php
 */

$webroot = file_exists(__DIR__ . '/../config/config.php') ? dirname(__DIR__) : dirname(__DIR__) . '/public_html';

require_once $webroot . '/config/config.php';
require_once $webroot . '/admin/includes/db.php';

$jsonPath = $webroot . '/data/menu.json';
if (!file_exists($jsonPath)) {
    die("❌ Error: {$jsonPath} not found.\n");
}

$data = json_decode(file_get_contents($jsonPath), true);
if (!$data || empty($data['categories'])) {
    die("❌ Error: Invalid menu JSON format.\n");
}

$pdo = get_db();

echo "Starting synchronization of menu database from data/menu.json...\n";

$pdo->beginTransaction();
try {
    $pdo->exec("DELETE FROM menu_categories");
    $pdo->exec("DELETE FROM menu_items");

    $catStmt = $pdo->prepare("INSERT INTO menu_categories (slug, name, display_order, description, is_active) VALUES (?, ?, ?, ?, 1)");
    $itemStmt = $pdo->prepare("
        INSERT INTO menu_items (
            category_slug, name, description, price,
            is_vegetarian, is_vegan, is_gluten_free, is_spicy,
            is_popular, display_order, is_available
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
    ");

    $totalDishes = 0;
    foreach ($data['categories'] as $catOrder => $cat) {
        $catStmt->execute([
            $cat['slug'],
            $cat['name'],
            $catOrder + 1,
            $cat['description'] ?? ''
        ]);

        foreach ($cat['items'] as $itemOrder => $item) {
            $diet = $item['dietary'] ?? [];
            $tags = $item['tags'] ?? [];

            $isVeg = !empty($diet['vegetarian']) ? 1 : 0;
            $isVegan = !empty($diet['vegan']) ? 1 : 0;
            $isGf = !empty($diet['gluten_free']) ? 1 : 0;
            $isSpicy = in_array('Spicy', $tags) ? 1 : 0;
            $isPopular = (in_array('Popular', $tags) || in_array('Chef Special', $tags)) ? 1 : 0;

            $itemStmt->execute([
                $cat['slug'],
                $item['name'],
                $item['description'] ?? '',
                $item['price'] ?? 0.00,
                $isVeg,
                $isVegan,
                $isGf,
                $isSpicy,
                $isPopular,
                $itemOrder + 1
            ]);
            $totalDishes++;
        }
    }

    $pdo->commit();
    echo "✓ Successfully imported " . count($data['categories']) . " categories and {$totalDishes} dishes into SQLite database.\n";
} catch (Throwable $e) {
    $pdo->rollBack();
    die("❌ Sync failed: " . $e->getMessage() . "\n");
}

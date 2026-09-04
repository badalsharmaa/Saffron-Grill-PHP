<?php
/**
 * Saffron Grill - Menu API Endpoint
 */
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/config.php';

try {
    $pdo = get_db();
    $categories = $pdo->query("SELECT * FROM menu_categories WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();
    $items = $pdo->query("SELECT * FROM menu_items WHERE is_available = 1 ORDER BY display_order ASC")->fetchAll();

    $result = [];
    foreach ($categories as $cat) {
        $catSlug = $cat['slug'];
        $catItems = array_values(array_filter($items, function($i) use ($catSlug) {
            return $i['category_slug'] === $catSlug;
        }));
        $result[] = [
            'category' => $cat['name'],
            'slug' => $cat['slug'],
            'items' => $catItems
        ];
    }

    echo json_encode(['success' => true, 'menu' => $result]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

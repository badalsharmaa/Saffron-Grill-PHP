<?php
/**
 * Saffron Grill — Menu Data Bridge & Overrides Engine
 */

if (!function_exists('loadSaffronMenu')) {
    function loadSaffronMenu(): array {
        $jsonFile = __DIR__ . '/menu.json';
        $baseCategories = [];
        $baseItems = [];

        if (file_exists($jsonFile)) {
            $json = json_decode(file_get_contents($jsonFile), true);
            if (is_array($json) && !empty($json['categories'])) {
                $counter = 1;
                foreach ($json['categories'] as $cat) {
                    $catId = $cat['slug'] ?? (string)$cat['id'];
                    $baseCategories[] = [
                        'id' => $catId,
                        'name' => $cat['name'],
                        'description' => $cat['description'] ?? '',
                        'icon' => 'utensils'
                    ];

                    if (!empty($cat['items']) && is_array($cat['items'])) {
                        foreach ($cat['items'] as $it) {
                            $dietary = $it['dietary'] ?? [];
                            $tags = $it['tags'] ?? [];
                            $isVeg = !empty($dietary['vegetarian']) || in_array('Vegetarian', $tags);
                            $isGf = !empty($dietary['gluten_free']) || in_array('Gluten Free', $tags);
                            $isSpicy = in_array('Spicy', $tags);

                            $isVegan = !empty($dietary['vegan']) || in_array('Vegan', $tags);
                            $hasNuts = !empty($dietary['nuts']) || in_array('Nuts', $tags);

                            $baseItems[] = [
                                'id' => (string)($it['id'] ?? $counter),
                                'name' => $it['name'] ?? '',
                                'category' => $cat['name'],
                                'category_id' => $catId,
                                'price' => (float)($it['price'] ?? 0),
                                'description' => $it['description'] ?? '',
                                'image' => $it['image'] ?? '',
                                'veg' => $isVeg ? 1 : 0,
                                'vegan' => $isVegan ? 1 : 0,
                                'nuts' => $hasNuts ? 1 : 0,
                                'spicy' => $isSpicy ? 1 : 0,
                                'gluten_free' => $isGf ? 1 : 0,
                                'is_buffet_item' => 0,
                                'is_available' => 1
                            ];
                            $counter++;
                        }
                    }
                }
            }
        }

        // Apply CMS Overrides if CMS class is available
        $cmsHelper = dirname(__DIR__) . '/api/cms_helper.php';
        if (file_exists($cmsHelper)) {
            require_once $cmsHelper;
        }

        $overrides = function_exists('cms_menu_overrides') ? cms_menu_overrides() : [];

        $finalItems = [];
        $seenIds = [];

        // 1. Process base items
        foreach ($baseItems as $item) {
            $itemId = (string)$item['id'];
            $seenIds[$itemId] = true;

            if (isset($overrides[$itemId])) {
                $ov = $overrides[$itemId];
                if (!empty($ov['is_deleted'])) {
                    continue; // Soft deleted
                }
                if (!empty($ov['name'])) $item['name'] = $ov['name'];
                if (!empty($ov['category'])) $item['category'] = $ov['category'];
                if (!empty($ov['description'])) $item['description'] = $ov['description'];
                if (!empty($ov['image'])) $item['image'] = $ov['image'];
                if (isset($ov['price']) && $ov['price'] > 0) $item['price'] = (float)$ov['price'];
                if (isset($ov['is_available'])) $item['is_available'] = $ov['is_available'] ? 1 : 0;
                if (isset($ov['spicy'])) $item['spicy'] = $ov['spicy'] ? 1 : 0;
                if (isset($ov['veg'])) $item['veg'] = $ov['veg'] ? 1 : 0;
                if (isset($ov['gluten_free'])) $item['gluten_free'] = $ov['gluten_free'] ? 1 : 0;
                if (isset($ov['is_buffet_item'])) $item['is_buffet_item'] = $ov['is_buffet_item'] ? 1 : 0;
            }

            $finalItems[] = $item;
        }

        // 2. Add custom dishes added in CMS
        foreach ($overrides as $ovId => $ov) {
            if (!empty($ov['is_custom']) && empty($ov['is_deleted']) && !isset($seenIds[(string)$ovId])) {
                $finalItems[] = [
                    'id' => (string)$ovId,
                    'name' => $ov['name'] ?? 'Custom Dish',
                    'category' => $ov['category'] ?? 'Appetizers',
                    'category_id' => strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $ov['category'] ?? 'appetizers')),
                    'price' => (float)($ov['price'] ?? 0),
                    'description' => $ov['description'] ?? '',
                    'image' => $ov['image'] ?? '',
                    'veg' => !empty($ov['veg']) ? 1 : 0,
                    'spicy' => !empty($ov['spicy']) ? 1 : 0,
                    'gluten_free' => !empty($ov['gluten_free']) ? 1 : 0,
                    'is_buffet_item' => !empty($ov['is_buffet_item']) ? 1 : 0,
                    'is_available' => isset($ov['is_available']) ? ($ov['is_available'] ? 1 : 0) : 1
                ];
            }
        }

        // Custom Categories from CMS
        $customCategories = class_exists('CMS') ? CMS::getCategories() : $baseCategories;

        return [
            'categories' => !empty($customCategories) ? $customCategories : $baseCategories,
            'items' => $finalItems
        ];
    }
}

$MENU_DATA = loadSaffronMenu();
$CATEGORIES = $MENU_DATA['categories'];
$MENU_ITEMS = $MENU_DATA['items'];

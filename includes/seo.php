<?php
/**
 * Saffron Grill - Unified SEO, GEO & AI Structured Data Helper
 * Generates valid Schema.org JSON-LD graphs, meta tags, and AI discovery tags.
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

/**
 * Returns common AI discovery and crawler link tags.
 */
function get_ai_discovery_head_tags(): string {
    $baseUrl = 'https://saffrongrillrestaurant.com';
    return '<link rel="alternate" type="text/plain" href="' . $baseUrl . '/llms.txt" title="LLM Context Summary" />' . "\n" .
           '<link rel="alternate" type="text/plain" href="' . $baseUrl . '/llms-full.txt" title="LLM Full Knowledge Base" />' . "\n" .
           '<link rel="alternate" type="application/json" href="' . $baseUrl . '/restaurant-facts.json" title="Machine-Readable Facts" />';
}

/**
 * Returns the canonical Restaurant entity schema array.
 */
function get_restaurant_schema_entity(): array {
    return [
        '@type' => 'Restaurant',
        '@id' => 'https://saffrongrillrestaurant.com/#restaurant',
        'name' => 'Saffron Grill',
        'legalName' => 'Saffron Grill San Ramon',
        'image' => 'https://saffrongrillrestaurant.com/assets/story_main.webp',
        'url' => 'https://saffrongrillrestaurant.com',
        'telephone' => '+19258463077',
        'email' => 'gosaffrongrill@gmail.com',
        'priceRange' => '$$',
        'servesCuisine' => [
            'Indian',
            'North Indian',
            'Mughlai',
            'Tandoori',
            'Halal',
            'Vegetarian',
            'Vegan'
        ],
        'currenciesAccepted' => 'USD',
        'paymentAccepted' => 'Cash, Credit Card, Apple Pay, Google Pay',
        'acceptsReservations' => true,
        'menu' => 'https://saffrongrillrestaurant.com/menu',
        'hasMap' => 'https://maps.google.com/?cid=7708573752697881186',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '3191 Crow Canyon Pl, Ste D',
            'addressLocality' => 'San Ramon',
            'addressRegion' => 'CA',
            'postalCode' => '94583',
            'addressCountry' => 'US'
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 37.7663,
            'longitude' => -121.9745
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '11:30',
                'closes' => '15:00',
                'name' => 'Weekday Lunch Buffet'
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Saturday', 'Sunday'],
                'opens' => '12:00',
                'closes' => '15:30',
                'name' => 'Weekend Grand Feast Buffet'
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '17:00',
                'closes' => '22:00',
                'name' => 'Dinner Service'
            ]
        ],
        'areaServed' => [
            'San Ramon', 'Danville', 'Dublin', 'Pleasanton', 'Blackhawk',
            'Alamo', 'Livermore', 'Walnut Creek', 'Tri-Valley', 'East Bay'
        ],
        'sameAs' => [
            'https://www.facebook.com/profile.php?id=61590010434038',
            'https://www.instagram.com/saffrongrillrestaurant',
            'https://www.yelp.com/biz/saffron-grill-san-ramon'
        ]
    ];
}

/**
 * Returns BreadcrumbList schema array for a given trail: ['Crumb Name' => 'URL'].
 */
function get_breadcrumbs_schema(array $crumbs): array {
    $itemListElement = [];
    $position = 1;
    foreach ($crumbs as $name => $url) {
        $itemListElement[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $name,
            'item' => $url
        ];
    }
    return [
        '@type' => 'BreadcrumbList',
        'itemListElement' => $itemListElement
    ];
}

/**
 * Returns complete Menu schema built dynamically from data/menu.json (82 items, 9 sections).
 */
function get_full_menu_schema(): array {
    $menuDataFile = __DIR__ . '/../data/menu.json';
    if (!file_exists($menuDataFile)) {
        return [];
    }
    $raw = file_get_contents($menuDataFile);
    $data = json_decode($raw, true);
    if (!$data || empty($data['categories'])) {
        return [];
    }

    $sections = [];
    foreach ($data['categories'] as $cat) {
        $items = [];
        foreach ($cat['items'] ?? [] as $item) {
            $menuItem = [
                '@type' => 'MenuItem',
                'name' => $item['name'],
                'description' => $item['description'] ?? '',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => number_format((float)($item['price'] ?? 0), 2, '.', ''),
                    'priceCurrency' => 'USD',
                    'availability' => 'https://schema.org/InStock'
                ]
            ];

            // Add dietary attributes if present
            $dietary = $item['dietary'] ?? [];
            $suitableFor = [];
            if (!empty($dietary['vegetarian'])) {
                $suitableFor[] = 'https://schema.org/VegetarianDiet';
            }
            if (!empty($dietary['vegan'])) {
                $suitableFor[] = 'https://schema.org/VeganDiet';
            }
            if (!empty($dietary['gluten_free'])) {
                $suitableFor[] = 'https://schema.org/GlutenFreeDiet';
            }
            if (!empty($dietary['halal'])) {
                $suitableFor[] = 'https://schema.org/HalalDiet';
            }
            if (!empty($suitableFor)) {
                $menuItem['suitableForDiet'] = count($suitableFor) === 1 ? $suitableFor[0] : $suitableFor;
            }

            $items[] = $menuItem;
        }

        $sections[] = [
            '@type' => 'MenuSection',
            'name' => $cat['name'],
            'description' => $cat['description'] ?? '',
            'hasMenuItem' => $items
        ];
    }

    return [
        '@type' => 'Menu',
        '@id' => 'https://saffrongrillrestaurant.com/menu#menu',
        'name' => 'Saffron Grill Dine-In & Takeout Menu',
        'url' => 'https://saffrongrillrestaurant.com/menu',
        'inLanguage' => 'en',
        'mainEntityOfPage' => 'https://saffrongrillrestaurant.com/menu',
        'hasMenuSection' => $sections
    ];
}

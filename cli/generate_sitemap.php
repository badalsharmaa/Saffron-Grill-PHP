<?php
/**
 * Saffron Grill - Dynamic XML Sitemap Generator
 * CLI tool to build, validate, and write production sitemap.xml
 */

$rootDir = dirname(__DIR__);
$sitemapPath = $rootDir . '/sitemap.xml';

$baseUrl = 'https://saffrongrillrestaurant.com';
$today = date('Y-m-d');

$pages = [
    [
        'loc' => $baseUrl . '/',
        'lastmod' => $today,
        'changefreq' => 'daily',
        'priority' => '1.0',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/social_image.png',
                'title' => 'Saffron Grill San Ramon Authentic Indian Cuisine',
                'caption' => 'Authentic Indian Cuisine, Tandoori Sizzlers, and Royal Dining in San Ramon, CA'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/menu',
        'lastmod' => $today,
        'changefreq' => 'weekly',
        'priority' => '0.9',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/butter-chicken.webp',
                'title' => 'Authentic Indian Restaurant Menu — Saffron Grill'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/catering',
        'lastmod' => $today,
        'changefreq' => 'weekly',
        'priority' => '0.9',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/catering.webp',
                'title' => 'Indian Food Catering Tri-Valley & Bay Area'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/reserve',
        'lastmod' => $today,
        'changefreq' => 'weekly',
        'priority' => '0.9',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/ambiance-1.webp',
                'title' => 'Reserve Your Table — Saffron Grill San Ramon'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/story',
        'lastmod' => $today,
        'changefreq' => 'monthly',
        'priority' => '0.8',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/story_main.webp',
                'title' => 'Our Heritage, Pillars & Philosophy — Saffron Grill'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/contact',
        'lastmod' => $today,
        'changefreq' => 'monthly',
        'priority' => '0.8',
        'images' => [
            [
                'loc' => $baseUrl . '/assets/storefront.jpeg',
                'title' => 'Saffron Grill Location & Directions — San Ramon, CA'
            ]
        ]
    ],
    [
        'loc' => $baseUrl . '/privacy-policy',
        'lastmod' => $today,
        'changefreq' => 'yearly',
        'priority' => '0.3',
    ],
    [
        'loc' => $baseUrl . '/terms',
        'lastmod' => $today,
        'changefreq' => 'yearly',
        'priority' => '0.3',
    ],
];

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->setIndentString('  ');
$xml->startDocument('1.0', 'UTF-8');

$xml->startElement('urlset');
$xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$xml->writeAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

foreach ($pages as $p) {
    $xml->startElement('url');
    $xml->writeElement('loc', $p['loc']);
    $xml->writeElement('lastmod', $p['lastmod']);
    $xml->writeElement('changefreq', $p['changefreq']);
    $xml->writeElement('priority', $p['priority']);

    if (!empty($p['images'])) {
        foreach ($p['images'] as $img) {
            $xml->startElement('image:image');
            $xml->writeElement('image:loc', $img['loc']);
            if (!empty($img['title'])) {
                $xml->writeElement('image:title', $img['title']);
            }
            if (!empty($img['caption'])) {
                $xml->writeElement('image:caption', $img['caption']);
            }
            $xml->endElement(); // image:image
        }
    }

    $xml->endElement(); // url
}

$xml->endElement(); // urlset
$xml->endDocument();

$content = $xml->outputMemory();
file_put_contents($sitemapPath, $content);

echo "✓ Sitemap generated successfully at {$sitemapPath}\n";
echo "Total URLs indexed: " . count($pages) . "\n";

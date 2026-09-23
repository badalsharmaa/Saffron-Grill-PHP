<?php
/**
 * Saffron Grill - Global Header Template
 * SEO, GEO Hyper-local, Google Consent Mode v2 & OpenGraph
 */
require_once __DIR__ . '/../config/config.php';

$pageTitle = $pageTitle ?? APP_NAME . ' — ' . APP_TAGLINE;
$pageDesc = $pageDesc ?? 'Authentic Indian Cuisine & Lunch Buffet in San Ramon, CA. Savor tandoori specialties, rich curries, daily lunch buffets ($19.99 weekday / $21.99 weekend), and luxury catering across the East Bay.';
$pageKeywords = $pageKeywords ?? 'Indian restaurant San Ramon, lunch buffet San Ramon, Indian food catering Tri-Valley, tandoori chicken, butter chicken, biryani San Ramon, Halal Indian food Dublin CA, Danville Indian restaurant';
$canonicalUrl = $canonicalUrl ?? (BASE_URL . '/' . ltrim($_SERVER['REQUEST_URI'] ?? '', '/'));
$ogImage = $ogImage ?? (BASE_URL . '/assets/social_image.png');
$gtmId = defined('GTM_CONTAINER_ID') ? GTM_CONTAINER_ID : '';
$gaId = defined('GA_MEASUREMENT_ID') ? GA_MEASUREMENT_ID : 'G-B5FSX73C4M';
$currentStatus = get_restaurant_status();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>" />
<meta name="keywords" content="<?= e($pageKeywords) ?>" />
<meta name="author" content="Saffron Grill" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

<!-- Canonical URL -->
<link rel="canonical" href="<?= e($canonicalUrl) ?>" />

<!-- Hyper-Local GEO Meta Tags -->
<meta name="geo.region" content="US-CA" />
<meta name="geo.placename" content="San Ramon, California" />
<meta name="geo.position" content="<?= e(GEO_LAT) ?>;<?= e(GEO_LNG) ?>" />
<meta name="ICBM" content="<?= e(GEO_LAT) ?>, <?= e(GEO_LNG) ?>" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="restaurant" />
<meta property="og:url" content="<?= e($canonicalUrl) ?>" />
<meta property="og:title" content="<?= e($pageTitle) ?>" />
<meta property="og:description" content="<?= e($pageDesc) ?>" />
<meta property="og:image" content="<?= e($ogImage) ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:type" content="image/png" />
<meta property="og:site_name" content="<?= e(APP_NAME) ?>" />
<meta property="og:locale" content="en_US" />

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="<?= e($canonicalUrl) ?>" />
<meta name="twitter:title" content="<?= e($pageTitle) ?>" />
<meta name="twitter:description" content="<?= e($pageDesc) ?>" />
<meta name="twitter:image" content="<?= e($ogImage) ?>" />

<!-- Favicons & Icons -->
<link rel="icon" type="image/png" href="<?= asset('emblem.png') ?>" />
<link rel="apple-touch-icon" href="<?= asset('emblem.png') ?>" />

<!-- Google Fonts Preconnect & Stylesheets -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="<?= asset('styles.css') ?>" />

<!-- Google Consent Mode v2 (Strict Default: Denied) -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){ dataLayer.push(arguments); }
  gtag('consent', 'default', {
    'ad_storage': 'denied',
    'ad_user_data': 'denied',
    'ad_personalization': 'denied',
    'analytics_storage': 'denied',
    'wait_for_update': 500
  });

  // Rehydrate existing visitor consent if stored in cookie
  (function () {
    var match = document.cookie.match(/(?:^|; )saffron_consent=([^;]+)/);
    if (match && decodeURIComponent(match[1]) === 'granted') {
      gtag('consent', 'update', {
        'ad_storage': 'granted',
        'ad_user_data': 'granted',
        'ad_personalization': 'granted',
        'analytics_storage': 'granted'
      });
    }
  })();
</script>

<?php if (!empty($gaId)): ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($gaId) ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?= e($gaId) ?>');
</script>
<?php endif; ?>

<?php if (!empty($gtmId)): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= e($gtmId) ?>');</script>
<!-- End Google Tag Manager -->
<?php endif; ?>

<!-- Schema.org JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "<?= e(APP_NAME) ?>",
  "image": "<?= e($ogImage) ?>",
  "@id": "https://saffrongrillrestaurant.com/#restaurant",
  "url": "https://saffrongrillrestaurant.com",
  "telephone": "<?= e(PHONE_TEL) ?>",
  "priceRange": "$$",
  "servesCuisine": ["Indian", "North Indian", "Tandoori", "Vegetarian", "Halal"],
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "3191 Crow Canyon Pl, Ste D",
    "addressLocality": "San Ramon",
    "addressRegion": "CA",
    "postalCode": "94583",
    "addressCountry": "US"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": <?= e(GEO_LAT) ?>,
    "longitude": <?= e(GEO_LNG) ?>
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "11:30",
      "closes": "15:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "17:00",
      "closes": "22:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Saturday", "Sunday"],
      "opens": "12:00",
      "closes": "15:30"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Saturday", "Sunday"],
      "opens": "17:00",
      "closes": "22:00"
    }
  ],
  "menu": "https://saffrongrillrestaurant.com/menu",
  "acceptsReservations": "True",
  "sameAs": [
    "https://www.facebook.com/profile.php?id=61590010434038",
    "https://www.instagram.com/saffrongrillrestaurant"
  ]
}
</script>
</head>
<body>
<?php if (!empty($gtmId)): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($gtmId) ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>

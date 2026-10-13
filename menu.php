<?php
/**
 * Saffron Grill - Full Restaurant Menu
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/seo.php';
require_once __DIR__ . '/data/menu.php';

$menuData = loadSaffronMenu();
$menuCategories = $menuData['categories'] ?? [];
$menuItems = $menuData['items'] ?? [];

// Group items by category name
$menuByCategory = [];
foreach ($menuItems as $dish) {
    if (isset($dish['is_available']) && ($dish['is_available'] === 0 || $dish['is_available'] === '0')) {
        continue;
    }
    $cName = $dish['category'] ?? 'Other';
    $menuByCategory[$cName][] = $dish;
}

$pageTitle = 'Menu — Saffron Grill · Authentic Indian Cuisine';
$pageDesc = 'Explore Saffron Grill\'s full menu of authentic Indian dishes in San Ramon, CA. From tandoori specialties and rich curries to vegetarian classics and desserts.';
$canonicalUrl = 'https://saffrongrillrestaurant.com/menu';
$ogImage = 'https://saffrongrillrestaurant.com/assets/social_image.png';
$gtmId = defined('GTM_CONTAINER_ID') ? GTM_CONTAINER_ID : '';
$gaId = defined('GA_MEASUREMENT_ID') ? GA_MEASUREMENT_ID : 'G-B5FSX73C4M';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

<!-- Canonical Tag -->
<link rel="canonical" href="<?= e($canonicalUrl) ?>" />

<!-- AI Discovery Link Tags -->
<?= get_ai_discovery_head_tags() ?>

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

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="<?= e($canonicalUrl) ?>" />
<meta property="twitter:title" content="<?= e($pageTitle) ?>" />
<meta property="twitter:description" content="<?= e($pageDesc) ?>" />
<meta property="twitter:image" content="<?= e($ogImage) ?>" />

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
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= e($gtmId) ?>');</script>
<?php endif; ?>

<!-- Schema.org Unified Graph (Restaurant + Breadcrumbs + Full Menu) -->
<script type="application/ld+json">
<?= json_encode([
  '@context' => 'https://schema.org',
  '@graph' => array_filter([
    get_restaurant_schema_entity(),
    get_breadcrumbs_schema([
      'Home' => 'https://saffrongrillrestaurant.com/',
      'Menu' => 'https://saffrongrillrestaurant.com/menu'
    ]),
    get_full_menu_schema()
  ])
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<link rel="icon" type="image/png" href="assets/emblem.png" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="styles.css?v=<?= filemtime(__DIR__ . '/styles.css') ?>" />
<style>
/* Menu Item Dietary Tags styling */
.menu-item .tag {
  font-size: 11px;
  letter-spacing: .06em;
  text-transform: uppercase;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 3px;
  white-space: nowrap;
  margin-left: 8px;
  display: inline-block;
  vertical-align: middle;
}
</style>
</head>
<body>
<?php if (!empty($gtmId)): ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($gtmId) ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>

<!-- ============== NAV ============== -->
<nav class="nav" id="nav">
  <a class="nav-brand" href="/" aria-label="Saffron Grill home">
    <img src="assets/emblem.png" alt="" />
    <span class="wordmark">
      <b>Saffron Grill</b>
      <span>Authentic Indian Cuisine</span>
    </span>
  </a>
  <div class="nav-links">
    <a href="/story">Story</a>
    <a href="/menu" class="active">Menu</a>
    <a href="/catering">Catering</a>
    <a href="/contact">Contact</a>
  </div>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold nav-cta" target="_blank" rel="noopener noreferrer">Order Online</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="/story">Story</a>
  <a href="/menu" class="active">Menu</a>
  <a href="/catering">Catering</a>
  <a href="/contact">Contact</a>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold" target="_blank" rel="noopener noreferrer" style="color:#3a2208">Order Online</a>
</div>

<!-- ============== HERO ============== -->
<header class="hero" id="top" style="min-height: 55vh; padding-top: 150px; padding-bottom: 80px;">
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="hero-bg-slide active">
      <img class="hero-bg-img" src="assets/hero2-first-frame.jpg" alt="Saffron Grill Culinary Vision" />
      <video class="hero-bg-video playing" muted playsinline autoplay loop preload="auto" poster="assets/hero2-first-frame.jpg">
        <source src="assets/Video/hero2.webm" type="video/webm">
        <source src="assets/Video/hero2_backup.mp4" type="video/mp4">
      </video>
    </div>
  </div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">Culinary Vision</p>
    <h1 class="reveal d1">
      <span class="l1">The Saffron Menu</span>
      <span class="l2 gold-text italic">A Symphony of Flavors</span>
    </h1>
    
    <!-- Decorative Divider -->
    <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 200px; margin: 18px auto;" />

    <p class="lede on-dark reveal d2" style="max-width: 650px; margin-inline: auto; margin-top: 12px; font-size: 20px; color: var(--cream-2);">
      Indulge in a sensory journey through traditional Indian recipes, crafted with passion and infused with exotic, freshly ground spices.
    </p>

    <div class="hero-cta reveal d2" style="margin-top: 28px; display: flex; justify-content: center; gap: clamp(12px, 2vw, 20px);">
      <a href="https://order.boons.io/site/saffron-grill/390/y" class="btn btn-gold-slide" target="_blank" rel="noopener noreferrer">
        <span>Order Online</span>
      </a>
      <a href="/contact" class="btn btn-ghost-slide">
        <span>Visit Restaurant</span>
      </a>
    </div>
  </div>
</header>

<!-- ============== SIGNATURES ============== -->
<section class="section surface-cream" id="signatures" data-screen-label="Signatures">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow center reveal">Signature Dishes</span>
      <h2 class="h-section reveal d1">Guest Favorites, Served Every Day</h2>
      <img class="ornament" src="assets/divider.png" alt="" />
      <p class="lede reveal d2" style="margin-top:14px">While our buffet showcases variety, these are the dishes guests ask for again and again.</p>
      <p class="body-text reveal d2" style="margin-top:14px; text-align: center; margin-inline: auto;">
        From smoky tandoori specialties and flavorful curries to comforting vegetarian classics, each dish has earned its place on the table through years of customer favorites and repeat orders.
      </p>
    </div>
    
    <div class="tabs reveal" id="tabs">
      <button class="tab active" data-cat="tandoori">Tandoori</button>
      <button class="tab" data-cat="veg">Vegetarian</button>
      <button class="tab" data-cat="nonveg">Non-Vegetarian</button>
      <button class="tab" data-cat="dessert">Desserts</button>
    </div>
    <div class="dish-grid" id="dishGrid"></div>
  </div>
</section>

<!-- ============== FULL MENU ============== -->
<section class="section surface-dark" id="menu-section" data-screen-label="Full Menu">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">The Full Menu</span>
      <h2 class="h-section gold-text reveal d1">Something for Every Taste</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Explore our complete collection of authentic recipes, organized by course.</p>
    </div>
    
    <div class="menu-grid" id="menuGrid" data-static="true">
      <?php foreach ($menuCategories as $catIdx => $category): 
          $catName = $category['name'] ?? '';
          $dishesInCat = $menuByCategory[$catName] ?? [];
          if (empty($dishesInCat)) continue;
          $colDelay = ($catIdx % 2 !== 0) ? ' d1' : '';
      ?>
        <!-- <?= e($catName) ?> -->
        <div class="menu-col reveal<?= $colDelay ?>">
          <h3><?= e($catName) ?></h3>
          <?php foreach ($dishesInCat as $dish): 
              $isVeg = !empty($dish['veg']);
              $isVegan = !empty($dish['vegan']);
              $isGf = !empty($dish['gluten_free']);
              $hasNuts = !empty($dish['nuts']);
              $isSpicy = !empty($dish['spicy']);
              $priceVal = is_numeric($dish['price']) ? number_format((float)$dish['price'], 2) : e($dish['price']);
          ?>
            <div class="menu-item">
              <div class="top">
                <span class="name">
                  <?= e($dish['name']) ?>
                  <?php if ($isVegan): ?>
                    <span class="tag tag-vegan">Vegan</span>
                  <?php elseif ($isVeg): ?>
                    <span class="tag tag-veg">Veg</span>
                  <?php else: ?>
                    <span class="tag tag-nonveg">Non-Veg</span>
                  <?php endif; ?>
                  <?php if ($isGf): ?>
                    <span class="tag tag-gf">GF</span>
                  <?php endif; ?>
                  <?php if ($hasNuts): ?>
                    <span class="tag tag-nuts">Nuts</span>
                  <?php endif; ?>
                  <?php if ($isSpicy): ?>
                    <span class="tag tag-spice">Spicy</span>
                  <?php endif; ?>
                </span>
                <span class="leader"></span>
                <span class="price">$<?= $priceVal ?></span>
              </div>
              <?php if (!empty($dish['description'])): ?>
                <div class="desc"><?= e($dish['description']) ?></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============== FOOTER ============== -->
<footer class="footer">
  <div class="wrap">
    <div class="footer-top">
      <div class="footer-brand">
        <img src="assets/emblem.png" alt="Saffron Grill" style="width:64px" />
        <p style="font-family:var(--ff-display); color:var(--cream); font-size:20px; letter-spacing:.1em; margin-top:14px">SAFFRON GRILL</p>
        <p>Authentic Indian cuisine in the heart of San Ramon — daily buffets, tandoori specialties, vegetarian &amp; non-vegetarian feasts, and full-service catering.</p>
        <div class="footer-social" aria-label="Saffron Grill social links">
          <a href="https://www.facebook.com/profile.php?id=61590010434038" target="_blank" rel="noopener noreferrer">Facebook</a>
          <a href="https://www.instagram.com/saffrongrillrestaurant" target="_blank" rel="noopener noreferrer">Instagram</a>
        </div>
      </div>
      <div>
        <h4>Explore</h4>
        <ul>
          <li><a href="/story">Story</a></li>
          <li><a href="/menu">Menu</a></li>
          <li><a href="/catering">Catering</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Visit</h4>
        <ul>
          <li><a href="https://maps.app.goo.gl/yyEfLC6ogW2JiApg8" target="_blank" rel="noopener noreferrer">3191 Crow Canyon Pl</a></li>
          <li><a href="https://maps.app.goo.gl/yyEfLC6ogW2JiApg8" target="_blank" rel="noopener noreferrer">San Ramon, CA 94583</a></li>
          <li><a href="tel:+19258463077">+1 (925) 846-3077</a></li>
          <li><a href="tel:+19253694696">+1 (925) 369-4696</a></li>
          <li><a href="mailto:gosaffrongrill@gmail.com">gosaffrongrill@gmail.com</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <span id="year"></span> Saffron Grill · Authentic Indian Cuisine</span>
      <span>San Ramon, California · <a href="/privacy-policy" style="color: inherit; opacity: 0.6;">Privacy Policy</a> · <a href="/admin.php" rel="nofollow" style="color: inherit; opacity: 0.6;">Admin Login</a></span>
    </div>
  </div>
</footer>

<!-- ============== DYNAMIC PROMOTIONAL POPUP ============== -->
<?php require __DIR__ . '/includes/popup.php'; ?>

<?php require_once __DIR__ . '/includes/consent_banner.php'; ?>

<!-- ============== SCRIPTS ============== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" crossorigin="anonymous"></script>
<script src="assets/image-slot.js"></script>
<script src="app.js?v=<?= filemtime(__DIR__ . '/app.js') ?>"></script>
<script src="popup.js?v=<?= filemtime(__DIR__ . '/popup.js') ?>"></script>
</body>
</html>

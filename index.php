<?php
/**
 * Saffron Grill - Authentic Indian Cuisine · San Ramon
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Saffron Grill — Authentic Indian Cuisine · San Ramon';
$pageDesc = 'Saffron Grill — authentic Indian cuisine in San Ramon, CA. Daily lunch buffets, tandoori specialties, vegetarian & non-vegetarian dishes, catering & family dining.';
$canonicalUrl = 'https://saffrongrillsanramon.com/';
$ogImage = 'https://saffrongrillsanramon.com/assets/story_main.webp';
$gtmId = defined('GTM_CONTAINER_ID') ? GTM_CONTAINER_ID : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>" />

<!-- Canonical Tag -->
<link rel="canonical" href="<?= e($canonicalUrl) ?>" />

<!-- Hyper-Local GEO Meta Tags -->
<meta name="geo.region" content="US-CA" />
<meta name="geo.placename" content="San Ramon, California" />
<meta name="geo.position" content="<?= e(GEO_LAT) ?>;<?= e(GEO_LNG) ?>" />
<meta name="ICBM" content="<?= e(GEO_LAT) ?>, <?= e(GEO_LNG) ?>" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="<?= e($canonicalUrl) ?>" />
<meta property="og:title" content="<?= e($pageTitle) ?>" />
<meta property="og:description" content="<?= e($pageDesc) ?>" />
<meta property="og:image" content="<?= e($ogImage) ?>" />

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

<?php if (!empty($gtmId)): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= e($gtmId) ?>');</script>
<!-- End Google Tag Manager -->
<?php endif; ?>

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Saffron Grill",
  "image": "https://saffrongrillsanramon.com/assets/story_main.webp",
  "@id": "https://saffrongrillsanramon.com/#restaurant",
  "url": "https://saffrongrillsanramon.com",
  "telephone": "+19258463077",
  "priceRange": "$$",
  "servesCuisine": "Indian",
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
    "latitude": 37.7663,
    "longitude": -121.9745
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
  "menu": "https://saffrongrillsanramon.com/menu.php",
  "acceptsReservations": "True",
  "sameAs": [
    "https://www.facebook.com/profile.php?id=61590010434038",
    "https://www.instagram.com/saffrongrillrestaurant"
  ]
}
</script>

<link rel="icon" type="image/png" href="assets/emblem.png" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php if (!empty($gtmId)): ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($gtmId) ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>

<!-- ============== NAV ============== -->
<nav class="nav" id="nav">
  <a class="nav-brand" href="index.php" aria-label="Saffron Grill home">
    <img src="assets/emblem.png" alt="" />
    <span class="wordmark">
      <b>Saffron Grill</b>
      <span>Authentic Indian Cuisine</span>
    </span>
  </a>
  <div class="nav-links">
    <a href="story.php">Story</a>
    <a href="menu.php">Menu</a>
    <a href="catering.php">Catering</a>
    <a href="contact.php">Contact</a>
  </div>
  <a href="contact.php#reserve" class="btn btn-gold nav-cta js-open-reserve">Reserve a Table</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php">Story</a>
  <a href="menu.php">Menu</a>
  <a href="catering.php">Catering</a>
  <a href="contact.php">Contact</a>
  <a href="contact.php#reserve" class="btn btn-gold js-open-reserve" style="color:#3a2208">Reserve a Table</a>
</div>

<!-- ============== HERO ============== -->
<header class="hero" id="top" data-screen-label="Hero">
  <!-- Video Background Carousel -->
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    
    <div class="hero-bg-slide active" data-slide="0">
      <img class="hero-bg-img" src="assets/hero-first-frame.jpg" alt="" />
      <video class="hero-bg-video" muted playsinline preload="auto" loop></video>
    </div>
    <div class="hero-bg-slide" data-slide="1">
      <img class="hero-bg-img" src="assets/hero2-first-frame.jpg" alt="" />
      <video class="hero-bg-video" muted playsinline preload="auto" loop></video>
    </div>
    <div class="hero-bg-slide" data-slide="2">
      <img class="hero-bg-img" src="assets/hero3-first-frame.jpg" alt="" />
      <video class="hero-bg-video" muted playsinline preload="auto" loop></video>
    </div>
  </div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">San Ramon, CA</p>
    <h1 class="reveal d1">
      <span class="l1">Authentic Indian</span>
      <span class="l2 gold-text italic">Cuisine Crafted</span>
    </h1>
    
    <!-- Decorative Divider -->
    <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 200px; margin: 18px auto;" />

    <!-- Glassmorphic Trust Row -->
    <div class="hero-trust-row reveal d2">
      <div class="trust-item">
        <svg class="icon star-icon" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>4.8 Google Rating</span>
      </div>
      <span class="trust-separator"></span>
      <div class="trust-item">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        <span>5,000+ Guests</span>
      </div>
      <span class="trust-separator"></span>
      <div class="trust-item">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        <span>Weekend Buffet</span>
      </div>
      <span class="trust-separator"></span>
      <div class="trust-item">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
        <span>Fresh Tandoor</span>
      </div>
    </div>

    <!-- CTA Buttons with Premium Sliding Transition -->
    <div class="hero-cta reveal d2">
      <a href="contact.php#reserve" class="btn btn-gold-slide js-open-reserve">
        <span>Reserve a Table</span>
      </a>
      <a href="menu.php" class="btn btn-ghost-slide">
        <span>Explore the Menu</span>
      </a>
    </div>
  </div>

  <!-- Premium Bottom Feature Dashboard -->
  <div class="hero-dashboard reveal d3">
    <div class="dashboard-inner wrap">
      <!-- Box 1 -->
      <div class="dashboard-box">
        <div class="db-icon-wrap">
          <svg class="db-icon star-fill" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
        <div>
          <span class="db-label">Google Rating</span>
          <span class="db-val">⭐ 4.8 / 5.0 Rating</span>
        </div>
      </div>
      <!-- Box 2 -->
      <div class="dashboard-box">
        <div class="db-icon-wrap">
          <svg class="db-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        </div>
        <div>
          <span class="db-label">Weekend Buffet</span>
          <span class="db-val">Sat &amp; Sun · 12:00–3:30</span>
        </div>
      </div>
      <!-- Box 3 -->
      <div class="dashboard-box">
        <div class="db-icon-wrap">
          <svg class="db-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div>
          <span class="db-label">Fresh Ingredients</span>
          <span class="db-val">Sourced Daily</span>
        </div>
      </div>
      <!-- Box 4 -->
      <div class="dashboard-box">
        <div class="db-icon-wrap">
          <svg class="db-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <div>
          <span class="db-label">Traditional Recipes</span>
          <span class="db-val">Generations Old</span>
        </div>
      </div>
    </div>
  </div>

  <a href="#story" class="scroll-cue" aria-label="Scroll down">
    <span class="line"></span>
    Discover
  </a>
</header>

<!-- ============== STORY ============== -->
<section class="section surface-cream" id="story" data-screen-label="Story">
  <div class="wrap story-grid">
    <div class="story-figure reveal">
      <image-slot id="story-main" class="frame-main frame-gold" shape="rounded" radius="6" placeholder="Dining room / chef plating" src="assets/story_main.webp"></image-slot>
      <image-slot id="story-float" class="frame-float" shape="rounded" radius="4" placeholder="Tandoor flame" src="assets/dishes/chatgpt_1.webp"></image-slot>
    </div>
    <div>
      <span class="eyebrow reveal">Our Story</span>
      <h2 class="h-section reveal d1">A Restaurant Built Around Sharing</h2>
      <img class="ornament sm" style="margin-left:0" src="assets/divider.png" alt="" />
      <p class="lede reveal d2" style="margin-top:8px">Some meals are about choosing a single dish. Ours are about bringing people together around a table filled with options.</p>
      <p class="body-text reveal d2" style="margin-top:18px">At Saffron Grill, you'll find the dishes guests know and love, alongside new favorites waiting to be discovered. From freshly prepared curries and tandoori specialties to vegetarian classics and house-made desserts, every visit offers something different to enjoy.</p>
      <p class="body-text reveal d2" style="margin-top:18px">Whether you're joining us for a quick lunch, a family dinner, or a celebration with friends, our goal remains the same: serve great food generously and make everyone feel welcome.</p>
      <div class="story-stats reveal d3">
        <div class="stat">
          <div class="num">20+</div>
          <div class="lbl">Daily Buffet<br>Selections</div>
        </div>
        <div class="divider"></div>
        <div class="stat">
          <div class="num">100%</div>
          <div class="lbl">Freshly Prepared<br>Every Day</div>
        </div>
        <div class="divider"></div>
        <div class="stat">
          <div class="num">40+</div>
          <div class="lbl">Veg &amp; Non-Veg<br>Options</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============== BUFFET ============== -->
<section class="section surface-leather" id="buffet" data-screen-label="Buffet">
  <div class="wrap">
    <div class="buffet-head">
      <div class="sec-head">
        <span class="eyebrow on-dark reveal">The Buffet Experience</span>
        <h2 class="h-section gold-text reveal d1" style="margin-top:16px">The Experience We're Known For</h2>
        <p class="lede on-dark reveal d2" style="margin-top:14px">Our buffet is where many guests discover Saffron Grill for the first time—and where many become regulars.</p>
        <p class="body-text on-dark reveal d2" style="margin-top:14px">Every day features a rotating selection of favorites, including rich curries, tandoori specialties, fresh naan, rice dishes, appetizers, salads, and desserts. The lineup changes regularly, giving you a reason to come back and try something new.</p>
        <p class="body-text on-dark reveal d2" style="margin-top:14px">Whether you're stopping by for lunch or enjoying a relaxed weekend gathering, the buffet offers the freedom to explore Indian cuisine one plate at a time.</p>
      </div>
      <a href="buffet.php" class="btn btn-ghost reveal d2">See Today's Offerings</a>
    </div>
    <div class="buffet-grid">
      <article class="buffet-card reveal d1">
        <div class="media">
          <span class="badge">Mon – Fri</span>
          <video autoplay muted loop playsinline preload="auto" class="buffet-vid">
            <source src="assets/buffet-vid-1.webm" type="video/webm">
          </video>
        </div>
        <div class="body">
          <h3>Daily Lunch Buffet</h3>
          <p class="when">11:30 AM – 3:00 PM</p>
          <p>A convenient weekday buffet featuring a variety of vegetarian and non-vegetarian selections prepared fresh throughout service.</p>
          <div class="buffet-tags">
            <span>Curries</span><span>Tandoori</span><span>Fresh Naan</span><span>Biryani</span><span>Dessert</span>
          </div>
        </div>
      </article>
      <article class="buffet-card reveal d2">
        <div class="media">
          <span class="badge">Sat – Sun</span>
          <video autoplay muted loop playsinline preload="auto" class="buffet-vid">
            <source src="assets/buffet-vid-2.webm" type="video/webm">
          </video>
        </div>
        <div class="body">
          <h3>Weekend Grand Buffet</h3>
          <p class="when">12:00 PM – 3:30 PM</p>
          <p>Expanded selections, additional specialties, and a larger variety of dishes designed for longer family meals and celebrations.</p>
          <div class="buffet-tags">
            <span>Chef's Specials</span><span>Live Counters</span><span>Regional Dishes</span><span>Sweets</span>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============== SIGNATURES ============== -->
<section class="section surface-cream" id="signatures" data-screen-label="Signatures">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow center reveal">Signature Dishes</span>
      <h2 class="h-section reveal d1">Guest Favorites, Served Every Day</h2>
      <img class="ornament" src="assets/divider.png" alt="" />
      <p class="lede reveal d2" style="margin-top:14px">While the buffet showcases variety, these are the dishes guests ask for again and again.</p>
      <p class="body-text reveal d2" style="margin-top:14px">From smoky tandoori specialties and flavorful curries to comforting vegetarian classics, each dish has earned its place on the table through years of customer favorites and repeat orders.<br><br>Whether you're trying Saffron Grill for the first time or returning for a familiar favorite, these selections represent some of the best-loved flavors in our kitchen.</p>
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

<!-- ============== MENU ============== -->
<section class="section surface-dark" id="menu" data-screen-label="Menu">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Menu Highlights</span>
      <h2 class="h-section gold-text reveal d1">Something for Every Taste at the Table</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">A great dining experience means everyone finds something they love.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">Our menu features vegetarian specialties, hearty meat dishes, tandoori selections, seafood favorites, fresh breads, rice dishes, appetizers, and traditional desserts. Whether you're craving bold spices, comforting classics, or something entirely new, there's always another dish worth discovering.<br><br>Because the best meals aren't about choosing one favorite—they're about sharing several.</p>
    </div>
    <div class="menu-grid" id="menuGrid"></div>
    <p class="menu-note reveal">Vegetarian, vegan &amp; gluten-friendly options throughout · Spice levels to taste</p>
    <div class="center reveal" style="margin-top: 32px">
      <a href="menu.php" class="btn btn-gold">View Full Menu</a>
    </div>
  </div>
</section>

<!-- ============== CATERING ============== -->
<section class="section surface-paper" id="catering" data-screen-label="Catering">
  <div class="wrap cater-grid">
    <div>
      <span class="eyebrow reveal">Catering</span>
      <h2 class="h-section reveal d1" style="margin-top:16px">Bring Saffron Grill to Your Next Celebration</h2>
      <img class="ornament sm" style="margin-left:0" src="assets/divider.png" alt="" />
      <p class="body-text reveal d2" style="margin-top:16px">From office lunches and corporate gatherings to weddings, birthdays, graduations, and family events, our catering team helps bring people together through great food.</p>
      <p class="body-text reveal d2" style="margin-top:12px">Choose from a wide range of vegetarian and non-vegetarian options, buffet-style service, party trays, and customized menus tailored to your event.</p>
      <p class="body-text reveal d2" style="margin-top:12px">Whether you're serving twenty guests or hundreds, we'll help create a menu that fits the occasion.</p>
      <div class="reveal d3" style="margin-top:30px; display:flex; gap:14px; flex-wrap:wrap">
        <a href="catering.php#inquiry-section" class="btn btn-crimson">Request Catering Information</a>
      </div>
    </div>
    <div class="reveal d1">
      <div class="arch frame-gold cater-vid-wrap">
        <video autoplay muted loop playsinline preload="none">
          <source src="assets/catering-vid.webm" type="video/webm">
        </video>
      </div>
    </div>
  </div>
</section>

<!-- ============== GALLERY ============== -->
<section class="section surface-dark" id="gallery" data-screen-label="Gallery">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Gallery</span>
      <h2 class="h-section gold-text reveal d1">A Look Inside Saffron Grill</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">The vibrant buffet spreads. The signature dishes. The celebrations. The everyday family dinners.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">Every image tells part of the story of what guests experience when they visit Saffron Grill. Browse through the moments, meals, and memories shared around our tables.</p>
    </div>
    <div class="gallery-grid reveal">
      <image-slot id="g1" class="g-tall" placeholder="Signature curry" src="assets/dishes/butter_chicken.webp"></image-slot>
      <image-slot id="g2" placeholder="Naan from the tandoor" src="assets/dishes/chatgpt_3.webp"></image-slot>
      <image-slot id="g3" class="g-wide" placeholder="Table spread" src="assets/buffet_lunch.webp"></image-slot>
      <img src="assets/storefront.jpeg" alt="Saffron Grill storefront, San Ramon" />
      <image-slot id="g5" placeholder="Dessert" src="assets/dishes/gulab_jamun.webp"></image-slot>
      <image-slot id="g4" placeholder="Appetizer" src="assets/dishes/chatgpt_4.webp"></image-slot>
      <image-slot id="g6" class="g-wide" placeholder="Dining room" src="assets/buffet_weekend.webp"></image-slot>
      <image-slot id="g7" placeholder="Chai / drinks" src="assets/dishes/chatgpt_2.webp"></image-slot>
      <image-slot id="g8" placeholder="Spices" src="assets/dishes/chatgpt_5.webp"></image-slot>
    </div>
  </div>
</section>

<!-- ============== INSTAGRAM POSTS ============== -->
<section class="section surface-leather instagram-section" id="instagram" data-screen-label="Instagram">
  <div class="wrap">
    <div class="sec-head center instagram-head">
      <span class="eyebrow on-dark center reveal">Follow Along</span>
      <h2 class="h-section gold-text reveal d1">From Our Instagram</h2>
      <img class="ornament reveal d1" src="assets/divider.png" alt="" />
      <p class="lede on-dark reveal d2">A look at recent Saffron Grill moments, dishes, and dining experiences.</p>
      <a class="btn btn-ghost reveal d3" href="https://www.instagram.com/saffrongrillrestaurant" target="_blank" rel="noopener noreferrer">Follow Us</a>
    </div>
  </div>
  <div class="instagram-marquee reveal d3" aria-label="Instagram posts carousel">
    <div class="instagram-track">
      <article class="instagram-card"><img src="assets/instagram_post/post-01.webp" alt="Saffron Grill Instagram post 1" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-02.webp" alt="Saffron Grill Instagram post 2" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-03.webp" alt="Saffron Grill Instagram post 3" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-04.webp" alt="Saffron Grill Instagram post 4" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-05.webp" alt="Saffron Grill Instagram post 5" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-06.webp" alt="Saffron Grill Instagram post 6" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-07.webp" alt="Saffron Grill Instagram post 7" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-08.webp" alt="Saffron Grill Instagram post 8" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-09.webp" alt="Saffron Grill Instagram post 9" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-10.webp" alt="Saffron Grill Instagram post 10" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card"><img src="assets/instagram_post/post-11.webp" alt="Saffron Grill Instagram post 11" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-01.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-02.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-03.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-04.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-05.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-06.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-07.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-08.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-09.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-10.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
      <article class="instagram-card" aria-hidden="true"><img src="assets/instagram_post/post-11.webp" alt="" loading="lazy" width="1218" height="1528" /></article>
    </div>
  </div>
</section>

<!-- ============== RESERVE ============== -->
<section class="section surface-dark" id="reserve" data-screen-label="Reserve">
  <img class="hero-mandala" src="assets/mandala.png" alt="" style="opacity:.06; width:min(90vh,760px); animation-duration:220s" />
  <div class="wrap" style="position:relative; z-index:2">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Reservations</span>
      <h2 class="h-section gold-text reveal d1">Your Table Is Waiting</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Join generations of memories around food made for sharing.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">Plan a catered gathering with our team, or bring Saffron Grill home tonight with online ordering.</p>
    </div>
    <div class="reserve-card reserve-cta-card reveal d2">
      <div class="reserve-cta-actions">
        <a href="contact.php#reserve" class="btn btn-gold js-open-reserve">Reservation</a>
        <a href="https://order.boons.io/site/saffron-grill/390/y" class="btn btn-crimson" target="_blank" rel="noopener noreferrer">Order Online</a>
      </div>
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
          <li><a href="story.php">Story</a></li>
          <li><a href="menu.php">Menu</a></li>
          <li><a href="catering.php">Catering</a></li>
          <li><a href="contact.php">Contact</a></li>
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
      <span>San Ramon, California · <a href="admin/login.php" style="color: inherit; opacity: 0.6;">Staff Login</a> · <a href="privacy-policy.php" style="color: inherit; opacity: 0.6;">Privacy Policy</a></span>
    </div>
  </div>
</footer>

<!-- ============== PREMIUM POPUP ============== -->
<div id="sgPopup" class="sgp-overlay" role="dialog" aria-modal="true"
     aria-labelledby="sgpTitle" aria-hidden="true">
  <div class="sgp-backdrop"></div>
  <div class="sgp-panel">
    <div class="sgp-shine" aria-hidden="true"></div>
    <div class="sgp-inner">
      <span class="sgp-eyebrow eyebrow on-dark center">Welcome</span>
      <h2 class="sgp-title gold-text" id="sgpTitle">A Table Awaits</h2>
      <div class="sgp-divider" aria-hidden="true">
        <img src="assets/divider.png" alt="" />
      </div>
      <p class="sgp-body lede on-dark">Authentic Indian cuisine. Daily buffets. Tandoori
      specialties. Family feasts. All in the heart of San Ramon.</p>
      <p class="sgp-note body-text on-dark">Reserve your table or explore the menu — we're
      open for lunch &amp; dinner daily.</p>
      <div class="sgp-actions">
        <a href="contact.php#reserve" class="btn btn-gold js-open-reserve">Reserve a Table</a>
        <a href="menu.php" class="btn btn-ghost">Explore Menu</a>
      </div>
    </div>
    <button class="sgp-close" id="pgClose" aria-label="Close">
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
        <line x1="1" y1="1" x2="11" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <line x1="11" y1="1" x2="11" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
    </button>
  </div>
</div>

<?php require_once __DIR__ . '/includes/consent_banner.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" crossorigin="anonymous"></script>
<script src="assets/image-slot.js"></script>
<script src="app.js"></script>
<script src="popup.js"></script>

<script>
// Consent Banner Controller
(function() {
  var consentBanner = document.getElementById('consentBanner');
  var btnAccept = document.getElementById('btnAcceptConsent');
  var btnDecline = document.getElementById('btnDeclineConsent');

  if (consentBanner && !document.cookie.match(/(?:^|; )saffron_consent=/)) {
    setTimeout(function() { consentBanner.style.display = 'block'; }, 1000);
  }

  function setConsent(status) {
    var maxAge = 60 * 60 * 24 * 365;
    document.cookie = "saffron_consent=" + encodeURIComponent(status) + "; path=/; max-age=" + maxAge + "; SameSite=Lax";
    if (consentBanner) consentBanner.style.display = 'none';

    if (window.gtag) {
      gtag('consent', 'update', {
        'ad_storage': status === 'granted' ? 'granted' : 'denied',
        'ad_user_data': status === 'granted' ? 'granted' : 'denied',
        'ad_personalization': status === 'granted' ? 'granted' : 'denied',
        'analytics_storage': status === 'granted' ? 'granted' : 'denied'
      });
    }

    fetch('consent-sync.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ consent: status })
    }).catch(function(){});
  }

  if (btnAccept) btnAccept.addEventListener('click', function() { setConsent('granted'); });
  if (btnDecline) btnDecline.addEventListener('click', function() { setConsent('denied'); });
})();
</script>
</body>
</html>

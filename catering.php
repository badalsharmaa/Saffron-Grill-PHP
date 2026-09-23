<?php
/**
 * Saffron Grill - Catering & Private Events · San Ramon
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Catering & Private Events — Saffron Grill · San Ramon';
$pageDesc = 'Saffron Grill catering services in San Ramon, CA. Custom menus, full-service setups, and premium Indian cuisine for corporate events, weddings, and family parties.';
$canonicalUrl = 'https://saffrongrillrestaurant.com/catering.php';
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
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:type" content="image/png" />

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

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CateringService",
  "name": "Saffron Grill Catering Services",
  "description": "Premium full-service Indian food catering for weddings, corporate events, and private parties in San Ramon and the wider San Francisco Bay Area.",
  "provider": {
    "@type": "Restaurant",
    "name": "Saffron Grill",
    "image": "https://saffrongrillrestaurant.com/assets/story_main.webp",
    "telephone": "+19258463077",
    "priceRange": "$$",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "3191 Crow Canyon Pl, Ste D",
      "addressLocality": "San Ramon",
      "addressRegion": "CA",
      "postalCode": "94583",
      "addressCountry": "US"
    }
  },
  "areaServed": [
    {
      "@type": "AdministrativeArea",
      "name": "San Ramon"
    },
    {
      "@type": "AdministrativeArea",
      "name": "Contra Costa County"
    },
    {
      "@type": "AdministrativeArea",
      "name": "San Francisco Bay Area"
    }
  ]
}
</script>

<link rel="icon" type="image/png" href="assets/emblem.png" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="styles.css?v=<?= filemtime(__DIR__ . '/styles.css') ?>" />
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
    <a href="catering.php" class="active">Catering</a>
    <a href="contact.php">Contact</a>
  </div>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold nav-cta" target="_blank" rel="noopener noreferrer">Order Online</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php">Story</a>
  <a href="menu.php">Menu</a>
  <a href="catering.php" class="active">Catering</a>
  <a href="contact.php">Contact</a>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold" target="_blank" rel="noopener noreferrer" style="color:#3a2208">Order Online</a>
</div>

<!-- ============== HERO ============== -->
<header class="hero" id="top" data-screen-label="Hero">
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="hero-bg-slide active">
      <img class="hero-bg-img" src="assets/catering.webp" alt="Saffron Grill Premium Catering Spread" />
      <video class="hero-bg-video playing" muted playsinline autoplay loop preload="auto">
        <source src="assets/hero3.webm" type="video/webm">
      </video>
    </div>
  </div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">Elevated Gatherings</p>
    <h1 class="reveal d1">
      <span class="l1">Exquisite Catering</span>
      <span class="l2 gold-text italic">For Every Occasion</span>
    </h1>
    
    <!-- Decorative Divider -->
    <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 200px; margin: 18px auto;" />

    <!-- Glassmorphic Trust/Detail Row -->
    <div class="hero-trust-row reveal d2">
      <div class="trust-item">
        <svg class="icon star-icon" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>Customized Menus</span>
      </div>
      <span class="trust-separator"></span>
      <div class="trust-item">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        <span>10 to 500+ Guests</span>
      </div>
      <span class="trust-separator"></span>
      <div class="trust-item">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        <span>Full-Service Setup</span>
      </div>
    </div>

    <!-- CTA Buttons with Premium Sliding Transition -->
    <div class="hero-cta reveal d2">
      <a href="#inquiry-section" class="btn btn-gold-slide">
        <span>Inquire Now</span>
      </a>
      <a href="#packages" class="btn btn-ghost-slide">
        <span>View Packages</span>
      </a>
    </div>
  </div>

  <a href="#services" class="scroll-cue" aria-label="Scroll down">
    <span class="line"></span>
    Discover Services
  </a>
</header>

<!-- ============== SERVICES SHOWCASE ============== -->
<section class="section surface-cream" id="services" data-screen-label="Services">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow center reveal">Our Services</span>
      <h2 class="h-section reveal d1">Catering Designed For Your Event</h2>
      <img class="ornament" src="assets/divider.png" alt="" />
      <p class="lede reveal d2" style="margin-top:14px">Whether it's an intimate celebration or a large-scale corporate event, we design menus that elevate the dining experience and leave a lasting impression.</p>
    </div>

    <div class="services-grid">
      <!-- Corporate Events -->
      <article class="service-card reveal d1">
        <div class="media">
          <image-slot id="cater-corp" src="assets/buffet_lunch.webp" placeholder="Corporate Lunch" shape="rect"></image-slot>
        </div>
        <div class="body">
          <h3>Corporate Lunches &amp; Events</h3>
          <p>Delight your teams and clients with authentic flavors. We provide convenient individual lunch boxes, grand buffets, and custom menus designed for board meetings, conferences, and office milestones.</p>
          <ul>
            <li>Customized dietary options (Veg, Vegan, GF)</li>
            <li>Professional, timely drop-off &amp; setup</li>
            <li>Flexible menus tailored for business schedules</li>
          </ul>
        </div>
      </article>

      <!-- Family Celebrations -->
      <article class="service-card reveal d2">
        <div class="media">
          <image-slot id="cater-fam" src="assets/ambiance-3.webp" placeholder="Family Celebration" shape="rect"></image-slot>
        </div>
        <div class="body">
          <h3>Family Celebrations</h3>
          <p>Mark life's most precious milestones with warm hospitality. From birthdays and anniversaries to graduations and reunions, we serve comforting classics and party trays that gather your loved ones together.</p>
          <ul>
            <li>Vibrant appetizers &amp; traditional sweets</li>
            <li>Portioned party trays for simple hosting</li>
            <li>Menus suited for multi-generational dining</li>
          </ul>
        </div>
      </article>

      <!-- Grand Events & Weddings -->
      <article class="service-card reveal d3">
        <div class="media">
          <image-slot id="cater-wedding" src="assets/buffet-feast.webp" placeholder="Wedding Buffet" shape="rect"></image-slot>
        </div>
        <div class="body">
          <h3>Weddings &amp; Grand Galas</h3>
          <p>Transform your special day into a legendary feast. We specialize in opulent, full-service catering, elegant display setups, curated multicourse spreads, and live interactive stations that delight guests.</p>
          <ul>
            <li>Interactive live tandoori bread stations</li>
            <li>Attentive service staff &amp; complete dinnerware</li>
            <li>Bespoke culinary planning consultations</li>
          </ul>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============== PRICING & PACKAGES ============== -->
<section class="section surface-leather" id="packages" data-screen-label="Packages">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Packages</span>
      <h2 class="h-section gold-text reveal d1">Pricing &amp; Curated Plans</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Choose one of our premium buffet plans or work directly with our culinary team to build a custom menu.</p>
    </div>

    <div class="packages-grid">
      <!-- Bronze Plan -->
      <div class="package-card reveal d1">
        <h3>Bronze Plan</h3>
        <div class="package-price-indicator">$$</div>
        <p class="package-subtitle">Classic Buffet · Min. 20 Guests</p>
        
        <ul class="package-features">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>1 Gourmet Appetizer (Veg/Non-Veg)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Vegetarian Main Curries</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>1 Signature Chicken Curry</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Fragrant Saffron Basmati Rice</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Fresh Butter &amp; Garlic Naan</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>1 Classic Dessert (Gulab Jamun)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Raita, Mint &amp; Tamarind Chutneys</span>
          </li>
        </ul>

        <a href="#inquiry-section" class="btn btn-ghost select-pkg-btn" data-package="bronze">
          <span>Select Bronze Plan</span>
        </a>
      </div>

      <!-- Silver Plan -->
      <div class="package-card featured reveal d2">
        <span class="package-badge">Most Popular</span>
        <h3>Silver Plan</h3>
        <div class="package-price-indicator">$$$</div>
        <p class="package-subtitle">Royal Feast Buffet · Min. 30 Guests</p>
        
        <ul class="package-features">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Appetizers (1 Veg, 1 Non-Veg)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Premium Vegetarian Curries</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Signature Meat Curries (Chicken/Lamb)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Aromatic Biryani or Saffron Rice</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Assorted Fresh Naan Basket</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Desserts (Gulab Jamun &amp; Kheer)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Accompaniments, Raita &amp; Papadum</span>
          </li>
        </ul>

        <a href="#inquiry-section" class="btn btn-gold select-pkg-btn" data-package="silver">
          <span>Select Silver Plan</span>
        </a>
      </div>

      <!-- Gold Plan -->
      <div class="package-card reveal d3">
        <h3>Gold Plan</h3>
        <div class="package-price-indicator">$$$$</div>
        <p class="package-subtitle">Imperial Banquet · Min. 50 Guests</p>
        
        <ul class="package-features">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>3 Gourmet Appetizers (2 Veg, 1 Non-Veg)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>3 Premium Vegetarian Curries</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>2 Imperial Meat/Lamb/Seafood Curries</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Specialty Biryani (Goat, Chicken, or Veg)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Clay Oven Bread Station Setup (optional)</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>3 Premium Desserts &amp; Hot Masala Chai</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Full Salad Bar, Raita &amp; Relishes</span>
          </li>
        </ul>

        <a href="#inquiry-section" class="btn btn-ghost select-pkg-btn" data-package="gold">
          <span>Select Gold Plan</span>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============== CATERING INQUIRY FORM ============== -->
<section class="section surface-dark" id="inquiry-section" data-screen-label="Catering Inquiry">
  <img class="hero-mandala" src="assets/mandala.png" alt="" style="opacity:.04; width:min(90vh,760px); animation-duration:220s" />
  <div class="wrap" style="position:relative; z-index:2">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Inquire</span>
      <h2 class="h-section gold-text reveal d1">Plan Your Catering Event</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Let us bring the authentic flavors of Saffron Grill to your gathering.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">Please fill out the form below with your event details. Our catering coordinator will contact you within 24 hours to customize your menu and service options.</p>
    </div>

    <div class="reserve-card reveal d2">
      <form id="cateringForm" novalidate action="send-mail.php" method="POST">
        <input type="hidden" name="form_type" value="catering_inquiry" />
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>" />
        
        <!-- Honeypot -->
        <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;">
          <input type="text" name="website_hp" tabindex="-1" autocomplete="off" />
        </div>

        <div class="form-grid">
          <div class="field">
            <label for="c-name">Name</label>
            <input id="c-name" name="name" type="text" placeholder="Your name" autocomplete="name" />
            <span class="err"></span>
          </div>
          <div class="field">
            <label for="c-phone">Phone</label>
            <input id="c-phone" name="phone" type="tel" placeholder="(925) 000-0000" autocomplete="tel" />
            <span class="err"></span>
          </div>
          <div class="field">
            <label for="c-email">Email</label>
            <input id="c-email" name="email" type="email" placeholder="email@example.com" autocomplete="email" />
            <span class="err"></span>
          </div>
          <div class="field">
            <label for="c-date">Event Date</label>
            <input id="c-date" name="date" type="date" />
            <span class="err"></span>
          </div>
          <div class="field">
            <label for="c-guests">Guest Count</label>
            <input id="c-guests" name="guests" type="number" min="10" placeholder="Minimum 10 guests" />
            <span class="err"></span>
          </div>
          <div class="field">
            <label for="c-occasion">Occasion</label>
            <select id="c-occasion" name="occasion">
              <option value="">Select occasion…</option>
              <option value="corporate">Corporate Lunch / Event</option>
              <option value="birthday">Birthday Celebration</option>
              <option value="anniversary">Anniversary</option>
              <option value="wedding">Wedding / Reception</option>
              <option value="graduation">Graduation Party</option>
              <option value="other">Other Special Event</option>
            </select>
            <span class="err"></span>
          </div>
          <div class="field full">
            <label for="c-package">Desired Package <span style="opacity:.5">(optional)</span></label>
            <select id="c-package" name="package">
              <option value="">Select package…</option>
              <option value="bronze">Bronze Package (Classic Buffet)</option>
              <option value="silver">Silver Package (Royal Feast)</option>
              <option value="gold">Gold Package (Imperial Experience)</option>
              <option value="custom">Custom / Bespoke Menu</option>
            </select>
            <span class="err"></span>
          </div>
          <div class="field full">
            <label for="c-notes">Notes &amp; Special Requests <span style="opacity:.5">(optional)</span></label>
            <input id="c-notes" name="notes" type="text" placeholder="Dietary restrictions, preferred dishes, live tandoor setup, venue details..." />
            <span class="err"></span>
          </div>
        </div>
        <div class="reserve-actions">
          <button type="submit" class="btn btn-gold">Submit Inquiry</button>
          <span class="or">or call directly</span>
          <a class="tel" href="tel:+19253694696">+1 (925) 369-4696</a>
        </div>
      </form>

      <div class="reserve-success hidden" id="cateringSuccess">
        <div class="check">✓</div>
        <h3 class="h-sub gold-text">Inquiry Received</h3>
        <p class="body-text on-dark" style="margin:12px auto 0; ">Thank you, <span id="cSuccessName">friend</span>. Your catering inquiry has been received. Our team will review your details and contact you at <span id="cSuccessPhone">your phone</span> or write to <span id="cSuccessEmail">your email</span> to design your customized feast.</p>
        <button class="btn btn-ghost" style="margin-top:24px" id="cateringReset">Submit another inquiry</button>
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
      <span>San Ramon, California · <a href="privacy-policy.php" style="color: inherit; opacity: 0.6;">Privacy Policy</a></span>
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
        <a href="menu.php"    class="btn btn-ghost">Explore Menu</a>
      </div>
    </div>
    <button class="sgp-close" id="pgClose" aria-label="Close">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="2" y1="2" x2="12" y2="12"></line>
        <line x1="12" y1="2" x2="2" y2="12"></line>
      </svg>
    </button>
  </div>
</div>

<?php require_once __DIR__ . '/includes/consent_banner.php'; ?>

<!-- ============== SCRIPTS ============== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" crossorigin="anonymous"></script>
<script src="assets/image-slot.js"></script>
<script src="app.js?v=<?= filemtime(__DIR__ . '/app.js') ?>"></script>
<script src="popup.js?v=<?= filemtime(__DIR__ . '/popup.js') ?>"></script>

<script>
  // Simple Package Pre-Selection Handler
  document.querySelectorAll('.select-pkg-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      var pkg = this.getAttribute('data-package');
      var sel = document.getElementById('c-package');
      if (sel && pkg) {
        sel.value = pkg;
      }
    });
  });
</script>
</body>
</html>

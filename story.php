<?php
/**
 * Saffron Grill - Our Story & Philosophy · San Ramon
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Our Story & Philosophy — Saffron Grill · San Ramon';
$pageDesc = 'Discover the culinary philosophy and rich heritage of Saffron Grill in San Ramon, CA. Learn about our traditional clay tandoor cooking, hand-selected spices, and fresh daily ingredients.';
$canonicalUrl = 'https://saffrongrillrestaurant.com/story.php';
$ogImage = 'https://saffrongrillrestaurant.com/assets/story_main.webp';
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
  "@type": "AboutPage",
  "name": "About Saffron Grill",
  "description": "Learn about Saffron Grill's culinary philosophy, traditional clay tandoor cooking methods, and our dedication to fresh ingredients and authentic Indian cuisine in San Ramon, CA.",
  "mainEntity": {
    "@type": "Restaurant",
    "name": "Saffron Grill",
    "image": "https://saffrongrillrestaurant.com/assets/story_main.webp",
    "telephone": "+19258463077",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "3191 Crow Canyon Pl, Ste D",
      "addressLocality": "San Ramon",
      "addressRegion": "CA",
      "postalCode": "94583",
      "addressCountry": "US"
    }
  }
}
</script>

<link rel="icon" type="image/png" href="assets/emblem.png" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="styles.css" />
<style>
  /* Page-specific overrides and additions for story.html */
  .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: clamp(20px, 3vw, 36px);
    margin-top: 50px;
  }
  .value-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(227, 189, 118, 0.15);
    border-radius: 6px;
    padding: clamp(30px, 4.5vw, 48px) 24px;
    text-align: center;
    transition: transform 0.4s var(--ease), border-color 0.4s var(--ease), box-shadow 0.4s var(--ease);
    position: relative;
    overflow: hidden;
  }
  .value-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(227, 189, 118, 0.05), transparent);
    opacity: 0;
    transition: opacity 0.4s var(--ease);
    pointer-events: none;
  }
  .value-card:hover {
    transform: translateY(-8px);
    border-color: rgba(227, 189, 118, 0.45);
    box-shadow: var(--shadow-card);
  }
  .value-card:hover::before {
    opacity: 1;
  }
  .value-icon {
    width: 44px;
    height: 44px;
    margin: 0 auto 20px;
    color: var(--gold-lt);
    display: flex;
    align-items: center;
    justify-content: center;
    filter: drop-shadow(0 4px 8px rgba(227,189,118,0.22));
    transition: transform 0.4s var(--ease);
  }
  .value-card:hover .value-icon {
    transform: scale(1.1);
  }
  .value-card h3 {
    font-size: clamp(18px, 2vw, 22px);
    color: var(--cream);
    margin-bottom: 12px;
    font-family: var(--ff-display);
    letter-spacing: 0.06em;
  }
  .value-card p {
    font-size: 14.5px;
    color: #cbb79f;
    line-height: 1.6;
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
  <a class="nav-brand" href="index.php" aria-label="Saffron Grill home">
    <img src="assets/emblem.png" alt="" />
    <span class="wordmark">
      <b>Saffron Grill</b>
      <span>Authentic Indian Cuisine</span>
    </span>
  </a>
  <div class="nav-links">
    <a href="story.php" class="active">Story</a>
    <a href="menu.php">Menu</a>
    <a href="catering.php">Catering</a>
    <a href="contact.php">Contact</a>
  </div>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold nav-cta" target="_blank" rel="noopener noreferrer">Order Online</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php" class="active">Story</a>
  <a href="menu.php">Menu</a>
  <a href="catering.php">Catering</a>
  <a href="contact.php">Contact</a>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold" target="_blank" rel="noopener noreferrer" style="color:#3a2208">Order Online</a>
</div>

<!-- ============== HERO ============== -->
<header class="hero" id="top" data-screen-label="Hero" style="min-height: 75vh; padding-top: 140px; padding-bottom: 80px;">
  <!-- Parallax Mandala Background -->
  <img class="hero-mandala" src="assets/mandala.png" alt="" style="opacity:.07; width:min(110vh,900px); animation-duration:180s" />
  
  <!-- Overlay Gradients -->
  <div class="hero-overlay-gradient"></div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">Culinary Philosophy</p>
    <h1 class="reveal d1">
      <span class="l1">The Art of Indian</span>
      <span class="l2 gold-text italic">Culinary Harmony</span>
    </h1>
    
    <!-- Decorative Divider -->
    <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 200px; margin: 18px auto;" />

    <p class="lede on-dark reveal d2" style="max-width: 820px; margin-inline: auto; margin-top: 24px; font-size: clamp(20px, 2.5vw, 26px); color: #f2e6d4;">
      "Food is more than nourishment — it is a language of warmth, an invitation to gather, and a celebration of sensory balance. At Saffron Grill, we blend tradition and craft to create meals meant for sharing."
    </p>

    <!-- CTA Buttons with Premium Sliding Transition -->
    <div class="hero-cta reveal d2" style="margin-top: 36px;">
      <a href="#heritage" class="btn btn-gold-slide">
        <span>Our Heritage</span>
      </a>
      <a href="menu.php" class="btn btn-ghost-slide">
        <span>Explore Menu</span>
      </a>
    </div>
  </div>

  <a href="#heritage" class="scroll-cue" aria-label="Scroll down">
    <span class="line"></span>
    Read Story
  </a>
</header>

<!-- ============== HERITAGE NARRATIVE ============== -->
<section class="section surface-cream" id="heritage" data-screen-label="Heritage">
  <div class="wrap story-grid">
    <div class="story-figure reveal">
      <image-slot id="heritage-main" class="frame-main frame-gold" shape="rounded" radius="6" placeholder="Fresh spices and ingredients" src="assets/dishes/chatgpt_5.webp"></image-slot>
      <image-slot id="heritage-float" class="frame-float" shape="rounded" radius="4" placeholder="Freshly baked hot naan" src="assets/dishes/garlic_naan.webp"></image-slot>
    </div>
    <div>
      <span class="eyebrow reveal">Our Heritage</span>
      <h2 class="h-section reveal d1">A Legacy of Spices &amp; Sourcing</h2>
      <img class="ornament sm" style="margin-left:0" src="assets/divider.png" alt="" />
      <p class="lede reveal d2" style="margin-top:8px">From hand-selected spices to daily local harvest, our dishes carry stories from kitchens of antiquity.</p>
      <p class="body-text reveal d2" style="margin-top:18px">The story of Saffron Grill is rooted in a simple obsession: to preserve the honest, traditional flavor profiles of Indian cuisine while utilizing the exceptional bounty of California's local farms. Every morning, our kitchen comes alive with the aroma of freshly ground coriander, turmeric, cumin, and true Kashmiri chillies, each hand-picked and imported directly to ensure absolute purity.</p>
      <p class="body-text reveal d2" style="margin-top:18px">We believe that premium Indian cooking demands uncompromising ingredient quality. That is why our chefs source fresh vegetables and meats daily. Our chicken, lamb, and seafood are never frozen, ensuring that they absorb the complex marinades of yogurt, ginger, garlic, and home-blended masalas before entering the tandoor—our custom clay oven that burns at over 800°F.</p>
      <p class="body-text reveal d2" style="margin-top:18px">From our house-simmered Dal Makhani, which cooks slowly for over sixteen hours, to the fresh paneer pressed daily, we take no shortcuts. This balance of local sourcing and historic recipes is what defines the unique Saffron Grill experience.</p>
    </div>
  </div>
</section>

<!-- ============== STATS ROW ============== -->
<section class="section surface-cream" style="padding-block: 40px; border-top: 1px solid rgba(42,26,18,0.06); border-bottom: 1px solid rgba(42,26,18,0.06);">
  <div class="wrap">
    <div class="story-stats reveal d1" style="margin-top:0; border:none; padding:0;">
      <div class="stat">
        <div class="num">20+</div>
        <div class="lbl">Aromatic Spices<br>Imported Directly</div>
      </div>
      <div class="divider" style="background: rgba(42,26,18,0.1);"></div>
      <div class="stat">
        <div class="num">100%</div>
        <div class="lbl">Daily Fresh<br>Ingredients</div>
      </div>
      <div class="divider" style="background: rgba(42,26,18,0.1);"></div>
      <div class="stat">
        <div class="num">800+</div>
        <div class="lbl">Degrees Tandoor<br>Baking Temperature</div>
      </div>
      <div class="divider" style="background: rgba(42,26,18,0.1);"></div>
      <div class="stat">
        <div class="num">5000+</div>
        <div class="lbl">Satisfied Guests<br>Served Monthly</div>
      </div>
    </div>
  </div>
</section>

<!-- ============== CORE VALUES ============== -->
<section class="section surface-dark" id="values" data-screen-label="Values">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Core Values</span>
      <h2 class="h-section gold-text reveal d1">The Pillars of Saffron Grill</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Every dish we plate, every guest we welcome, and every choice we make is guided by four principles.</p>
    </div>

    <div class="values-grid reveal d2">
      <!-- Card 1: Authenticity -->
      <article class="value-card">
        <div class="value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 100%; height: 100%;">
            <path d="M12 2C8.5 2 6 5.5 6 9c0 6.5 6 13 6 13s6-6.5 6-13c0-3.5-2.5-7-6-7z"/>
            <circle cx="12" cy="9" r="3"/>
          </svg>
        </div>
        <h3>Authenticity</h3>
        <p>We honor time-tested culinary traditions, using genuine clay tandoors and hand-blended spices to deliver the true heritage of Indian cooking without shortcuts.</p>
      </article>

      <!-- Card 2: Hospitality -->
      <article class="value-card">
        <div class="value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 100%; height: 100%;">
            <path d="M3 19h18"/>
            <path d="M5 19a7 7 0 0 1 14 0"/>
            <path d="M12 5V3"/>
            <circle cx="12" cy="3" r="1"/>
          </svg>
        </div>
        <h3>Hospitality</h3>
        <p>In accordance with the timeless philosophy of <em>Atithi Devo Bhava</em> (The Guest is God), we welcome everyone as family, serving with warmth, grace, and generosity.</p>
      </article>

      <!-- Card 3: Quality -->
      <article class="value-card">
        <div class="value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 100%; height: 100%;">
            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 20 2c1 5.5-2 9.5-9 18z"/>
            <path d="M9 22a5 5 0 0 1-5-5c0-4.5 5-7 5-7"/>
          </svg>
        </div>
        <h3>Quality</h3>
        <p>We source only the finest local vegetables, fresh dairy, and never-frozen premium meats, matching them with authentic spices to ensure excellence on every single plate.</p>
      </article>

      <!-- Card 4: Community -->
      <article class="value-card">
        <div class="value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 100%; height: 100%;">
            <circle cx="12" cy="12" r="10"/>
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v6M12 16v6M2 12h6M16 12h6"/>
          </svg>
        </div>
        <h3>Community</h3>
        <p>Food is the ultimate gatherer. We are proud to foster connection, laughter, and community around our sharing tables here in the heart of San Ramon.</p>
      </article>
    </div>
  </div>
</section>

<!-- ============== AMBIANCE / GALLERY ============== -->
<section class="section surface-leather" id="ambiance" data-screen-label="Ambiance">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Ambiance</span>
      <h2 class="h-section gold-text reveal d1">A Space of Warmth &amp; Comfort</h2>
      <img class="ornament" src="assets/divider.png" alt="" />
      <p class="lede on-dark reveal d2" style="margin-top:14px">We design our dining room to be an extension of our kitchen—vibrant, warm, and highly inviting.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">From the soft glow of our custom lighting to the rich textures of our leather booths, Saffron Grill is crafted to elevate your dining experience. Whether you are enjoying a quick weekday buffet lunch or celebrating a milestone with a multi-course family dinner, our warm space provides the perfect backdrop for sharing memorable food and laughter.</p>
    </div>
    
    <div class="gallery-grid reveal" style="margin-top: 52px;">
      <image-slot id="a1" class="g-tall" placeholder="Dining room seating" src="assets/ambiance-1.webp"></image-slot>
      <image-slot id="a2" placeholder="Details and settings" src="assets/ambiance-2.webp"></image-slot>
      <image-slot id="a3" class="g-wide" placeholder="Warm layout ambiance" src="assets/ambiance-3.webp"></image-slot>
      <image-slot id="a4" placeholder="Buffet selection" src="assets/ambiance-4.webp"></image-slot>
      <image-slot id="a5" placeholder="Tandoor fire" src="assets/tandoor-flames.webp"></image-slot>
      <image-slot id="a6" placeholder="Freshly baked naan" src="assets/dishes/garlic_naan.webp"></image-slot>
      <image-slot id="a7" class="g-wide" placeholder="Celebration dinner" src="assets/ambiance-7.webp"></image-slot>
      <image-slot id="a8" placeholder="Plating signatures" src="assets/plating-masterpiece.webp"></image-slot>
      <image-slot id="a9" placeholder="Traditional desserts" src="assets/dishes/gulab_jamun.webp"></image-slot>
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
<script src="app.js"></script>
<script src="popup.js"></script>
</body>
</html>

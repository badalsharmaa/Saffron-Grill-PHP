<?php
/**
 * Saffron Grill - Full Restaurant Menu
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Menu — Saffron Grill · Authentic Indian Cuisine';
$pageDesc = 'Explore Saffron Grill\'s full menu of authentic Indian dishes in San Ramon, CA. From tandoori specialties and rich curries to vegetarian classics and desserts.';
$canonicalUrl = 'https://saffrongrillrestaurant.com/menu.php';
$ogImage = 'https://saffrongrillrestaurant.com/assets/social_image.png';
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

<?php if (!empty($gtmId)): ?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= e($gtmId) ?>');</script>
<?php endif; ?>

<!-- JSON-LD Menu Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Menu",
  "@id": "https://saffrongrillrestaurant.com/menu.php#menu",
  "name": "Saffron Grill Menu",
  "mainEntityOfPage": "https://saffrongrillrestaurant.com/menu.php",
  "inLanguage": "en",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "USD"
  },
  "hasMenuSection": [
    {
      "@type": "MenuSection",
      "name": "Lunch Buffet",
      "description": "Daily Lunch Buffet (Mon-Fri 11:30 AM - 3:00 PM) & Grand Weekend Buffet (Sat-Sun 12:00 PM - 3:30 PM) featuring a rich spread of tandoori specialties, vegetarian & non-vegetarian curries, fresh naan, and desserts."
    },
    {
      "@type": "MenuSection",
      "name": "Tandoori Specialties",
      "description": "Traditional clay tandoor baked meats and breads, marinated in yogurt and hand-selected spices.",
      "hasMenuItem": [
        {
          "@type": "MenuItem",
          "name": "Tandoori Chicken",
          "description": "Bone-in chicken marinated in yogurt and spices, grilled to perfection in the clay tandoor."
        },
        {
          "@type": "MenuItem",
          "name": "Paneer Tikka Masala",
          "description": "Grilled paneer cubes cooked in a rich, creamy tomato onion sauce."
        }
      ]
    },
    {
      "@type": "MenuSection",
      "name": "Signature Curries",
      "description": "Authentic recipes crafted with freshly ground spices.",
      "hasMenuItem": [
        {
          "@type": "MenuItem",
          "name": "Butter Chicken",
          "description": "Tender tandoori chicken simmered in a smooth, buttery tomato cream gravy."
        },
        {
          "@type": "MenuItem",
          "name": "Goat Curry",
          "description": "Tender pieces of goat slow-cooked in a robust gravy of hand-ground spices, onions, and fresh ginger."
        }
      ]
    }
  ]
}
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
  <a class="nav-brand" href="index.php" aria-label="Saffron Grill home">
    <img src="assets/emblem.png" alt="" />
    <span class="wordmark">
      <b>Saffron Grill</b>
      <span>Authentic Indian Cuisine</span>
    </span>
  </a>
  <div class="nav-links">
    <a href="story.php">Story</a>
    <a href="menu.php" class="active">Menu</a>
    <a href="catering.php">Catering</a>
    <a href="contact.php">Contact</a>
  </div>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold nav-cta" target="_blank" rel="noopener noreferrer">Order Online</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php">Story</a>
  <a href="menu.php" class="active">Menu</a>
  <a href="catering.php">Catering</a>
  <a href="contact.php">Contact</a>
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
      <a href="contact.php" class="btn btn-ghost-slide">
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
      <!-- Salads & Appetizers -->
      <div class="menu-col reveal">
        <h3>Salads & Appetizers</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Sweet Potato and Peanut Chaat <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-nuts">Nuts</span></span>
            <span class="leader"></span>
            <span class="price">$11.99</span>
          </div>
          <div class="desc">Mint and tamarind chutneys, yogurt, gram flour vermicelli</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Malai Soya Chap <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Roasted soya chap tossed with mild malai sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Aloo Tikki Chaat <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Cottage cheese stuffed potato patties served with tamarind, mint, and yogurt</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lemon Pepper Chicken <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Tender chicken tossed with zesty lemon, cracked black pepper, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Three Cheese and Asparagus Kabab <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Deep fried cottage cheese, mozzarella, cheddar, and asparagus patties</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Five Spice Calamari <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Crispy calamari seasoned with aromatic five-spice seasoning and served golden and tender.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Potato and Peas Samosa <span class="tag tag-vegan">Vegan</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Crispy pastry filled with spiced potatoes and peas, served with traditional chutneys.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Fish Amritsari <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Crispy batter-fried basa seasoned with gram flour, carom seeds, cumin, coriander, ginger, and garlic.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Gobi Manchurian <span class="tag tag-vegan">Vegan</span></span>
            <span class="leader"></span>
            <span class="price">$11.99</span>
          </div>
          <div class="desc">Crispy cauliflower tossed in garlic, ginger, green onion, and tangy tomato sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tawa Masala Lamb Chops <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$21.99</span>
          </div>
          <div class="desc">Pan fried lamb chop with onion, tomato, ginger, and cilantro</div>
        </div>
      </div>

      <!-- Tandoor Clay Oven Appetizers -->
      <div class="menu-col reveal d1">
        <h3>Tandoor Clay Oven Appetizers</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Panch Pooran Paneer Tikka <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Toasted five spice cottage cheese kabab</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Chicken (Half) <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Bone-in chicken marinated in hung yogurt and homemade spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Chicken (Full) <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$23.99</span>
          </div>
          <div class="desc">Bone-in chicken marinated in hung yogurt and homemade spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Gobi <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Skewer roasted cauliflower with yogurt, cilantro, and cumin</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Cajun Spiced Salmon Tikka <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$21.99</span>
          </div>
          <div class="desc">Tender salmon marinated in aromatic Cajun spices, yogurt, and herbs, then roasted to perfection in the tandoor.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lahori Chicken Tikka <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Tandoor roasted chicken marinated in yogurt, ginger, garlic, and Lahori spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lal Mirch Shrimp Tikka <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$20.99</span>
          </div>
          <div class="desc">Juicy shrimp marinated with red chilies, yogurt, and aromatic spices, then roasted in the tandoor.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Banjara Chicken Tikka <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Boneless chicken thigh marinated in hung yogurt, fresh cilantro mint toasted cumin and crushed black peppercorns</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kalmi Fish <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$21.99</span>
          </div>
          <div class="desc">Tandoor roasted whole golden pompano fish with chef’s special spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kastoori Malai Tikka <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Tender chicken marinated in creamy yogurt, aromatic spices, and kasoori methi, then chargrilled to perfection.</div>
        </div>
      </div>

      <!-- Non-Veg Entrées -->
      <div class="menu-col reveal d2">
        <h3>Non-Veg Entrées</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Butter Chicken <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Roasted and shredded chicken thigh in creamy tomato sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Rogan Josh <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Tender slow-braised lamb cooked with aromatic fennel, onions, and traditional Kashmiri spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Achari Chicken Curry <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Tender chicken thigh pieces cooked with onion, tomato, and pickle spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Bunnah Gosht <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Tender goat slow cooked with caramelized onions, tomatoes, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Malai Methi Chicken Korma <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-nuts">Nuts</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Tender chicken thigh pieces cooked in creamy cashew nut and fenugreek sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Vindalu <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Tender lamb simmered in a tangy, spicy vindaloo sauce with aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Tikka Masala <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Tandoor roasted chicken thigh with onion, ginger, garlic, green pepper, and fresh tomato sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Nalli Nihari Gosht <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$22.99</span>
          </div>
          <div class="desc">Slow-cooked lamb shank simmered in a rich, aromatic nihari gravy with traditional spices until tender.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Karavali Shrimp <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Juicy shrimp cooked in a flavorful coastal-style sauce with aromatic spices and fresh herbs.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kadhai Fish Masala <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$21.99</span>
          </div>
          <div class="desc">Tender fish cooked with bell peppers, onions, tomatoes, and aromatic kadhai spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kadhai Shrimp Masala <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Juicy shrimp cooked with onions, bell peppers, tomatoes, and freshly ground kadhai spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goat Curry <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Bone-in goat cubes cooked with onion, tomato, and yogurt</div>
        </div>
      </div>

      <!-- Veg Entrées -->
      <div class="menu-col reveal">
        <h3>Veg Entrées</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Yellow Dal Tadka <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Yellow lentils tempered with cumin, garlic, and aromatic spices for a comforting and flavorful dish.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Malai Paneer <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-nuts">Nuts</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Cottage cheese cubes in onion and cashew nut creamy sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Dal Makhni <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Black lentils and red kidney beans slow cooked in a creamy tomato based gravy</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Paneer Lababdar <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Cottage cheese cubes simmered in a rich, creamy tomato gravy with aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Peshawari Chana <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Chickpeas slow cooked with tomatoes, onions, and aromatic Peshawari spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kadhai Paneer <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Cottage cheese cooked with bell peppers, onions, tomatoes, and freshly ground kadhai spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Dumpukht Gobi <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Cauliflower slow-cooked in a rich, aromatic masala for deep and flavorful taste.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Palak Paneer <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Cottage cheese cubes in spinach and garlic</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Badami Baingan <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span> <span class="tag tag-nuts">Nuts</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Tender eggplant cooked in a rich almond-based gravy with aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Baingan Bharta <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Fire roasted eggplant with onion, tomato, and homemade spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Masaledar Bhindi <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Fresh okra sautéed with caramelized onion, tangy tomato, ginger, and garlic</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Mushroom Amchuri <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Button mushrooms sautéed with caramelized onion, cumin, green chili, ginger, and amchur spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Panchratan Veg Korma <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">A rich medley of vegetables simmered in a creamy, aromatic korma sauce with traditional Indian spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Corn Saag <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Sweet corn simmered with creamy spinach, garlic, and aromatic Indian spices.</div>
        </div>
      </div>

      <!-- Sides -->
      <div class="menu-col reveal d1">
        <h3>Sides</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Plain Yogurt (8oz) <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Cool and creamy plain yogurt, perfect alongside spicy dishes.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Green Salad (Tomato, Onion, Cucumber) <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Freshly sliced tomato, onion, and cucumber served crisp and refreshing.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Cucumber, Mint Raita (8oz) <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$4.99</span>
          </div>
          <div class="desc">Creamy yogurt blended with refreshing cucumber, mint, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Papad (3 pcs) <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Crisp, thin lentil wafers, lightly roasted or fried for a crunchy accompaniment.</div>
        </div>
      </div>

      <!-- Desserts -->
      <div class="menu-col reveal d2">
        <h3>Desserts</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Rasmalai <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Soft cottage cheese dumplings soaked in sweet, creamy saffron milk.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Gajar Ka Halwa <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span> <span class="tag tag-nuts">Nuts</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Slow-cooked carrots simmered with milk, sugar, and cardamom, finished with nuts.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Gulab Jamun <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Soft milk dumplings soaked in warm, fragrant sugar syrup.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lychee Panna Cotta <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Silky panna cotta infused with refreshing lychee and delicate floral notes.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Moong Dal Halwa <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Rich and indulgent moong lentil pudding slow cooked with ghee, sugar, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Falooda Ice Cream <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Creamy ice cream layered with sweet falooda, fragrant rose syrup, and refreshing toppings.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kesari Rice Kheer <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Creamy rice pudding infused with saffron, cardamom, and delicate sweetness.</div>
        </div>
      </div>

      <!-- Drinks -->
      <div class="menu-col reveal">
        <h3>Drinks</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Mango Lassi <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Creamy yogurt blended with ripe mango for a refreshing and naturally sweet drink.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chai <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Traditional Indian tea brewed with milk and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Sweet Lassi <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Smooth, creamy yogurt drink lightly sweetened for a refreshing finish.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Coke <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Chilled classic Coca-Cola.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Diet Coke <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Zero calorie Diet Coke.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Fresh Lime Soda <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$7.99</span>
          </div>
          <div class="desc">Refreshing lime juice blended with chilled soda for a zesty, sparkling drink.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Sprite <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Crisp, refreshing lemon-lime sparkling soda.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Thums Up / Limca <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Popular Indian bottled sodas — bold spiced Thums Up or zesty cloudy lemon Limca.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Rose Sharbat <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$7.99</span>
          </div>
          <div class="desc">Refreshing rose-flavored drink with delicate floral sweetness.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Coke Zero <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Zero sugar Coca-Cola.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lemonade <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$2.99</span>
          </div>
          <div class="desc">Refreshing sweetened chilled lemonade.</div>
        </div>
      </div>

      <!-- Rice & Biryani -->
      <div class="menu-col reveal d1">
        <h3>Rice & Biryani</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Saffron Basmati Rice <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Fragrant basmati rice delicately infused with saffron and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Dum Biryani <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Fragrant basmati rice layered with tender chicken, herbs, and aromatic spices, slow cooked to perfection.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Haryali Subz Pulao <span class="tag tag-vegan">Vegan</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Fragrant basmati rice cooked with fresh vegetables, herbs, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goat Dum Biryani <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Fragrant basmati rice layered with tender goat, herbs, and aromatic spices, slow cooked to perfection.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Vegetable Dum Biryani <span class="tag tag-veg">Veg</span> <span class="tag tag-gf">GF</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Fragrant basmati rice layered with seasoned vegetables and aromatic spices, slow cooked to perfection.</div>
        </div>
      </div>

      <!-- Breads from Tandoor -->
      <div class="menu-col reveal d2">
        <h3>Breads from Tandoor</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Plain Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Soft and fluffy traditional naan baked fresh in the tandoor.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lacha Paratha <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Flaky, layered Indian flatbread baked to golden perfection.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Roti <span class="tag tag-vegan">Vegan</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Whole wheat flatbread freshly baked in the tandoor.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Stuffed Potato Kulcha <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Tandoor-baked leavened bread stuffed with seasoned potatoes and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Garlic Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$4.99</span>
          </div>
          <div class="desc">Soft tandoor-baked naan topped with fragrant garlic and herbs.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Stuffed Onion Cilantro Kulcha <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Tandoor-baked kulcha stuffed with flavorful onion, fresh cilantro, and aromatic spices.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Garlic Pesto Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Soft naan topped with aromatic garlic and flavorful pesto, baked in the tandoor.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Stuffed Cheese Kulcha <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$7.99</span>
          </div>
          <div class="desc">Soft tandoor-baked kulcha generously stuffed with melted cheese.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Butter Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$7.99</span>
          </div>
          <div class="desc">Soft, fluffy naan brushed generously with melted butter.</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Bread Basket <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Assortment of freshly baked Indian breads, perfect for sharing.</div>
        </div>
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
</body>
</html>

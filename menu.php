<?php
/**
 * Saffron Grill - Full Restaurant Menu
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Menu — Saffron Grill · Authentic Indian Cuisine';
$pageDesc = 'Explore Saffron Grill\'s full menu of authentic Indian dishes in San Ramon, CA. From tandoori specialties and rich curries to vegetarian classics and desserts.';
$canonicalUrl = 'https://saffrongrillsanramon.com/menu.php';
$ogImage = 'https://saffrongrillsanramon.com/assets/hero2-first-frame.jpg';
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

<!-- JSON-LD Menu Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Menu",
  "@id": "https://saffrongrillsanramon.com/menu.php#menu",
  "name": "Saffron Grill Menu",
  "mainEntityOfPage": "https://saffrongrillsanramon.com/menu.php",
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
<link rel="stylesheet" href="styles.css" />
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
  <a href="contact.php#reserve" class="btn btn-gold nav-cta js-open-reserve">Reserve a Table</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php">Story</a>
  <a href="menu.php" class="active">Menu</a>
  <a href="catering.php">Catering</a>
  <a href="contact.php">Contact</a>
  <a href="contact.php#reserve" class="btn btn-gold js-open-reserve" style="color:#3a2208">Reserve a Table</a>
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
            <span class="name">Amritsari Fish <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Crispy batter fried basa with gram flour, carom seeds, cumin, coriander, ginger, and garlic</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Salt and Pepper Calamari <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$11.99</span>
          </div>
          <div class="desc">Deep fried calamari with salt and pepper</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Ginger Crab <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Blue crab meat with onion, ginger, and coconut milk</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Nimbu Chicken <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Roasted chicken breast with ginger and fresh lime juice</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Malai Soya Chop <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$11.99</span>
          </div>
          <div class="desc">Roasted soya chop tossed with mild malai sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Three Cheese and Asparagus Kabab <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Deep fried cottage cheese, mozzarella, cheddar, and asparagus patties</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tofu and Sago Kabab <span class="tag tag-veg">Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Deep fried tofu, sago, royal cumin, and green chili patties</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Aloo Tikki Chaat <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Cottage cheese stuffed potato patties served with tamarind, mint, and yogurt</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Roasted Sweet Potato and Peanut Chaat <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Mint and tamarind chutneys, yogurt, gram flour vermicelli</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Gobi Manchurian <span class="tag tag-veg">Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Crispy cauliflower tossed in garlic, ginger, green onion, and tangy tomato sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Cauliflower Kurchan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$10.99</span>
          </div>
          <div class="desc">Crispy cauliflower tossed in mild creamy coconut sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Potato and Peas Samosa <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$8.99</span>
          </div>
          <div class="desc">Cumin flavored potato and peas filled in flaky pastry</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Arugula Salad <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$9.99</span>
          </div>
          <div class="desc">Green olives, cherry tomato, sprouts, cucumber, cranberry, and feta cheese</div>
        </div>
      </div>

      <!-- Tandoor Clay Oven Appetizers -->
      <div class="menu-col reveal d1">
        <h3>Tandoor Clay Oven Appetizers</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Panch Pooran Paneer Tikka <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Toasted five spice cottage cheese kabab</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Cauliflower <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Skewer roasted cauliflower with yogurt, cilantro, and cumin</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lemongrass Chicken Tikka <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Boneless chicken breast marinated in mild creamy sauce and lemongrass flavor</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Chicken (Full) <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$21.99</span>
          </div>
          <div class="desc">Chicken on the bone marinated in hung yogurt and homemade spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tawa Masala Chap <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$20.99</span>
          </div>
          <div class="desc">Pan fried lamb chop with onion, tomato, ginger, and cilantro</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Apricot and Walnut Chicken Kabab <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Minced chicken with mint, cashew nuts, apricots, walnuts, pepper, cilantro, and green cardamom</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lime and Olive Oil Salmon <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Atlantic salmon marinated in citrus and olive oil</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kalmi Fish <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Tandoor roasted whole golden pompano fish with chef's special spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Mustard Shrimp <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Jumbo shrimp marinated in yogurt, mustard, ginger, and garlic</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Chicken (Half) <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Chicken on the bone marinated in hung yogurt and homemade spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kasturi Chicken Tikka <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Boneless chicken thigh marinated in yogurt, fenugreek, and home-ground spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Lamb Seekh Kabab <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Minced lamb seasoned with herbs, mint, and spices, skewered and char-grilled in the tandoor</div>
        </div>
      </div>

      <!-- Vegetarian Entrees -->
      <div class="menu-col reveal d2">
        <h3>Vegetarian Entrees</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Avocado and Paneer Curry <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Fresh avocado and cottage cheese cooked with ginger, garlic, and coconut cream</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Smoked Eggplant <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Clay oven roasted eggplant cooked with fresh green peas, onion, tomato, and ginger</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Jackfruit Masala <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Baby jackfruit cooked with onion, tomato, and ground spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kale & Cauliflower Bhurji <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Grated cauliflower and kale tossed with cumin, turmeric, and ginger</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chana Masala <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Garbanzo beans cooked with onion, tomato, pomegranate seeds, and ground spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Paneer Tikka Masala <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Cottage cheese cooked in tomato cream sauce with fenugreek</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Yellow Dal Tadka <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$12.99</span>
          </div>
          <div class="desc">Yellow lentils tempered with cumin, garlic, and green chilies</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Dal Makhani <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Slow-cooked black lentils with cream, butter, and mild spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Malai Kofta <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Cottage cheese and potato dumplings in a rich, creamy cashew and saffron gravy</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Saag Paneer <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$14.99</span>
          </div>
          <div class="desc">Fresh spinach puree simmered with cottage cheese cubes, garlic, and a hint of cream</div>
        </div>
      </div>

      <!-- Chicken Entrees -->
      <div class="menu-col reveal">
        <h3>Chicken Entrees</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Butter Chicken <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Tender chicken simmered in buttery tomato sauce with fenugreek</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Tikka Masala <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Boneless chicken cooked in creamy tomato onion sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Korma <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Chicken cooked in mild cashew nut and saffron sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Vindaloo <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Fiery Goan curry with potatoes, vinegar, and hot chilies</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Saag <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">Chicken pieces cooked with fresh spinach puree, garlic, and subtle spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Chettinad <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$16.99</span>
          </div>
          <div class="desc">South Indian style spicy chicken with roasted coconut, black pepper, and curry leaves</div>
        </div>
      </div>

      <!-- Lamb & Goat Entrees -->
      <div class="menu-col reveal d1">
        <h3>Lamb & Goat Entrees</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goat Curry <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Slow-cooked bone-in goat in traditional onion and tomato gravy</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Rogan Josh <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Kashmiri style lamb curry with aromatic spices and yogurt</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Korma <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Tender lamb in rich and creamy cashew nut sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Vindaloo <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Spicy lamb curry with potatoes and tangy vinegar sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Saag <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Tender boneless lamb simmered in spiced fresh spinach and herb gravy</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goat Bhuna Masala <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Bone-in goat pan-roasted with thick caramelized onions, ginger, and crushed whole spices</div>
        </div>
      </div>

      <!-- Seafood Entrees -->
      <div class="menu-col reveal d2">
        <h3>Seafood Entrees</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goan Fish Curry <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$18.99</span>
          </div>
          <div class="desc">Fish cooked with coconut milk, kokum, and Goan spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Shrimp Tikka Masala <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Jumbo shrimp in creamy tomato fenugreek sauce</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kerala Coconut Shrimp <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Shrimp simmered with mustard seeds, curry leaves, and coconut cream</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Salmon Malabar Curry <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$20.99</span>
          </div>
          <div class="desc">Pan-seared Atlantic salmon in a velvety South Indian coastal gravy infused with tamarind and coconut</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Shrimp Vindaloo <span class="tag tag-nonveg">Non-Veg</span> <span class="tag tag-spice">Spicy</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Jumbo shrimp cooked with diced russet potatoes in a hot, tangy chili-vinegar reduction</div>
        </div>
      </div>

      <!-- Rice & Biryani -->
      <div class="menu-col reveal">
        <h3>Rice & Biryani</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Chicken Biryani <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$15.99</span>
          </div>
          <div class="desc">Aromatic basmati rice cooked with spiced chicken and herbs</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Lamb Biryani <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Basmati rice layered with tender lamb, saffron, and mint</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Goat Biryani <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$17.99</span>
          </div>
          <div class="desc">Bone-in goat cooked dum style with fragrant basmati rice</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Vegetable Biryani <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$13.99</span>
          </div>
          <div class="desc">Basmati rice cooked with fresh seasonal vegetables and spices</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Jeera Rice <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Fragrant basmati rice tempered with toasted cumin seeds</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Shrimp Dum Biryani <span class="tag tag-nonveg">Non-Veg</span></span>
            <span class="leader"></span>
            <span class="price">$19.99</span>
          </div>
          <div class="desc">Succulent jumbo prawns slow-cooked with aged basmati rice, caramelized shallots, mint, and kewra water</div>
        </div>
      </div>

      <!-- Tandoori Breads -->
      <div class="menu-col reveal d1">
        <h3>Tandoori Breads</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Plain Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.49</span>
          </div>
          <div class="desc">Traditional clay oven baked flatbread</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Garlic Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Naan topped with fresh garlic and cilantro</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Butter Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Layered naan brushed with melted butter</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Cheese Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$4.99</span>
          </div>
          <div class="desc">Naan stuffed with melted mozzarella cheese</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Tandoori Roti <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.49</span>
          </div>
          <div class="desc">Whole wheat flatbread baked in the tandoor</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Kashmiri Peshawari Naan <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Artisanal naan stuffed with crushed almonds, golden raisins, shredded coconut, and cardamom</div>
        </div>
      </div>

      <!-- Desserts & Beverages -->
      <div class="menu-col reveal d2">
        <h3>Desserts & Beverages</h3>
        <div class="menu-item">
          <div class="top">
            <span class="name">Gulab Jamun <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Warm milk dumplings in cardamom-rose sugar syrup</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Rasmalai <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$6.99</span>
          </div>
          <div class="desc">Soft cheese patties in sweetened saffron-cardamom milk</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Mango Kulfi <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$5.99</span>
          </div>
          <div class="desc">Traditional Indian ice cream with mango and pistachios</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Mango Lassi <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$4.99</span>
          </div>
          <div class="desc">Chilled sweet yogurt drink blended with mango pulp</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Masala Chai <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$3.99</span>
          </div>
          <div class="desc">Traditional spiced Indian tea brewed with milk and herbs</div>
        </div>
        <div class="menu-item">
          <div class="top">
            <span class="name">Sweet or Salted Lassi <span class="tag tag-veg">Veg</span></span>
            <span class="leader"></span>
            <span class="price">$4.49</span>
          </div>
          <div class="desc">Refreshing traditional hand-churned yogurt beverage seasoned with roasted cumin or fragrant rose water</div>
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
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
        <line x1="1" y1="1" x2="11" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <line x1="11" y1="1" x2="1" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
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

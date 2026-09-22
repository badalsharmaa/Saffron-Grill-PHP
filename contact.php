<?php
/**
 * Saffron Grill - Contact & Reservations · San Ramon
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Contact & Reservations — Saffron Grill · San Ramon';
$pageDesc = 'Get in touch with Saffron Grill in San Ramon, CA. Find our hours, location, and make table reservations or inquiries online.';
$canonicalUrl = 'https://saffrongrillrestaurant.com/contact.php';
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
  "image": "https://saffrongrillrestaurant.com/assets/story_main.webp",
  "@id": "https://saffrongrillrestaurant.com/#restaurant",
  "url": "https://saffrongrillrestaurant.com",
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
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Where is Saffron Grill located?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Saffron Grill is located at 3191 Crow Canyon Pl, Ste D, San Ramon, CA 94583, right next to the major Crow Canyon shopping center with ample parking."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer a buffet?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! We serve a delicious daily buffet. Join us for our Lunch Buffet, Monday through Friday from 11:30 AM to 3:00 PM, and our Grand Weekend Buffet on Saturday and Sunday from 12:00 PM to 3:30 PM, featuring fresh tandoori meats, diverse curries, and vegetarian options."
      }
    },
    {
      "@type": "Question",
      "name": "Are there vegetarian and vegan options?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, Saffron Grill is highly vegetarian-friendly. We offer a dedicated selection of traditional vegetarian dishes, from Paneer Tikka Masala to Dal Makhani, as well as several naturally vegan curries. Let your server know if you have specific dietary preferences!"
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer catering services?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! We provide premium catering for corporate events, weddings, family gatherings, and private parties in San Ramon and the wider Bay Area. Visit our Catering page or contact us to request a custom menu."
      }
    },
    {
      "@type": "Question",
      "name": "Can I make a reservation online?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, you can easily reserve a table through our reservation system directly on our website or by calling us. For large parties or special events, we recommend booking in advance."
      }
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
  /* Custom subpage hero */
  .hero-subpage {
    position: relative;
    padding-block: 0;
    min-height: 55vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--espresso);
    overflow: hidden;
  }
  .hero-subpage-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.38;
    filter: blur(1px) brightness(0.65);
    z-index: 0;
  }
  .hero-subpage-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(31,15,8,0.7) 0%, rgba(31,15,8,0.96) 100%);
    z-index: 1;
  }
  .hero-subpage-inner {
    position: relative;
    z-index: 2;
    text-align: center;
    padding-block: clamp(130px, 18vh, 220px) clamp(70px, 9vh, 140px);
  }

  /* Custom location grid for contact.html */
  .location-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: clamp(40px, 6vw, 80px);
    align-items: stretch;
    margin-top: 40px;
  }
  .location-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .location-map-wrap {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid rgba(200, 148, 63, 0.2);
    box-shadow: var(--shadow-card);
    min-height: 480px;
  }
  .location-map-wrap iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
    filter: grayscale(0.2) sepia(0.15) saturate(1.1);
    transition: filter 0.5s ease;
  }
  .location-map-wrap iframe:hover {
    filter: none;
  }
  
  /* Additional adjustment for hours table to match light background */
  .hours-table-light {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 24px;
  }
  .hours-table-light td {
    padding: 14px 0;
    border-bottom: 1px solid rgba(42, 26, 18, 0.12);
    font-size: 15.5px;
    color: var(--ink);
    vertical-align: top;
  }
  .hours-table-light td.day {
    font-weight: 600;
    letter-spacing: .04em;
    color: var(--ink);
  }
  .hours-table-light td.time {
    text-align: right;
    color: var(--ink-soft);
  }
  
  /* Contact link buttons on cream background */
  .contact-link-btn {
    transition: color 0.3s var(--ease);
  }
  .contact-link-btn:hover {
    color: var(--gold-dp) !important;
  }

  @media (max-width: 991px) {
    .location-grid {
      grid-template-columns: 1fr;
      gap: 48px;
    }
    .location-map-wrap {
      min-height: 380px;
    }
  }
</style>
</head>
<body>

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
    <a href="contact.php" class="active">Contact</a>
  </div>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold nav-cta" target="_blank" rel="noopener noreferrer">Order Online</a>
  <button class="nav-toggle" id="navToggle" aria-label="Open menu"><span></span><span></span><span></span></button>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="story.php">Story</a>
  <a href="menu.php">Menu</a>
  <a href="catering.php">Catering</a>
  <a href="contact.php" class="active">Contact</a>
  <a href="<?= e(ORDER_ONLINE_URL) ?>" class="btn btn-gold" target="_blank" rel="noopener noreferrer" style="color:#3a2208">Order Online</a>
</div>

<!-- ============== HERO ============== -->
<header class="hero subpage" id="top" style="min-height: 55vh; padding-top: 150px; padding-bottom: 80px;">
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="hero-bg-slide active">
      <img class="hero-bg-img" src="assets/storefront.jpeg" alt="Saffron Grill Storefront" />
    </div>
  </div>
  
  <div class="hero-inner wrap">
    <p class="hero-tag reveal">San Ramon, CA</p>
    <h1 class="reveal d1">
      <span class="l1">Get in Touch</span>
      <span class="l2 gold-text italic">Reservations &amp; Info</span>
    </h1>
    
    <!-- Decorative Divider -->
    <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 200px; margin: 18px auto;" />

    <div class="hero-cta reveal d2">
      <a href="#reserve" class="btn btn-gold-slide">
        <span>Reserve a Table</span>
      </a>
      <a href="#location" class="btn btn-ghost-slide">
        <span>Find Our Location</span>
      </a>
    </div>
  </div>
</header>

<!-- ============== LOCATION & MAP SECTION ============== -->
<section class="section surface-cream" id="location" data-screen-label="Location">
  <div class="wrap location-grid">
    <!-- Location Details Column -->
    <div class="location-info reveal">
      <span class="eyebrow">Hours &amp; Location</span>
      <h2 class="h-section" style="margin-top: 12px; color: var(--ink);">Join Us at Saffron Grill</h2>
      <img class="ornament sm" style="margin-left: 0; margin-top: 8px; margin-bottom: 24px;" src="assets/divider.png" alt="" />
      
      <!-- Hours Table -->
      <div style="margin-bottom: 32px;">
        <h3 class="h-sub" style="color: var(--aubergine); margin-bottom: 12px; font-size: 18px; font-family: var(--ff-sans); letter-spacing: 0.1em; text-transform: uppercase;">Dining Hours</h3>
        <table class="hours-table-light">
          <tr>
            <td class="day">Mon – Fri</td>
            <td class="time">11:30 AM – 3:00 PM<br>5:00 PM – 10:00 PM</td>
          </tr>
          <tr>
            <td class="day">Sat – Sun</td>
            <td class="time">12:00 PM – 3:30 PM<br>5:00 PM – 10:00 PM</td>
          </tr>
        </table>
      </div>

      <!-- Address Details -->
      <div style="margin-bottom: 32px;">
        <h3 class="h-sub" style="color: var(--aubergine); margin-bottom: 10px; font-size: 18px; font-family: var(--ff-sans); letter-spacing: 0.1em; text-transform: uppercase;">Our Address</h3>
        <p style="font-family: var(--ff-serif); font-size: 22px; line-height: 1.5; color: var(--ink); margin-bottom: 16px;">
          3191 Crow Canyon Pl<br>San Ramon, CA 94583
        </p>
        <a class="btn btn-ghost on-light" href="https://maps.app.goo.gl/yyEfLC6ogW2JiApg8" target="_blank" rel="noopener noreferrer">Get Directions</a>
      </div>

      <!-- Contact Details -->
      <div>
        <h3 class="h-sub" style="color: var(--aubergine); margin-bottom: 16px; font-size: 18px; font-family: var(--ff-sans); letter-spacing: 0.1em; text-transform: uppercase;">Reservations &amp; Inquiries</h3>
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <a class="contact-link-btn" href="tel:+19258463077" style="display: inline-flex; align-items: center; gap: 12px; font-family: var(--ff-serif); font-size: 19px; color: var(--ink); font-weight: 500;">
            <svg style="width: 20px; height: 20px; color: var(--gold-dp);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            +1 (925) 846-3077
          </a>
          <a class="contact-link-btn" href="tel:+19253694696" style="display: inline-flex; align-items: center; gap: 12px; font-family: var(--ff-serif); font-size: 19px; color: var(--ink); font-weight: 500;">
            <svg style="width: 20px; height: 20px; color: var(--gold-dp);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            +1 (925) 369-4696
          </a>
          <a class="contact-link-btn" href="mailto:gosaffrongrill@gmail.com" style="display: inline-flex; align-items: center; gap: 12px; font-family: var(--ff-serif); font-size: 19px; color: var(--ink); font-weight: 500;">
            <svg style="width: 20px; height: 20px; color: var(--gold-dp);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            gosaffrongrill@gmail.com
          </a>
        </div>
      </div>
    </div>
    
    <!-- Interactive Google Map Column -->
    <div class="location-map-wrap reveal d1">
      <iframe
        title="Saffron Grill location map"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps?q=3191+Crow+Canyon+Pl,+San+Ramon,+CA+94583&output=embed"
      ></iframe>
    </div>
  </div>
</section>

<!-- ============== CONTACT FORM SECTION ============== -->
<section class="section surface-leather" id="contact-form-section" data-screen-label="Contact Us">
  <!-- Mandala Background Effect -->
  <img class="hero-mandala" src="assets/mandala.png" alt="" style="opacity:.015; width:min(90vh,760px); animation-duration:220s; pointer-events:none;" />
  
  <div class="wrap" style="position:relative; z-index:2">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Send a Message</span>
      <h2 class="h-section gold-text reveal d1">Contact Our Team</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Have a question, feedback, or special request? We'd love to hear from you.</p>
    </div>
    
    <div class="reserve-card high-contrast reveal d2" style="background: rgba(22, 7, 20, 0.96); border: 1px solid rgba(227, 189, 118, 0.4); backdrop-filter: blur(16px); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.75);">
      <form id="contactForm" novalidate action="send-mail.php" method="POST">
        <input type="hidden" name="form_type" value="contact_message" />
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
          <div class="field full">
            <label for="c-email">Email</label>
            <input id="c-email" name="email" type="email" placeholder="email@example.com" autocomplete="email" />
            <span class="err"></span>
          </div>
          <div class="field full">
            <label for="c-subject">Subject</label>
            <select id="c-subject" name="subject">
              <option value="">Select subject…</option>
              <option value="general">General Inquiry</option>
              <option value="feedback">Feedback &amp; Suggestions</option>
              <option value="catering">Catering Inquiry</option>
              <option value="private-party">Private Dining / Party</option>
              <option value="other">Other</option>
            </select>
            <span class="err"></span>
          </div>
          <div class="field full">
            <label for="c-message">Message</label>
            <textarea id="c-message" name="message" rows="5" placeholder="Write your message here..."></textarea>
            <span class="err"></span>
          </div>
        </div>
        <div class="reserve-actions">
          <button type="submit" class="btn btn-gold">Send Message</button>
          <span class="or">or call</span>
          <a class="tel" href="tel:+19258463077">+1 (925) 846-3077</a>
        </div>
      </form>
      
      <div class="reserve-success hidden" id="contactSuccess" style="text-align: center; padding-block: 20px;">
        <div class="check">✓</div>
        <h3 class="h-sub gold-text">Message Sent</h3>
        <p class="body-text on-dark" style="margin:12px auto 0; max-width: 400px;">Thank you, <span id="contactSuccessName">friend</span>. Your message has been sent successfully. We will get back to you shortly.</p>
        <button class="btn btn-ghost" style="margin-top:24px" id="contactReset">Send another message</button>
      </div>
    </div>
  </div>
</section>

<!-- ============== FAQ SECTION ============== -->
<section class="section surface-paper" id="faq" data-screen-label="FAQ">
  <div class="wrap">
    <div class="sec-head center reveal">
      <span class="eyebrow center">Got Questions?</span>
      <h2 class="h-section center" style="color: var(--ink);">Frequently Asked Questions</h2>
      <img class="ornament reveal d1" src="assets/divider.png" alt="" style="width: 160px; margin: 12px auto 0;" />
    </div>

    <div class="faq-container reveal d2">
      <!-- FAQ 1 -->
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-1">
          Where is Saffron Grill located?
          <span class="faq-trigger-icon" aria-hidden="true"></span>
        </button>
        <div id="faq-ans-1" class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Saffron Grill is located at <a href="https://maps.app.goo.gl/yyEfLC6ogW2JiApg8" target="_blank" rel="noopener noreferrer">3191 Crow Canyon Pl, Ste D, San Ramon, CA 94583</a>, conveniently situated near the Crow Canyon shopping center with plenty of guest parking available.
          </div>
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-2">
          Do you offer a buffet?
          <span class="faq-trigger-icon" aria-hidden="true"></span>
        </button>
        <div id="faq-ans-2" class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Yes! We host a highly popular daily buffet:
            <ul style="margin-top: 10px; padding-left: 20px; list-style-type: disc;">
              <li><strong>Lunch Buffet:</strong> Monday through Friday from 11:30 AM to 3:00 PM.</li>
              <li><strong>Grand Weekend Buffet:</strong> Saturday and Sunday from 12:00 PM to 3:30 PM.</li>
            </ul>
            Our buffet features a rotating selection of tandoori grilled items, authentic curries, vegetarian specials, fresh naan served directly to your table, and classic Indian desserts.
          </div>
        </div>
      </div>

      <!-- FAQ 3 -->
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-3">
          Are there vegetarian and vegan options?
          <span class="faq-trigger-icon" aria-hidden="true"></span>
        </button>
        <div id="faq-ans-3" class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Absolutely. Indian cuisine is naturally rich in vegetarian offerings, and Saffron Grill takes special pride in our plant-based selections. We offer a wide range of dedicated vegetarian specialties (like Paneer Tikka Masala and Dal Makhani) and several vegan-friendly lentil and vegetable curries. Please let your server know if you have specific vegan or allergen requirements so we can accommodate you!
          </div>
        </div>
      </div>

      <!-- FAQ 4 -->
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-4">
          Do you offer catering services?
          <span class="faq-trigger-icon" aria-hidden="true"></span>
        </button>
        <div id="faq-ans-4" class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Yes, we provide professional, full-service catering for all sizes of events including corporate lunches, weddings, family reunions, and holiday parties across San Ramon and the San Francisco Bay Area. You can browse details and request a customized menu on our <a href="catering.php">Catering page</a>.
          </div>
        </div>
      </div>

      <!-- FAQ 5 -->
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-5">
          Can I make a reservation online?
          <span class="faq-trigger-icon" aria-hidden="true"></span>
        </button>
        <div id="faq-ans-5" class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Yes, you can easily secure a table using the online reservation button in our navigation menu, or by filling out the reservation form below on this page. For parties larger than 8, or special event bookings, please call us directly at <a href="tel:+19258463077">+1 (925) 846-3077</a> or <a href="tel:+19253694696">+1 (925) 369-4696</a> to ensure availability.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var faqQuestions = document.querySelectorAll(".faq-question");
  faqQuestions.forEach(function(question) {
    question.addEventListener("click", function() {
      var item = this.parentElement;
      var answer = this.nextElementSibling;
      var isActive = item.classList.contains("active");

      // Close all other FAQ items
      document.querySelectorAll(".faq-item").forEach(function(el) {
        el.classList.remove("active");
        el.querySelector(".faq-question").setAttribute("aria-expanded", "false");
        el.querySelector(".faq-answer").style.maxHeight = null;
      });

      if (!isActive) {
        item.classList.add("active");
        this.setAttribute("aria-expanded", "true");
        // Dynamically calculate scroll height for smooth transition
        answer.style.maxHeight = answer.scrollHeight + "px";
      }
    });
  });
});
</script>

<!-- ============== RESERVATIONS SECTION ============== -->
<section class="section surface-dark" id="reserve" data-screen-label="Reserve">
  <!-- Mandala Background Effect -->
  <img class="hero-mandala" src="assets/mandala.png" alt="" style="opacity:.05; width:min(90vh,760px); animation-duration:220s" />
  
  <div class="wrap" style="position:relative; z-index:2">
    <div class="sec-head center">
      <span class="eyebrow on-dark center reveal">Reservations</span>
      <h2 class="h-section gold-text reveal d1">Your Table Is Waiting</h2>
      <p class="lede on-dark reveal d2" style="margin-top:14px">Join generations of memories around food made for sharing.</p>
      <p class="body-text on-dark reveal d2" style="margin-top:14px">Plan a catered gathering with our team, or bring Saffron Grill home tonight with online ordering.</p>
    </div>
    
    <div class="reserve-card reserve-cta-card reveal d2">
      <div class="reserve-cta-actions">
        <a href="#reserve" class="btn btn-gold js-open-reserve">Reservation</a>
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
<script src="app.js"></script>
<script src="popup.js"></script>
</body>
</html>

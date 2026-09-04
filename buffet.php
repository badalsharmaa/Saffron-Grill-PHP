<?php
/**
 * Saffron Grill - Daily Grand Lunch Buffet Page
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Daily Grand Lunch Buffet — Saffron Grill · San Ramon, CA';
$pageDesc = 'Experience San Ramon\'s favorite Indian lunch buffet at Saffron Grill. Over 20 hot dishes daily, clay tandoor naans, vegetarian & Halal meats ($19.99 Weekday / $21.99 Weekend).';
$canonicalUrl = BASE_URL . '/buffet';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<!-- ============== HERO ============== -->
<header class="hero" id="top" style="min-height: 55vh; padding-top: 140px; padding-bottom: 70px;">
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="hero-bg-slide active">
      <img class="hero-bg-img" src="<?= asset('buffet-feast.webp') ?>" alt="Saffron Grill Grand Lunch Buffet" />
      <video class="hero-bg-video playing" muted playsinline autoplay loop preload="auto" poster="<?= asset('buffet-feast.webp') ?>">
        <source src="<?= asset('buffet-vid-1.webm') ?>" type="video/webm">
      </video>
    </div>
  </div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">Daily Feast Experience</p>
    <h1 class="reveal d1">
      <span class="l1">San Ramon's Premier</span>
      <span class="l2 gold-text italic">Grand Lunch Buffet</span>
    </h1>
    <img class="ornament reveal d1" src="<?= asset('divider.png') ?>" alt="" style="width: 200px; margin: 18px auto;" />
    <p class="lede on-dark reveal d2" style="max-width: 680px; margin: 0 auto;">Over 20 chef-crafted hot dishes rotated daily. Unlimited appetizers, rich curries, tandoori grills, steaming basmati biryani, table-served fresh naans, and traditional desserts.</p>
  </div>
</header>

<!-- ============== PRICING & HOURS SECTION ============== -->
<section class="section surface-cream">
  <div class="wrap">
    <div style="text-align: center; max-width: 650px; margin: 0 auto 36px;">
      <span class="eyebrow reveal">Feast Schedule</span>
      <h2 class="h-section reveal d1" style="margin-top: 8px;">Buffet Timings &amp; Pricing</h2>
      <img class="ornament sm" src="<?= asset('divider.png') ?>" alt="" style="margin: 12px auto;" />
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; max-width: 900px; margin: 0 auto;">
      <!-- Weekday Card -->
      <div class="reveal d1" style="background: #fff; border: 2px solid #e5dcd3; border-radius: 12px; padding: 32px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: relative;">
        <span style="background: #260e22; color: #f5d485; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 16px;">Monday – Friday</span>
        <h3 style="font-family: 'Cinzel', serif; font-size: 24px; margin-bottom: 8px;">Weekday Power Lunch</h3>
        <div style="font-size: 36px; font-weight: 700; color: #c2410c; margin-bottom: 8px;"><?= e(BUFFET_WEEKDAY_PRICE) ?> <span style="font-size: 14px; font-weight: 400; color: #666;">/ person</span></div>
        <p style="color: #666; font-size: 14px; margin-bottom: 20px;"><strong>11:30 AM – 3:00 PM</strong></p>
        <p style="color: #555; font-size: 13.5px; line-height: 1.6; margin-bottom: 24px;">The Tri-Valley's favorite weekday lunch option. Fast, wholesome, and delicious for busy professionals and families.</p>
        <ul style="text-align: left; font-size: 13.5px; color: #444; list-style: none; padding: 0; margin-bottom: 24px; display: flex; flex-direction: column; gap: 8px;">
          <li>✓ 15+ Rotated Hot Entrees &amp; Appetizers</li>
          <li>✓ Vegetarian &amp; Halal Non-Veg Curries</li>
          <li>✓ Fresh Garlic or Butter Naan served at table</li>
          <li>✓ Basmati Rice, Chutneys &amp; Fresh Salad Bar</li>
          <li>✓ Warm Gulab Jamun &amp; Kheer</li>
        </ul>
        <button class="btn btn-gold js-open-reserve" type="button" style="width: 100%;">Reserve a Weekday Table</button>
      </div>

      <!-- Weekend Card -->
      <div class="reveal d2" style="background: #fff; border: 2px solid #eab308; border-radius: 12px; padding: 32px; text-align: center; box-shadow: 0 10px 30px rgba(234,179,8,0.15); position: relative;">
        <span style="position: absolute; top: -12px; right: 20px; background: #c2410c; color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; padding: 4px 10px; border-radius: 4px;">Grand Weekend Special</span>
        <span style="background: #260e22; color: #f5d485; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 16px;">Saturday &amp; Sunday</span>
        <h3 style="font-family: 'Cinzel', serif; font-size: 24px; margin-bottom: 8px;">Grand Royal Feast</h3>
        <div style="font-size: 36px; font-weight: 700; color: #c2410c; margin-bottom: 8px;"><?= e(BUFFET_WEEKEND_PRICE) ?> <span style="font-size: 14px; font-weight: 400; color: #666;">/ person</span></div>
        <p style="color: #666; font-size: 14px; margin-bottom: 20px;"><strong>12:00 PM – 3:30 PM</strong></p>
        <p style="color: #555; font-size: 13.5px; line-height: 1.6; margin-bottom: 24px;">An expanded feast with rich goat curries, live sizzlers, special biryanis, and premium royal desserts.</p>
        <ul style="text-align: left; font-size: 13.5px; color: #444; list-style: none; padding: 0; margin-bottom: 24px; display: flex; flex-direction: column; gap: 8px;">
          <li>✓ 20+ Premium Entrees &amp; Tandoori Grills</li>
          <li>✓ Slow-Cooked Goat Curry &amp; Butter Chicken</li>
          <li>✓ Specialty Paneer &amp; Seasonal Veggies</li>
          <li>✓ Hot Tandoori Naan Assortment</li>
          <li>✓ Gulab Jamun, Rasmalai &amp; Mango Treats</li>
        </ul>
        <button class="btn btn-gold js-open-reserve" type="button" style="width: 100%;">Reserve a Weekend Table</button>
      </div>
    </div>
  </div>
</section>

<!-- ============== WHAT'S IN THE BUFFET ============== -->
<section class="section surface-leather">
  <div class="wrap">
    <div style="text-align: center; max-width: 650px; margin: 0 auto 36px;">
      <span class="eyebrow on-dark reveal">Everyday Spread</span>
      <h2 class="h-section gold-text reveal d1" style="margin-top: 8px;">What You'll Savor</h2>
      <img class="ornament sm" src="<?= asset('divider.png') ?>" alt="" style="margin: 12px auto;" />
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
      <div style="background: rgba(26,8,24,0.6); border: 1px solid rgba(234,179,8,0.25); border-radius: 8px; padding: 22px;">
        <h4 style="color: #f5d485; font-family: 'Cinzel', serif; font-size: 17px; margin-bottom: 8px;">🍢 Sizzlers &amp; Starters</h4>
        <p style="color: #d1c4cb; font-size: 13.5px; line-height: 1.5;">Vegetable pakoras, samosas, crispy lahsuni gobi, and tandoori chicken hot from the clay oven.</p>
      </div>
      <div style="background: rgba(26,8,24,0.6); border: 1px solid rgba(234,179,8,0.25); border-radius: 8px; padding: 22px;">
        <h4 style="color: #f5d485; font-family: 'Cinzel', serif; font-size: 17px; margin-bottom: 8px;">🍲 Rich Curries</h4>
        <p style="color: #d1c4cb; font-size: 13.5px; line-height: 1.5;">Creamy butter chicken, chicken tikka masala, kashmiri lamb/goat curry, dal makhani, and palak paneer.</p>
      </div>
      <div style="background: rgba(26,8,24,0.6); border: 1px solid rgba(234,179,8,0.25); border-radius: 8px; padding: 22px;">
        <h4 style="color: #f5d485; font-family: 'Cinzel', serif; font-size: 17px; margin-bottom: 8px;">🫓 Fresh Clay Oven Naan</h4>
        <p style="color: #d1c4cb; font-size: 13.5px; line-height: 1.5;">Brought directly to your dining table hot and glistening with pure butter or fresh minced garlic.</p>
      </div>
      <div style="background: rgba(26,8,24,0.6); border: 1px solid rgba(234,179,8,0.25); border-radius: 8px; padding: 22px;">
        <h4 style="color: #f5d485; font-family: 'Cinzel', serif; font-size: 17px; margin-bottom: 8px;">🍨 Royal Sweets &amp; Salads</h4>
        <p style="color: #d1c4cb; font-size: 13.5px; line-height: 1.5;">Warm gulab jamun, rasmalai, aromatic rice kheer, cucumber raita, and house-made mint &amp; tamarind chutneys.</p>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

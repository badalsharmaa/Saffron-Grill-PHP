<?php
/**
 * Saffron Grill - Navigation Bar Component
 */
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '', '.php');
$status = get_restaurant_status();
?>
<!-- Announcement Banner if active -->
<?php if (get_setting('announcement_active', '1') === '1'): ?>
<div class="top-announcement" style="background: linear-gradient(90deg, #260e22, #44143a, #260e22); color: #f5d485; font-size: 13px; padding: 7px 15px; text-align: center; letter-spacing: 0.03em; border-bottom: 1px solid rgba(234, 179, 8, 0.2); position: relative; z-index: 101;">
  <span><?= e(get_setting('announcement_banner', '✨ Daily Grand Lunch Buffet: $19.99 Weekdays & $21.99 Weekends with Fresh Naan & Tandoori Sizzlers!')) ?></span>
</div>
<?php endif; ?>

<!-- ============== NAV ============== -->
<nav class="nav" id="nav">
  <a class="nav-brand" href="/" aria-label="Saffron Grill home">
    <img src="<?= asset('emblem.png') ?>" alt="Saffron Grill Emblem" />
    <span class="wordmark">
      <b><?= e(APP_NAME) ?></b>
      <span><?= e(APP_TAGLINE) ?></span>
    </span>
  </a>

  <div class="nav-links">
    <a href="/" class="<?= $currentPage === 'index' ? 'active' : '' ?>">Home</a>
    <a href="/story" class="<?= $currentPage === 'story' ? 'active' : '' ?>">Our Story</a>
    <a href="/buffet" class="<?= $currentPage === 'buffet' ? 'active' : '' ?>">Lunch Buffet</a>
    <a href="/menu" class="<?= $currentPage === 'menu' ? 'active' : '' ?>">Menu</a>
    <a href="/catering" class="<?= $currentPage === 'catering' ? 'active' : '' ?>">Catering</a>
    <a href="/contact" class="<?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a>
  </div>

  <div class="nav-actions">
    <div class="nav-status" title="<?= e($status['status_text']) ?>">
      <span class="dot <?= $status['is_open'] ? 'live' : '' ?>"></span>
      <span id="openState"><?= e($status['status_text']) ?></span>
    </div>
    <button class="btn btn-gold btn-sm js-open-reserve" type="button" data-reserve-trigger>
      <span>Reserve a Table</span>
    </button>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" type="button">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div class="mobile-menu" id="mobileMenu">
  <a href="/" class="<?= $currentPage === 'index' ? 'active' : '' ?>">Home</a>
  <a href="/story" class="<?= $currentPage === 'story' ? 'active' : '' ?>">Our Story</a>
  <a href="/buffet" class="<?= $currentPage === 'buffet' ? 'active' : '' ?>">Lunch Buffet</a>
  <a href="/menu" class="<?= $currentPage === 'menu' ? 'active' : '' ?>">Menu</a>
  <a href="/catering" class="<?= $currentPage === 'catering' ? 'active' : '' ?>">Catering</a>
  <a href="/contact" class="<?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a>
  <div style="margin-top: 20px; padding: 0 20px; display: flex; flex-direction: column; gap: 12px;">
    <button class="btn btn-gold js-open-reserve" type="button" style="width: 100%;">
      <span>Reserve a Table</span>
    </button>
    <a href="tel:<?= e(PHONE_TEL) ?>" class="btn btn-outline" style="width: 100%; text-align: center;">
      <span>Call <?= e(PHONE_PRIMARY) ?></span>
    </a>
  </div>
</div>

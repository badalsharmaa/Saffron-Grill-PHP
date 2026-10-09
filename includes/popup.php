<?php
/**
 * Saffron Grill — Dynamic Promotional Popup Modal
 * Driven by CMS::getPopupConfig()
 */

if (!function_exists('cms_popup_config')) {
    $helper = __DIR__ . '/../api/cms_helper.php';
    if (file_exists($helper)) require_once $helper;
}

$popupCfg = function_exists('cms_popup_config') ? cms_popup_config() : [
    'is_active' => true,
    'delay_seconds' => 1.5,
    'show_frequency' => 'session',
    'enable_lead_capture' => false,
    'lead_capture_title' => 'Join Saffron VIP Club for Exclusive Offers',
    'slides' => [
        [
            'id' => 1,
            'image' => '/assets/hero2-first-frame.jpg',
            'alt' => 'Daily Grand Lunch Buffet Feast',
            'title' => 'Daily Grand Lunch Buffet Feast',
            'link' => '/menu'
        ]
    ]
];

if (empty($popupCfg['is_active'])) {
    return; // Popup disabled in CMS
}

$slides = !empty($popupCfg['slides']) ? $popupCfg['slides'] : [];
$firstSlide = $slides[0] ?? [
    'image' => '/assets/hero2-first-frame.jpg',
    'title' => 'Daily Grand Lunch Buffet',
    'link' => '/menu'
];
?>

<!-- ============== DYNAMIC POPUP MODAL ============== -->
<div id="sgPopup" class="sgp-overlay" role="dialog" aria-modal="true"
     aria-labelledby="sgpTitle" aria-hidden="true"
     data-delay="<?= (float)($popupCfg['delay_seconds'] ?? 1.5) ?>"
     data-frequency="<?= e($popupCfg['show_frequency'] ?? 'session') ?>">
  <div class="sgp-backdrop"></div>
  <div class="sgp-panel">
    <div class="sgp-shine" aria-hidden="true"></div>
    <div class="sgp-inner">
      <span class="sgp-eyebrow eyebrow on-dark center"><?= e(cms_get('popup_eyebrow', 'Welcome to Saffron Grill')) ?></span>
      <h2 class="sgp-title gold-text" id="sgpTitle"><?= e($firstSlide['title'] ?? 'A Table Awaits') ?></h2>
      
      <div class="sgp-divider" aria-hidden="true">
        <img src="/assets/divider.png" alt="" />
      </div>

      <?php if (!empty($firstSlide['image'])): ?>
      <div class="sgp-flyer-wrap" style="margin: 12px auto 16px; max-width: 320px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(227, 189, 118, 0.3); box-shadow: 0 8px 24px rgba(0,0,0,0.5);">
        <img src="<?= e($firstSlide['image']) ?>" alt="<?= e($firstSlide['title'] ?? 'Special Offer') ?>" style="width: 100%; height: auto; display: block; object-fit: cover;">
      </div>
      <?php endif; ?>

      <p class="sgp-body lede on-dark"><?= e(cms_get('popup_body', 'Authentic Indian cuisine. Daily buffets. Tandoori specialties. Family feasts. All in the heart of San Ramon.')) ?></p>
      
      <p class="sgp-note body-text on-dark"><?= e(cms_get('popup_note', "Reserve your table or explore our menu — we're open for lunch & dinner daily.")) ?></p>
      
      <?php if (!empty($popupCfg['enable_lead_capture'])): ?>
      <div class="sgp-lead-box" style="margin: 14px 0; padding: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(227,189,118,0.25); border-radius: 6px;">
        <p style="font-size: 13px; color: var(--gold); margin-bottom: 8px; font-weight: 600;"><?= e($popupCfg['lead_capture_title'] ?? 'Join VIP Club for Exclusive Offers') ?></p>
        <form action="/send-mail.php" method="POST" style="display: flex; gap: 8px;">
          <input type="hidden" name="form_type" value="vip_signup">
          <input type="hidden" name="csrf_token" value="<?= function_exists('csrf_token') ? csrf_token() : '' ?>">
          <input type="email" name="email" placeholder="Enter your email" required style="flex: 1; padding: 6px 10px; font-size: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.4); color: #fff;">
          <button type="submit" class="btn btn-gold" style="padding: 6px 12px; font-size: 12px;">Join</button>
        </form>
      </div>
      <?php endif; ?>

      <div class="sgp-actions">
        <a href="<?= e($firstSlide['link'] ?? '/contact#reserve') ?>" class="btn btn-gold js-open-reserve"><?= e(cms_get('popup_btn1_text', 'Reserve a Table')) ?></a>
        <a href="/menu" class="btn btn-ghost"><?= e(cms_get('popup_btn2_text', 'Explore Menu')) ?></a>
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

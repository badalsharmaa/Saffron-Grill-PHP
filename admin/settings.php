<?php
/**
 * Saffron Grill Admin - Site Settings & Operational Constants Editor
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$activeTab = 'settings';
$adminTitle = 'Settings — Saffron Grill CRM';

$pdo = get_db();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_settings') {
    $settingsToSave = [
        'site_name' => trim($_POST['site_name'] ?? 'Saffron Grill'),
        'site_tagline' => trim($_POST['site_tagline'] ?? ''),
        'contact_phone' => trim($_POST['contact_phone'] ?? ''),
        'contact_phone_alt' => trim($_POST['contact_phone_alt'] ?? ''),
        'contact_email' => trim($_POST['contact_email'] ?? ''),
        'buffet_weekday_price' => trim($_POST['buffet_weekday_price'] ?? '$19.99'),
        'buffet_weekend_price' => trim($_POST['buffet_weekend_price'] ?? '$21.99'),
        'announcement_banner' => trim($_POST['announcement_banner'] ?? ''),
        'announcement_active' => isset($_POST['announcement_active']) ? '1' : '0',
        'gtm_container_id' => trim($_POST['gtm_container_id'] ?? ''),
        'min_catering_guests' => trim($_POST['min_catering_guests'] ?? '25'),
    ];

    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP) 
        ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value, updated_at = CURRENT_TIMESTAMP");
    
    foreach ($settingsToSave as $k => $v) {
        $stmt->execute([$k, $v]);
    }
    $msg = "Settings updated successfully!";
}

// Fetch all settings
$settings = [];
$rows = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll();
foreach ($rows as $r) {
    $settings[$r['setting_key']] = $r['setting_value'];
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="data-card" style="max-width: 800px; margin: 0 auto;">
  <div class="card-header">
    <h2 class="card-title">Restaurant Configuration &amp; Live Information</h2>
  </div>

  <?php if (!empty($msg)): ?>
    <div style="background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13.5px;">
      <?= e($msg) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="settings.php">
    <input type="hidden" name="action" value="save_settings">

    <div style="display: flex; flex-direction: column; gap: 18px;">
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Restaurant Name</label>
          <input type="text" name="site_name" value="<?= e($settings['site_name'] ?? 'Saffron Grill') ?>" required>
        </div>
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Tagline</label>
          <input type="text" name="site_tagline" value="<?= e($settings['site_tagline'] ?? '') ?>">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Primary Phone</label>
          <input type="text" name="contact_phone" value="<?= e($settings['contact_phone'] ?? '(925) 846-3077') ?>" required>
        </div>
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Alternate Phone</label>
          <input type="text" name="contact_phone_alt" value="<?= e($settings['contact_phone_alt'] ?? '(925) 369-4696') ?>">
        </div>
      </div>

      <div>
        <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Contact Email</label>
        <input type="email" name="contact_email" value="<?= e($settings['contact_email'] ?? 'gosaffrongrill@gmail.com') ?>" required>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Weekday Buffet Price</label>
          <input type="text" name="buffet_weekday_price" value="<?= e($settings['buffet_weekday_price'] ?? '$19.99') ?>">
        </div>
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Weekend Buffet Price</label>
          <input type="text" name="buffet_weekend_price" value="<?= e($settings['buffet_weekend_price'] ?? '$21.99') ?>">
        </div>
      </div>

      <div>
        <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Top Announcement Bar Banner</label>
        <input type="text" name="announcement_banner" value="<?= e($settings['announcement_banner'] ?? '') ?>">
        <label style="display: flex; align-items: center; gap: 6px; font-size: 12.5px; margin-top: 6px;">
          <input type="checkbox" name="announcement_active" value="1" <?= ($settings['announcement_active'] ?? '1') === '1' ? 'checked' : '' ?>> Show Announcement Banner on Website
        </label>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Google Tag Manager ID (GTM-XXXX)</label>
          <input type="text" name="gtm_container_id" value="<?= e($settings['gtm_container_id'] ?? '') ?>" placeholder="GTM-XXXXXXX">
        </div>
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Min Catering Guests</label>
          <input type="number" name="min_catering_guests" value="<?= e($settings['min_catering_guests'] ?? '25') ?>">
        </div>
      </div>

      <div style="margin-top: 12px;">
        <button type="submit" class="btn-action" style="padding: 12px 24px; font-size: 14px;">
          <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Save All Changes
        </button>
      </div>

    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

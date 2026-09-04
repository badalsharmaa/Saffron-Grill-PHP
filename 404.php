<?php
/**
 * Saffron Grill - 404 Not Found Page
 */
require_once __DIR__ . '/config/config.php';

http_response_code(404);
$pageTitle = 'Page Not Found (404) — Saffron Grill';
$pageDesc = 'The page you are looking for does not exist.';
$canonicalUrl = BASE_URL . '/404';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<div class="wrap" style="text-align: center; max-width: 600px; margin: 160px auto 100px; padding: 0 20px;">
  <div style="font-size: 72px; color: #eab308; font-family: 'Cinzel', serif; font-weight: 700;">404</div>
  <h1 style="font-family: 'Cinzel', serif; font-size: 26px; color: #260e22; margin: 8px 0 16px;">Dish or Page Not Found</h1>
  <p style="color: #666; font-size: 15px; margin-bottom: 24px;">The page you are looking for may have been moved or is no longer available.</p>
  <div style="display: flex; justify-content: center; gap: 12px;">
    <a href="index.php" class="btn btn-gold">Return to Home</a>
    <a href="menu.php" class="btn btn-outline">Explore Menu</a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

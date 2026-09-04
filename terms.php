<?php
/**
 * Saffron Grill - Terms of Service
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Terms of Service — Saffron Grill · San Ramon, CA';
$pageDesc = 'Terms of service and dining policies for Saffron Grill in San Ramon, CA.';
$canonicalUrl = BASE_URL . '/terms';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<div class="wrap" style="max-width: 800px; margin: 140px auto 80px; padding: 0 20px;">
  <h1 style="font-family: 'Cinzel', serif; font-size: 32px; color: #260e22; margin-bottom: 12px;">Terms of Service</h1>
  <p style="font-size: 13px; color: #888; margin-bottom: 30px;">Last Updated: September 2026</p>

  <div style="font-size: 14.5px; line-height: 1.7; color: #444; display: flex; flex-direction: column; gap: 20px;">
    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">1. Table Reservations &amp; Seating Policies</h2>
      <p>Table reservations are held for up to 15 minutes past the scheduled arrival time. During peak hours and weekend grand buffets, seating preference (e.g. window booths) is accommodated based on floor availability.</p>
    </section>

    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">2. Buffet Dining Guidelines</h2>
      <p>Buffet pricing applies per individual guest. Take-out or box-packing from the buffet counter is strictly prohibited to maintain health and safety codes.</p>
    </section>

    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">3. Event Catering Agreements</h2>
      <p>Large catering orders require confirmation and advance deposit. Minimum guest count guarantees must be finalized 48 hours prior to the event date.</p>
    </section>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

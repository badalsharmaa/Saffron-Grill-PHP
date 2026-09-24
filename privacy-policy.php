<?php
/**
 * Saffron Grill - Privacy Policy (CCPA & GDPR Compliant)
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Privacy Policy — Saffron Grill · San Ramon, CA';
$pageDesc = 'Privacy policy and data protection practices for Saffron Grill in San Ramon, CA.';
$canonicalUrl = BASE_URL . '/privacy-policy';
$breadcrumbs = [
    'Home' => 'https://saffrongrillrestaurant.com/',
    'Privacy Policy' => 'https://saffrongrillrestaurant.com/privacy-policy'
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<div class="wrap" style="max-width: 800px; margin: 140px auto 80px; padding: 0 20px;">
  <h1 style="font-family: 'Cinzel', serif; font-size: 32px; color: #260e22; margin-bottom: 12px;">Privacy Policy</h1>
  <p style="font-size: 13px; color: #888; margin-bottom: 30px;">Last Updated: September 2026</p>

  <div style="font-size: 14.5px; line-height: 1.7; color: #444; display: flex; flex-direction: column; gap: 20px;">
    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">1. Information We Collect</h2>
      <p>When you use our online reservation system, submit catering inquiries, or interact with our website, we may collect personal details including your name, telephone number, email address, party size, and dietary requirements.</p>
    </section>

    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">2. How We Use Your Information</h2>
      <p>Your details are used exclusively to process and confirm table bookings, prepare event catering proposals, communicate changes regarding your reservations, and enhance your dining experience.</p>
    </section>

    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">3. Google Consent Mode v2 &amp; Cookie Preferences</h2>
      <p>In adherence to modern privacy regulations and Google Consent Mode v2, advertising and analytical identifiers (such as Google Ads tracking cookies) remain denied until you explicitly grant consent through our interactive cookie banner.</p>
    </section>

    <section>
      <h2 style="font-family: 'Cinzel', serif; font-size: 20px; color: #260e22; margin-bottom: 8px;">4. Contact Us</h2>
      <p>For questions or requests to delete your contact records, please reach out to us at <a href="mailto:<?= e(CONTACT_EMAIL) ?>" style="color: #c2410c;"><?= e(CONTACT_EMAIL) ?></a> or call <a href="tel:<?= e(PHONE_TEL) ?>" style="color: #c2410c;"><?= e(PHONE_PRIMARY) ?></a>.</p>
    </section>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

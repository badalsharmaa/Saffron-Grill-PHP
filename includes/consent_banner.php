<?php
/**
 * Saffron Grill - Google Consent Mode v2 Interactive Cookie Banner
 */
?>
<div id="consentBanner" style="display: none; position: fixed; bottom: 16px; left: 16px; right: 16px; max-width: 500px; background: rgba(26, 8, 24, 0.96); border: 1px solid rgba(234, 179, 8, 0.35); border-radius: 10px; padding: 18px 20px; z-index: 99999; box-shadow: 0 10px 30px rgba(0,0,0,0.6); backdrop-filter: blur(10px); color: #fff;">
  <div style="display: flex; align-items: flex-start; gap: 14px;">
    <div style="font-size: 24px; color: #eab308; line-height: 1;">🍪</div>
    <div style="flex: 1;">
      <strong style="display: block; font-size: 14px; margin-bottom: 4px; font-family: 'Cinzel', serif; color: #f5d485;">Privacy & Cookies Preferences</strong>
      <p style="font-size: 12.5px; color: #d1c4cb; margin: 0 0 12px; line-height: 1.45;">
        We use cookies and analytical identifiers to improve your dining reservations experience, personalize offers, and measure marketing campaigns.
      </p>
      <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <button type="button" id="btnAcceptConsent" style="background: #eab308; color: #1a0818; font-weight: 600; border: none; border-radius: 4px; padding: 6px 14px; font-size: 12px; cursor: pointer;">Accept All</button>
        <button type="button" id="btnDeclineConsent" style="background: transparent; color: #d1c4cb; border: 1px solid rgba(255,255,255,0.2); border-radius: 4px; padding: 6px 14px; font-size: 12px; cursor: pointer;">Essential Only</button>
        <a href="privacy-policy.php" style="color: #eab308; font-size: 12px; align-self: center; text-decoration: underline; margin-left: auto;">Privacy Policy</a>
      </div>
    </div>
  </div>
</div>

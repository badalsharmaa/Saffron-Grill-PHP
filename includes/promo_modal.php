<?php
/**
 * Saffron Grill - Lunch Buffet Promo Modal
 */
?>
<div class="promo-modal-backdrop" id="promoModal" aria-hidden="true" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(14, 5, 13, 0.85); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
  <div class="promo-modal-panel" style="background: radial-gradient(circle at top, #33122e, #1a0818); border: 1px solid rgba(234, 179, 8, 0.4); border-radius: 12px; max-width: 520px; width: 100%; padding: 28px; position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.8); text-align: center;">
    <button class="promo-close js-close-promo" type="button" style="position: absolute; top: 12px; right: 16px; background: none; border: none; font-size: 26px; color: #fff; cursor: pointer;">&times;</button>
    
    <span class="badge" style="background: rgba(234, 179, 8, 0.2); border: 1px solid #eab308; color: #f5d485; font-size: 11px; text-transform: uppercase; letter-spacing: 0.15em; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-bottom: 12px;">Daily Grand Buffet Feast</span>
    
    <h3 style="font-family: 'Cinzel', serif; font-size: 24px; color: #fff; margin-bottom: 8px;">San Ramon's Premier Lunch Buffet</h3>
    
    <p style="color: #d1c4cb; font-size: 14px; line-height: 1.6; margin-bottom: 18px;">
      Over 20 hot dishes daily including tandoori specialties, vegetarian & non-vegetarian curries, basmati rice, hot naans brought to your table, fresh salads, and royal desserts!
    </p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
      <div style="background: rgba(255,255,255,0.06); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
        <strong style="color: #eab308; display: block; font-size: 13px;">Mon – Fri</strong>
        <span style="font-size: 18px; font-weight: 700; color: #fff;"><?= e(BUFFET_WEEKDAY_PRICE) ?></span>
        <span style="display: block; font-size: 11px; color: #a89a9f;">11:30 AM – 3:00 PM</span>
      </div>
      <div style="background: rgba(255,255,255,0.06); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
        <strong style="color: #eab308; display: block; font-size: 13px;">Sat – Sun</strong>
        <span style="font-size: 18px; font-weight: 700; color: #fff;"><?= e(BUFFET_WEEKEND_PRICE) ?></span>
        <span style="display: block; font-size: 11px; color: #a89a9f;">12:00 PM – 3:30 PM</span>
      </div>
    </div>

    <div style="display: flex; gap: 10px; justify-content: center;">
      <a href="buffet.php" class="btn btn-gold btn-sm">Explore Buffet Menu</a>
      <button class="btn btn-outline btn-sm js-open-reserve js-close-promo" type="button">Reserve a Table</button>
    </div>
  </div>
</div>

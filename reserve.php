<?php
/**
 * Saffron Grill - Dedicated Table Reservation Page
 */
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Reserve a Table — Saffron Grill · San Ramon, CA';
$pageDesc = 'Book your table online at Saffron Grill in San Ramon, CA. Experience authentic Indian cuisine, daily lunch buffet, and memorable dining.';
$canonicalUrl = BASE_URL . '/reserve';
$breadcrumbs = [
    'Home' => 'https://saffrongrillrestaurant.com/',
    'Reserve a Table' => 'https://saffrongrillrestaurant.com/reserve'
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<!-- ============== HERO ============== -->
<header class="hero" id="top" style="min-height: 45vh; padding-top: 140px; padding-bottom: 50px;">
  <div class="hero-bg-carousel">
    <div class="hero-overlay-dark"></div>
    <div class="hero-overlay-gradient"></div>
    <div class="hero-bg-slide active">
      <img class="hero-bg-img" src="<?= asset('ambiance-1.webp') ?>" alt="Saffron Grill Dining Atmosphere" />
    </div>
  </div>

  <div class="hero-inner wrap">
    <p class="hero-tag reveal">Table Booking</p>
    <h1 class="reveal d1">
      <span class="l1">Reserve Your Table</span>
      <span class="l2 gold-text italic">At Saffron Grill</span>
    </h1>
    <img class="ornament reveal d1" src="<?= asset('divider.png') ?>" alt="" style="width: 200px; margin: 18px auto;" />
  </div>
</header>

<!-- ============== RESERVATION SECTION ============== -->
<section class="section surface-cream" style="padding: 60px 0 90px;">
  <div class="wrap" style="max-width: 720px; margin: 0 auto;">
    <div style="background: #FFFFFF; border: 1px solid rgba(227, 189, 118, 0.35); border-radius: 16px; padding: clamp(26px, 4vw, 44px); box-shadow: 0 16px 45px rgba(38, 14, 34, 0.08), 0 2px 10px rgba(0, 0, 0, 0.03);">
      
      <div style="text-align: center; margin-bottom: 28px;">
        <span class="eyebrow" style="color: var(--gold-dp, #c5a059); font-size: 11px; letter-spacing: 0.16em;">Instant Confirmation</span>
        <h2 style="font-family: 'Cinzel', serif; font-size: clamp(22px, 3.2vw, 28px); color: #260e22; margin: 6px 0 10px; font-weight: 700;">Book Your Dining Experience</h2>
        <p style="color: #64748b; font-size: 14.5px; max-width: 480px; margin: 0 auto; line-height: 1.5;">Fill out the details below and we will reserve your table with royal hospitality.</p>
      </div>

      <div id="pageReserveAlert" style="display: none; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px; font-weight: 500;"></div>

      <form id="pageReserveForm" method="POST" action="send-mail.php">
        <input type="hidden" name="form_type" value="table_reservation" />
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>" />

        <!-- Honeypot -->
        <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;">
          <label for="p_website_hp">Leave blank</label>
          <input type="text" name="website_hp" id="p_website_hp" tabindex="-1" autocomplete="off" />
        </div>

        <!-- Tracking -->
        <input type="hidden" name="gclid" value="" />
        <input type="hidden" name="gbraid" value="" />
        <input type="hidden" name="wbraid" value="" />
        <input type="hidden" name="utm_source" value="" />
        <input type="hidden" name="utm_medium" value="" />
        <input type="hidden" name="utm_campaign" value="" />

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div style="grid-column: span 2;">
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Full Name *</label>
            <input type="text" name="name" required placeholder="e.g. Ananya Rao" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';" />
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Phone Number *</label>
            <input type="tel" name="phone" required placeholder="(925) 000-0000" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';" />
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Email Address</label>
            <input type="email" name="email" placeholder="name@example.com" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';" />
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Reservation Date *</label>
            <input type="date" name="reservation_date" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';" />
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Preferred Time *</label>
            <select name="reservation_time" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';">
              <optgroup label="Lunch Buffet">
                <option value="11:30 AM">11:30 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="12:30 PM">12:30 PM</option>
                <option value="1:00 PM">1:00 PM</option>
                <option value="1:30 PM">1:30 PM</option>
                <option value="2:00 PM">2:00 PM</option>
              </optgroup>
              <optgroup label="Dinner Service">
                <option value="5:00 PM" selected>5:00 PM</option>
                <option value="5:30 PM">5:30 PM</option>
                <option value="6:00 PM">6:00 PM</option>
                <option value="6:30 PM">6:30 PM</option>
                <option value="7:00 PM">7:00 PM</option>
                <option value="7:30 PM">7:30 PM</option>
                <option value="8:00 PM">8:00 PM</option>
                <option value="8:30 PM">8:30 PM</option>
                <option value="9:00 PM">9:00 PM</option>
              </optgroup>
            </select>
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Party Size *</label>
            <select name="party_size" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';">
              <option value="1">1 Guest</option>
              <option value="2" selected>2 Guests</option>
              <option value="3">3 Guests</option>
              <option value="4">4 Guests</option>
              <option value="5">5 Guests</option>
              <option value="6">6 Guests</option>
              <option value="8">8 Guests</option>
              <option value="10">10+ Guests (Large Party)</option>
            </select>
          </div>

          <div>
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Seating Preference</label>
            <select name="seating_area" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';">
              <option value="Main Dining">Main Dining</option>
              <option value="Near Buffet">Near Buffet</option>
              <option value="Window Booth">Window Booth</option>
              <option value="Quiet Corner">Quiet Corner</option>
            </select>
          </div>

          <div style="grid-column: span 2;">
            <label style="display: block; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; margin-bottom: 6px; font-weight: 700;">Special Requests / High Chair</label>
            <textarea name="special_requests" rows="2" placeholder="e.g. Anniversary celebration, booster seat, quiet area..." style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; background: #fafafa; scrollbar-width: none; -ms-overflow-style: none; transition: all 0.2s;" onfocus="this.style.borderColor='#c5a059'; this.style.boxShadow='0 0 0 3px rgba(197,160,89,0.18)'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; this.style.background='#fafafa';"></textarea>
          </div>
        </div>

        <div style="margin-top: 24px;">
          <button type="submit" id="pReserveSubmitBtn" class="btn btn-gold" style="width: 100%; padding: 15px; font-size: 15px; font-weight: 700; border-radius: 8px; box-shadow: 0 4px 18px rgba(197, 160, 89, 0.35);">
            <span>Confirm Reservation</span>
          </button>
        </div>
      </form>

      <div id="pReserveSuccessView" style="display: none; text-align: center; padding: 32px 16px; animation: formSuccessFadeIn 0.4s ease forwards;">
        <div style="width: 70px; height: 70px; border-radius: 50%; margin: 0 auto 18px; display: grid; place-items: center; background: linear-gradient(135deg, #F5D485, #C5A059); color: #260E22; font-size: 32px; font-weight: 800; box-shadow: 0 10px 25px rgba(197, 160, 89, 0.35);">✓</div>
        <span class="eyebrow" style="color: var(--gold-dp, #c5a059); font-size: 11px; letter-spacing: 0.16em;">Confirmed</span>
        <h3 style="font-family: 'Cinzel', serif; color: #260e22; margin: 6px 0 8px; font-size: 26px;">Table Reserved!</h3>
        <p style="color: #64748b; font-size: 15px; margin-bottom: 20px; line-height: 1.5; max-width: 440px; margin-left: auto; margin-right: auto;">We look forward to hosting you at Saffron Grill San Ramon with regal hospitality.</p>
        <div style="background: rgba(197, 160, 89, 0.12); border: 1px dashed rgba(197, 160, 89, 0.6); border-radius: 10px; padding: 12px 24px; display: inline-block;">
          <span style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.08em; display: block;">Booking Code</span>
          <strong id="pBookingCode" style="font-size: 20px; color: #260e22; font-family: monospace; letter-spacing: 0.05em;">SG-0000</strong>
        </div>
        <div style="margin-top: 24px;">
          <a href="/" class="btn btn-secondary" style="padding: 10px 20px; font-size: 13px;">Return to Home</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Page Reservation JS Handler -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var pForm = document.getElementById('pageReserveForm');
  var pAlert = document.getElementById('pageReserveAlert');
  var pBtn = document.getElementById('pReserveSubmitBtn');
  var pSuccess = document.getElementById('pReserveSuccessView');
  var pCode = document.getElementById('pBookingCode');

  if (pForm) {
    pForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (pBtn) {
        pBtn.disabled = true;
        pBtn.innerHTML = '<span>Processing...</span>';
      }
      if (pAlert) pAlert.style.display = 'none';

      var formData = new FormData(pForm);

      fetch('send-mail.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.success) {
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'book_reservation',
            reservation_id: data.booking_code || ('RES-' + Date.now()),
            party_size: formData.get('party_size'),
            reservation_date: formData.get('reservation_date'),
            transaction_id: data.booking_code || ('RES-' + Date.now())
          });

          pForm.style.display = 'none';
          if (pCode) pCode.textContent = data.booking_code || 'CONFIRMED';
          if (pSuccess) pSuccess.style.display = 'block';
        } else {
          if (pAlert) {
            pAlert.style.display = 'block';
            pAlert.style.background = '#fee2e2';
            pAlert.style.border = '1px solid #ef4444';
            pAlert.style.color = '#b91c1c';
            pAlert.textContent = data.message || 'Unable to complete reservation.';
          }
        }
      })
      .catch(function(err) {
        if (pAlert) {
          pAlert.style.display = 'block';
          pAlert.style.background = '#fee2e2';
          pAlert.style.border = '1px solid #ef4444';
          pAlert.style.color = '#b91c1c';
          pAlert.textContent = 'A network error occurred. Please call ' + <?= json_encode(PHONE_PRIMARY) ?>;
        }
      })
      .finally(function() {
        if (pBtn) {
          pBtn.disabled = false;
          pBtn.innerHTML = '<span>Confirm Reservation</span>';
        }
      });
    });
  }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
/**
 * Saffron Grill - Global Footer Component
 */
require_once __DIR__ . '/reservation_modal.php';
require_once __DIR__ . '/promo_modal.php';
require_once __DIR__ . '/consent_banner.php';
?>

<!-- ============== FOOTER ============== -->
<footer class="footer" id="contact">
  <div class="footer-grid">
    <div class="footer-col brand-col">
      <div class="f-brand">
        <img src="<?= asset('emblem.png') ?>" alt="Saffron Grill Emblem" />
        <div>
          <b><?= e(APP_NAME) ?></b>
          <span><?= e(APP_TAGLINE) ?></span>
        </div>
      </div>
      <p class="f-desc">
        A regal sanctuary for authentic Indian gastronomy in the heart of San Ramon. From our daily grand lunch buffets to sizzling clay tandoor delicacies and bespoke catering across the Tri-Valley.
      </p>
      <div class="f-socials">
        <a href="https://www.facebook.com/profile.php?id=61590010434038" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <a href="https://www.instagram.com/saffrongrillrestaurant" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="https://www.yelp.com/biz/saffron-grill-san-ramon" target="_blank" rel="noopener noreferrer" aria-label="Yelp">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
        </a>
      </div>
    </div>

    <div class="footer-col">
      <h4 class="f-title">Quick Links</h4>
      <ul class="f-links">
        <li><a href="/">Home</a></li>
        <li><a href="/story">Our Heritage & Story</a></li>
        <li><a href="/menu">Full Restaurant Menu</a></li>
        <li><a href="/catering">Party & Event Catering</a></li>
        <li><a href="/reserve">Book a Table</a></li>
        <li><a href="/contact">Location & Directions</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4 class="f-title">Hours of Feast</h4>
      <ul class="f-hours">
        <li>
          <span class="fh-day">Mon – Fri (Lunch Buffet)</span>
          <span class="fh-time">11:30 AM – 3:00 PM <span class="fh-price">(<?= e(BUFFET_WEEKDAY_PRICE) ?>)</span></span>
        </li>
        <li>
          <span class="fh-day">Sat – Sun (Grand Buffet)</span>
          <span class="fh-time">12:00 PM – 3:30 PM <span class="fh-price">(<?= e(BUFFET_WEEKEND_PRICE) ?>)</span></span>
        </li>
        <li>
          <span class="fh-day">Daily Dinner Service</span>
          <span class="fh-time">5:00 PM – 10:00 PM</span>
        </li>
      </ul>
    </div>

    <div class="footer-col">
      <h4 class="f-title">San Ramon Sanctuary</h4>
      <address class="f-addr">
        <span>3191 Crow Canyon Pl, Ste D</span>
        <span>San Ramon, CA 94583</span>
      </address>
      <div class="f-contact">
        <a href="tel:<?= e(PHONE_TEL) ?>">Primary: <?= e(PHONE_PRIMARY) ?></a>
        <a href="tel:+19253694696">Alternate: <?= e(PHONE_ALT) ?></a>
        <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a>
      </div>
      <div style="margin-top: 14px;">
        <button class="btn btn-gold btn-sm js-open-reserve" type="button" style="width: 100%;">Reserve a Table</button>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="fb-inner">
      <p>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?>. All Rights Reserved. Crafted with royal passion.</p>
      <div class="fb-links">
        <a href="/privacy-policy">Privacy Policy</a>
        <a href="/terms">Terms of Service</a>
        <a href="llms.txt" target="_blank">AI Context (llms.txt)</a>
      </div>
    </div>
  </div>
</footer>

<!-- Floating Action Bar for Mobile -->
<div class="floating-actions" style="position: fixed; bottom: 20px; right: 20px; z-index: 99; display: flex; flex-direction: column; gap: 10px;">
  <a href="tel:<?= e(PHONE_TEL) ?>" class="fab-btn" title="Call Saffron Grill" style="background: #260e22; border: 1px solid #eab308; color: #eab308; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
  </a>
</div>

<!-- Core JavaScript Files -->
<script src="<?= asset('app.js') ?>"></script>
<script src="<?= asset('popup.js') ?>"></script>

<!-- Google Consent Mode v2, Attribution & AJAX Form Integration -->
<script>
(function() {
  "use strict";

  // Capture UTM parameters and Ad Identifiers (gclid, gbraid, wbraid) from URL
  var params = new URLSearchParams(window.location.search);
  var trackingFields = ['gclid', 'gbraid', 'wbraid', 'utm_source', 'utm_medium', 'utm_campaign'];
  var captured = {};
  trackingFields.forEach(function(key) {
    var val = params.get(key);
    if (val) {
      sessionStorage.setItem('sg_' + key, val);
      captured[key] = val;
    } else {
      var stored = sessionStorage.getItem('sg_' + key);
      if (stored) captured[key] = stored;
    }
  });

  // Inject tracking parameters into forms
  function populateFormTracking() {
    trackingFields.forEach(function(key) {
      var val = captured[key] || '';
      var input = document.getElementById('res_' + key) || document.querySelector('input[name="' + key + '"]');
      if (input && val) input.value = val;
    });
  }
  populateFormTracking();

  // Cookie Consent Handlers
  var consentBanner = document.getElementById('consentBanner');
  var btnAccept = document.getElementById('btnAcceptConsent');
  var btnDecline = document.getElementById('btnDeclineConsent');

  if (consentBanner && !document.cookie.match(/(?:^|; )saffron_consent=/)) {
    setTimeout(function() { consentBanner.style.display = 'block'; }, 1000);
  }

  function setConsent(status) {
    var maxAge = 60 * 60 * 24 * 365; // 1 year
    document.cookie = "saffron_consent=" + encodeURIComponent(status) + "; path=/; max-age=" + maxAge + "; SameSite=Lax";
    if (consentBanner) consentBanner.style.display = 'none';

    if (window.gtag) {
      if (status === 'granted') {
        gtag('consent', 'update', {
          'ad_storage': 'granted',
          'ad_user_data': 'granted',
          'ad_personalization': 'granted',
          'analytics_storage': 'granted'
        });
      } else {
        gtag('consent', 'update', {
          'ad_storage': 'denied',
          'ad_user_data': 'denied',
          'ad_personalization': 'denied',
          'analytics_storage': 'denied'
        });
      }
    }

    // Inform server
    fetch('consent-sync.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ consent: status, tracking: captured })
    }).catch(function(){});
  }

  if (btnAccept) btnAccept.addEventListener('click', function() { setConsent('granted'); });
  if (btnDecline) btnDecline.addEventListener('click', function() { setConsent('denied'); });

  // Modal Triggers
  var modal = document.getElementById('reserveModal');
  var openTriggers = document.querySelectorAll('.js-open-reserve, [data-reserve-trigger]');
  var closeTriggers = document.querySelectorAll('.js-close-reserve');

  openTriggers.forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
        populateFormTracking();
      }
    });
  });

  closeTriggers.forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
      }
    });
  });

  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
      }
    });
  }

  // Promo Modal Trigger (2.5s delay on initial visit)
  var promo = document.getElementById('promoModal');
  var closePromo = document.querySelectorAll('.js-close-promo');
  if (promo && !sessionStorage.getItem('sg_promo_seen')) {
    setTimeout(function() {
      promo.style.display = 'flex';
      sessionStorage.setItem('sg_promo_seen', '1');
    }, 2500);
  }
  closePromo.forEach(function(btn) {
    btn.addEventListener('click', function() {
      if (promo) promo.style.display = 'none';
    });
  });

  // AJAX Table Reservation Submission Handler
  var reserveForm = document.getElementById('ajaxReserveForm');
  var reserveAlert = document.getElementById('reserveAlert');
  var reserveSubmitBtn = document.getElementById('reserveSubmitBtn');
  var reserveSuccessView = document.getElementById('reserveSuccessView');
  var confirmedBookingCode = document.getElementById('confirmedBookingCode');

  if (reserveForm) {
    reserveForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (reserveSubmitBtn) {
        reserveSubmitBtn.disabled = true;
        reserveSubmitBtn.innerHTML = '<span>Processing Reservation...</span>';
      }
      if (reserveAlert) reserveAlert.style.display = 'none';

      var formData = new FormData(reserveForm);

      fetch('send-mail.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.success) {
          // Push Conversion to Google Tag Manager dataLayer with Deduplication Transaction ID
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'book_reservation',
            reservation_id: data.booking_code || ('RES-' + Date.now()),
            party_size: formData.get('party_size'),
            reservation_date: formData.get('reservation_date'),
            transaction_id: data.booking_code || ('RES-' + Date.now())
          });

          reserveForm.style.display = 'none';
          if (confirmedBookingCode) confirmedBookingCode.textContent = data.booking_code || 'CONFIRMED';
          if (reserveSuccessView) reserveSuccessView.style.display = 'block';
        } else {
          if (reserveAlert) {
            reserveAlert.style.display = 'block';
            reserveAlert.style.background = 'rgba(239, 68, 68, 0.15)';
            reserveAlert.style.border = '1px solid #ef4444';
            reserveAlert.style.color = '#fca5a5';
            reserveAlert.textContent = data.message || 'Unable to submit reservation. Please try again or call us.';
          }
        }
      })
      .catch(function(err) {
        if (reserveAlert) {
          reserveAlert.style.display = 'block';
          reserveAlert.style.background = 'rgba(239, 68, 68, 0.15)';
          reserveAlert.style.border = '1px solid #ef4444';
          reserveAlert.style.color = '#fca5a5';
          reserveAlert.textContent = 'A network error occurred. Please call us directly at ' + <?= json_encode(PHONE_PRIMARY) ?>;
        }
      })
      .finally(function() {
        if (reserveSubmitBtn) {
          reserveSubmitBtn.disabled = false;
          reserveSubmitBtn.innerHTML = '<span>Confirm Table Reservation</span>';
        }
      });
    });
  }

})();
</script>
</body>
</html>

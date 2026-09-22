<?php
/**
 * Saffron Grill - Reusable Table Reservation Modal Component
 */
?>
<div class="modal-backdrop" id="reserveModal" aria-hidden="true" role="dialog" aria-label="Table Reservation" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(14, 5, 13, 0.85); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
  <div class="modal-panel" style="background: radial-gradient(circle at top, #2d0e28, #180616); border: 1px solid rgba(234, 179, 8, 0.4); border-radius: 12px; max-width: 580px; width: 100%; padding: 32px; position: relative; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.85); max-height: 90vh; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
    <button class="modal-close js-close-reserve" type="button" aria-label="Close modal" style="position: absolute; top: 14px; right: 18px; background: none; border: none; font-size: 28px; color: #f5d485; cursor: pointer; line-height: 1;">&times;</button>
    
    <div class="modal-header">
      <span class="eyebrow" style="color: #eab308; font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase;">Instant Booking</span>
      <h3 style="font-family: 'Cinzel', serif; margin: 4px 0 8px; color: #fff;">Reserve Your Table</h3>
      <p style="color: #d1c4cb; font-size: 14px; margin: 0;">Experience authentic Indian dining & royal hospitality in San Ramon.</p>
    </div>

    <!-- Alert / Message Box -->
    <div class="form-alert" id="reserveAlert" style="display: none; margin: 12px 0; padding: 10px 14px; border-radius: 6px; font-size: 13.5px;"></div>

    <form id="ajaxReserveForm" class="reserve-form" method="POST" action="send-mail.php">
      <input type="hidden" name="form_type" value="table_reservation" />
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>" />
      
      <!-- Honeypot Spam Trap (must be left empty by humans) -->
      <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;">
        <label for="res_website_hp">Leave this field blank</label>
        <input type="text" name="website_hp" id="res_website_hp" tabindex="-1" autocomplete="off" />
      </div>

      <!-- Tracking Attributes (Extracted via JS) -->
      <input type="hidden" name="gclid" id="res_gclid" value="" />
      <input type="hidden" name="gbraid" id="res_gbraid" value="" />
      <input type="hidden" name="wbraid" id="res_wbraid" value="" />
      <input type="hidden" name="utm_source" id="res_utm_source" value="" />
      <input type="hidden" name="utm_medium" id="res_utm_medium" value="" />
      <input type="hidden" name="utm_campaign" id="res_utm_campaign" value="" />

      <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 14px;">
        <div class="form-group" style="grid-column: span 2;">
          <label for="res_name" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Full Name *</label>
          <input type="text" name="name" id="res_name" required placeholder="e.g. Rahul Sharma" style="width: 100%; padding: 10px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;" />
        </div>

        <div class="form-group">
          <label for="res_phone" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Phone Number *</label>
          <input type="tel" name="phone" id="res_phone" required placeholder="(925) 000-0000" style="width: 100%; padding: 10px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;" />
        </div>

        <div class="form-group">
          <label for="res_email" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Email Address</label>
          <input type="email" name="email" id="res_email" placeholder="name@example.com" style="width: 100%; padding: 10px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;" />
        </div>

        <div class="form-group">
          <label for="res_date" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Reservation Date *</label>
          <input type="date" name="reservation_date" id="res_date" required style="width: 100%; padding: 10px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;" />
        </div>

        <div class="form-group">
          <label for="res_time" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Preferred Time *</label>
          <select name="reservation_time" id="res_time" required style="width: 100%; padding: 10px 12px; background: #260e22; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;">
            <optgroup label="Lunch Buffet & Dining">
              <option value="11:30 AM">11:30 AM (Lunch Buffet)</option>
              <option value="12:00 PM">12:00 PM (Lunch Buffet)</option>
              <option value="12:30 PM">12:30 PM (Lunch Buffet)</option>
              <option value="1:00 PM">1:00 PM (Lunch Buffet)</option>
              <option value="1:30 PM">1:30 PM (Lunch Buffet)</option>
              <option value="2:00 PM">2:00 PM (Lunch Buffet)</option>
              <option value="2:30 PM">2:30 PM (Lunch Buffet)</option>
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

        <div class="form-group">
          <label for="res_party" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Number of Guests *</label>
          <select name="party_size" id="res_party" required style="width: 100%; padding: 10px 12px; background: #260e22; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;">
            <option value="1">1 Person</option>
            <option value="2" selected>2 People</option>
            <option value="3">3 People</option>
            <option value="4">4 People</option>
            <option value="5">5 People</option>
            <option value="6">6 People</option>
            <option value="7">7 People</option>
            <option value="8">8 People</option>
            <option value="10">10+ People (Large Party)</option>
            <option value="20">20+ People (Private Group)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="res_seating" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Seating Area</label>
          <select name="seating_area" id="res_seating" style="width: 100%; padding: 10px 12px; background: #260e22; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;">
            <option value="Main Dining">Main Dining Hall</option>
            <option value="Buffet Area">Near Buffet Bar</option>
            <option value="Window / Booth">Window Booth</option>
            <option value="Private Corner">Quiet Corner</option>
          </select>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="res_requests" style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; color: #e5e5e5;">Special Requests / High Chair / Dietary Needs</label>
          <textarea name="special_requests" id="res_requests" rows="2" placeholder="e.g. High chair needed, celebrating anniversary, mild spice preference..." style="width: 100%; padding: 8px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff; scrollbar-width: none; -ms-overflow-style: none;"></textarea>
        </div>
      </div>

      <div style="margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
        <button type="submit" class="btn btn-gold" id="reserveSubmitBtn" style="flex: 1; padding: 12px;">
          <span>Confirm Table Reservation</span>
        </button>
      </div>
      <p style="font-size: 11.5px; color: #a89a9f; text-align: center; margin-top: 10px;">For immediate parties of 15+ or same-day rush bookings, please call <a href="tel:<?= e(PHONE_TEL) ?>" style="color: #eab308;"><?= e(PHONE_PRIMARY) ?></a>.</p>
    </form>

    <!-- Success Confirmation View -->
    <div id="reserveSuccessView" style="display: none; text-align: center; padding: 20px 10px;">
      <div style="font-size: 44px; color: #eab308; margin-bottom: 8px;">✓</div>
      <h3 style="font-family: 'Cinzel', serif; color: #fff; margin-bottom: 6px;">Reservation Confirmed!</h3>
      <p style="color: #d1c4cb; font-size: 14px; margin-bottom: 16px;">We look forward to hosting you at Saffron Grill San Ramon.</p>
      <div style="background: rgba(234, 179, 8, 0.1); border: 1px dashed #eab308; border-radius: 8px; padding: 12px; margin-bottom: 18px; display: inline-block;">
        <span style="font-size: 12px; color: #e5e5e5; display: block; text-transform: uppercase;">Booking Reference</span>
        <strong id="confirmedBookingCode" style="font-size: 18px; color: #eab308; letter-spacing: 0.1em;">SG-0000</strong>
      </div>
      <div>
        <button type="button" class="btn btn-outline js-close-reserve">Close</button>
      </div>
    </div>

  </div>
</div>

<?php
/**
 * Saffron Grill — Website Pages & Content Manager
 */

$pageTitle = 'Page Customizer';
$currentPage = 'pages';

$settings = CMS::getAllSettings();
$editPage = $_GET['edit'] ?? null;
$validPages = ['popup', 'home', 'story', 'buffet', 'catering', 'reserve', 'contact', 'policies'];

if ($editPage !== null && !in_array($editPage, $validPages, true)) {
    $editPage = null;
}
$popup = ($editPage === 'popup') ? CMS::getPopupConfig() : null;

require_once __DIR__ . '/components/header.php';
?>

<?php if ($editPage === null): ?>
    <!-- ============================================================= -->
    <!-- MASTER VIEW: APPLE macOS / iOS SETTINGS STYLE DIRECTORY       -->
    <!-- ============================================================= -->
    <div class="apple-settings-wrap">
        <!-- Top Central Hero Card -->
        <div class="apple-header-card">
            <div class="apple-header-icon-box" style="background: linear-gradient(135deg, rgba(197, 160, 89, 0.15), rgba(217, 119, 6, 0.2)); color: var(--gold);">
                <?= AdminIcons::get('paint_brush', 34) ?>
            </div>
            <h1 class="apple-header-title">Website Pages &amp; Content</h1>
            <p class="apple-header-subtitle">Customize copy, hero sections, storytelling narratives, buffet pricing, catering packages, operational restaurant hours, and legal policies across all public website pages.</p>
        </div>

        <!-- Grouped List Card with Hairline Dividers -->
        <div class="apple-grouped-card">
            <!-- 0. Promotional Popup & Specials -->
            <a href="/admin.php?page=pages&edit=popup" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);">
                    <?= AdminIcons::get('popup', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Promotional Popup &amp; Specials</div>
                    <div class="apple-setting-desc">Homepage promotional flyer popup, modal slides, upload flyers, timing &amp; lead capture</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 1. Home Page -->
            <a href="/admin.php?page=pages&edit=home" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #C5A059 0%, #D97706 100%);">
                    <?= AdminIcons::get('dashboard', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Home Page</div>
                    <div class="apple-setting-desc">Hero banner, announcement bar, culinary vision teaser, buffet spotlight &amp; testimonials</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 2. Our Story / Heritage -->
            <a href="/admin.php?page=pages&edit=story" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                    <?= AdminIcons::get('sparkles', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Our Heritage &amp; Story</div>
                    <div class="apple-setting-desc">San Ramon restaurant narrative, royal Mughlai roots, culinary philosophy &amp; chef story</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 3. Lunch Buffet & Dining -->
            <a href="/admin.php?page=pages&edit=buffet" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <?= AdminIcons::get('utensils', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Lunch Buffet &amp; Service Hours</div>
                    <div class="apple-setting-desc">Weekday ($19.99) &amp; weekend ($21.99) pricing, buffet hours, and dinner schedules</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 4. Catering Page -->
            <a href="/admin.php?page=pages&edit=catering" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);">
                    <?= AdminIcons::get('utensils', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Party &amp; Event Catering</div>
                    <div class="apple-setting-desc">Catering hero title, live tandoor features, guest statistics, package overviews &amp; FAQs</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 5. Table Reservations -->
            <a href="/admin.php?page=pages&edit=reserve" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);">
                    <?= AdminIcons::get('calendar', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Table Reservations Policy</div>
                    <div class="apple-setting-desc">Dining room capacity advisory, booking policies, party size rules &amp; confirmation notice</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 6. Contact Us & Store Details -->
            <a href="/admin.php?page=pages&edit=contact" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #EC4899 0%, #BE185D 100%);">
                    <?= AdminIcons::get('phone', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Contact Us &amp; Restaurant Details</div>
                    <div class="apple-setting-desc">San Ramon address, phone numbers, contact emails, social channels &amp; Google Maps URL</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 7. Legal Policies -->
            <a href="/admin.php?page=pages&edit=policies" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #64748B 0%, #475569 100%);">
                    <?= AdminIcons::get('file_text', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Privacy Policy &amp; Terms</div>
                    <div class="apple-setting-desc">Review revision dates and compliance terms for CCPA, California Privacy, and site usage</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- ============================================================= -->
    <!-- SUB-VIEW: SECTION CUSTOMIZER                                  -->
    <!-- ============================================================= -->
    <div style="max-width: 900px; margin: 0 auto; padding-bottom: 4rem;">
        
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="/admin.php?page=pages" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 6px;">
                <?= AdminIcons::get('chevron_left', 16) ?>
                <span>Back to Directory</span>
            </a>
            <span style="font-size: 13px; font-weight: 700; color: var(--gold); text-transform: uppercase;">
                Editing: <?= ucfirst($editPage) ?> Section
            </span>
        </div>

        <?php if ($editPage === 'popup'): ?>
            <!-- POPUP FLYER CUSTOMIZER -->
            <form method="POST" action="/admin.php?page=popup&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                
                <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Promotional Popup Flyer</h2>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Configure modal flyer shown to visitors with special offers, discounts, or buffet specials.</p>
                </div>

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <div>
                            <div style="font-weight: 700; font-size: 15px; color: var(--navy);">Enable Promotional Popup</div>
                            <div style="font-size: 12.5px; color: var(--text-muted);">Toggle popup modal display on public website</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="is_active" value="1" <?= !empty($popup['is_active']) ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label">Display Delay (Seconds)</label>
                            <input type="number" step="0.5" name="delay_seconds" class="form-control" value="<?= e($popup['delay_seconds'] ?? 1.5) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Display Frequency</label>
                            <select name="show_frequency" class="form-control">
                                <option value="session" <?= ($popup['show_frequency'] ?? '') === 'session' ? 'selected' : '' ?>>Once per browser session (Recommended)</option>
                                <option value="always" <?= ($popup['show_frequency'] ?? '') === 'always' ? 'selected' : '' ?>>Every page load</option>
                                <option value="once" <?= ($popup['show_frequency'] ?? '') === 'once' ? 'selected' : '' ?>>Once per visitor lifetime</option>
                            </select>
                        </div>
                    </div>

                    <h3 style="font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 12px;">Popup Slides &amp; Media Flyers</h3>
                    
                    <div id="popupSlidesContainer" style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 1.25rem;">
                        <?php 
                        $slides = $popup['slides'] ?? [];
                        foreach ($slides as $idx => $slide): 
                        ?>
                            <div class="slide-card" style="background: #FAF7F2; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px; position: relative;">
                                <div style="display: grid; grid-template-columns: 120px 1fr; gap: 14px;">
                                    <div>
                                        <img src="<?= e($slide['image']) ?>" alt="Slide Preview" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <div style="display: flex; gap: 8px;">
                                            <input type="text" name="slides[<?= $idx ?>][image]" value="<?= e($slide['image']) ?>" placeholder="/assets/... image path" class="form-control form-control-sm" id="slideImg_<?= $idx ?>">
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="chooseImageFor('slideImg_<?= $idx ?>')">Choose</button>
                                        </div>
                                        <input type="text" name="slides[<?= $idx ?>][title]" value="<?= e($slide['title'] ?? '') ?>" placeholder="Slide Title (e.g. Daily Grand Lunch Buffet)" class="form-control form-control-sm">
                                        <input type="text" name="slides[<?= $idx ?>][link]" value="<?= e($slide['link'] ?? '/menu') ?>" placeholder="Destination Link (e.g. /menu)" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Popup Configuration</button>
            </form>

        <?php elseif ($editPage === 'home'): ?>
            <!-- HOME PAGE CUSTOMIZER -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="home">
                <input type="hidden" name="edit_page" value="home">

                <!-- Announcement Bar -->
                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Top Announcement Banner</h3>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <span style="font-weight: 700; font-size: 13.5px;">Enable Top Announcement Bar</span>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="announcement_enabled" value="1" <?= (CMS::getSetting('announcement_enabled', '1') === '1') ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Banner Text</label>
                        <input type="text" name="announcement_text" class="form-control" value="<?= e(CMS::getSetting('announcement_text', '')) ?>">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 140px; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Target Link</label>
                            <input type="text" name="announcement_link" class="form-control" value="<?= e(CMS::getSetting('announcement_link', '/menu')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Background Color</label>
                            <input type="color" name="announcement_bg_color" class="form-control" style="height: 42px; padding: 2px;" value="<?= e(CMS::getSetting('announcement_bg_color', '#C5A059')) ?>">
                        </div>
                    </div>
                </div>

                <!-- Hero Section Copy -->
                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Homepage Hero Headlines</h3>
                    <div class="form-group">
                        <label class="form-label">Eyebrow Tag / Badge</label>
                        <input type="text" name="hero_badge" class="form-control" value="<?= e(CMS::getSetting('hero_badge', 'Regal Indian Gastronomy · San Ramon')) ?>">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Hero Title Line 1</label>
                            <input type="text" name="hero_title_line1" class="form-control" value="<?= e(CMS::getSetting('hero_title_line1', 'A Symphony of')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Title Line 2 (Gold Accent)</label>
                            <input type="text" name="hero_title_line2" class="form-control" value="<?= e(CMS::getSetting('hero_title_line2', 'Indian Heritage')) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hero Subtitle</label>
                        <textarea name="hero_subtitle" class="form-control" rows="3"><?= e(CMS::getSetting('hero_subtitle', '')) ?></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Primary Button Text</label>
                            <input type="text" name="hero_btn_primary_text" class="form-control" value="<?= e(CMS::getSetting('hero_btn_primary_text', 'Explore Menu')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Primary Button Link</label>
                            <input type="text" name="hero_btn_primary_link" class="form-control" value="<?= e(CMS::getSetting('hero_btn_primary_link', '/menu')) ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Home Page Changes</button>
            </form>

        <?php elseif ($editPage === 'buffet'): ?>
            <!-- BUFFET & OPERATIONAL HOURS -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="buffet">
                <input type="hidden" name="edit_page" value="buffet">

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Daily Grand Lunch Buffet Pricing &amp; Hours</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Weekday Lunch Buffet Price</label>
                            <input type="text" name="buffet_weekday_price" class="form-control" value="<?= e(CMS::getSetting('buffet_weekday_price', '$19.99')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekday Hours</label>
                            <input type="text" name="buffet_weekday_hours" class="form-control" value="<?= e(CMS::getSetting('buffet_weekday_hours', 'Mon–Fri: 11:30 AM – 3:00 PM')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekend Grand Feast Price</label>
                            <input type="text" name="buffet_weekend_price" class="form-control" value="<?= e(CMS::getSetting('buffet_weekend_price', '$21.99')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekend Hours</label>
                            <input type="text" name="buffet_weekend_hours" class="form-control" value="<?= e(CMS::getSetting('buffet_weekend_hours', 'Sat–Sun: 12:00 PM – 3:30 PM')) ?>">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label">Daily Dinner Service Hours</label>
                        <input type="text" name="dinner_hours" class="form-control" value="<?= e(CMS::getSetting('dinner_hours', 'Daily: 5:00 PM – 10:00 PM')) ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Buffet Settings</button>
            </form>

        <?php elseif ($editPage === 'contact'): ?>
            <!-- CONTACT DETAILS & LOCATIONS -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="contact">
                <input type="hidden" name="edit_page" value="contact">

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Restaurant Location &amp; Contact Details</h3>
                    <div class="form-group">
                        <label class="form-label">Street Address &amp; Suite</label>
                        <input type="text" name="restaurant_address" class="form-control" value="<?= e(CMS::getSetting('restaurant_address', '3191 Crow Canyon Pl, Ste D, San Ramon, CA 94583')) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Primary Phone</label>
                            <input type="text" name="restaurant_phone_primary" class="form-control" value="<?= e(CMS::getSetting('restaurant_phone_primary', '(925) 846-3077')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alternate Phone</label>
                            <input type="text" name="restaurant_phone_alt" class="form-control" value="<?= e(CMS::getSetting('restaurant_phone_alt', '(925) 369-4696')) ?>">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">General Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="<?= e(CMS::getSetting('contact_email', 'gosaffrongrill@gmail.com')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catering Quote Email</label>
                            <input type="email" name="catering_email" class="form-control" value="<?= e(CMS::getSetting('catering_email', 'gosaffrongrill@gmail.com')) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Maps Directions URL</label>
                        <input type="url" name="google_maps_url" class="form-control" value="<?= e(CMS::getSetting('google_maps_url', 'https://maps.google.com/?cid=7708573752697881186')) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 10px;">
                        <div class="form-group">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="instagram_url" class="form-control" value="<?= e(CMS::getSetting('instagram_url', 'https://www.instagram.com/saffrongrillrestaurant')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" name="facebook_url" class="form-control" value="<?= e(CMS::getSetting('facebook_url', 'https://www.facebook.com/profile.php?id=61590010434038')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Yelp URL</label>
                            <input type="url" name="yelp_url" class="form-control" value="<?= e(CMS::getSetting('yelp_url', 'https://www.yelp.com/biz/saffron-grill-san-ramon')) ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Contact Details</button>
            </form>

        <?php elseif ($editPage === 'catering'): ?>
            <!-- CATERING PAGE CUSTOMIZER -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="catering">
                <input type="hidden" name="edit_page" value="catering">

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Catering Headings &amp; Statistics</h3>
                    <div class="form-group">
                        <label class="form-label">Catering Headline</label>
                        <input type="text" name="catering_hero_title" class="form-control" value="<?= e(CMS::getSetting('catering_hero_title', 'Royal Feasts for Unforgettable Celebrations')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catering Subtitle</label>
                        <textarea name="catering_hero_subtitle" class="form-control" rows="2"><?= e(CMS::getSetting('catering_hero_subtitle', '')) ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 14px;">
                        <div class="form-group">
                            <label class="form-label">Stat 1 Number</label>
                            <input type="text" name="catering_stat1_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat1_num', '500+')) ?>">
                            <label class="form-label" style="margin-top:6px;">Stat 1 Label</label>
                            <input type="text" name="catering_stat1_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat1_label', 'Events Catered')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stat 2 Number</label>
                            <input type="text" name="catering_stat2_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat2_num', '20+')) ?>">
                            <label class="form-label" style="margin-top:6px;">Stat 2 Label</label>
                            <input type="text" name="catering_stat2_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat2_label', 'Signature Curries')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stat 3 Number</label>
                            <input type="text" name="catering_stat3_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat3_num', '100%')) ?>">
                            <label class="form-label" style="margin-top:6px;">Stat 3 Label</label>
                            <input type="text" name="catering_stat3_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat3_label', 'Fresh Clay Tandoor')) ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Catering Settings</button>
            </form>

        <?php elseif ($editPage === 'story' || $editPage === 'reserve' || $editPage === 'policies'): ?>
            <!-- STORY / POLICIES -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="<?= e($editPage) ?>">
                <input type="hidden" name="edit_page" value="<?= e($editPage) ?>">

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;"><?= ucfirst($editPage) ?> Content &amp; Policies</h3>
                    <div class="form-group">
                        <label class="form-label">Last Revision Date</label>
                        <input type="text" name="<?= e($editPage) ?>_updated" class="form-control" value="<?= e(CMS::getSetting($editPage . '_updated', 'September 2026')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Narrative / Policy Content Notes</label>
                        <textarea name="<?= e($editPage) ?>_content" class="form-control" rows="8"><?= e(CMS::getSetting($editPage . '_content', '')) ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Save Changes</button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
function chooseImageFor(inputId) {
    if (window.MediaPicker) {
        window.MediaPicker.open(function(asset) {
            var el = document.getElementById(inputId);
            if (el) {
                el.value = asset.url;
            }
        });
    }
}
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>

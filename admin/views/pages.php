<?php
/**
 * Saffron Grill — Professional Website Pages & Content Customizer
 * Apple macOS / iOS Inspired Settings Architecture with Granular Section Controls
 */

$pageTitle = 'Page Customizer';
$currentPage = 'pages';

$settings = CMS::getAllSettings();
$editPage = $_GET['edit'] ?? null;
$validPages = ['popup', 'home', 'story', 'buffet', 'catering', 'contact', 'policies'];

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
            <p class="apple-header-subtitle">Customize copy, hero banners, storytelling narratives, buffet pricing, catering packages, operational restaurant hours, and legal policies across all public website pages.</p>
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

            <!-- 5. Contact Us & Store Details -->
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
    <?php
    $previewUrl = match ($editPage) {
        'popup' => '/?preview_popup=1',
        'home' => '/',
        'story' => '/story',
        'buffet' => '/menu',
        'catering' => '/catering',
        'contact' => '/contact',
        'policies' => '/privacy-policy',
        default => '/'
    };

    $pageSections = match ($editPage) {
        'home' => [
            ['card_id' => 'card-announcement', 'preview_id' => 'top', 'title' => 'Announcement Banner', 'icon' => 'announcement'],
            ['card_id' => 'card-hero', 'preview_id' => 'top', 'title' => 'Hero Banner & CTAs', 'icon' => 'elements'],
            ['card_id' => 'card-story', 'preview_id' => 'story', 'title' => 'Story Spotlight', 'icon' => 'sparkles'],
            ['card_id' => 'card-catering', 'preview_id' => 'catering', 'title' => 'Catering Teaser', 'icon' => 'utensils'],
            ['card_id' => 'card-reviews', 'preview_id' => 'signatures', 'title' => 'Chef Signatures & Reviews', 'icon' => 'sparkles'],
        ],
        'popup' => [
            ['card_id' => 'card-popup-general', 'preview_id' => 'top', 'title' => 'Popup Rules & Timing', 'icon' => 'settings'],
            ['card_id' => 'card-popup-slides', 'preview_id' => 'top', 'title' => 'Flyer Slides & Media', 'icon' => 'image'],
            ['card_id' => 'card-popup-actions', 'preview_id' => 'top', 'title' => 'Action Buttons', 'icon' => 'elements'],
        ],
        'story' => [
            ['card_id' => 'card-story-hero', 'preview_id' => 'top', 'title' => 'Story Hero Header', 'icon' => 'elements'],
            ['card_id' => 'card-story-roots', 'preview_id' => 'heritage', 'title' => 'Clay Tandoor & Heritage', 'icon' => 'sparkles'],
            ['card_id' => 'card-story-phil', 'preview_id' => 'values', 'title' => 'Core Values & Pillars', 'icon' => 'utensils'],
        ],
        'buffet' => [
            ['card_id' => 'card-buffet-pricing', 'preview_id' => 'buffet', 'title' => 'Buffet Rates & Schedule', 'icon' => 'dollar'],
            ['card_id' => 'card-buffet-features', 'preview_id' => 'buffet', 'title' => 'Included Specialties', 'icon' => 'check_circle'],
        ],
        'catering' => [
            ['card_id' => 'card-catering-hero', 'preview_id' => 'top', 'title' => 'Catering Hero Banner', 'icon' => 'elements'],
            ['card_id' => 'card-catering-packages', 'preview_id' => 'packages', 'title' => 'Party Packages Tier List', 'icon' => 'tag'],
        ],
        'contact' => [
            ['card_id' => 'card-contact-info', 'preview_id' => 'location', 'title' => 'Address, Hours & Map', 'icon' => 'phone'],
        ],
        'policies' => [
            ['card_id' => 'card-policy-privacy', 'preview_id' => 'top', 'title' => 'Privacy Policy Terms', 'icon' => 'file_text'],
        ],
        default => [
            ['card_id' => 'card-general', 'preview_id' => 'top', 'title' => 'General Settings', 'icon' => 'settings']
        ]
    };
    ?>

    <!-- ============================================================= -->
    <!-- SUB-VIEW: STREETBEAT-STYLE 3-PANEL LIVE VISUAL CUSTOMIZER     -->
    <!-- ============================================================= -->
    <div class="sg-wc" id="sgWcEditor" data-preview-url="<?= e($previewUrl) ?>">
        <!-- ============ TOP TOOLBAR ============ -->
        <div class="sg-wc-toolbar">
            <div class="sg-wc-toolbar-left">
                <a href="/admin.php?page=pages" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 6px;" title="Back to All Pages Directory">
                    <?= AdminIcons::get('arrow_left', 15) ?>
                    <span>Directory</span>
                </a>
                <select class="sg-wc-page-select" id="sgPageSelect" onchange="window.location.href='/admin.php?page=pages&edit=' + this.value">
                    <option value="home" <?= $editPage === 'home' ? 'selected' : '' ?>>🏠 Homepage (/)</option>
                    <option value="popup" <?= $editPage === 'popup' ? 'selected' : '' ?>>🎉 Promotional Popup</option>
                    <option value="story" <?= $editPage === 'story' ? 'selected' : '' ?>>📖 Our Story (/story)</option>
                    <option value="buffet" <?= $editPage === 'buffet' ? 'selected' : '' ?>>🍛 Lunch Buffet (/menu)</option>
                    <option value="catering" <?= $editPage === 'catering' ? 'selected' : '' ?>>🎪 Party Catering (/catering)</option>
                    <option value="contact" <?= $editPage === 'contact' ? 'selected' : '' ?>>📍 Contact &amp; Hours (/contact)</option>
                    <option value="policies" <?= $editPage === 'policies' ? 'selected' : '' ?>>📜 Legal Policies</option>
                </select>
            </div>

            <div class="sg-wc-devices" role="group" aria-label="Preview viewport device">
                <button type="button" class="sg-wc-device is-active" data-device="desktop">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    Desktop
                </button>
                <button type="button" class="sg-wc-device" data-device="tablet">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                    Tablet
                </button>
                <button type="button" class="sg-wc-device" data-device="mobile">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="7" y="2" width="10" height="20" rx="2.5"/><path d="M12 18h.01"/></svg>
                    Mobile
                </button>
            </div>

            <div class="sg-wc-toolbar-actions">
                <button type="button" class="btn btn-secondary btn-sm" id="sgTogglePreviewBtn" title="Toggle Split Preview">
                    <?= AdminIcons::get('eye', 14) ?>
                    <span id="sgTogglePreviewLabel">Hide Preview</span>
                </button>
                <a class="btn btn-secondary btn-sm" id="sgPreviewTab" href="<?= e($previewUrl) ?>" target="_blank" rel="noopener">
                    <?= AdminIcons::get('external_link', 14) ?>
                    <span>New Tab</span>
                </a>
                <button type="button" class="btn btn-primary btn-sm" id="sgSaveTopBtn" style="gap:6px;">
                    <?= AdminIcons::get('check', 14) ?>
                    <span>Save</span>
                </button>
            </div>
        </div>

        <!-- ============ BODY ============ -->
        <div class="sg-wc-body">
            <!-- 1. LEFT SECTION NAV -->
            <aside class="sg-wc-panel-nav" id="sgWcNavPanel">
                <div class="sg-wc-nav-header"><?= ucfirst($editPage) ?> Sections</div>
                <ul class="sg-wc-nav-list" id="sgWcNavList">
                    <?php foreach ($pageSections as $idx => $sec): ?>
                        <li>
                            <button type="button" class="sg-wc-nav-item<?= $idx === 0 ? ' is-active' : '' ?>"
                                    data-target-card="<?= e($sec['card_id']) ?>"
                                    data-preview-section="<?= e($sec['preview_id']) ?>"
                                    data-name="<?= e($sec['title']) ?>">
                                <span class="sg-wc-nav-icon"><?= AdminIcons::get($sec['icon'], 16) ?></span>
                                <span><?= e($sec['title']) ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <!-- 2. MIDDLE CONTEXTUAL FIELDS -->
            <div class="sg-wc-panel-fields" id="sgWcFieldsPanel">

        <?php if ($editPage === 'popup'): ?>
            <!-- ========================================== -->
            <!-- 0. PROMOTIONAL POPUP FLYER & SLIDES        -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=popup&action=save" id="popupCustomizerForm">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="popup">
                <input type="hidden" name="edit_page" value="popup">
                
                <div class="card" id="card-popup-general" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <div>
                            <div style="font-weight: 800; font-size: 16px; color: var(--navy);">Enable Promotional Popup</div>
                            <div style="font-size: 13px; color: var(--text-muted);">Toggle whether the cinematic popup flyer appears for website visitors</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="is_active" value="1" <?= !empty($popup['is_active']) ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <!-- Promotional Image Option -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <div>
                            <div style="font-weight: 800; font-size: 15px; color: var(--navy);">Show Image in Popup</div>
                            <div style="font-size: 13px; color: var(--text-muted);">Display promotional flyer artwork (switch off to disable images and show a sleek text-only popup)</div>
                        </div>
                        <label class="switch">
                            <input type="hidden" name="has_image_setting" value="1">
                            <input type="checkbox" name="show_image" id="showImageSwitch" value="1" <?= empty($popup['disable_image']) ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label">Display Delay (Seconds)</label>
                            <input type="number" step="0.5" min="0" max="30" name="delay_seconds" class="form-control" value="<?= e($popup['delay_seconds'] ?? 1.5) ?>">
                            <small style="color:var(--text-muted); font-size:12px;">Recommended: 1.5s to 3.0s</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Display Frequency</label>
                            <select name="show_frequency" class="form-control">
                                <option value="session" <?= ($popup['show_frequency'] ?? '') === 'session' ? 'selected' : '' ?>>Once per browser session (Recommended)</option>
                                <option value="always" <?= ($popup['show_frequency'] ?? '') === 'always' ? 'selected' : '' ?>>Every page reload (Testing / Aggressive)</option>
                                <option value="once" <?= ($popup['show_frequency'] ?? '') === 'once' ? 'selected' : '' ?>>Once per visitor device lifetime</option>
                            </select>
                            <small style="color:var(--text-muted); font-size:12px;">Controls how often repeat visitors see the popup</small>
                        </div>
                    </div>

                    <!-- Inline Lead Capture Feature -->
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1.25rem; margin-top: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <div>
                                <span style="font-weight: 700; font-size: 14px; color: var(--navy);">Optional Inline Lead / VIP Capture</span>
                                <p style="font-size: 12.5px; color: var(--text-muted); margin: 0;">Show a quick email/phone signup form on the popup modal for exclusive offers</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="enable_lead_capture" value="1" <?= !empty($popup['enable_lead_capture']) ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lead Offer Headline</label>
                            <input type="text" name="lead_capture_title" value="<?= e($popup['lead_capture_title'] ?? 'Join Saffron VIP Club for Exclusive Offers & 10% Off') ?>" class="form-control" placeholder="e.g. Join VIP Club for 10% Off Your Order">
                        </div>
                    </div>
                </div>

                <!-- Slide Cards Builder -->
                <div class="card" id="card-popup-slides" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Promotional Slides &amp; Media Flyers</h3>
                            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Add flyer artwork, buffet banners, or holiday specials displayed inside the popup.</p>
                        </div>
                        <button type="button" id="addSlideBtn" class="btn btn-secondary btn-sm" style="gap: 6px;">
                            <?= AdminIcons::get('plus', 15) ?>
                            <span>Add New Slide</span>
                        </button>
                    </div>

                    <div id="popupSlidesContainer" style="display: flex; flex-direction: column; gap: 16px;">
                        <div id="noSlidesNotice" style="display: <?= empty($popup['slides']) ? 'block' : 'none' ?>; padding: 24px; text-align: center; background: #FAF7F2; border: 2px dashed #CBD5E1; border-radius: 12px; color: var(--text-muted);">
                            <p style="margin: 0 0 6px; font-weight: 700; color: var(--navy);">No Promotional Slides</p>
                            <p style="margin: 0; font-size: 13px;">The popup will display a sleek text-focused card without slides. Click <strong>&quot;+ Add New Slide&quot;</strong> above if you wish to add flyer slides.</p>
                        </div>

                        <?php 
                        $slides = $popup['slides'] ?? [];
                        foreach ($slides as $idx => $slide): 
                        ?>
                            <div class="slide-card" data-index="<?= $idx ?>" style="background: #FAF7F2; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px; position: relative;">
                                <div style="display: grid; grid-template-columns: 140px 1fr 40px; gap: 16px; align-items: start;">
                                    <!-- Image Thumbnail & Upload Column -->
                                    <div style="display: flex; flex-direction: column; gap: 8px; text-align: center;">
                                        <img src="<?= !empty($slide['image']) ? e($slide['image']) : '/assets/emblem.png' ?>" alt="Slide Preview" class="preview-thumb-<?= $idx ?>" style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1; background: #fff;" onerror="this.src='/assets/emblem.png'">
                                        <div style="display: flex; gap: 6px;">
                                            <button type="button" class="btn btn-secondary btn-sm" style="flex:1; font-size:11px; padding: 4px 6px;" onclick="chooseImageFor('slideImg_<?= $idx ?>', '.preview-thumb-<?= $idx ?>')">
                                                Choose
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm" style="font-size:11px; padding: 4px 6px; color: #DC2626;" onclick="clearImageFor('slideImg_<?= $idx ?>', '.preview-thumb-<?= $idx ?>')" title="Remove image from this slide">
                                                Clear
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Slide Form Inputs -->
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:12px;">Image URL / Path <span style="font-weight: normal; color: var(--text-muted);">(Optional)</span></label>
                                            <input type="text" name="slides[<?= $idx ?>][image]" value="<?= e($slide['image']) ?>" placeholder="/assets/... image path" class="form-control form-control-sm" id="slideImg_<?= $idx ?>">
                                        </div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                            <div class="form-group" style="margin-bottom:0;">
                                                <label class="form-label" style="font-size:12px;">Slide Title / Heading</label>
                                                <input type="text" name="slides[<?= $idx ?>][title]" value="<?= e($slide['title'] ?? '') ?>" placeholder="e.g. Daily Grand Lunch Buffet" class="form-control form-control-sm">
                                            </div>
                                            <div class="form-group" style="margin-bottom:0;">
                                                <label class="form-label" style="font-size:12px;">Button Destination Link</label>
                                                <input type="text" name="slides[<?= $idx ?>][link]" value="<?= e($slide['link'] ?? '/menu') ?>" placeholder="e.g. /menu or /contact#reserve" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <input type="hidden" name="slides[<?= $idx ?>][id]" value="<?= e($slide['id'] ?? ($idx + 1)) ?>">
                                        <input type="hidden" name="slides[<?= $idx ?>][alt]" value="<?= e($slide['alt'] ?? ($slide['title'] ?? 'Promotion')) ?>">
                                    </div>

                                    <!-- Delete Slide Button -->
                                    <button type="button" class="btn btn-danger btn-sm remove-slide-btn" style="padding: 6px; width: 34px; height: 34px; justify-content: center; align-self: flex-start;" title="Delete this slide">
                                        <?= AdminIcons::get('trash', 14) ?>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Popup Configuration</span>
                    </button>
                </div>
            </form>

        <?php elseif ($editPage === 'home'): ?>
            <!-- ========================================== -->
            <!-- 1. HOME PAGE CUSTOMIZER                    -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="home">
                <input type="hidden" name="edit_page" value="home">

                <!-- 1. Top Announcement Bar -->
                <div class="card" id="card-announcement" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 2px;">Top Announcement Banner</h3>
                            <p style="font-size: 12.5px; color: var(--text-muted); margin: 0;">High-visibility notification banner displayed across the header</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="announcement_enabled" value="1" <?= (CMS::getSetting('announcement_enabled', '1') === '1') ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Banner Announcement Text</label>
                        <input type="text" name="announcement_text" class="form-control" value="<?= e(CMS::getSetting('announcement_text', '✨ Grand Lunch Buffet Served Daily · Weekdays $19.99 | Weekends $21.99 · Fresh Clay Tandoor & Curries')) ?>" placeholder="Enter announcement banner message...">
                    </div>

                    <div style="grid-template-columns: 1fr 140px; display: grid; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Click Target Link</label>
                            <input type="text" name="announcement_link" class="form-control" value="<?= e(CMS::getSetting('announcement_link', '/menu')) ?>" placeholder="/menu or https://...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Background Color</label>
                            <input type="color" name="announcement_bg_color" class="form-control" style="height: 42px; padding: 2px;" value="<?= e(CMS::getSetting('announcement_bg_color', '#C5A059')) ?>">
                        </div>
                    </div>
                </div>

                <!-- 2. Homepage Hero Header -->
                <div class="card" id="card-hero" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Hero Banner Headlines &amp; Call to Actions</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Eyebrow Tag / Location Badge</label>
                        <input type="text" name="hero_badge" class="form-control" value="<?= e(CMS::getSetting('hero_badge', 'San Ramon, CA')) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Hero Title Line 1 (White)</label>
                            <input type="text" name="hero_title_line1" class="form-control" value="<?= e(CMS::getSetting('hero_title_line1', 'Authentic Indian')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Title Line 2 (Gold Accent)</label>
                            <input type="text" name="hero_title_line2" class="form-control" value="<?= e(CMS::getSetting('hero_title_line2', 'Cuisine Crafted')) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Subtitle / Description</label>
                        <textarea name="hero_subtitle" class="form-control" rows="2" placeholder="Optional brief paragraph below the headline..."><?= e(CMS::getSetting('hero_subtitle', '')) ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Primary Button Text</label>
                            <input type="text" name="hero_btn_primary_text" class="form-control" value="<?= e(CMS::getSetting('hero_btn_primary_text', 'Reserve a Table')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Primary Button Link</label>
                            <input type="text" name="hero_btn_primary_link" class="form-control" value="<?= e(CMS::getSetting('hero_btn_primary_link', '/reserve')) ?>">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Secondary Button Text</label>
                            <input type="text" name="hero_btn_secondary_text" class="form-control" value="<?= e(CMS::getSetting('hero_btn_secondary_text', 'Explore the Menu')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Secondary Button Link</label>
                            <input type="text" name="hero_btn_secondary_link" class="form-control" value="<?= e(CMS::getSetting('hero_btn_secondary_link', '/menu')) ?>">
                        </div>
                    </div>

                    <!-- Hero Background Image Customizer -->
                    <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label">Hero Slide 1 Background Image</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <img src="<?= e(CMS::getSetting('hero_bg_image', '/assets/hero-first-frame.jpg')) ?>" class="preview-thumb-hero" style="width: 60px; height: 42px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border-color);" onerror="this.src='/assets/emblem.png'">
                            <input type="text" name="hero_bg_image" id="heroBgInput" value="<?= e(CMS::getSetting('hero_bg_image', '/assets/hero-first-frame.jpg')) ?>" class="form-control" style="flex:1;">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="chooseImageFor('heroBgInput', '.preview-thumb-hero')">Choose Media</button>
                        </div>
                    </div>
                </div>

                <!-- 3. Culinary Vision / Story Spotlight on Home -->
                <div class="card" id="card-story" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Story Spotlight on Homepage</h3>
                    <div class="form-group">
                        <label class="form-label">Eyebrow Tag</label>
                        <input type="text" name="home_story_eyebrow" class="form-control" value="<?= e(CMS::getSetting('home_story_eyebrow', 'Our Story')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Headline</label>
                        <input type="text" name="home_story_title" class="form-control" value="<?= e(CMS::getSetting('home_story_title', 'A Restaurant Built Around Sharing')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lede Intro Sentence</label>
                        <textarea name="home_story_lede" class="form-control" rows="2"><?= e(CMS::getSetting('home_story_lede', 'Some meals are about choosing a single dish. Ours are about bringing people together around a table filled with options.')) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Body Narrative</label>
                        <textarea name="home_story_body" class="form-control" rows="3"><?= e(CMS::getSetting('home_story_body', "At Saffron Grill, you'll find the dishes guests know and love, alongside new favorites waiting to be discovered. From freshly prepared curries and tandoori specialties to vegetarian classics and house-made desserts, every visit offers something different to enjoy.")) ?></textarea>
                    </div>
                </div>

                <!-- 4. Catering Spotlight Banner on Home -->
                <div class="card" id="card-catering" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Catering Spotlight Banner</h3>
                    <div class="form-group">
                        <label class="form-label">Section Eyebrow</label>
                        <input type="text" name="home_catering_eyebrow" class="form-control" value="<?= e(CMS::getSetting('home_catering_eyebrow', 'Catering')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catering Headline</label>
                        <input type="text" name="home_catering_title" class="form-control" value="<?= e(CMS::getSetting('home_catering_title', 'Bring Saffron Grill to Your Next Celebration')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catering Description</label>
                        <textarea name="home_catering_desc" class="form-control" rows="3"><?= e(CMS::getSetting('home_catering_desc', 'From office lunches and corporate gatherings to weddings, birthdays, graduations, and family events, our catering team helps bring people together through great food. Choose from party trays, buffet service, and live tandoors.')) ?></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">CTA Button Label</label>
                            <input type="text" name="home_catering_btn_text" class="form-control" value="<?= e(CMS::getSetting('home_catering_btn_text', 'Request Catering Information')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">CTA Button Link</label>
                            <input type="text" name="home_catering_btn_link" class="form-control" value="<?= e(CMS::getSetting('home_catering_btn_link', '/catering#inquiry-section')) ?>">
                        </div>
                    </div>
                </div>

                <!-- 5. Guest Testimonials / Word on the Street -->
                <div class="card" id="card-reviews" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Guest Reviews &amp; Testimonials</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 14px;">Social proof reviews shown to visitors</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                        <!-- Review 1 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div style="font-weight: 700; color: var(--navy); margin-bottom: 8px;">Review Card 1</div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Reviewer Name</label>
                                <input type="text" name="home_review1_author" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review1_author', 'Aman P.')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Platform / Location</label>
                                <input type="text" name="home_review1_source" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review1_source', 'Google Review · San Ramon')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Review Quote</label>
                                <textarea name="home_review1_text" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('home_review1_text', 'The lunch buffet is unmatched in the Tri-Valley. Piping hot naan served straight to our table and the butter chicken is the best I have ever had.')) ?></textarea>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div style="font-weight: 700; color: var(--navy); margin-bottom: 8px;">Review Card 2</div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Reviewer Name</label>
                                <input type="text" name="home_review2_author" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review2_author', 'Sarah M.')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Platform / Location</label>
                                <input type="text" name="home_review2_source" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review2_source', 'Yelp Elite · Danville')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Review Quote</label>
                                <textarea name="home_review2_text" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('home_review2_text', 'Catered our daughter’s birthday party for 80 guests. Everything arrived on time, sizzling hot, and guests could not stop raving about the tandoori kebabs.')) ?></textarea>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div style="font-weight: 700; color: var(--navy); margin-bottom: 8px;">Review Card 3</div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Reviewer Name</label>
                                <input type="text" name="home_review3_author" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review3_author', 'Raj & Meena K.')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Platform / Location</label>
                                <input type="text" name="home_review3_source" class="form-control form-control-sm" value="<?= e(CMS::getSetting('home_review3_source', 'Verified Diner · Dublin')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Review Quote</label>
                                <textarea name="home_review3_text" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('home_review3_text', 'Authentic flavors that remind us of royal dining in Northern India. Excellent customer service, elegant ambiance, and consistently superb food.')) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Home Page Changes</span>
                    </button>
                </div>
            </form>

        <?php elseif ($editPage === 'story'): ?>
            <!-- ========================================== -->
            <!-- 2. OUR STORY & HERITAGE CUSTOMIZER         -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="story">
                <input type="hidden" name="edit_page" value="story">

                <!-- 1. Header Banner -->
                <div class="card" id="card-story-hero" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Story Page Header Banner</h3>
                    <div class="form-group">
                        <label class="form-label">Page Tag / Eyebrow</label>
                        <input type="text" name="story_hero_tag" class="form-control" value="<?= e(CMS::getSetting('story_hero_tag', 'Culinary Philosophy')) ?>">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Title Line 1</label>
                            <input type="text" name="story_hero_title1" class="form-control" value="<?= e(CMS::getSetting('story_hero_title1', 'The Art of Indian')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Title Line 2 (Gold Accent)</label>
                            <input type="text" name="story_hero_title2" class="form-control" value="<?= e(CMS::getSetting('story_hero_title2', 'Culinary Harmony')) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hero Philosophy Quote</label>
                        <textarea name="story_hero_quote" class="form-control" rows="3"><?= e(CMS::getSetting('story_hero_quote', '"Food is more than nourishment — it is a language of warmth, an invitation to gather, and a celebration of sensory balance. At Saffron Grill, we blend tradition and craft to create meals meant for sharing."')) ?></textarea>
                    </div>
                </div>

                <!-- 2. Heritage Narrative & Image -->
                <div class="card" id="card-story-roots" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Section 1: The Clay Tandoor &amp; Spices Heritage</h3>
                    <div class="form-group">
                        <label class="form-label">Section Eyebrow</label>
                        <input type="text" name="story_sec1_eyebrow" class="form-control" value="<?= e(CMS::getSetting('story_sec1_eyebrow', 'Our Heritage')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Headline</label>
                        <input type="text" name="story_sec1_title" class="form-control" value="<?= e(CMS::getSetting('story_sec1_title', 'A Legacy of Spices & Sourcing')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lede Paragraph</label>
                        <textarea name="story_sec1_lede" class="form-control" rows="2"><?= e(CMS::getSetting('story_sec1_lede', 'From hand-selected spices to daily local harvest, our dishes carry stories from kitchens of antiquity.')) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Narrative Paragraph 1</label>
                        <textarea name="story_sec1_p1" class="form-control" rows="3"><?= e(CMS::getSetting('story_sec1_p1', 'The story of Saffron Grill is rooted in a simple obsession: to preserve the honest, traditional flavor profiles of Indian cuisine while utilizing the exceptional bounty of California’s local farms. Every morning, our kitchen comes alive with the aroma of freshly ground coriander, turmeric, cumin, and true Kashmiri chillies, each hand-picked and imported directly to ensure absolute purity.')) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Narrative Paragraph 2</label>
                        <textarea name="story_sec1_p2" class="form-control" rows="3"><?= e(CMS::getSetting('story_sec1_p2', 'We believe that premium Indian cooking demands uncompromising ingredient quality. That is why our chefs source fresh vegetables and meats daily. Our chicken, lamb, and seafood are never frozen, ensuring that they absorb the complex marinades of yogurt, ginger, garlic, and home-blended masalas before entering the tandoor—our custom clay oven that burns at over 800°F.')) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Heritage Section Main Photo</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <img src="<?= e(CMS::getSetting('story_sec1_image', '/assets/dishes/chatgpt_5.webp')) ?>" class="preview-thumb-story1" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);" onerror="this.src='/assets/emblem.png'">
                            <input type="text" name="story_sec1_image" id="storySec1Img" value="<?= e(CMS::getSetting('story_sec1_image', '/assets/dishes/chatgpt_5.webp')) ?>" class="form-control" style="flex:1;">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="chooseImageFor('storySec1Img', '.preview-thumb-story1')">Choose Media</button>
                        </div>
                    </div>
                </div>

                <!-- 3. Core Values / Pillars of Excellence -->
                <div class="card" id="card-story-phil" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Core Values &amp; Pillars of Excellence (4 Cards)</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <!-- Pillar 1 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Pillar 1 Title</label>
                                <input type="text" name="story_pillar1_title" class="form-control form-control-sm" value="<?= e(CMS::getSetting('story_pillar1_title', 'Authenticity')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Pillar 1 Description</label>
                                <textarea name="story_pillar1_desc" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('story_pillar1_desc', 'We honor time-tested culinary traditions, using genuine clay tandoors and hand-blended spices to deliver the true heritage of Indian cooking without shortcuts.')) ?></textarea>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Pillar 2 Title</label>
                                <input type="text" name="story_pillar2_title" class="form-control form-control-sm" value="<?= e(CMS::getSetting('story_pillar2_title', 'Hospitality')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Pillar 2 Description</label>
                                <textarea name="story_pillar2_desc" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('story_pillar2_desc', 'In accordance with the timeless philosophy of Atithi Devo Bhava (The Guest is God), we welcome everyone as family, serving with warmth, grace, and generosity.')) ?></textarea>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Pillar 3 Title</label>
                                <input type="text" name="story_pillar3_title" class="form-control form-control-sm" value="<?= e(CMS::getSetting('story_pillar3_title', 'Quality')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Pillar 3 Description</label>
                                <textarea name="story_pillar3_desc" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('story_pillar3_desc', 'We source only the finest local vegetables, fresh dairy, and never-frozen premium meats, matching them with authentic spices to ensure excellence on every single plate.')) ?></textarea>
                            </div>
                        </div>

                        <!-- Pillar 4 -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Pillar 4 Title</label>
                                <input type="text" name="story_pillar4_title" class="form-control form-control-sm" value="<?= e(CMS::getSetting('story_pillar4_title', 'Community')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Pillar 4 Description</label>
                                <textarea name="story_pillar4_desc" class="form-control form-control-sm" rows="3"><?= e(CMS::getSetting('story_pillar4_desc', 'Food is the ultimate gatherer. We are proud to foster connection, laughter, and community around our sharing tables here in the heart of San Ramon.')) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Heritage &amp; Story Changes</span>
                    </button>
                </div>
            </form>

        <?php elseif ($editPage === 'buffet'): ?>
            <!-- ========================================== -->
            <!-- 3. BUFFET & DINING HOURS CUSTOMIZER        -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="buffet">
                <input type="hidden" name="edit_page" value="buffet">

                <div class="card" id="card-buffet-pricing" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Daily Grand Lunch Buffet Pricing &amp; Hours</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Weekday Lunch Buffet Price</label>
                            <input type="text" name="buffet_weekday_price" class="form-control" value="<?= e(CMS::getSetting('buffet_weekday_price', '$19.99')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekday Lunch Hours</label>
                            <input type="text" name="buffet_weekday_hours" class="form-control" value="<?= e(CMS::getSetting('buffet_weekday_hours', 'Mon–Fri: 11:30 AM – 3:00 PM')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekend Grand Feast Price</label>
                            <input type="text" name="buffet_weekend_price" class="form-control" value="<?= e(CMS::getSetting('buffet_weekend_price', '$21.99')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Weekend Lunch Hours</label>
                            <input type="text" name="buffet_weekend_hours" class="form-control" value="<?= e(CMS::getSetting('buffet_weekend_hours', 'Sat–Sun: 12:00 PM – 3:30 PM')) ?>">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label">Daily Dinner Service Hours</label>
                        <input type="text" name="dinner_hours" class="form-control" value="<?= e(CMS::getSetting('dinner_hours', 'Daily: 5:00 PM – 10:00 PM')) ?>">
                    </div>

                    <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label">Buffet Special Dietary Advisory Notice</label>
                        <input type="text" name="buffet_dietary_notice" class="form-control" value="<?= e(CMS::getSetting('buffet_dietary_notice', 'All meats are 100% Zabiha Halal. Vegetarian, vegan, and gluten-free items labeled daily.')) ?>">
                    </div>
                </div>

                <div class="card" id="card-buffet-features" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Buffet Inclusions &amp; Experience Highlights</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Highlight 1</label>
                            <input type="text" name="buffet_feat1" class="form-control" value="<?= e(CMS::getSetting('buffet_feat1', 'Piping hot butter & garlic naan served directly to your table')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Highlight 2</label>
                            <input type="text" name="buffet_feat2" class="form-control" value="<?= e(CMS::getSetting('buffet_feat2', '14+ rotating authentic meat & vegetarian curries')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Highlight 3</label>
                            <input type="text" name="buffet_feat3" class="form-control" value="<?= e(CMS::getSetting('buffet_feat3', 'Fresh tandoori chicken sizzlers straight from our 800°F clay oven')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Highlight 4</label>
                            <input type="text" name="buffet_feat4" class="form-control" value="<?= e(CMS::getSetting('buffet_feat4', 'Crisp salad bar, house-made raita, chutneys, and royal Indian desserts')) ?>">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Buffet Settings</span>
                    </button>
                </div>
            </form>

        <?php elseif ($editPage === 'catering'): ?>
            <!-- ========================================== -->
            <!-- 4. CATERING & PACKAGES CUSTOMIZER          -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="catering">
                <input type="hidden" name="edit_page" value="catering">

                <!-- 1. Hero & Intro -->
                <div class="card" id="card-catering-hero" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Catering Hero Header</h3>
                    <div class="form-group">
                        <label class="form-label">Hero Badge</label>
                        <input type="text" name="catering_hero_badge" class="form-control" value="<?= e(CMS::getSetting('catering_hero_badge', 'Elevated Gatherings')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catering Title Line 1</label>
                        <input type="text" name="catering_hero_title" class="form-control" value="<?= e(CMS::getSetting('catering_hero_title', 'Exquisite Catering For Every Occasion')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catering Subtitle</label>
                        <textarea name="catering_hero_subtitle" class="form-control" rows="2"><?= e(CMS::getSetting('catering_hero_subtitle', 'From intimate dinner parties to grand galas with live tandoor stations, Saffron Grill delivers unforgettable royal feasts.')) ?></textarea>
                    </div>

                    <!-- 3 Proof-point Stats -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 14px;">
                        <div class="form-group">
                            <label class="form-label">Stat 1</label>
                            <input type="text" name="catering_stat1_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat1_num', '1,200+')) ?>" style="margin-bottom:6px;">
                            <input type="text" name="catering_stat1_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat1_label', 'Events Catered')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stat 2</label>
                            <input type="text" name="catering_stat2_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat2_num', '20–1,000+')) ?>" style="margin-bottom:6px;">
                            <input type="text" name="catering_stat2_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat2_label', 'Guests Accommodated')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stat 3</label>
                            <input type="text" name="catering_stat3_num" class="form-control" value="<?= e(CMS::getSetting('catering_stat3_num', '100%')) ?>" style="margin-bottom:6px;">
                            <input type="text" name="catering_stat3_label" class="form-control" value="<?= e(CMS::getSetting('catering_stat3_label', 'Fresh Clay Tandoor')) ?>">
                        </div>
                    </div>
                </div>

                <!-- 2. Catering Package Tiers Customizer (Bronze, Silver, Gold) -->
                <div class="card" id="card-catering-packages" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Catering Package Tiers (Bronze, Silver, Gold)</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">Customize package pricing and inclusions shown on the Catering page.</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                        <!-- Package 1: Bronze -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div style="font-weight: 700; color: var(--navy); margin-bottom: 8px;">Bronze Package</div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Price Indicator / Per Person</label>
                                <input type="text" name="catering_pkg1_price" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg1_price', '$22 / Person')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Subtitle / Min Guests</label>
                                <input type="text" name="catering_pkg1_sub" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg1_sub', 'Classic Buffet · Min. 20 Guests')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Inclusions Summary</label>
                                <textarea name="catering_pkg1_inclusions" class="form-control form-control-sm" rows="4"><?= e(CMS::getSetting('catering_pkg1_inclusions', "1 Gourmet Appetizer (Veg/Non-Veg)\n2 Vegetarian Curries\n1 Chicken Curry\nSaffron Basmati Rice & Naan\n1 Classic Dessert\nRaita, Chutneys")) ?></textarea>
                            </div>
                        </div>

                        <!-- Package 2: Silver (Featured) -->
                        <div style="background: #FFFBEB; padding: 14px; border-radius: 10px; border: 2px solid var(--gold);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <div style="font-weight: 800; color: #92400E;">Silver Package</div>
                                <span class="badge badge-gold" style="font-size: 10.5px;">Most Popular</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Price Indicator / Per Person</label>
                                <input type="text" name="catering_pkg2_price" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg2_price', '$28 / Person')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Subtitle / Min Guests</label>
                                <input type="text" name="catering_pkg2_sub" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg2_sub', 'Royal Feast Buffet · Min. 30 Guests')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Inclusions Summary</label>
                                <textarea name="catering_pkg2_inclusions" class="form-control form-control-sm" rows="4"><?= e(CMS::getSetting('catering_pkg2_inclusions', "2 Appetizers (1 Veg, 1 Non-Veg)\n2 Premium Vegetarian Curries\n2 Meat Curries (Chicken/Lamb)\nAromatic Biryani or Saffron Rice\nAssorted Naan Basket\n2 Desserts & Accompaniments")) ?></textarea>
                            </div>
                        </div>

                        <!-- Package 3: Gold -->
                        <div style="background: #FAF7F2; padding: 14px; border-radius: 10px; border: 1px solid #E2E8F0;">
                            <div style="font-weight: 700; color: var(--navy); margin-bottom: 8px;">Gold Package</div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Price Indicator / Per Person</label>
                                <input type="text" name="catering_pkg3_price" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg3_price', '$36 / Person')) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size:12px;">Subtitle / Min Guests</label>
                                <input type="text" name="catering_pkg3_sub" class="form-control form-control-sm" value="<?= e(CMS::getSetting('catering_pkg3_sub', 'Imperial Banquet · Min. 50 Guests')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Inclusions Summary</label>
                                <textarea name="catering_pkg3_inclusions" class="form-control form-control-sm" rows="4"><?= e(CMS::getSetting('catering_pkg3_inclusions', "3 Gourmet Appetizers (2 Veg, 1 Non-Veg)\n3 Premium Vegetarian Curries\n2 Imperial Meat/Lamb/Seafood Curries\nSpecialty Dum Biryani\nLive Clay Oven Bread Station\n3 Desserts & Hot Masala Chai")) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Catering Settings</span>
                    </button>
                </div>
            </form>

        <?php elseif ($editPage === 'contact'): ?>
            <!-- ========================================== -->
            <!-- 5. CONTACT US & STORE DETAILS              -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="contact">
                <input type="hidden" name="edit_page" value="contact">

                <div class="card" id="card-contact-info" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Restaurant Location &amp; Contact Details</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Full Street Address &amp; Suite</label>
                        <input type="text" name="restaurant_address" class="form-control" value="<?= e(CMS::getSetting('restaurant_address', '3191 Crow Canyon Pl, San Ramon, CA 94583')) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Primary Phone (Reservations &amp; Orders)</label>
                            <input type="text" name="restaurant_phone_primary" class="form-control" value="<?= e(CMS::getSetting('restaurant_phone_primary', '(925) 846-3077')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alternate Phone (Catering &amp; Events)</label>
                            <input type="text" name="restaurant_phone_alt" class="form-control" value="<?= e(CMS::getSetting('restaurant_phone_alt', '(925) 369-4696')) ?>">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">General Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="<?= e(CMS::getSetting('contact_email', 'gosaffrongrill@gmail.com')) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catering Inquiries Email</label>
                            <input type="email" name="catering_email" class="form-control" value="<?= e(CMS::getSetting('catering_email', 'gosaffrongrill@gmail.com')) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Maps Directions Share URL</label>
                        <input type="url" name="google_maps_url" class="form-control" value="<?= e(CMS::getSetting('google_maps_url', 'https://maps.app.goo.gl/yyEfLC6ogW2JiApg8')) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Maps Live Embed Iframe URL</label>
                        <input type="text" name="google_maps_embed_url" class="form-control" value="<?= e(CMS::getSetting('google_maps_embed_url', 'https://www.google.com/maps?q=3191+Crow+Canyon+Pl,+San+Ramon,+CA+94583&output=embed')) ?>" placeholder="https://www.google.com/maps/embed?... or ?q=...&output=embed">
                        <small style="color:var(--text-muted); font-size:12px;">This URL feeds directly into the interactive map displayed on <code>/contact</code>.</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 14px;">
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

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Contact Details</span>
                    </button>
                </div>
            </form>


        <?php elseif ($editPage === 'policies'): ?>
            <!-- ========================================== -->
            <!-- 7. PRIVACY POLICY & LEGAL TERMS CUSTOMIZER -->
            <!-- ========================================== -->
            <form method="POST" action="/admin.php?page=pages&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="active_tab" value="policies">
                <input type="hidden" name="edit_page" value="policies">

                <div class="card" id="card-policy-privacy" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Website Privacy Policy &amp; CCPA Notice</h3>
                    <div class="form-group">
                        <label class="form-label">Last Revision Date</label>
                        <input type="text" name="policies_updated" class="form-control" value="<?= e(CMS::getSetting('policies_updated', 'September 2026')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Privacy Policy Content</label>
                        <textarea name="policies_content" class="form-control" rows="10"><?= e(CMS::getSetting('policies_content', "Saffron Grill is dedicated to safeguarding guest privacy and complying with California Consumer Privacy Act (CCPA) standards.\n\nInformation We Collect:\nWe collect basic contact details provided voluntarily through reservation inquiries, catering requests, and order forms.\n\nHow We Use Your Information:\nInformation is exclusively used to coordinate your reservations, prepare catering quotes, and communicate regarding restaurant services. We do not sell or monetize personal guest information.\n\nYour Rights:\nCalifornia residents have the right to request access to or deletion of collected personal data by contacting gosaffrongrill@gmail.com.")) ?></textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; gap: 8px;">
                        <?= AdminIcons::get('save', 16) ?>
                        <span>Save Policy Changes</span>
                    </button>
                </div>
            </form>

        <?php endif; ?>
            </div>

            <!-- 3. RIGHT INTERACTIVE LIVE STOREFRONT PREVIEW -->
            <section class="sg-wc-preview" id="sgWcPreview" data-device="desktop">
                <div class="sg-wc-stage" id="sgWcStage">
                    <div class="sg-wc-frame" id="sgWcFrame">
                        <iframe id="sgLivePreview" src="<?= e($previewUrl) ?>?preview=1"
                                title="Saffron Grill Live Storefront Preview"
                                loading="eager"></iframe>
                    </div>
                    <div class="sg-wc-device-caption" id="sgWcDeviceCaption" hidden></div>
                </div>
            </section>
        </div>

        <!-- ============ STICKY BOTTOM STATUS BAR ============ -->
        <div class="sg-wc-statusbar">
            <div class="sg-wc-status-left">
                <span class="sg-wc-status-editing">
                    You’re editing: <strong><?= ucfirst($editPage) ?></strong> <?= AdminIcons::get('chevron_right', 12) ?>
                    <strong id="sgStatusSection"><?= !empty($pageSections[0]['title']) ? e($pageSections[0]['title']) : 'General' ?></strong>
                </span>
                <span class="sg-wc-live-badge" id="sgLiveBadge"><span class="sg-wc-live-dot"></span> Live</span>
            </div>
            <div class="sg-wc-status-right">
                <span class="sg-wc-saved-time" id="sgSavedTime"><?= AdminIcons::get('check_circle', 14) ?> Last saved: just now</span>
                <button type="button" class="btn btn-secondary btn-sm" id="sgDiscardBtn" disabled>Discard Changes</button>
                <button type="button" class="btn btn-primary btn-sm" id="sgSaveBtn">Save Changes</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Client-side helper scripts for Image Pickers & Dynamic Slide Builder -->
<script>
function chooseImageFor(inputId, previewSelector) {
    if (window.MediaPicker) {
        window.MediaPicker.open(function(asset) {
            var el = document.getElementById(inputId);
            if (el) {
                el.value = asset.url;
            }
            if (previewSelector) {
                var preview = document.querySelector(previewSelector);
                if (preview) {
                    preview.src = asset.url;
                }
            }
        });
    } else {
        alert("Media Picker is initializing. Please wait a moment or enter the image path directly.");
    }
}

function clearImageFor(inputId, previewSelector) {
    var el = document.getElementById(inputId);
    if (el) {
        el.value = '';
    }
    if (previewSelector) {
        var preview = document.querySelector(previewSelector);
        if (preview) {
            preview.src = '/assets/emblem.png';
        }
    }
}

// Dynamic Slide Row Addition for Popup Builder
document.addEventListener('DOMContentLoaded', function() {
    var addSlideBtn = document.getElementById('addSlideBtn');
    var slidesContainer = document.getElementById('popupSlidesContainer');

    if (addSlideBtn && slidesContainer) {
        addSlideBtn.addEventListener('click', function() {
            var noNotice = document.getElementById('noSlidesNotice');
            if (noNotice) noNotice.style.display = 'none';

            var existingCards = slidesContainer.querySelectorAll('.slide-card');
            var nextIdx = existingCards.length;
            var nextId = nextIdx + 1;

            var cardDiv = document.createElement('div');
            cardDiv.className = 'slide-card';
            cardDiv.setAttribute('data-index', nextIdx);
            cardDiv.style.cssText = 'background: #FAF7F2; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px; position: relative; animation: fadeIn 0.3s ease;';

            cardDiv.innerHTML = `
                <div style="display: grid; grid-template-columns: 140px 1fr 40px; gap: 16px; align-items: start;">
                    <div style="display: flex; flex-direction: column; gap: 8px; text-align: center;">
                        <img src="/assets/hero-first-frame.jpg" alt="Slide Preview" class="preview-thumb-${nextIdx}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1; background: #fff;">
                        <div style="display: flex; gap: 6px;">
                            <button type="button" class="btn btn-secondary btn-sm" style="flex:1; font-size:11px; padding: 4px 6px;" onclick="chooseImageFor('slideImg_${nextIdx}', '.preview-thumb-${nextIdx}')">
                                Choose
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" style="font-size:11px; padding: 4px 6px; color: #DC2626;" onclick="clearImageFor('slideImg_${nextIdx}', '.preview-thumb-${nextIdx}')" title="Remove image from this slide">
                                Clear
                            </button>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" style="font-size:12px;">Image URL / Path <span style="font-weight: normal; color: var(--text-muted);">(Optional)</span></label>
                            <input type="text" name="slides[${nextIdx}][image]" value="/assets/hero-first-frame.jpg" placeholder="/assets/... image path" class="form-control form-control-sm" id="slideImg_${nextIdx}">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Slide Title / Heading</label>
                                <input type="text" name="slides[${nextIdx}][title]" value="Special Offer" placeholder="e.g. Daily Grand Lunch Buffet" class="form-control form-control-sm">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:12px;">Button Destination Link</label>
                                <input type="text" name="slides[${nextIdx}][link]" value="/menu" placeholder="e.g. /menu or /contact#reserve" class="form-control form-control-sm">
                            </div>
                        </div>
                        <input type="hidden" name="slides[${nextIdx}][id]" value="${nextId}">
                        <input type="hidden" name="slides[${nextIdx}][alt]" value="Special Offer">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-slide-btn" style="padding: 6px; width: 34px; height: 34px; justify-content: center; align-self: flex-start;" title="Delete this slide">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </div>
            `;

            slidesContainer.appendChild(cardDiv);
        });
    }

    // Event Delegation for Slide Deletion
    if (slidesContainer) {
        slidesContainer.addEventListener('click', function(e) {
            var delBtn = e.target.closest('.remove-slide-btn');
            if (delBtn) {
                var card = delBtn.closest('.slide-card');
                if (card) {
                    if (confirm("Are you sure you want to remove this promotion slide?")) {
                        card.remove();
                        var remaining = slidesContainer.querySelectorAll('.slide-card');
                        var noNotice = document.getElementById('noSlidesNotice');
                        if (noNotice && remaining.length === 0) {
                            noNotice.style.display = 'block';
                        }
                    }
                }
            }
        });
    }
});

// ============================================================
// Saffron Grill — Live Visual Customizer Script (StreetBeat Architecture)
// ============================================================
(function initVisualCustomizer() {
    var editor = document.getElementById('sgWcEditor');
    if (!editor) return;

    var iframe = document.getElementById('sgLivePreview');
    var preview = document.getElementById('sgWcPreview');
    var navItems = Array.prototype.slice.call(editor.querySelectorAll('.sg-wc-nav-item'));
    var fieldsPanel = document.getElementById('sgWcFieldsPanel');
    var statusSection = document.getElementById('sgStatusSection');
    var liveBadge = document.getElementById('sgLiveBadge');
    var savedTime = document.getElementById('sgSavedTime');
    var btnSave = document.getElementById('sgSaveBtn');
    var btnSaveTop = document.getElementById('sgSaveTopBtn');
    var btnDiscard = document.getElementById('sgDiscardBtn');
    var btnTogglePreview = document.getElementById('sgTogglePreviewBtn');
    var labelTogglePreview = document.getElementById('sgTogglePreviewLabel');
    var caption = document.getElementById('sgWcDeviceCaption');

    var previewReady = false;
    var pendingSection = null;
    var dirty = false;

    // Toast Notification Helper
    function showToast(msg, isSuccess) {
        var existing = document.getElementById('sgToastNotice');
        if (existing) existing.remove();

        var toast = document.createElement('div');
        toast.id = 'sgToastNotice';
        toast.style.cssText = 'position:fixed;bottom:64px;right:24px;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:700;z-index:99999;box-shadow:0 10px 25px rgba(0,0,0,0.18);display:flex;align-items:center;gap:8px;animation:fadeIn 0.2s ease;' +
            (isSuccess ? 'background:#1B1834;color:#C5A059;border:1px solid #C5A059;' : 'background:#DC2626;color:#FFF;');
        toast.innerHTML = '<span>' + msg + '</span>';
        document.body.appendChild(toast);
        setTimeout(function() {
            toast.style.transition = 'opacity 0.4s ease';
            toast.style.opacity = '0';
            setTimeout(function() { toast.remove(); }, 400);
        }, 3200);
    }

    // Preview messaging (postMessage to iframe)
    function postToPreview(section) {
        if (!iframe || !iframe.contentWindow || !section) return;
        iframe.contentWindow.postMessage(
            { type: 'sg-editor', action: 'scrollTo', section: section },
            '*'
        );
    }

    window.addEventListener('message', function(ev) {
        if (ev.data && ev.data.type === 'sg-preview-ready') {
            previewReady = true;
            if (pendingSection) {
                postToPreview(pendingSection);
                pendingSection = null;
            }
        }
    });

    // Section selection
    function selectSection(item) {
        var cardId = item.getAttribute('data-target-card');
        var previewSec = item.getAttribute('data-preview-section');
        var secName = item.getAttribute('data-name');

        navItems.forEach(function(n) { n.classList.toggle('is-active', n === item); });
        if (statusSection) statusSection.textContent = secName;

        if (cardId && fieldsPanel) {
            var targetCard = document.getElementById(cardId);
            if (targetCard) {
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        if (previewSec) {
            if (previewReady) {
                postToPreview(previewSec);
            } else {
                pendingSection = previewSec;
                postToPreview(previewSec);
            }
        }
    }

    navItems.forEach(function(item) {
        item.addEventListener('click', function() { selectSection(item); });
    });

    // Device Viewports (Desktop, Tablet, Mobile)
    var DEVICE_CAPS = {
        desktop: '',
        tablet: 'iPad Tablet · 768px Bezel',
        mobile: 'iPhone Mobile · 390px Bezel'
    };
    editor.querySelectorAll('.sg-wc-device').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var device = btn.getAttribute('data-device');
            editor.querySelectorAll('.sg-wc-device').forEach(function(b) {
                b.classList.toggle('is-active', b === btn);
            });
            if (preview) {
                preview.setAttribute('data-device', device);
                if (preview.style.display === 'none') {
                    preview.style.display = 'flex';
                    if (labelTogglePreview) labelTogglePreview.textContent = 'Hide Preview';
                }
            }
            if (caption) {
                caption.textContent = DEVICE_CAPS[device] || '';
                caption.hidden = !DEVICE_CAPS[device];
            }
        });
    });

    // Toggle Preview split visibility
    if (btnTogglePreview && preview) {
        btnTogglePreview.addEventListener('click', function() {
            if (preview.style.display === 'none') {
                preview.style.display = 'flex';
                if (labelTogglePreview) labelTogglePreview.textContent = 'Hide Preview';
            } else {
                preview.style.display = 'none';
                if (labelTogglePreview) labelTogglePreview.textContent = 'Show Preview';
            }
        });
    }

    // Character counters & original value snapshots
    var inputs = Array.prototype.slice.call(fieldsPanel.querySelectorAll('input, textarea, select'));
    inputs.forEach(function(el) {
        el.dataset.orig = el.value;
    });

    function updateCounter(input) {
        var max = input.getAttribute('maxlength') || input.getAttribute('data-max');
        if (!max) return;
        var wrap = input.closest('.sg-wc-input-wrap');
        var counter = wrap ? wrap.querySelector('.sg-wc-count') : null;
        if (!counter && wrap) {
            counter = document.createElement('span');
            counter.className = 'sg-wc-count' + (input.tagName.toLowerCase() === 'textarea' ? ' sg-wc-count-ta' : '');
            wrap.appendChild(counter);
        }
        if (counter) {
            counter.textContent = input.value.length + '/' + max;
        }
    }

    editor.querySelectorAll('[data-count]').forEach(function(input) {
        updateCounter(input);
        input.addEventListener('input', function() { updateCounter(input); });
    });

    // Dirty state tracking
    function setDirty(on) {
        if (dirty === on) return;
        dirty = on;
        if (btnSave) btnSave.disabled = !on;
        if (btnSaveTop) btnSaveTop.disabled = !on;
        if (btnDiscard) btnDiscard.disabled = !on;

        if (liveBadge) {
            liveBadge.classList.toggle('is-dirty', on);
            var dot = liveBadge.querySelector('.sg-wc-live-dot');
            liveBadge.innerHTML = '';
            if (dot) liveBadge.appendChild(dot);
            liveBadge.appendChild(document.createTextNode(on ? ' Unsaved Changes' : ' Live'));
        }
    }

    fieldsPanel.addEventListener('input', function() { setDirty(true); });
    fieldsPanel.addEventListener('change', function() { setDirty(true); });

    // Discard Changes
    if (btnDiscard) {
        btnDiscard.addEventListener('click', function() {
            if (!dirty) return;
            inputs.forEach(function(el) {
                if (typeof el.dataset.orig !== 'undefined') {
                    if (el.type === 'checkbox') {
                        el.checked = (el.dataset.orig === '1' || el.dataset.orig === 'true');
                    } else {
                        el.value = el.dataset.orig;
                    }
                    if (el.hasAttribute('data-count')) updateCounter(el);
                }
            });
            setDirty(false);
            showToast('Changes discarded — restored original settings.', true);
        });
    }

    // AJAX Save Form Handler
    function saveChangesAjax() {
        var form = fieldsPanel.querySelector('form');
        if (!form) return;

        var btnText = btnSave ? btnSave.innerText : 'Save';
        if (btnSave) { btnSave.disabled = true; btnSave.innerText = 'Saving...'; }
        if (btnSaveTop) { btnSaveTop.disabled = true; btnSaveTop.innerText = 'Saving...'; }

        var formData = new FormData(form);
        formData.append('csrf_token', window.CMS_CSRF || '');

        fetch('/admin.php?page=pages&action=ajax_save', {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                setDirty(false);
                inputs.forEach(function(el) { el.dataset.orig = el.value; });
                if (savedTime) {
                    savedTime.innerHTML = 'Last saved: ' + (data.updated_at || 'just now');
                }
                showToast('✓ ' + (data.message || 'Page settings saved successfully!'), true);
                if (iframe && iframe.contentWindow) {
                    try { iframe.contentWindow.location.reload(); } catch (e) {}
                }
            } else {
                showToast('Error: ' + (data.error || 'Failed to save settings.'), false);
                setDirty(true);
            }
        })
        .catch(function(err) {
            showToast('Network error while saving. Please check connection.', false);
            setDirty(true);
        })
        .finally(function() {
            if (btnSave) { btnSave.disabled = false; btnSave.innerText = 'Save Changes'; }
            if (btnSaveTop) { btnSaveTop.disabled = false; btnSaveTop.innerText = 'Save'; }
        });
    }

    // Enable Save buttons from start
    if (btnSave) btnSave.disabled = false;
    if (btnSaveTop) btnSaveTop.disabled = false;

    // Hook up both button clicks and form submit
    if (btnSave) btnSave.addEventListener('click', saveChangesAjax);
    if (btnSaveTop) btnSaveTop.addEventListener('click', saveChangesAjax);
    var mainForm = fieldsPanel.querySelector('form');
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveChangesAjax();
        });
    }
})();
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>

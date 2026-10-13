<?php
/**
 * Saffron Grill — Modernized Executive Operations Dashboard
 * Command center with native mobile app layout, live buffet & dinner switches,
 * 2x2 bento metric tiles, mobile touch lead cards, and Apple-style grouped management controls.
 */

$pageTitle = 'Operations Dashboard';
$currentPage = 'dashboard';

$buffetPaused = (CMS::getSetting('buffet_paused', '0') === '1');
$dinnerClosed = (CMS::getSetting('dinner_closed', '0') === '1');
$announcementActive = (bool)CMS::getSetting('announcement_enabled', '1');
$announcementText = CMS::getSetting('announcement_text', '✨ Daily Grand Lunch Buffet: $19.99 Weekdays & $21.99 Weekends!');

$leadStats = CMS::getLeadStats();
$recentLeads = CMS::getLeads(['limit' => 6]);
$categories = CMS::getCategories();

// Fetch live menu items count
require_once dirname(__DIR__, 2) . '/data/menu.php';
global $MENU_ITEMS;
$menuItemsCount = count($MENU_ITEMS ?? []);

$user = CMSAuth::user() ?? ['name' => 'Admin'];
$hour = (int)date('H');
$greetingTime = $hour < 12 ? 'morning' : ($hour < 17 ? 'afternoon' : 'evening');
$firstName = explode(' ', trim($user['name'] ?? 'Admin'))[0] ?: 'Admin';
$userInitial = strtoupper(substr($firstName, 0, 1));

require_once __DIR__ . '/components/header.php';
?>

<div class="dashboard-view" style="font-size: 14px;">

    <!-- ======================================================================
         1. MOBILE NATIVE APP HEADER (Visible only on mobile <=768px)
         ====================================================================== -->
    <div class="dash-mobile-app-header">
        <div class="dash-app-user-row">
            <div class="dash-app-user-info">
                <div class="dash-app-avatar" style="background: linear-gradient(135deg, #C5A059 0%, #D97706 100%);">
                    <?= e($userInitial) ?>
                </div>
                <div>
                    <div class="dash-app-greeting">Good <?= $greetingTime ?>, <?= e($firstName) ?> 👋</div>
                    <div class="dash-app-brand-sub">Saffron Grill San Ramon</div>
                </div>
            </div>
            <div class="dash-app-actions">
                <a href="/" target="_blank" class="dash-app-icon-btn" title="View Public Storefront">
                    <?= AdminIcons::get('external_link', 16) ?>
                </a>
            </div>
        </div>

        <!-- Mobile Service Status Switchers -->
        <div class="dash-mobile-outlets-container">
            <div class="dash-outlets-header-row">
                <span class="dash-outlets-section-label">Service Operational Status</span>
                <a href="/admin.php?page=menu&section=outlets" class="dash-outlets-manage-link" title="Manage Services">
                    <span>Manage</span>
                    <?= AdminIcons::get('chevron_right', 12) ?>
                </a>
            </div>
            <div class="dash-mobile-outlets-bar">
                <a href="/admin.php?page=menu&section=outlets" class="dash-outlet-chip <?= $buffetPaused ? 'chip-closed' : 'chip-open' ?>" title="Lunch Buffet Status">
                    <span class="pulse-dot"></span>
                    <span class="chip-label">Lunch Buffet:</span>
                    <strong><?= $buffetPaused ? 'Paused' : 'Active' ?></strong>
                </a>
                <a href="/admin.php?page=menu&section=outlets" class="dash-outlet-chip <?= $dinnerClosed ? 'chip-closed' : 'chip-open' ?>" title="Dinner Service Status">
                    <span class="pulse-dot"></span>
                    <span class="chip-label">Dinner Service:</span>
                    <strong><?= $dinnerClosed ? 'Closed' : 'Open' ?></strong>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile 1-Tap Quick Action Pills (Horizontal Touch Bar) -->
    <div class="dash-mobile-quick-actions">
        <a href="/admin.php?page=submissions" class="dash-quick-action-pill">
            <?= AdminIcons::get('inbox', 14) ?>
            <span><?= $leadStats['new'] > 0 ? $leadStats['new'] . ' New Inquiries' : 'All Leads (' . $leadStats['total'] . ')' ?></span>
            <?php if ($leadStats['new'] > 0): ?>
                <span class="pill-dot-alert"></span>
            <?php endif; ?>
        </a>
        <a href="/admin.php?page=menu&section=catalog" class="dash-quick-action-pill">
            <?= AdminIcons::get('menu', 14) ?>
            <span>Dishes &amp; Prices</span>
        </a>
        <a href="/admin.php?page=menu&section=categories" class="dash-quick-action-pill">
            <?= AdminIcons::get('utensils', 14) ?>
            <span>Categories (<?= count($categories) ?>)</span>
        </a>
        <a href="/admin.php?page=menu&section=outlets" class="dash-quick-action-pill">
            <?= AdminIcons::get('store', 14) ?>
            <span>Service Switches</span>
        </a>
        <a href="/admin.php?page=media" class="dash-quick-action-pill">
            <?= AdminIcons::get('media_library', 14) ?>
            <span>Media Library</span>
        </a>
        <a href="/admin.php?page=pages&edit=popup" class="dash-quick-action-pill">
            <?= AdminIcons::get('popup', 14) ?>
            <span>Promo Flyer</span>
        </a>
    </div>

    <!-- ======================================================================
         2. DESKTOP WELCOME & STORE CONTROL BANNER (Visible on desktop >768px)
         ====================================================================== -->
    <div class="apple-header-card dash-desktop-hero" style="margin-bottom: 1.5rem; text-align: left; padding: 1.75rem 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 4px;">
                    <?= AdminIcons::get('sparkles', 13) ?>
                    <span>Executive Operations Hub</span>
                </div>
                <h1 style="font-size: 24px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">
                    Good <?= $greetingTime ?>, <?= e($firstName) ?>
                </h1>
                <p style="font-size: 13.5px; color: var(--text-secondary); max-width: 600px; margin: 0;">
                    Welcome to the Saffron Grill command center. Manage live buffet and dinner services, track table reservations, review catering quotes, and publish menu updates.
                </p>
            </div>

            <!-- Service Status Chips on Desktop -->
            <div style="display: flex; gap: 12px; align-items: center;">
                <div class="dash-outlet-chip <?= $buffetPaused ? 'chip-closed' : 'chip-open' ?>" style="padding: 8px 14px;">
                    <span class="pulse-dot"></span>
                    <span class="chip-label">Lunch Buffet:</span>
                    <strong><?= $buffetPaused ? 'Paused' : 'Active' ?></strong>
                </div>
                <div class="dash-outlet-chip <?= $dinnerClosed ? 'chip-closed' : 'chip-open' ?>" style="padding: 8px 14px;">
                    <span class="pulse-dot"></span>
                    <span class="chip-label">Dinner Service:</span>
                    <strong><?= $dinnerClosed ? 'Closed' : 'Open' ?></strong>
                </div>
                <a href="/admin.php?page=menu&section=outlets" class="btn btn-secondary btn-sm" title="Configure Service Switches">
                    <?= AdminIcons::get('settings', 14) ?>
                    <span>Switches</span>
                </a>
            </div>
        </div>
    </div>

    <?php
    $needsAttentionCount = $leadStats['new'] + ($buffetPaused ? 1 : 0) + ($dinnerClosed ? 1 : 0);
    ?>
    <!-- ======================================================================
         2.5. NEEDS ATTENTION ACTION CENTER (StreetBeat Architecture)
         ====================================================================== -->
    <div class="dash-attention-card">
        <div class="dash-attention-left">
            <div class="dash-attention-icon">
                <?= AdminIcons::get('alert_triangle', 20) ?>
            </div>
            <div>
                <div class="dash-attention-title">Needs Attention (<?= $needsAttentionCount ?> items)</div>
                <div class="dash-attention-sub">
                    <?= $leadStats['new'] > 0 ? "You have <strong>{$leadStats['new']} new customer inquiries</strong> awaiting response." : "All guest leads reviewed. Keep operational switches synchronized." ?>
                </div>
            </div>
        </div>
        <div class="dash-attention-chips">
            <?php if ($leadStats['new'] > 0): ?>
                <a href="/admin.php?page=submissions&status=new" class="dash-attention-chip" style="background: #FEF3C7; color: #B45309; border-color: #FDE68A;">
                    <?= AdminIcons::get('inbox', 14) ?>
                    <span><?= $leadStats['new'] ?> New Leads</span>
                </a>
            <?php endif; ?>
            <a href="/admin.php?page=submissions&source=reservation" class="dash-attention-chip">
                <?= AdminIcons::get('calendar', 14) ?>
                <span>Bookings (<?= $leadStats['reservations'] ?>)</span>
            </a>
            <a href="/admin.php?page=submissions&source=catering" class="dash-attention-chip">
                <?= AdminIcons::get('utensils', 14) ?>
                <span>Catering (<?= $leadStats['catering'] ?>)</span>
            </a>
            <?php if ($buffetPaused): ?>
                <a href="/admin.php?page=menu&section=outlets" class="dash-attention-chip" style="background: #FEE2E2; color: #B91C1C; border-color: #FECACA;">
                    <span class="pulse-dot" style="background:#EF4444;"></span>
                    <span>Buffet Paused</span>
                </a>
            <?php endif; ?>
            <a href="/admin.php?page=pages&edit=home" class="dash-attention-chip" style="background: rgba(197, 160, 89, 0.15); color: #B45309; border-color: rgba(197, 160, 89, 0.3);">
                <?= AdminIcons::get('paint_brush', 14) ?>
                <span>Live Customizer</span>
            </a>
        </div>
    </div>

    <!-- ======================================================================
         3. 2x2 BENTO METRIC TILES ROW (Responsive grid)
         ====================================================================== -->
    <div class="crm-grid-4" style="gap: 14px; margin-bottom: 1.5rem;">
        <!-- Reservations -->
        <a href="/admin.php?page=submissions&source=reservation" class="stat-card" style="text-decoration: none; color: inherit; border-radius: 14px; border: 1px solid var(--border-color); background: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: transform 0.15s ease;">
            <div class="stat-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span class="stat-title" style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Table Bookings</span>
                <div class="stat-icon-tile squircle-blue" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('calendar', 16) ?>
                </div>
            </div>
            <div class="stat-main-val" style="font-size: clamp(24px, 3.5vw, 28px); font-weight: 800; color: var(--navy);"><?= number_format($leadStats['reservations']) ?></div>
            <div class="stat-sub-val" style="font-size: 11.5px; color: var(--text-secondary); margin-top: 2px;">Guest table reservations</div>
        </a>

        <!-- Catering Inquiries -->
        <a href="/admin.php?page=submissions&source=catering" class="stat-card" style="text-decoration: none; color: inherit; border-radius: 14px; border: 1px solid var(--border-color); background: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: transform 0.15s ease;">
            <div class="stat-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span class="stat-title" style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Catering Inquiries</span>
                <div class="stat-icon-tile squircle-orange" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('utensils', 16) ?>
                </div>
            </div>
            <div class="stat-main-val" style="font-size: clamp(24px, 3.5vw, 28px); font-weight: 800; color: var(--gold);"><?= number_format($leadStats['catering']) ?></div>
            <div class="stat-sub-val" style="font-size: 11.5px; color: #059669; font-weight: 600; margin-top: 2px;">
                <?= number_format($leadStats['total_guests']) ?> estimated guests
            </div>
        </a>

        <!-- Total Submissions / Leads -->
        <a href="/admin.php?page=submissions" class="stat-card" style="text-decoration: none; color: inherit; border-radius: 14px; border: 1px solid var(--border-color); background: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: transform 0.15s ease;">
            <div class="stat-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span class="stat-title" style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Total Inquiries</span>
                <div class="stat-icon-tile squircle-purple" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('inbox', 16) ?>
                </div>
            </div>
            <div class="stat-main-val" style="font-size: clamp(24px, 3.5vw, 28px); font-weight: 800; color: var(--navy);"><?= number_format($leadStats['total']) ?></div>
            <div class="stat-sub-val" style="font-size: 11.5px; color: var(--text-secondary); margin-top: 2px;">
                <?= $leadStats['new'] > 0 ? "<span style='color: #D97706; font-weight: 700;'>{$leadStats['new']} new to review</span>" : "All reviewed" ?>
            </div>
        </a>

        <!-- Live Menu Items -->
        <a href="/admin.php?page=menu&section=catalog" class="stat-card" style="text-decoration: none; color: inherit; border-radius: 14px; border: 1px solid var(--border-color); background: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: transform 0.15s ease;">
            <div class="stat-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span class="stat-title" style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Live Menu Items</span>
                <div class="stat-icon-tile squircle-green" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('menu', 16) ?>
                </div>
            </div>
            <div class="stat-main-val" style="font-size: clamp(24px, 3.5vw, 28px); font-weight: 800; color: var(--navy);"><?= number_format($menuItemsCount) ?></div>
            <div class="stat-sub-val" style="font-size: 11.5px; color: var(--text-secondary); margin-top: 2px;"><?= count($categories) ?> active categories</div>
        </a>
    </div>

    <!-- ======================================================================
         4. SPLIT SECTION: RECENT SUBMISSIONS (Left) & MANAGEMENT SHORTCUTS (Right)
         ====================================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- Left: Recent Form Submissions -->
        <div style="background: #FFFFFF; border-radius: 14px; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03); padding: 1.5rem; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <div>
                    <h2 style="font-size: 17px; font-weight: 800; color: var(--navy); margin-bottom: 2px;">Recent Submissions</h2>
                    <p style="font-size: 12.5px; color: var(--text-muted); margin: 0;">Latest reservations, catering requests &amp; inquiries</p>
                </div>
                <a href="/admin.php?page=submissions" class="btn btn-secondary btn-sm" style="font-size: 12px; padding: 4px 10px;">
                    <span>View All (<?= $leadStats['total'] ?>)</span>
                    <?= AdminIcons::get('arrow_right', 12) ?>
                </a>
            </div>

            <?php if (empty($recentLeads)): ?>
                <div style="text-align: center; padding: 2.5rem 1rem; color: var(--text-muted);">
                    <div style="width: 44px; height: 44px; margin: 0 auto 12px; border-radius: 12px; background: #F8F9FA; display: flex; align-items: center; justify-content: center; color: #CBD5E1;">
                        <?= AdminIcons::get('inbox', 22) ?>
                    </div>
                    <div style="font-weight: 700; color: var(--navy); margin-bottom: 4px;">No Submissions Yet</div>
                    <div style="font-size: 12.5px;">Customer table bookings and inquiries will appear here.</div>
                </div>
            <?php else: ?>
                <div class="dash-submissions-list" style="display: flex; flex-direction: column; gap: 8px;">
                    <?php foreach ($recentLeads as $lead): 
                        $d = $lead['details'] ?? [];
                        $src = $lead['source'];
                        $srcLabel = match($src) {
                            'reservation', 'table_reservation' => 'Reservation',
                            'catering', 'catering_inquiry' => 'Catering',
                            'contact', 'contact_message' => 'Contact',
                            'popup', 'popup_lead' => 'Popup VIP',
                            default => ucfirst($src)
                        };
                        $srcColor = match($src) {
                            'reservation', 'table_reservation' => '#0284C7',
                            'catering', 'catering_inquiry' => '#D97706',
                            'contact', 'contact_message' => '#8B5CF6',
                            default => '#64748B'
                        };
                        $statusClass = 'status-' . strtolower($lead['status'] ?? 'new');
                    ?>
                        <a href="/admin.php?page=submissions&q=<?= urlencode($lead['name'] ?? '') ?>" class="dash-lead-row" style="text-decoration: none; color: inherit; padding: 10px 12px; border-radius: 10px; border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; transition: all 0.15s ease;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; background: <?= $srcColor ?>15; color: <?= $srcColor ?>;">
                                    <?= $srcLabel ?>
                                </span>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px; color: var(--navy);">
                                        <?= e($lead['name'] ?: 'Guest') ?>
                                    </div>
                                    <div style="font-size: 11.5px; color: var(--text-muted);">
                                        <?= e($lead['phone'] ?: $lead['email'] ?: date('M j, Y', strtotime($lead['created_at']))) ?>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span class="badge-status <?= $statusClass ?>" style="font-size: 10.5px; padding: 2px 7px;">
                                    <?= ucfirst($lead['status']) ?>
                                </span>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 3px;">
                                    <?= date('M j, g:i a', strtotime($lead['created_at'])) ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Apple-Style Management Directory -->
        <div class="apple-grouped-card" style="margin: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div style="padding: 1.25rem 1.5rem 0.5rem;">
                <h2 style="font-size: 17px; font-weight: 800; color: var(--navy); margin-bottom: 2px;">Management Directory</h2>
                <p style="font-size: 12.5px; color: var(--text-muted); margin: 0;">Quick shortcuts to core restaurant controls</p>
            </div>

            <a href="/admin.php?page=menu" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <?= AdminIcons::get('menu', 20) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Menu &amp; Dish Catalog</div>
                    <div class="apple-setting-desc">Tandoor, curries, pricing, availability toggles &amp; categories</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 18) ?></div>
            </a>

            <a href="/admin.php?page=media" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);">
                    <?= AdminIcons::get('media_library', 20) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Media Library &amp; Assets</div>
                    <div class="apple-setting-desc">Upload food photos, flyers, optimize images &amp; copy CDN links</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 18) ?></div>
            </a>

            <a href="/admin.php?page=pages" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);">
                    <?= AdminIcons::get('paint_brush', 20) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Page Content Customizer</div>
                    <div class="apple-setting-desc">Hero banners, lunch buffet copy, catering packages &amp; hours</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 18) ?></div>
            </a>

            <a href="/admin.php?page=settings" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #64748B 0%, #475569 100%);">
                    <?= AdminIcons::get('settings', 20) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Settings &amp; Staff Access</div>
                    <div class="apple-setting-desc">Team user accounts, passwords, security &amp; system architecture</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 18) ?></div>
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>

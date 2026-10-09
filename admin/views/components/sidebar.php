<?php
/**
 * Saffron Grill — CMS Sidebar Component
 */
$currentPage = $currentPage ?? 'dashboard';
$user = CMSAuth::user();
?>
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-top">
        <div class="sidebar-brand-row">
            <a href="/admin.php?page=dashboard" class="sidebar-brand">
                <div class="brand-logo-box" style="background: rgba(197, 160, 89, 0.15); border: 1px solid rgba(197, 160, 89, 0.3);">
                    <img src="/assets/emblem.png" alt="Saffron Grill" class="brand-logo-img" style="object-fit: contain;">
                </div>
                <div>
                    <div class="brand-title" style="letter-spacing: 0.02em;">Saffron Grill</div>
                    <div class="brand-sub">Restaurant CMS</div>
                </div>
            </a>
            <button type="button" class="sidebar-close-btn" id="sidebarClose" aria-label="Close Navigation" title="Close Navigation">
                <?= AdminIcons::get('x', 18) ?>
            </button>
        </div>

        <!-- Universal Search -->
        <div class="sidebar-search-box">
            <span class="sidebar-search-icon">
                <?= AdminIcons::get('search', 14) ?>
            </span>
            <input type="text" id="adminSidebarSearch" class="sidebar-search-input" placeholder="Search CMS..." autocomplete="off">
            <kbd class="sidebar-search-kbd">⌘K</kbd>
        </div>
    </div>

    <!-- Navigation List with Squircles -->
    <nav class="sidebar-nav">
        <div class="nav-section-title">Overview</div>

        <a href="/admin.php?page=dashboard" class="nav-item <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
            <span class="nav-squircle squircle-blue">
                <?= AdminIcons::get('dashboard', 16) ?>
            </span>
            <span class="nav-text">Dashboard</span>
        </a>

        <a href="/admin.php?page=submissions" class="nav-item <?= in_array($currentPage, ['submissions', 'leads']) ? 'active' : '' ?>">
            <span class="nav-squircle squircle-amber" style="background: rgba(217, 119, 6, 0.15); color: #D97706;">
                <?= AdminIcons::get('inbox', 16) ?>
            </span>
            <span class="nav-text">Form Submissions</span>
            <?php $newCount = CMS::getNewLeadsCount(); if ($newCount > 0): ?>
                <span style="margin-left: auto; font-size: 11px; padding: 2px 7px; border-radius: 9999px; background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; font-weight: 700;"><?= $newCount ?></span>
            <?php endif; ?>
        </a>

        <div class="nav-section-title">Website Management</div>

        <a href="/admin.php?page=media" class="nav-item <?= $currentPage === 'media' ? 'active' : '' ?>">
            <span class="nav-squircle" style="background: rgba(14, 165, 233, 0.15); color: #0284C7;">
                <?= AdminIcons::get('media_library', 16) ?>
            </span>
            <span class="nav-text">Media Library</span>
        </a>

        <a href="/admin.php?page=pages" class="nav-item <?= in_array($currentPage, ['pages', 'elements', 'popup']) ? 'active' : '' ?>">
            <span class="nav-squircle squircle-purple">
                <?= AdminIcons::get('paint_brush', 16) ?>
            </span>
            <span class="nav-text">Page Customizer</span>
        </a>

        <a href="/admin.php?page=menu" class="nav-item <?= $currentPage === 'menu' ? 'active' : '' ?>">
            <span class="nav-squircle squircle-green">
                <?= AdminIcons::get('menu', 16) ?>
            </span>
            <span class="nav-text">Menu & Pricing</span>
        </a>

        <div class="nav-section-title">System</div>

        <a href="/admin.php?page=settings" class="nav-item <?= $currentPage === 'settings' ? 'active' : '' ?>">
            <span class="nav-squircle squircle-gray">
                <?= AdminIcons::get('settings', 16) ?>
            </span>
            <span class="nav-text">Settings & Profile</span>
        </a>
    </nav>

    <!-- Bottom User Bar -->
    <div class="sidebar-footer">
        <div class="user-badge-mini">
            <div class="user-avatar-mini" style="background: linear-gradient(135deg, #C5A059 0%, #D97706 100%);">
                <?= strtoupper(substr($user['name'] ?? 'Admin', 0, 2)) ?>
            </div>
            <div class="user-info-mini">
                <span class="user-name-mini"><?= e($user['name'] ?? 'Admin') ?></span>
                <span class="user-role-mini"><?= CMSAuth::isSuperAdmin() ? 'Super Administrator' : 'Staff Member' ?></span>
            </div>
        </div>
        <a href="/admin.php?action=logout" class="logout-icon-btn" title="Sign Out">
            <?= AdminIcons::get('logout', 16) ?>
        </a>
    </div>
</aside>

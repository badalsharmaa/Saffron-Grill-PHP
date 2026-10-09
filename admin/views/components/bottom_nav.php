<?php
/**
 * Saffron Grill — Mobile Bottom Navigation Bar
 * Fast 1-tap thumb navigation optimized for mobile CRM
 */
$currentTab = $currentPage ?? 'dashboard';
?>
<nav class="mobile-bottom-nav" aria-label="Mobile Navigation">
    <a href="/admin.php?page=dashboard" class="mobile-nav-item <?= $currentTab === 'dashboard' ? 'active' : '' ?>">
        <span class="mobile-nav-icon">
            <?= AdminIcons::get('dashboard', 20) ?>
        </span>
        <span class="mobile-nav-label">Dashboard</span>
    </a>

    <a href="/admin.php?page=submissions" class="mobile-nav-item <?= in_array($currentTab, ['submissions', 'leads']) ? 'active' : '' ?>">
        <span class="mobile-nav-icon">
            <?= AdminIcons::get('inbox', 20) ?>
        </span>
        <span class="mobile-nav-label">Submissions</span>
    </a>

    <a href="/admin.php?page=pages" class="mobile-nav-item <?= in_array($currentTab, ['pages', 'elements', 'popup']) ? 'active' : '' ?>">
        <span class="mobile-nav-icon">
            <?= AdminIcons::get('paint_brush', 20) ?>
        </span>
        <span class="mobile-nav-label">Customizer</span>
    </a>

    <a href="/admin.php?page=menu" class="mobile-nav-item <?= $currentTab === 'menu' ? 'active' : '' ?>">
        <span class="mobile-nav-icon">
            <?= AdminIcons::get('menu', 20) ?>
        </span>
        <span class="mobile-nav-label">Menu</span>
    </a>

    <a href="/admin.php?page=settings" class="mobile-nav-item <?= $currentTab === 'settings' ? 'active' : '' ?>">
        <span class="mobile-nav-icon">
            <?= AdminIcons::get('settings', 20) ?>
        </span>
        <span class="mobile-nav-label">Settings</span>
    </a>
</nav>

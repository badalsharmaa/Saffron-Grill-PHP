<?php
/**
 * Saffron Grill — CMS Header Component
 */
require_once __DIR__ . '/../../helpers/AdminIcons.php';
$flash = cms_get_flash();
$user = CMSAuth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Dashboard') ?> — Saffron Grill CMS</title>
    <link rel="icon" type="image/png" href="/assets/emblem.png">
    <meta name="csrf-token" content="<?= cms_generate_csrf() ?>">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <script>
        window.CMS_CSRF = '<?= cms_generate_csrf() ?>';
        // Immediate pre-hydration check for desktop sidebar collapsed state to prevent layout flash
        try {
            if (window.innerWidth >= 992 && localStorage.getItem('sg_sidebar_collapsed') === 'true') {
                document.documentElement.classList.add('sidebar-is-collapsed');
            }
        } catch (e) {}
    </script>
</head>
<body>
    <div class="admin-layout" id="adminLayout">
        <!-- Sidebar -->
        <?php require __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Top Bar -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Navigation" title="Toggle Navigation">
                        <?= AdminIcons::get('hamburger', 20) ?>
                    </button>
                    <div class="header-breadcrumbs">
                        <span class="header-page-title"><?= e($pageTitle ?? 'Overview') ?></span>
                    </div>
                </div>

                <div class="admin-header-right">
                    <a href="/" target="_blank" class="live-site-btn" title="View Public Website" aria-label="View Public Website">
                        <span class="live-site-text">View Website</span>
                        <?= AdminIcons::get('external_link', 14) ?>
                    </a>
                </div>
            </header>

            <!-- Page Content Wrapper -->
            <main class="crm-page-container">
                <?php if ($flash): ?>
                    <div class="flash-alert flash-<?= e($flash['type']) ?>">
                        <span><?= e($flash['message']) ?></span>
                        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:inherit;font-size:16px;">&times;</button>
                    </div>
                <?php endif; ?>

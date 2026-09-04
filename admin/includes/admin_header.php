<?php
/**
 * Saffron Grill Admin - Common Header
 */
require_once __DIR__ . '/auth.php';
require_admin_auth();

$activeTab = $activeTab ?? 'dashboard';
$adminUser = $_SESSION['saffron_admin_user'] ?? 'Staff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($adminTitle ?? 'Admin CRM — Saffron Grill') ?></title>
<link rel="icon" type="image/png" href="<?= asset('emblem.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0f0710;
    --card-bg: #1c0c1b;
    --card-border: rgba(234, 179, 8, 0.2);
    --gold: #eab308;
    --gold-light: #f5d485;
    --text: #f3f4f6;
    --text-muted: #9ca3af;
    --primary: #c2410c;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  a { color: var(--gold); text-decoration: none; }
  a:hover { text-decoration: underline; }

  /* Navbar */
  .admin-nav {
    background: #160814;
    border-bottom: 1px solid var(--card-border);
    padding: 12px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
  }
  .brand-group {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .brand-group img { height: 32px; }
  .brand-group h1 {
    font-family: 'Cinzel', serif;
    font-size: 18px;
    color: #fff;
    letter-spacing: 0.05em;
  }
  .admin-menu {
    display: flex;
    gap: 8px;
    align-items: center;
  }
  .admin-menu a {
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-muted);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 7px;
  }
  .admin-menu a:hover, .admin-menu a.active {
    background: rgba(234, 179, 8, 0.15);
    color: var(--gold-light);
    text-decoration: none;
  }
  .admin-icon {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
    stroke-width: 2.2;
  }
  .user-badge {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 13px;
    color: var(--text-muted);
  }
  .btn-logout {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.3);
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .btn-logout:hover {
    background: rgba(239, 68, 68, 0.25);
    color: #fff;
    text-decoration: none;
  }

  /* Main Container */
  .admin-container {
    max-width: 1280px;
    width: 100%;
    margin: 24px auto;
    padding: 0 24px;
    flex: 1;
  }

  /* Cards & Grid */
  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 28px;
  }
  .kpi-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 10px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .kpi-label { font-size: 12px; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; }
  .kpi-value { font-size: 28px; font-weight: 700; color: var(--gold-light); }
  .kpi-sub { font-size: 12px; color: #10b981; }

  .data-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 10px;
    padding: 24px;
    margin-bottom: 24px;
  }
  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }
  .card-title {
    font-family: 'Cinzel', serif;
    font-size: 18px;
    color: #fff;
  }

  /* Tables */
  table.admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
    text-align: left;
  }
  table.admin-table th {
    padding: 10px 14px;
    background: rgba(0,0,0,0.3);
    color: var(--gold);
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--card-border);
  }
  table.admin-table td {
    padding: 12px 14px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    color: var(--text);
  }
  table.admin-table tr:hover td {
    background: rgba(234, 179, 8, 0.04);
  }

  /* Badges */
  .badge-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .status-pending { background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); }
  .status-confirmed, .status-won { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
  .status-cancelled, .status-lost { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
  .status-seated, .status-quoted { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
  .status-new, .status-contacted { background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }

  /* Forms */
  input[type="text"], input[type="email"], input[type="tel"], input[type="date"], select, textarea {
    width: 100%;
    padding: 9px 12px;
    background: rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 6px;
    color: #fff;
    font-size: 13.5px;
  }
  input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: var(--gold);
  }
  .btn-action {
    background: var(--gold);
    color: #1a0818;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .btn-action:hover { background: var(--gold-light); text-decoration: none; }
</style>
</head>
<body>

<nav class="admin-nav">
  <div class="brand-group">
    <img src="<?= asset('emblem.png') ?>" alt="Saffron Emblem">
    <h1>Saffron CRM</h1>
  </div>
  <div class="admin-menu">
    <a href="index.php" class="<?= $activeTab === 'dashboard' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
      Dashboard
    </a>
    <a href="reservations.php" class="<?= $activeTab === 'reservations' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Reservations
    </a>
    <a href="leads.php" class="<?= $activeTab === 'leads' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Catering Leads
    </a>
    <a href="menu_manager.php" class="<?= $activeTab === 'menu' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      Menu CMS
    </a>
    <a href="settings.php" class="<?= $activeTab === 'settings' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      Settings
    </a>
    <a href="export.php" class="<?= $activeTab === 'export' ? 'active' : '' ?>">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      CSV Export
    </a>
  </div>
  <div class="user-badge">
    <span>Logged in as <strong><?= e($adminUser) ?></strong></span>
    <a href="../index.php" target="_blank" style="font-size: 12px; color: var(--gold); display: inline-flex; align-items: center; gap: 4px;">
      View Site
      <svg class="admin-icon" style="width: 12px; height: 12px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
    </a>
    <a href="logout.php" class="btn-logout">
      <svg class="admin-icon" style="width: 13px; height: 13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Logout
    </a>
  </div>
</nav>

<div class="admin-container">

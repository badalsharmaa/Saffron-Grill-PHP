<?php
/**
 * Saffron Grill Admin - Analytics Dashboard
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$activeTab = 'dashboard';
$adminTitle = 'Dashboard — Saffron Grill CRM';

$pdo = get_db();

// Fetch KPIs
$today = date('Y-m-d');
$totalReservations = $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
$todayReservations = $pdo->query("SELECT COUNT(*) FROM reservations WHERE reservation_date = '{$today}'")->fetchColumn();
$totalLeads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$newLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'new'")->fetchColumn();
$totalMenuItems = $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();

// Recent 5 Reservations
$recentRes = $pdo->query("SELECT * FROM reservations ORDER BY id DESC LIMIT 5")->fetchAll();

// Recent 5 Catering Leads
$recentLeads = $pdo->query("SELECT * FROM leads ORDER BY id DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/includes/admin_header.php';
?>

<!-- KPI Row -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-label">Today's Reservations</span>
    <span class="kpi-value"><?= (int)$todayReservations ?></span>
    <span class="kpi-sub"><?= date('M j, Y') ?></span>
  </div>
  <div class="kpi-card">
    <span class="kpi-label">Total Bookings</span>
    <span class="kpi-value"><?= (int)$totalReservations ?></span>
    <span class="kpi-sub">Lifetime guest bookings</span>
  </div>
  <div class="kpi-card">
    <span class="kpi-label">New Catering Inquiries</span>
    <span class="kpi-value"><?= (int)$newLeads ?></span>
    <span class="kpi-sub"><?= (int)$totalLeads ?> total leads</span>
  </div>
  <div class="kpi-card">
    <span class="kpi-label">Live Menu Items</span>
    <span class="kpi-value"><?= (int)$totalMenuItems ?></span>
    <span class="kpi-sub">Active in CMS</span>
  </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
  
  <!-- Recent Table Reservations -->
  <div class="data-card">
    <div class="card-header">
      <h2 class="card-title">Recent Table Bookings</h2>
      <a href="reservations.php" style="font-size: 13px;">View All (<?= $totalReservations ?>) &rarr;</a>
    </div>
    
    <?php if (empty($recentRes)): ?>
      <p style="color: var(--text-muted); font-size: 13.5px; text-align: center; padding: 20px;">No reservations submitted yet.</p>
    <?php else: ?>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Code</th>
            <th>Guest</th>
            <th>Date / Time</th>
            <th>Party</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentRes as $r): ?>
            <tr>
              <td><strong><?= e($r['booking_code']) ?></strong></td>
              <td>
                <?= e($r['guest_name']) ?><br>
                <small style="color: var(--text-muted);"><?= e($r['phone']) ?></small>
              </td>
              <td><?= e($r['reservation_date']) ?><br><small style="color: var(--gold);"><?= e($r['reservation_time']) ?></small></td>
              <td><?= e($r['party_size']) ?> Guests</td>
              <td><span class="badge-status status-<?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <!-- Recent Catering Inquiries -->
  <div class="data-card">
    <div class="card-header">
      <h2 class="card-title">Recent Catering Leads</h2>
      <a href="leads.php" style="font-size: 13px;">View All (<?= $totalLeads ?>) &rarr;</a>
    </div>

    <?php if (empty($recentLeads)): ?>
      <p style="color: var(--text-muted); font-size: 13.5px; text-align: center; padding: 20px;">No catering inquiries recorded yet.</p>
    <?php else: ?>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Code</th>
            <th>Client</th>
            <th>Event Date</th>
            <th>Guests</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentLeads as $l): ?>
            <tr>
              <td><strong><?= e($l['lead_code']) ?></strong></td>
              <td>
                <?= e($l['client_name']) ?><br>
                <small style="color: var(--text-muted);"><?= e($l['phone']) ?></small>
              </td>
              <td><?= e($l['event_date']) ?><br><small style="color: var(--gold);"><?= e($l['event_type']) ?></small></td>
              <td><?= e($l['guest_count']) ?> Guests</td>
              <td><span class="badge-status status-<?= strtolower($l['status']) ?>"><?= e($l['status']) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

<?php
/**
 * Saffron Grill Admin - Table Reservations Manager
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$activeTab = 'reservations';
$adminTitle = 'Table Reservations — Saffron Grill CRM';

$pdo = get_db();
$msg = '';

// Handle Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $resId = (int)$_POST['res_id'];
    $newStatus = trim($_POST['status'] ?? 'confirmed');
    $stmt = $pdo->prepare("UPDATE reservations SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$newStatus, $resId]);
    $msg = "Reservation #{$resId} status updated to {$newStatus}.";
}

// Search and Filter
$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$dateFilter = trim($_GET['date'] ?? '');

$query = "SELECT * FROM reservations WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (guest_name LIKE ? OR phone LIKE ? OR booking_code LIKE ? OR email LIKE ?)";
    $term = "%{$search}%";
    $params = array_merge($params, [$term, $term, $term, $term]);
}
if (!empty($statusFilter)) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}
if (!empty($dateFilter)) {
    $query .= " AND reservation_date = ?";
    $params[] = $dateFilter;
}

$query .= " ORDER BY reservation_date DESC, reservation_time ASC LIMIT 100";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$reservations = $stmt->fetchAll();

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="data-card">
  <div class="card-header">
    <h2 class="card-title">Table Reservations Ledger</h2>
    <a href="export.php?type=reservations" class="btn-action">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export CSV
    </a>
  </div>

  <?php if (!empty($msg)): ?>
    <div style="background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13.5px;">
      <?= e($msg) ?>
    </div>
  <?php endif; ?>

  <!-- Filter Bar -->
  <form method="GET" action="reservations.php" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search by Guest Name, Phone, or Booking Code..." value="<?= e($search) ?>">
    <select name="status">
      <option value="">All Statuses</option>
      <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
      <option value="confirmed" <?= $statusFilter === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
      <option value="seated" <?= $statusFilter === 'seated' ? 'selected' : '' ?>>Seated</option>
      <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>
    <input type="date" name="date" value="<?= e($dateFilter) ?>">
    <button type="submit" class="btn-action">Filter</button>
  </form>

  <?php if (empty($reservations)): ?>
    <p style="color: var(--text-muted); text-align: center; padding: 30px;">No reservations found matching your criteria.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Code</th>
          <th>Guest Details</th>
          <th>Date &amp; Time</th>
          <th>Party &amp; Seating</th>
          <th>Requests</th>
          <th>Source / Attribution</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $r): ?>
          <tr>
            <td><strong style="color: var(--gold-light);"><?= e($r['booking_code']) ?></strong></td>
            <td>
              <strong><?= e($r['guest_name']) ?></strong><br>
              <small><?= e($r['phone']) ?></small>
              <?php if ($r['email']): ?><br><small style="color: var(--text-muted);"><?= e($r['email']) ?></small><?php endif; ?>
            </td>
            <td>
              <strong><?= e($r['reservation_date']) ?></strong><br>
              <span style="color: var(--gold);"><?= e($r['reservation_time']) ?></span>
            </td>
            <td>
              <strong><?= e($r['party_size']) ?> Guests</strong><br>
              <small style="color: var(--text-muted);"><?= e($r['seating_area']) ?></small>
            </td>
            <td style="max-width: 200px; font-size: 12.5px; color: #d1c4cb;">
              <?= e($r['special_requests'] ?: '—') ?>
            </td>
            <td style="font-size: 11px; color: var(--text-muted);">
              <?= e($r['utm_source'] ?: 'Direct') ?>
              <?php if (!empty($r['gclid'])): ?><br><span style="color: #34d399;">Google Ads</span><?php endif; ?>
            </td>
            <td>
              <span class="badge-status status-<?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span>
            </td>
            <td>
              <form method="POST" action="reservations.php" style="display: flex; gap: 4px;">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="res_id" value="<?= $r['id'] ?>">
                <select name="status" onchange="this.form.submit()" style="padding: 4px 6px; font-size: 11.5px; width: auto;">
                  <option value="pending" <?= $r['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                  <option value="confirmed" <?= $r['status'] === 'confirmed' ? 'selected' : '' ?>>Confirm</option>
                  <option value="seated" <?= $r['status'] === 'seated' ? 'selected' : '' ?>>Seated</option>
                  <option value="cancelled" <?= $r['status'] === 'cancelled' ? 'selected' : '' ?>>Cancel</option>
                </select>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

<?php
/**
 * Saffron Grill Admin - Catering & Event Leads CRM
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$activeTab = 'leads';
$adminTitle = 'Catering Leads — Saffron Grill CRM';

$pdo = get_db();
$msg = '';

// Handle Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $leadId = (int)$_POST['lead_id'];
    $newStatus = trim($_POST['status'] ?? 'new');
    $stmt = $pdo->prepare("UPDATE leads SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$newStatus, $leadId]);
    $msg = "Lead #{$leadId} status updated to {$newStatus}.";
}

// Search and Filter
$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');

$query = "SELECT * FROM leads WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (client_name LIKE ? OR phone LIKE ? OR lead_code LIKE ? OR email LIKE ?)";
    $term = "%{$search}%";
    $params = array_merge($params, [$term, $term, $term, $term]);
}
if (!empty($statusFilter)) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY id DESC LIMIT 100";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$leads = $stmt->fetchAll();

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="data-card">
  <div class="card-header">
    <h2 class="card-title">Catering Proposals &amp; Event Pipeline</h2>
    <a href="export.php?type=leads" class="btn-action">
      <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export Leads CSV
    </a>
  </div>

  <?php if (!empty($msg)): ?>
    <div style="background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13.5px;">
      <?= e($msg) ?>
    </div>
  <?php endif; ?>

  <!-- Filter Bar -->
  <form method="GET" action="leads.php" style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 12px; margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search by Client Name, Phone, Email, or Reference Code..." value="<?= e($search) ?>">
    <select name="status">
      <option value="">All Lead Statuses</option>
      <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>New</option>
      <option value="contacted" <?= $statusFilter === 'contacted' ? 'selected' : '' ?>>Contacted</option>
      <option value="quoted" <?= $statusFilter === 'quoted' ? 'selected' : '' ?>>Proposal Sent</option>
      <option value="won" <?= $statusFilter === 'won' ? 'selected' : '' ?>>Booked (Won)</option>
      <option value="lost" <?= $statusFilter === 'lost' ? 'selected' : '' ?>>Lost / Declined</option>
    </select>
    <button type="submit" class="btn-action">Filter</button>
  </form>

  <?php if (empty($leads)): ?>
    <p style="color: var(--text-muted); text-align: center; padding: 30px;">No catering inquiries recorded yet.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Ref Code</th>
          <th>Client Info</th>
          <th>Event Details</th>
          <th>Guests &amp; Package</th>
          <th>Location &amp; Notes</th>
          <th>Campaign Source</th>
          <th>Status</th>
          <th>Update</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($leads as $l): ?>
          <tr>
            <td><strong style="color: var(--gold-light);"><?= e($l['lead_code']) ?></strong></td>
            <td>
              <strong><?= e($l['client_name']) ?></strong><br>
              <small><a href="tel:<?= e($l['phone']) ?>" style="color: #fff;"><?= e($l['phone']) ?></a></small><br>
              <small><a href="mailto:<?= e($l['email']) ?>" style="color: var(--gold);"><?= e($l['email']) ?></a></small>
            </td>
            <td>
              <strong><?= e($l['event_date']) ?></strong><br>
              <span style="color: var(--gold);"><?= e($l['event_type']) ?></span>
            </td>
            <td>
              <strong style="font-size: 15px; color: #f5d485;"><?= e($l['guest_count']) ?> Guests</strong><br>
              <small style="color: var(--text-muted);"><?= e($l['package_type']) ?></small>
            </td>
            <td style="max-width: 220px; font-size: 12.5px; color: #d1c4cb;">
              <strong>Venue:</strong> <?= e($l['venue_location'] ?: 'Tri-Valley') ?><br>
              <?= e($l['special_notes'] ?: 'No additional notes') ?>
            </td>
            <td style="font-size: 11px; color: var(--text-muted);">
              <?= e($l['utm_source'] ?: 'Organic/Direct') ?>
              <?php if (!empty($l['gclid'])): ?><br><span style="color: #34d399;">Google Ads Lead</span><?php endif; ?>
            </td>
            <td>
              <span class="badge-status status-<?= strtolower($l['status']) ?>"><?= e($l['status']) ?></span>
            </td>
            <td>
              <form method="POST" action="leads.php" style="display: flex; gap: 4px;">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="lead_id" value="<?= $l['id'] ?>">
                <select name="status" onchange="this.form.submit()" style="padding: 4px 6px; font-size: 11.5px; width: auto;">
                  <option value="new" <?= $l['status'] === 'new' ? 'selected' : '' ?>>New</option>
                  <option value="contacted" <?= $l['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                  <option value="quoted" <?= $l['status'] === 'quoted' ? 'selected' : '' ?>>Quoted</option>
                  <option value="won" <?= $l['status'] === 'won' ? 'selected' : '' ?>>Won</option>
                  <option value="lost" <?= $l['status'] === 'lost' ? 'selected' : '' ?>>Lost</option>
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

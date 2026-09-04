<?php
/**
 * Saffron Grill Admin - Menu CMS
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$activeTab = 'menu';
$adminTitle = 'Menu Manager — Saffron Grill CRM';

$pdo = get_db();
$msg = '';

// Handle Add Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_item') {
    $category = trim($_POST['category_slug']);
    $name = trim($_POST['name']);
    $desc = trim($_POST['description'] ?? '');
    $price = (float)$_POST['price'];
    $isVeg = isset($_POST['is_vegetarian']) ? 1 : 0;
    $isSpicy = isset($_POST['is_spicy']) ? 1 : 0;
    $isPop = isset($_POST['is_popular']) ? 1 : 0;

    if (!empty($name) && $price > 0) {
        $stmt = $pdo->prepare("INSERT INTO menu_items (category_slug, name, description, price, is_vegetarian, is_spicy, is_popular) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$category, $name, $desc, $price, $isVeg, $isSpicy, $isPop]);
        $msg = "Added dish '{$name}' to the menu.";
    }
}

// Handle Delete Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_item') {
    $itemId = (int)$_POST['item_id'];
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$itemId]);
    $msg = "Dish removed from the menu.";
}

// Fetch categories and items
$categories = $pdo->query("SELECT * FROM menu_categories ORDER BY display_order ASC")->fetchAll();
$items = $pdo->query("SELECT * FROM menu_items ORDER BY category_slug ASC, display_order ASC, name ASC")->fetchAll();

require_once __DIR__ . '/includes/admin_header.php';
?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
  
  <!-- Add New Dish Form -->
  <div class="data-card">
    <div class="card-header">
      <h2 class="card-title">Add New Dish</h2>
    </div>

    <?php if (!empty($msg)): ?>
      <div style="background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13px;">
        <?= e($msg) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="menu_manager.php">
      <input type="hidden" name="action" value="add_item">
      
      <div style="display: flex; flex-direction: column; gap: 14px;">
        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Category</label>
          <select name="category_slug" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= e($cat['slug']) ?>"><?= e($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Dish Name *</label>
          <input type="text" name="name" required placeholder="e.g. Saffron Dum Biryani">
        </div>

        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Price ($) *</label>
          <input type="number" step="0.01" name="price" required placeholder="18.99">
        </div>

        <div>
          <label style="display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px;">Description</label>
          <textarea name="description" rows="3" placeholder="Ingredients, culinary notes..."></textarea>
        </div>

        <div style="display: flex; gap: 14px; flex-wrap: wrap;">
          <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
            <input type="checkbox" name="is_vegetarian" value="1">
            <span style="color: #34d399; font-weight: 500;">Vegetarian</span>
          </label>
          <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
            <input type="checkbox" name="is_spicy" value="1">
            <span style="color: #f87171; font-weight: 500;">Spicy</span>
          </label>
          <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
            <input type="checkbox" name="is_popular" value="1">
            <span style="color: #facc15; font-weight: 500;">Popular</span>
          </label>
        </div>

        <button type="submit" class="btn-action" style="margin-top: 10px; width: 100%; justify-content: center;">
          <svg class="admin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add to Live Menu
        </button>
      </div>
    </form>
  </div>

  <!-- Live Menu Items List -->
  <div class="data-card">
    <div class="card-header">
      <h2 class="card-title">Current Dishes (<?= count($items) ?> Items)</h2>
    </div>

    <table class="admin-table">
      <thead>
        <tr>
          <th>Dish</th>
          <th>Category</th>
          <th>Price</th>
          <th>Tags</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td>
              <strong><?= e($item['name']) ?></strong><br>
              <small style="color: var(--text-muted);"><?= e($item['description']) ?></small>
            </td>
            <td><span style="font-size: 12px; color: var(--gold);"><?= e($item['category_slug']) ?></span></td>
            <td><strong>$<?= number_format((float)$item['price'], 2) ?></strong></td>
            <td>
              <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                <?php if ($item['is_vegetarian']): ?>
                  <span style="font-size: 10.5px; padding: 2px 6px; border-radius: 3px; background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3); font-weight: 600;">VEG</span>
                <?php else: ?>
                  <span style="font-size: 10.5px; padding: 2px 6px; border-radius: 3px; background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); font-weight: 600;">NON-VEG</span>
                <?php endif; ?>
                <?php if ($item['is_spicy']): ?>
                  <span style="font-size: 10.5px; padding: 2px 6px; border-radius: 3px; background: rgba(249,115,22,0.15); color: #fb923c; border: 1px solid rgba(249,115,22,0.3); font-weight: 600;">SPICY</span>
                <?php endif; ?>
                <?php if ($item['is_popular']): ?>
                  <span style="font-size: 10.5px; padding: 2px 6px; border-radius: 3px; background: rgba(234,179,8,0.15); color: #facc15; border: 1px solid rgba(234,179,8,0.3); font-weight: 600;">STAR</span>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <form method="POST" action="menu_manager.php" onsubmit="return confirm('Delete this dish?');">
                <input type="hidden" name="action" value="delete_item">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                <button type="submit" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; cursor: pointer; padding: 5px 8px; border-radius: 4px; display: inline-flex; align-items: center;" title="Delete Dish">
                  <svg class="admin-icon" style="width: 13px; height: 13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

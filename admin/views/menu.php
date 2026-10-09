<?php
/**
 * Saffron Grill — Modular Menu & Pricing Directory
 * Apple macOS/iOS Settings style architecture:
 *  - Directory View (when section is null)
 *  - Section: outlets (Operational Status & Emergency Switches)
 *  - Section: categories (Category Manager: Add, Edit, Re-order, Icons)
 *  - Section: catalog (Dish Catalog & Pricing List Form)
 *  - Section: io (Bulk Import & Export Hub)
 */

$pageTitle = 'Menu & Pricing';
$currentPage = 'menu';

$section = $_GET['section'] ?? null;
$validSections = ['outlets', 'categories', 'catalog', 'io'];
if ($section !== null && !in_array($section, $validSections, true)) {
    $section = null;
}

// Load menu items & categories
require_once dirname(__DIR__, 2) . '/data/menu.php';
global $MENU_ITEMS;
$overrides = CMS::getMenuOverrides();
$categories = CMS::getCategories();

// Operational status
$buffetPaused = (CMS::getSetting('buffet_paused', '0') === '1');
$dinnerClosed = (CMS::getSetting('dinner_closed', '0') === '1');
$closedMessage = CMS::getSetting('restaurant_closed_message', 'Online ordering is temporarily paused. Our dining room is currently welcoming guests.');

// Active vs Removed
$activeItems = $MENU_ITEMS ?? [];
$removedItems = [];
foreach ($overrides as $ovId => $ov) {
    if (!empty($ov['is_deleted'])) {
        $removedItems[$ovId] = $ov;
    }
}

// Category icons
$availableIcons = [
    'utensils' => 'Utensils & Dining',
    'sparkles' => 'Sparkles & Signature',
    'menu' => 'Menu & Breads',
    'tag' => 'Tag & Special',
    'calendar' => 'Calendar & Buffet',
    'clock' => 'Clock & Service',
    'star' => 'Star & Popular'
];

$allCategories = [];
foreach ($categories as $c) {
    $allCategories[$c['name']] = $c['name'];
}
foreach ($activeItems as $it) {
    if (!empty($it['category'])) {
        $allCategories[$it['category']] = $it['category'];
    }
}
ksort($allCategories);

require_once __DIR__ . '/components/header.php';
?>

<?php if ($section === null): ?>
    <!-- ============================================================= -->
    <!-- MASTER DIRECTORY VIEW: APPLE macOS / iOS SETTINGS STYLE       -->
    <!-- ============================================================= -->
    <div class="apple-settings-wrap">
        <!-- Top Central Hero Card -->
        <div class="apple-header-card">
            <div class="apple-header-icon-box" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.2)); color: #10B981;">
                <?= AdminIcons::get('menu', 34) ?>
            </div>
            <h1 class="apple-header-title">Menu &amp; Pricing Directory</h1>
            <p class="apple-header-subtitle">
                Configure operational service switches, organize menu categories, edit dish pricing in catalog list form, or export and import menu files.
            </p>
        </div>

        <!-- Grouped List Card with Hairline Dividers -->
        <div class="apple-grouped-card">
            <!-- 1. Operational Status & Service Switches -->
            <a href="/admin.php?page=menu&section=outlets" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                    <?= AdminIcons::get('store', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name" style="display: flex; align-items: center; gap: 8px;">
                        <span>Service Status &amp; Emergency Switches</span>
                        <?php if ($buffetPaused || $dinnerClosed): ?>
                            <span class="badge badge-warning" style="font-size: 11px; padding: 2px 7px;">
                                Service Paused
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="apple-setting-desc">Pause lunch buffet, close dinner service, and configure ordering closure notices</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 2. Menu Categories Manager -->
            <a href="/admin.php?page=menu&section=categories" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                    <?= AdminIcons::get('utensils', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Menu Categories Manager</div>
                    <div class="apple-setting-desc">Re-order menu sections, edit descriptions, assign icons, and configure courses</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 3. Complete Dishes & Pricing Catalog -->
            <a href="/admin.php?page=menu&section=catalog" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <?= AdminIcons::get('menu', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Dish Catalog &amp; Pricing List</div>
                    <div class="apple-setting-desc">Edit dish prices, toggle availability switches, assign food photography, spice &amp; veg tags</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 4. Bulk Import & Export Hub -->
            <a href="/admin.php?page=menu&section=io" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                    <?= AdminIcons::get('download', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Bulk Import &amp; Export Hub</div>
                    <div class="apple-setting-desc">Download entire restaurant menu as CSV or JSON, or upload spreadsheet updates</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- ============================================================= -->
    <!-- SUB-VIEW: SELECTED SECTION                                    -->
    <!-- ============================================================= -->
    <div style="max-width: 1000px; margin: 0 auto; padding-bottom: 4rem;">
        
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="/admin.php?page=menu" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 6px;">
                <?= AdminIcons::get('chevron_left', 16) ?>
                <span>Back to Menu Directory</span>
            </a>
            <span style="font-size: 13px; font-weight: 700; color: var(--gold); text-transform: uppercase;">
                Section: <?= ucfirst($section) ?>
            </span>
        </div>

        <?php if ($section === 'outlets'): ?>
            <!-- SERVICE SWITCHES -->
            <form method="POST" action="/admin.php?page=menu&action=save_restaurant_status">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">

                <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Service Status &amp; Emergency Switches</h2>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Control live operations when kitchen is at peak capacity or for special holiday schedules.</p>
                </div>

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color); margin-bottom: 1rem;">
                        <div>
                            <div style="font-weight: 700; font-size: 15px; color: var(--navy);">Lunch Buffet Service</div>
                            <div style="font-size: 12.5px; color: var(--text-muted);">Pause lunch buffet online availability</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="buffet_paused" value="1" <?= $buffetPaused ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color); margin-bottom: 1rem;">
                        <div>
                            <div style="font-weight: 700; font-size: 15px; color: var(--navy);">Dinner Service</div>
                            <div style="font-size: 12.5px; color: var(--text-muted);">Mark dinner service as closed</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="dinner_closed" value="1" <?= $dinnerClosed ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="form-group" style="margin-top: 1rem;">
                        <label class="form-label">Ordering Closure Customer Notice</label>
                        <textarea name="restaurant_closed_message" class="form-control" rows="3"><?= e($closedMessage) ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Save Operational Status</button>
            </form>

        <?php elseif ($section === 'categories'): ?>
            <!-- CATEGORIES MANAGER -->
            <form method="POST" action="/admin.php?page=menu&action=save_categories">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">

                <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Menu Categories Manager</h2>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Organize, rename, and assign display icons to restaurant menu sections.</p>
                </div>

                <div class="card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div id="categoriesList" style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach ($categories as $idx => $cat): ?>
                            <div class="category-row" style="background: #FAF7F2; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 160px 1fr 140px; gap: 12px; align-items: center;">
                                <div>
                                    <input type="text" name="categories[<?= $idx ?>][name]" value="<?= e($cat['name']) ?>" class="form-control form-control-sm" placeholder="Category Name" required>
                                </div>
                                <div>
                                    <input type="text" name="categories[<?= $idx ?>][description]" value="<?= e($cat['description'] ?? '') ?>" class="form-control form-control-sm" placeholder="Short description / subtitle">
                                </div>
                                <div>
                                    <select name="categories[<?= $idx ?>][icon]" class="form-control form-control-sm">
                                        <?php foreach ($availableIcons as $iconKey => $iconLabel): ?>
                                            <option value="<?= $iconKey ?>" <?= ($cat['icon'] ?? '') === $iconKey ? 'selected' : '' ?>><?= $iconLabel ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Save Categories Order</button>
            </form>

        <?php elseif ($section === 'catalog'): ?>
            <!-- COMPLETE DISH CATALOG & PRICING -->
            <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Dish Catalog &amp; Pricing List</h2>
                        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Edit live prices, availability switches, food images, and dietary tags.</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="openAddDishModal()">
                        <?= AdminIcons::get('plus', 14) ?>
                        <span>Add New Dish</span>
                    </button>
                </div>
            </div>

            <!-- Active vs Removed Tabs -->
            <?php 
            $catalogTab = $_GET['tab'] ?? 'active';
            $displayedItems = ($catalogTab === 'removed') ? $removedItems : $activeItems;
            ?>
            <div style="display: flex; gap: 8px; margin-bottom: 1.25rem;">
                <a href="/admin.php?page=menu&section=catalog&tab=active" class="btn btn-sm <?= $catalogTab === 'active' ? 'btn-primary' : 'btn-secondary' ?>">
                    Active Dishes (<?= count($activeItems) ?>)
                </a>
                <a href="/admin.php?page=menu&section=catalog&tab=removed" class="btn btn-sm <?= $catalogTab === 'removed' ? 'btn-primary' : 'btn-secondary' ?>">
                    Removed / Archived (<?= count($removedItems) ?>)
                </a>
            </div>

            <form method="POST" action="/admin.php?page=menu&action=save">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="redirect_section" value="catalog">

                <div class="card" style="border-radius: 14px; overflow: hidden; padding: 0;">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Photo</th>
                                    <th>Dish Name &amp; Category</th>
                                    <th style="width: 120px;">Price ($)</th>
                                    <th>Dietary</th>
                                    <th>Live Status</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($displayedItems as $dish): 
                                    $dishId = (string)($dish['id'] ?? $dish['item_id']);
                                    $isAvail = !empty($dish['is_available']);
                                    $dishJson = htmlspecialchars(json_encode($dish, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                                ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($dish['image'])): ?>
                                                <img src="<?= e($dish['image']) ?>" alt="" style="width: 38px; height: 38px; object-fit: cover; border-radius: 8px; border: 1px solid #E2E8F0;">
                                            <?php else: ?>
                                                <div style="width: 38px; height: 38px; border-radius: 8px; background: #FAF7F2; border: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: center; color: #94A3B8;">
                                                    <?= AdminIcons::get('picture', 16) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: var(--navy); font-size: 14px;">
                                                <?= e($dish['name']) ?>
                                            </div>
                                            <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 1px;">
                                                <?= e($dish['category']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="items[<?= $dishId ?>][price]" value="<?= number_format((float)$dish['price'], 2, '.', '') ?>" class="form-control form-control-sm" style="width: 90px; font-weight: 700;">
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                                <?php if (!empty($dish['veg'])): ?>
                                                    <span class="badge" style="background: #ECFDF5; color: #047857; border: 1px solid #D1FAE5; font-size: 10px;">Veg</span>
                                                <?php endif; ?>
                                                <?php if (!empty($dish['spicy'])): ?>
                                                    <span class="badge" style="background: #FEF2F2; color: #B91C1C; border: 1px solid #FEE2E2; font-size: 10px;">Spicy</span>
                                                <?php endif; ?>
                                                <?php if (!empty($dish['gluten_free'])): ?>
                                                    <span class="badge" style="background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; font-size: 10px;">GF</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" name="items[<?= $dishId ?>][is_available]" value="1" <?= $isAvail ? 'checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php if ($catalogTab === 'removed'): ?>
                                                <form method="POST" action="/admin.php?page=menu&action=restore_dish" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                                                    <input type="hidden" name="item_id" value="<?= e($dishId) ?>">
                                                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 12px;">Restore</button>
                                                </form>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="openEditDishModal(<?= $dishJson ?>)" style="font-size: 12px; padding: 4px 10px;">Edit</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-top: 1rem; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Save Table Changes</button>
                </div>
            </form>

        <?php elseif ($section === 'io'): ?>
            <!-- BULK IMPORT & EXPORT -->
            <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Bulk Import &amp; Export Hub</h2>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Download menu data as spreadsheets or batch upload dish updates via CSV or JSON.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Export Card -->
                <div class="card" style="padding: 1.75rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 6px;">Export Menu Catalog</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 1.25rem;">Download all active dishes and prices to open in Microsoft Excel, Google Sheets, or backup.</p>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin.php?page=menu&action=export_menu_csv" class="btn btn-secondary" style="gap: 6px;">
                            <?= AdminIcons::get('download', 14) ?>
                            <span>Export CSV</span>
                        </a>
                        <a href="/admin.php?page=menu&action=export_menu_json" class="btn btn-secondary" style="gap: 6px;">
                            <?= AdminIcons::get('download', 14) ?>
                            <span>Export JSON</span>
                        </a>
                    </div>
                </div>

                <!-- Import Card -->
                <div class="card" style="padding: 1.75rem;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 6px;">Import Menu Updates</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 1.25rem;">Upload a modified CSV or JSON file to update pricing and dish records in batch.</p>
                    <form method="POST" action="/admin.php?page=menu&action=import_menu" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <input type="file" name="menu_file" accept=".csv,.json" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Upload &amp; Import</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- ======================================================================
     ADD / EDIT DISH MODAL
     ====================================================================== -->
<div id="dishModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="modal-panel" style="background: #FFFFFF; border-radius: 16px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2rem; position: relative; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <button type="button" onclick="closeDishModal()" style="position: absolute; top: 16px; right: 18px; background: none; border: none; font-size: 24px; color: #94A3B8; cursor: pointer;">&times;</button>
        
        <h2 id="dishModalTitle" style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 1.25rem;">Edit Dish</h2>

        <form method="POST" action="/admin.php?page=menu&action=save_dish">
            <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
            <input type="hidden" name="item_id" id="dishModalId" value="">

            <div class="form-group">
                <label class="form-label">Dish Name</label>
                <input type="text" name="name" id="dishModalName" class="form-control" required placeholder="e.g. Saffron Butter Chicken">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category" id="dishModalCategory" class="form-control">
                        <?php foreach ($allCategories as $catName): ?>
                            <option value="<?= e($catName) ?>"><?= e($catName) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="dishModalPrice" class="form-control" required placeholder="18.99">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description &amp; Ingredients</label>
                <textarea name="description" id="dishModalDesc" class="form-control" rows="2" placeholder="Velvety spiced tomato sauce, fenugreek, cream..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Dish Image URL</label>
                <div style="display: flex; gap: 8px;">
                    <input type="text" name="image" id="dishModalImage" class="form-control" placeholder="/assets/... image URL">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="chooseImageFor('dishModalImage')">Choose</button>
                </div>
            </div>

            <div style="display: flex; gap: 16px; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" name="veg" id="dishModalVeg" value="1">
                    <span>Vegetarian</span>
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" name="spicy" id="dishModalSpicy" value="1">
                    <span>Spicy</span>
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" name="gluten_free" id="dishModalGf" value="1">
                    <span>Gluten Free</span>
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                    <input type="checkbox" name="is_available" id="dishModalAvail" value="1" checked>
                    <span>Available</span>
                </label>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                <button type="button" id="btnDeleteDishForm" class="btn btn-danger btn-sm" style="display: none;" onclick="deleteActiveDish()">
                    <?= AdminIcons::get('trash', 14) ?>
                    <span>Remove Dish</span>
                </button>
                <div style="margin-left: auto;">
                    <button type="submit" class="btn btn-primary">Save Dish</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAddDishModal() {
    document.getElementById('dishModalTitle').textContent = 'Add New Dish';
    document.getElementById('dishModalId').value = '';
    document.getElementById('dishModalName').value = '';
    document.getElementById('dishModalPrice').value = '';
    document.getElementById('dishModalDesc').value = '';
    document.getElementById('dishModalImage').value = '';
    document.getElementById('dishModalVeg').checked = false;
    document.getElementById('dishModalSpicy').checked = false;
    document.getElementById('dishModalGf').checked = false;
    document.getElementById('dishModalAvail').checked = true;
    document.getElementById('btnDeleteDishForm').style.display = 'none';

    document.getElementById('dishModal').style.display = 'flex';
}

function openEditDishModal(dish) {
    if (!dish) return;
    document.getElementById('dishModalTitle').textContent = 'Edit Dish: ' + (dish.name || '');
    document.getElementById('dishModalId').value = dish.id || dish.item_id || '';
    document.getElementById('dishModalName').value = dish.name || '';
    document.getElementById('dishModalCategory').value = dish.category || '';
    document.getElementById('dishModalPrice').value = dish.price || '';
    document.getElementById('dishModalDesc').value = dish.description || '';
    document.getElementById('dishModalImage').value = dish.image || '';
    document.getElementById('dishModalVeg').checked = !!dish.veg;
    document.getElementById('dishModalSpicy').checked = !!dish.spicy;
    document.getElementById('dishModalGf').checked = !!dish.gluten_free;
    document.getElementById('dishModalAvail').checked = (dish.is_available !== 0 && dish.is_available !== false);

    var delBtn = document.getElementById('btnDeleteDishForm');
    delBtn.style.display = 'inline-flex';

    document.getElementById('dishModal').style.display = 'flex';
}

function closeDishModal() {
    var modal = document.getElementById('dishModal');
    if (modal) modal.style.display = 'none';
}

function deleteActiveDish() {
    var id = document.getElementById('dishModalId').value;
    if (!id) return;
    if (confirm('Are you sure you want to remove this dish from the active menu? It can be restored later.')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin.php?page=menu&action=delete_dish';
        form.innerHTML = '<input type="hidden" name="csrf_token" value="' + window.CMS_CSRF + '"><input type="hidden" name="item_id" value="' + id + '">';
        document.body.appendChild(form);
        form.submit();
    }
}

function chooseImageFor(inputId) {
    if (window.MediaPicker) {
        window.MediaPicker.open(function(asset) {
            var el = document.getElementById(inputId);
            if (el) el.value = asset.url;
        });
    }
}
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>

<?php
/**
 * Saffron Grill — CMS Settings & Directory
 * Apple macOS/iOS style clean settings directory
 */

$pageTitle = 'Settings & Security';
$currentPage = 'settings';

$user = CMSAuth::user();
$isSuperAdmin = CMSAuth::isSuperAdmin();
$allUsers = $isSuperAdmin ? CMSAuth::getAllUsers() : [];

$subSection = $_GET['section'] ?? null;
$validSections = ['team', 'profile', 'system'];
if ($subSection !== null && !in_array($subSection, $validSections, true)) {
    $subSection = null;
}

// Security: If not super admin, cannot access team section
if ($subSection === 'team' && !$isSuperAdmin) {
    $subSection = null;
}

$pendingCount = 0;
if ($isSuperAdmin) {
    foreach ($allUsers as $u) {
        if (($u['status'] ?? '') === 'pending') {
            $pendingCount++;
        }
    }
}

require_once __DIR__ . '/components/header.php';
?>

<?php if ($subSection === null): ?>
    <!-- ============================================================= -->
    <!-- MASTER DIRECTORY VIEW: APPLE macOS / iOS SETTINGS STYLE       -->
    <!-- ============================================================= -->
    <div class="apple-settings-wrap">
        <!-- Top Central Hero Card -->
        <div class="apple-header-card">
            <div class="apple-header-icon-box" style="background: linear-gradient(135deg, rgba(197, 160, 89, 0.15), rgba(217, 119, 6, 0.2)); color: var(--gold);">
                <?= AdminIcons::get('settings', 34) ?>
            </div>
            <h1 class="apple-header-title">Settings &amp; Administrator Security</h1>
            <p class="apple-header-subtitle">
                Configure administrative credentials, manage authorized team members, monitor server architecture, or update your profile.
            </p>
        </div>

        <!-- Grouped List Card with Hairline Dividers -->
        <div class="apple-grouped-card">
            <?php if ($isSuperAdmin): ?>
                <!-- 1. Team & User Access Control -->
                <a href="/admin.php?page=settings&section=team" class="apple-setting-row">
                    <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                        <?= AdminIcons::get('shield', 22) ?>
                    </div>
                    <div class="apple-setting-info">
                        <div class="apple-setting-name" style="display: flex; align-items: center; gap: 8px;">
                            <span>Team &amp; User Access Control</span>
                            <?php if ($pendingCount > 0): ?>
                                <span class="badge badge-warning" style="font-size: 11px; padding: 2px 7px;">
                                    <?= $pendingCount ?> Pending
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="apple-setting-desc">Manage administrator accounts, approve pending staff registrations, promote roles &amp; reset passwords</div>
                    </div>
                    <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
                </a>
            <?php endif; ?>

            <!-- 2. Administrator Profile -->
            <a href="/admin.php?page=settings&section=profile" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                    <?= AdminIcons::get('users', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">Administrator Profile</div>
                    <div class="apple-setting-desc">Update personal name, contact email address, and change sign-in access password</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>

            <!-- 3. System Architecture -->
            <a href="/admin.php?page=settings&section=system" class="apple-setting-row">
                <div class="apple-squircle-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);">
                    <?= AdminIcons::get('sparkles', 22) ?>
                </div>
                <div class="apple-setting-info">
                    <div class="apple-setting-name">System Architecture</div>
                    <div class="apple-setting-desc">PHP runtime diagnostics, SQLite database storage size, sessions, and environment details</div>
                </div>
                <div class="apple-setting-chevron"><?= AdminIcons::get('chevron_right', 20) ?></div>
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- ============================================================= -->
    <!-- SUB-VIEW: SELECTED SETTINGS SECTION                           -->
    <!-- ============================================================= -->
    <div style="max-width: 900px; margin: 0 auto; padding-bottom: 4rem;">
        
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="/admin.php?page=settings" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 6px;">
                <?= AdminIcons::get('chevron_left', 16) ?>
                <span>Back to Settings Directory</span>
            </a>
            <span style="font-size: 13px; font-weight: 700; color: var(--gold); text-transform: uppercase;">
                Section: <?= ucfirst($subSection) ?>
            </span>
        </div>

        <?php if ($subSection === 'team'): ?>
            <!-- TEAM & USER ACCESS CONTROL -->
            <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Team &amp; Staff Access Control</h2>
                        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Super Administrator management for authorized restaurant personnel accounts.</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="openCreateUserModal()">
                        <?= AdminIcons::get('plus', 14) ?>
                        <span>Add Team Member</span>
                    </button>
                </div>
            </div>

            <div class="card" style="padding: 0; overflow: hidden; border-radius: 14px; margin-bottom: 1.5rem;">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUsers as $u): 
                                $isSelf = ($user && (int)$user['id'] === (int)$u['id']);
                                $isRoot = ((int)$u['id'] === 1);
                                $statusClass = match($u['status']) {
                                    'active' => 'status-completed',
                                    'pending' => 'status-new',
                                    'suspended' => 'status-archived',
                                    default => 'status-contacted'
                                };
                            ?>
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--navy); font-size: 13.5px;">
                                            <?= e($u['name']) ?>
                                            <?php if ($isSelf): ?>
                                                <span style="font-size: 11px; color: var(--gold); margin-left: 4px;">(You)</span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 1px;">
                                            @<?= e($u['username']) ?> &bull; <?= e($u['email']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="font-size: 11px; background: <?= $u['role'] === 'super_admin' ? '#FEF3C7' : '#F1F5F9' ?>; color: <?= $u['role'] === 'super_admin' ? '#B45309' : '#475569' ?>; border: 1px solid <?= $u['role'] === 'super_admin' ? '#FDE68A' : '#E2E8F0' ?>;">
                                            <?= $u['role'] === 'super_admin' ? 'Super Admin' : 'Staff' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status <?= $statusClass ?>" style="font-size: 11px;">
                                            <?= ucfirst($u['status']) ?>
                                        </span>
                                    </td>
                                    <td style="font-size: 12.5px; color: var(--text-muted);">
                                        <?= date('M j, Y', strtotime($u['created_at'])) ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 6px;">
                                            <?php if ($u['status'] === 'pending'): ?>
                                                <form method="POST" action="/admin.php?page=settings&action=manage_users" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                                                    <input type="hidden" name="sub_action" value="approve">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <button type="submit" class="btn btn-sm" style="background: #10B981; color: #fff; font-size: 11.5px; padding: 3px 8px;">Approve</button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (!$isRoot && !$isSelf): ?>
                                                <form method="POST" action="/admin.php?page=settings&action=manage_users" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                                                    <input type="hidden" name="sub_action" value="toggle_status">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <input type="hidden" name="status" value="<?= $u['status'] === 'active' ? 'suspended' : 'active' ?>">
                                                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 11.5px; padding: 3px 8px;">
                                                        <?= $u['status'] === 'active' ? 'Suspend' : 'Activate' ?>
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-secondary btn-sm" onclick="promptResetPassword(<?= $u['id'] ?>, '<?= e($u['username']) ?>')" style="font-size: 11.5px; padding: 3px 8px;">Reset PW</button>

                                                <form method="POST" action="/admin.php?page=settings&action=manage_users" style="display: inline;" onsubmit="return confirm('Permanently remove user <?= e($u['username']) ?>?');">
                                                    <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                                                    <input type="hidden" name="sub_action" value="delete">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" style="font-size: 11.5px; padding: 3px 8px;">&times;</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php elseif ($subSection === 'profile'): ?>
            <!-- ADMINISTRATOR PROFILE -->
            <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">Administrator Profile</h2>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Update your display name, notification email, and account password.</p>
            </div>

            <form method="POST" action="/admin.php?page=settings&action=update_profile">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">

                <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= e($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= e($user['username'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" required>
                    </div>

                    <h3 style="font-size: 15px; font-weight: 700; color: var(--navy); margin: 1.5rem 0 10px; padding-top: 1rem; border-top: 1px solid var(--border-color);">Change Account Password</h3>
                    <p style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 1rem;">Leave blank if you do not wish to change your sign-in password.</p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Save Profile Changes</button>
            </form>

        <?php elseif ($subSection === 'system'): ?>
            <!-- SYSTEM ARCHITECTURE DIAGNOSTICS -->
            <div class="apple-header-card" style="text-align: left; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;">
                <h2 style="font-size: 20px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">System Architecture Diagnostics</h2>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Technical environment information and database statistics.</p>
            </div>

            <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
                <?php 
                $pdo = CMSDatabase::getConnection();
                $dbSize = file_exists(CMS_DB_PATH) ? CMS::formatBytes(filesize(CMS_DB_PATH)) : 'Unknown';
                $sqliteVer = $pdo->query("SELECT sqlite_version()")->fetchColumn();
                ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 13.5px;">
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">PHP Version</span>
                        <div style="font-weight: 700; color: var(--navy);"><?= PHP_VERSION ?> (<?= PHP_SAPI ?>)</div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">SQLite Engine</span>
                        <div style="font-weight: 700; color: var(--navy);"><?= e($sqliteVer) ?></div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">Database Storage</span>
                        <div style="font-weight: 700; color: var(--navy);"><?= $dbSize ?> (WAL mode)</div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">Database Location</span>
                        <div style="font-weight: 700; color: var(--navy); font-size: 12px; word-break: break-all;"><?= e(CMS_DB_PATH) ?></div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">Memory Limit</span>
                        <div style="font-weight: 700; color: var(--navy);"><?= ini_get('memory_limit') ?></div>
                    </div>
                    <div>
                        <span style="color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; font-weight: 700;">Max File Upload</span>
                        <div style="font-weight: 700; color: var(--navy);"><?= ini_get('upload_max_filesize') ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Create User Modal -->
<div id="createUserModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="modal-panel" style="background: #FFFFFF; border-radius: 16px; max-width: 480px; width: 100%; padding: 2rem; position: relative; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <button type="button" onclick="closeCreateUserModal()" style="position: absolute; top: 16px; right: 18px; background: none; border: none; font-size: 24px; color: #94A3B8; cursor: pointer;">&times;</button>
        <h3 style="font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 1.25rem;">Create New Team Member</h3>

        <form method="POST" action="/admin.php?page=settings&action=manage_users">
            <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
            <input type="hidden" name="sub_action" value="create_user">

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Lead Host / Kitchen Manager">
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="team@saffrongrill.com">
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="username">
            </div>
            <div class="form-group">
                <label class="form-label">Temporary Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.25rem;">
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="staff">Staff Member</option>
                        <option value="super_admin">Super Administrator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active (Immediate)</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
        </form>
    </div>
</div>

<script>
function openCreateUserModal() {
    document.getElementById('createUserModal').style.display = 'flex';
}
function closeCreateUserModal() {
    document.getElementById('createUserModal').style.display = 'none';
}
function promptResetPassword(userId, username) {
    var newPw = prompt('Enter new password for @' + username + ' (min 6 characters):');
    if (newPw && newPw.length >= 6) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin.php?page=settings&action=manage_users';
        form.innerHTML = '<input type="hidden" name="csrf_token" value="' + window.CMS_CSRF + '">' +
                         '<input type="hidden" name="sub_action" value="reset_password">' +
                         '<input type="hidden" name="user_id" value="' + userId + '">' +
                         '<input type="hidden" name="new_password" value="' + newPw + '">';
        document.body.appendChild(form);
        form.submit();
    } else if (newPw !== null) {
        alert('Password must be at least 6 characters.');
    }
}
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>

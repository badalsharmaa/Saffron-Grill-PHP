<?php
/**
 * Saffron Grill — Central Admin & CMS Router
 */

require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/admin/auth.php';
require_once __DIR__ . '/admin/helpers/CMS.php';
require_once __DIR__ . '/admin/helpers/AdminIcons.php';

// Start and verify CMS session
CMSAuth::startSession();

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? null;

// Handle Logout
if ($action === 'logout') {
    CMSAuth::logout();
    exit;
}

// Handle Login Action (POST)
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!cms_verify_csrf($csrf)) {
        cms_set_flash('error', 'Security token expired. Please try again.');
        cms_redirect('/admin/');
    }

    // Bot challenge check
    $answer = (int)($_POST['bot_challenge'] ?? -1);
    $expected = (int)($_SESSION['cms_puzzle_answer'] ?? -2);
    if ($answer !== $expected) {
        cms_set_flash('error', 'Incorrect security math answer. Please try again.');
        cms_redirect('/admin/');
    }

    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $result = CMSAuth::attemptLogin($username, $password);
    if ($result['success']) {
        cms_set_flash('success', 'Welcome back! You are now logged in.');
        cms_redirect('/admin/?page=dashboard');
    } else {
        cms_set_flash('error', $result['error'] ?? 'Invalid username or password.');
        cms_redirect('/admin/');
    }
    exit;
}

// Handle Register Action (POST)
if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!cms_verify_csrf($csrf)) {
        cms_set_flash('error', 'Security token expired. Please try again.');
        cms_redirect('/admin/?mode=register');
    }

    // Bot challenge check
    $answer = (int)($_POST['bot_challenge'] ?? -1);
    $expected = (int)($_SESSION['cms_puzzle_answer'] ?? -2);
    if ($answer !== $expected) {
        cms_set_flash('error', 'Incorrect security math answer. Please try again.');
        cms_redirect('/admin/?mode=register');
    }

    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $confirmPassword = (string)($_POST['confirm_password'] ?? '');

    if ($password !== $confirmPassword) {
        cms_set_flash('error', 'Passwords do not match. Please re-enter.');
        cms_redirect('/admin/?mode=register');
    }

    $result = CMSAuth::register($name, $email, $username, $password);
    if ($result['success']) {
        cms_set_flash('success', $result['message']);
        cms_redirect('/admin/');
    } else {
        cms_set_flash('error', $result['error'] ?? 'Registration failed.');
        cms_redirect('/admin/?mode=register');
    }
    exit;
}

// If unauthenticated, show the clean login view directly
if (!CMSAuth::check()) {
    require __DIR__ . '/admin/views/login.php';
    exit;
}

// If already logged in and visiting login, go to dashboard
if ($page === 'login') {
    cms_redirect('/admin/?page=dashboard');
}

// All subsequent pages require active authentication
CMSAuth::requireLogin();

// ----------------------------------------------------------------------
// Global AJAX Endpoints
// ----------------------------------------------------------------------

// AJAX: Image Upload
if ($action === 'ajax_upload_image' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!cms_verify_csrf($token)) {
        echo json_encode(['success' => false, 'error' => 'Security session expired. Please refresh the page.']);
        exit;
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errCode = $_FILES['image']['error'] ?? 'missing';
        echo json_encode(['success' => false, 'error' => 'No image received or upload error (' . $errCode . ').']);
        exit;
    }

    $file = $_FILES['image'];
    if ($file['size'] > 15 * 1024 * 1024) {
        echo json_encode(['success' => false, 'error' => 'Image size exceeds maximum limit of 15MB.']);
        exit;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowedExts, true)) {
        echo json_encode(['success' => false, 'error' => 'Invalid file extension. Allowed: WEBP, PNG, JPG, GIF.']);
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($mime, $allowedMimes, true)) {
        echo json_encode(['success' => false, 'error' => 'Invalid image content type (' . htmlspecialchars($mime) . ').']);
        exit;
    }

    $uploadDir = __DIR__ . '/assets/uploads';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
    }

    $targetName = 'sg_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(4)), 0, 8) . '.' . $ext;
    $targetPath = $uploadDir . '/' . $targetName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode([
            'success' => true,
            'url' => '/assets/uploads/' . $targetName,
            'filename' => $targetName
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save uploaded image. Check directory permissions.']);
    }
    exit;
}

// WordPress-Style Media Library AJAX Endpoints
if ($action === 'ajax_media_upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!cms_verify_csrf($token)) {
        echo json_encode(['success' => false, 'error' => 'Security token invalid or expired. Refresh and try again.']);
        exit;
    }

    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'error' => 'No file received in upload payload.']);
        exit;
    }

    $res = CMS::processUploadedMedia($_FILES['file']);
    echo json_encode($res);
    exit;
}

if ($action === 'ajax_media_list') {
    header('Content-Type: application/json');
    $filters = [
        'search' => trim((string)($_GET['s'] ?? '')),
        'mime'   => trim((string)($_GET['mime'] ?? '')),
        'month'  => trim((string)($_GET['month'] ?? '')),
        'page'   => max(1, (int)($_GET['page'] ?? 1)),
        'limit'  => min(100, max(12, (int)($_GET['limit'] ?? 48)))
    ];

    $listData = CMS::getMediaList($filters);
    $months = CMS::getMediaMonths();
    $stats = CMS::getMediaStats();

    echo json_encode([
        'success' => true,
        'data' => $listData,
        'months' => $months,
        'stats' => $stats
    ]);
    exit;
}

if ($action === 'ajax_media_get') {
    header('Content-Type: application/json');
    $id = (int)($_GET['id'] ?? 0);
    $item = CMS::getMediaItem($id);
    if ($item) {
        echo json_encode(['success' => true, 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Media item not found.']);
    }
    exit;
}

if ($action === 'ajax_media_update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!cms_verify_csrf($token)) {
        echo json_encode(['success' => false, 'error' => 'Security token expired.']);
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid media ID.']);
        exit;
    }

    $data = [
        'title'    => $_POST['title'] ?? '',
        'alt_text' => $_POST['alt_text'] ?? '',
        'caption'  => $_POST['caption'] ?? ''
    ];

    $ok = CMS::updateMediaItem($id, $data);
    echo json_encode(['success' => $ok, 'error' => $ok ? null : 'Failed to update metadata.']);
    exit;
}

if ($action === 'ajax_media_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!cms_verify_csrf($token)) {
        echo json_encode(['success' => false, 'error' => 'Security token expired.']);
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid media ID.']);
        exit;
    }

    $ok = CMS::deleteMediaItem($id);
    echo json_encode(['success' => $ok, 'error' => $ok ? null : 'Failed to delete file.']);
    exit;
}

if ($action === 'ajax_media_sync' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!cms_verify_csrf($token)) {
        echo json_encode(['success' => false, 'error' => 'Security token expired.']);
        exit;
    }

    $count = CMS::syncExistingAssets();
    $stats = CMS::getMediaStats();
    echo json_encode([
        'success' => true,
        'synced' => $count,
        'stats' => $stats
    ]);
    exit;
}

// ----------------------------------------------------------------------
// Route by Page
// ----------------------------------------------------------------------

switch ($page) {
    case 'submissions':
    case 'leads':
        // Update Status
        if ($action === 'update_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=submissions');
            }

            $leadId = (int)($_POST['lead_id'] ?? 0);
            $newStatus = trim((string)($_POST['status'] ?? 'new'));
            if ($leadId > 0 && in_array($newStatus, ['new', 'contacted', 'completed', 'archived'], true)) {
                CMS::updateLeadStatus($leadId, $newStatus);
                cms_set_flash('success', 'Lead status updated to ' . ucfirst($newStatus) . '.');
            }
            cms_redirect('/admin.php?page=submissions');
        }

        // Save Notes
        if ($action === 'save_notes' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=submissions');
            }

            $leadId = (int)($_POST['lead_id'] ?? 0);
            $notes = trim((string)($_POST['notes'] ?? ''));
            if ($leadId > 0) {
                CMS::updateLeadNotes($leadId, $notes);
                cms_set_flash('success', 'Internal staff notes updated successfully.');
            }
            cms_redirect('/admin.php?page=submissions');
        }

        // Delete Submission
        if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=submissions');
            }

            $leadId = (int)($_POST['lead_id'] ?? 0);
            if ($leadId > 0) {
                CMS::deleteLead($leadId);
                cms_set_flash('success', 'Submission record removed successfully.');
            }
            cms_redirect('/admin.php?page=submissions');
        }

        // Export CSV
        if ($action === 'export_csv') {
            $src = $_GET['source'] ?? null;
            $st = $_GET['status'] ?? null;
            $filters = [];
            if ($src && $src !== 'all') $filters['source'] = $src;
            if ($st && $st !== 'all') $filters['status'] = $st;
            CMS::exportLeadsCsv($filters);
            exit;
        }

        require __DIR__ . '/admin/views/submissions.php';
        break;

    case 'popup':
        if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=pages&edit=popup');
            }

            CMS::savePopupConfig($_POST);
            cms_set_flash('success', 'Promotional popup configuration saved successfully!');
            cms_redirect('/admin.php?page=pages&edit=popup');
        }
        cms_redirect('/admin.php?page=pages&edit=popup');
        break;

    case 'pages':
    case 'elements':
        if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $activeTab = $_POST['active_tab'] ?? 'home';
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=pages&edit=' . urlencode($activeTab));
            }

            // General & Section Settings - Dynamic & Secure Persistence
            $ignoreKeys = ['csrf_token', 'active_tab', 'edit_page', 'action'];

            // Explicit checkbox toggles that might be absent from $_POST if unchecked
            if ($activeTab === 'home') {
                CMS::setSetting('announcement_enabled', !empty($_POST['announcement_enabled']) ? '1' : '0', 'home');
            }
            if ($activeTab === 'buffet') {
                CMS::setSetting('buffet_active', !empty($_POST['buffet_active']) ? '1' : '0', 'buffet');
            }

            foreach ($_POST as $k => $v) {
                if (in_array($k, $ignoreKeys, true)) continue;
                if (is_array($v)) {
                    // JSON encode structured arrays (e.g. packages, complex items)
                    CMS::setSetting($k, json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $activeTab);
                } else {
                    CMS::setSetting($k, (string)$v, $activeTab);
                }
            }

            cms_set_flash('success', 'Page settings updated and synchronized successfully!');
            cms_redirect('/admin.php?page=pages&edit=' . urlencode($activeTab));
        }
        require __DIR__ . '/admin/views/pages.php';
        break;

    case 'menu':
        // Save or update an individual dish
        if ($action === 'save_dish' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=catalog');
            }

            $dishId = CMS::saveDish($_POST);
            if ($dishId !== '') {
                cms_set_flash('success', 'Dish successfully saved and synchronized!');
            } else {
                cms_set_flash('error', 'Failed to save dish. Please verify input fields.');
            }
            cms_redirect('/admin.php?page=menu&section=catalog');
        }

        // Delete dish
        if ($action === 'delete_dish' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=catalog');
            }

            $itemId = trim((string)($_POST['item_id'] ?? ''));
            if ($itemId !== '') {
                CMS::deleteDish($itemId);
                cms_set_flash('success', 'Dish removed successfully from active menu.');
            }
            cms_redirect('/admin.php?page=menu&section=catalog');
        }

        // Restore dish
        if ($action === 'restore_dish' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=catalog&tab=removed');
            }

            $itemId = trim((string)($_POST['item_id'] ?? ''));
            if ($itemId !== '') {
                CMS::restoreDish($itemId);
                cms_set_flash('success', 'Dish restored successfully to active menu.');
            }
            cms_redirect('/admin.php?page=menu&section=catalog');
        }

        // Save Operational Service Status
        if ($action === 'save_restaurant_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=outlets');
            }

            $buffetPaused = !empty($_POST['buffet_paused']) ? '1' : '0';
            $dinnerClosed = !empty($_POST['dinner_closed']) ? '1' : '0';
            $closedMessage = trim((string)($_POST['restaurant_closed_message'] ?? ''));

            CMS::setSetting('buffet_paused', $buffetPaused, 'restaurant_status');
            CMS::setSetting('dinner_closed', $dinnerClosed, 'restaurant_status');
            if ($closedMessage !== '') {
                CMS::setSetting('restaurant_closed_message', $closedMessage, 'restaurant_status');
            }

            cms_set_flash('success', 'Service operational status updated successfully!');
            cms_redirect('/admin.php?page=menu&section=outlets');
        }

        // Save Menu Categories
        if ($action === 'save_categories' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=categories');
            }

            $categoriesRaw = $_POST['categories'] ?? [];
            if (is_array($categoriesRaw)) {
                CMS::saveCategories($categoriesRaw);
                cms_set_flash('success', 'Menu categories and icons saved successfully!');
            }
            cms_redirect('/admin.php?page=menu&section=categories');
        }

        // Export CSV
        if ($action === 'export_menu_csv') {
            CMS::exportMenuCsv();
            exit;
        }

        // Export JSON
        if ($action === 'export_menu_json') {
            CMS::exportMenuJson();
            exit;
        }

        // Import Menu
        if ($action === 'import_menu' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=io');
            }

            if (!isset($_FILES['menu_file']) || $_FILES['menu_file']['error'] !== UPLOAD_ERR_OK) {
                cms_set_flash('error', 'Please choose a valid CSV or JSON file to upload.');
                cms_redirect('/admin.php?page=menu&section=io');
            }

            $file = $_FILES['menu_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $rows = [];

            if ($ext === 'csv') {
                $handle = fopen($file['tmp_name'], 'r');
                if ($handle !== false) {
                    $bom = fread($handle, 3);
                    if ($bom !== "\xEF\xBB\xBF") {
                        rewind($handle);
                    }
                    $header = fgetcsv($handle);
                    if ($header) {
                        $header = array_map(function($h) { return trim(trim($h), "\xEF\xBB\xBF"); }, $header);
                        while (($data = fgetcsv($handle)) !== false) {
                            if (count($data) >= 2) {
                                $row = [];
                                foreach ($header as $i => $col) {
                                    $row[$col] = $data[$i] ?? '';
                                }
                                $rows[] = $row;
                            }
                        }
                    }
                    fclose($handle);
                }
            } elseif ($ext === 'json') {
                $content = file_get_contents($file['tmp_name']);
                $decoded = json_decode($content, true);
                if (is_array($decoded)) {
                    $rows = $decoded['items'] ?? $decoded;
                }
            }

            if (empty($rows)) {
                cms_set_flash('error', 'No valid dish rows found in uploaded file.');
                cms_redirect('/admin.php?page=menu&section=io');
            }

            $res = CMS::importMenuFromRows($rows);
            $msg = "Imported {$res['imported']} dishes successfully.";
            cms_set_flash('success', $msg);
            cms_redirect('/admin.php?page=menu&section=catalog');
        }

        // Batch save from table
        if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=menu&section=catalog');
            }

            if (isset($_POST['items']) && is_array($_POST['items'])) {
                foreach ($_POST['items'] as $itemId => $itemData) {
                    CMS::saveMenuOverride((string)$itemId, $itemData);
                }
            }

            cms_set_flash('success', 'Menu pricing and availability changes saved successfully!');
            cms_redirect('/admin.php?page=menu&section=catalog');
        }

        require __DIR__ . '/admin/views/menu.php';
        break;

    case 'settings':
        // Super Admin User Operations
        if ($action === 'manage_users' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            CMSAuth::requireSuperAdmin();

            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=settings&section=team');
            }

            $subAction = trim((string)($_POST['sub_action'] ?? ''));
            $targetUserId = (int)($_POST['user_id'] ?? 0);

            if ($subAction === 'approve') {
                $res = CMSAuth::updateUserStatus($targetUserId, 'active');
                if ($res['success']) {
                    cms_set_flash('success', 'User account approved and activated successfully.');
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to approve account.');
                }
            } elseif ($subAction === 'toggle_status') {
                $newStatus = trim((string)($_POST['status'] ?? 'active'));
                $res = CMSAuth::updateUserStatus($targetUserId, $newStatus);
                if ($res['success']) {
                    $label = $newStatus === 'active' ? 'activated' : 'suspended';
                    cms_set_flash('success', "User account has been {$label}.");
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to update user status.');
                }
            } elseif ($subAction === 'change_role') {
                $newRole = trim((string)($_POST['role'] ?? 'staff'));
                $res = CMSAuth::updateUserRole($targetUserId, $newRole);
                if ($res['success']) {
                    cms_set_flash('success', "User role updated successfully.");
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to change role.');
                }
            } elseif ($subAction === 'reset_password') {
                $newPassword = (string)($_POST['new_password'] ?? '');
                $res = CMSAuth::resetUserPassword($targetUserId, $newPassword);
                if ($res['success']) {
                    cms_set_flash('success', 'User password successfully reset.');
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to reset password.');
                }
            } elseif ($subAction === 'delete') {
                $res = CMSAuth::deleteUser($targetUserId);
                if ($res['success']) {
                    cms_set_flash('success', 'User account permanently removed.');
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to remove user account.');
                }
            } elseif ($subAction === 'create_user') {
                $name = trim((string)($_POST['name'] ?? ''));
                $email = trim((string)($_POST['email'] ?? ''));
                $username = trim((string)($_POST['username'] ?? ''));
                $password = (string)($_POST['password'] ?? '');
                $role = trim((string)($_POST['role'] ?? 'staff'));
                $status = trim((string)($_POST['status'] ?? 'active'));

                $res = CMSAuth::createUser($name, $email, $username, $password, $role, $status);
                if ($res['success']) {
                    cms_set_flash('success', "Team member '{$username}' created successfully.");
                } else {
                    cms_set_flash('error', $res['error'] ?? 'Failed to create user account.');
                }
            }

            cms_redirect('/admin.php?page=settings&section=team');
        }

        if ($action === 'update_profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!cms_verify_csrf($_POST['csrf_token'] ?? '')) {
                cms_set_flash('error', 'Invalid security token.');
                cms_redirect('/admin.php?page=settings&section=profile');
            }

            $user = CMSAuth::user();
            $name = trim((string)($_POST['name'] ?? ''));
            $email = trim((string)($_POST['email'] ?? ''));
            $username = trim((string)($_POST['username'] ?? ''));
            $newPassword = (string)($_POST['new_password'] ?? '');
            $confirmPassword = (string)($_POST['confirm_password'] ?? '');

            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    cms_set_flash('error', 'Password must be at least 6 characters long.');
                    cms_redirect('/admin.php?page=settings&section=profile');
                }
                if ($newPassword !== $confirmPassword) {
                    cms_set_flash('error', 'New password and confirmation do not match.');
                    cms_redirect('/admin.php?page=settings&section=profile');
                }
            }

            $result = CMSAuth::updateProfile($user['id'], $name, $email, !empty($username) ? $username : null, !empty($newPassword) ? $newPassword : null);
            if (empty($result['success'])) {
                cms_set_flash('error', $result['error'] ?? 'Failed to update profile.');
            } else {
                cms_set_flash('success', 'Administrator profile updated successfully!');
            }
            cms_redirect('/admin.php?page=settings&section=profile');
        }

        require __DIR__ . '/admin/views/settings.php';
        break;

    case 'media':
        require __DIR__ . '/admin/views/media.php';
        break;

    case 'dashboard':
    default:
        require __DIR__ . '/admin/views/dashboard.php';
        break;
}

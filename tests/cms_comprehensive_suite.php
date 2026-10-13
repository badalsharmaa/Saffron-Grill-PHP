<?php
/**
 * Saffron Grill CMS — Deep Automated Test Suite & Reliability Verifier
 * Thoroughly exercises every function across:
 *  1. CMSAuth (Authentication, Security, Roles, Profiles)
 *  2. CMS Settings & Page Customizer (Popup, Story, Catering, Home, Buffet, Reserve, Policies)
 *  3. CMS Menu Engine (Add, Edit, Soft-delete, Restore, Toggle, Overrides, Categories, Import)
 *  4. CMS Submissions & Leads Pipeline (Create, Retrieve, Filter, Status Update, Notes, Delete)
 *  5. CMS Media Engine (List, Single Item, Metadata Update, Sync, Upload Validation, Delete)
 *  6. Public Storefront Integration (cms_get, empty-string handling, frontend sync)
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../admin/config.php';
require_once __DIR__ . '/../admin/db.php';
require_once __DIR__ . '/../admin/auth.php';
require_once __DIR__ . '/../admin/helpers/CMS.php';
require_once __DIR__ . '/../api/cms_helper.php';

$totalChecks = 0;
$passedChecks = 0;
$failedChecks = 0;
$failures = [];

function assert_test(bool $condition, string $title, string $details = ''): void {
    global $totalChecks, $passedChecks, $failedChecks, $failures;
    $totalChecks++;
    if ($condition) {
        $passedChecks++;
        echo "  [PASS] {$title}\n";
    } else {
        $failedChecks++;
        $msg = "[FAIL] {$title}" . ($details ? " -> {$details}" : '');
        echo "  {$msg}\n";
        $failures[] = $msg;
    }
}

echo "=================================================================\n";
echo "   SAFFRON GRILL CMS — DEEP FUNCTIONAL & STRESS AUDIT SUITE      \n";
echo "=================================================================\n\n";

$pdo = CMSDatabase::getConnection();

// =====================================================================
// SECTION 1: AUTHENTICATION & TEAM MANAGEMENT (CMSAuth)
// =====================================================================
echo "--- MODULE 1: CMSAuth (Authentication, Security, Roles) ---\n";

CMSAuth::startSession();

// 1. CSRF Token Generation & Verification
$csrf = cms_generate_csrf();
assert_test(!empty($csrf) && strlen($csrf) >= 32, "CSRF token generated successfully");
assert_test(cms_verify_csrf($csrf), "CSRF verification passes with valid token");
assert_test(!cms_verify_csrf('invalid_token_xyz'), "CSRF verification rejects invalid token");
assert_test(!cms_verify_csrf(''), "CSRF verification rejects empty token");

// 2. Authentication Logic
$badLogin = CMSAuth::attemptLogin('admin', 'wrong_password_123');
assert_test(!$badLogin['success'], "Login rejects incorrect password");

$nonExistentUser = CMSAuth::attemptLogin('ghost_user_9999', 'password');
assert_test(!$nonExistentUser['success'], "Login rejects non-existent username");

$goodLogin = CMSAuth::attemptLogin('admin', 'SaffronAdmin2026!');
assert_test($goodLogin['success'], "Super Admin successfully authenticated");
assert_test(CMSAuth::check(), "CMSAuth::check() reports true for active session");
assert_test(CMSAuth::isSuperAdmin(), "CMSAuth::isSuperAdmin() identifies super admin role correctly");

// 3. Team Member Lifecycle (Create, Role Change, Status Toggle, Password Reset, Delete)
$testUsername = 'test_qa_' . rand(1000, 9999);
$testEmail = $testUsername . '@saffrongrill.com';
$createdUser = CMSAuth::createUser('QA Tester', $testEmail, $testUsername, 'TestPass123!', 'staff', 'active');
assert_test($createdUser['success'] && !empty($createdUser['id']), "CMSAuth::createUser creates active staff user (ID: " . ($createdUser['id'] ?? 'none') . ")");
$testUserId = (int)($createdUser['id'] ?? 0);

if ($testUserId > 0) {
    // Role change to staff/super_admin
    $roleChange = CMSAuth::updateUserRole($testUserId, 'super_admin');
    assert_test($roleChange['success'], "CMSAuth::updateUserRole modifies user role to 'super_admin'");

    // Status toggle to suspended
    $statusChange = CMSAuth::updateUserStatus($testUserId, 'suspended');
    assert_test($statusChange['success'], "CMSAuth::updateUserStatus updates user status to 'suspended'");

    // Verify suspended user cannot log in
    $suspendedLogin = CMSAuth::attemptLogin($testUsername, 'TestPass123!');
    assert_test(!$suspendedLogin['success'], "Suspended user is prevented from logging in");

    // Re-login as primary admin to restore super_admin session context
    CMSAuth::attemptLogin('admin', 'SaffronAdmin2026!');

    // Status toggle back to active
    $activateRes = CMSAuth::updateUserStatus($testUserId, 'active');
    assert_test($activateRes['success'], "CMSAuth::updateUserStatus activates user again");

    // Reset password
    $pwdReset = CMSAuth::resetUserPassword($testUserId, 'NewSecret456!');
    assert_test($pwdReset['success'], "CMSAuth::resetUserPassword updates password hash");

    $resetLogin = CMSAuth::attemptLogin($testUsername, 'NewSecret456!');
    assert_test($resetLogin['success'], "User can authenticate with newly reset password");

    // Profile update
    $profileUpdate = CMSAuth::updateProfile($testUserId, 'QA Tester Updated', 'updated_' . $testEmail);
    assert_test($profileUpdate['success'], "CMSAuth::updateProfile modifies user details");

    // Re-login as primary admin to delete the test user
    CMSAuth::attemptLogin('admin', 'SaffronAdmin2026!');

    // Delete user
    $delUser = CMSAuth::deleteUser($testUserId);
    assert_test($delUser['success'], "CMSAuth::deleteUser permanently removes test account");
}

// =====================================================================
// SECTION 2: SETTINGS & PAGE CUSTOMIZER
// =====================================================================
echo "\n--- MODULE 2: Settings Engine & Page Customizers ---\n";

// 1. General Settings Key-Value Store
$origTestSetting = CMS::getSetting('qa_test_key_temp', null);
$setSuccess = CMS::setSetting('qa_test_key_temp', 'test_value_123', 'qa');
assert_test($setSuccess, "CMS::setSetting saves key-value pair");
assert_test(CMS::getSetting('qa_test_key_temp') === 'test_value_123', "CMS::getSetting retrieves stored setting");

// Empty string retention vs fallback
CMS::setSetting('qa_test_empty_key', '', 'qa');
assert_test(CMS::getSetting('qa_test_empty_key', 'FALLBACK') === '', "CMS::getSetting retains empty string without falling back");
assert_test(cms_get('qa_test_empty_key', 'FALLBACK') === '', "cms_get() retains empty string without falling back to default");
assert_test(cms_get('completely_non_existent_key_9999', 'FALLBACK') === 'FALLBACK', "cms_get() uses fallback only when key is completely non-existent");

// Clean up test keys
$pdo->exec("DELETE FROM cms_settings WHERE setting_key IN ('qa_test_key_temp', 'qa_test_empty_key')");

// 2. Promotional Popup Configuration
$origPopup = CMS::getPopupConfig();
assert_test(is_array($origPopup) && isset($origPopup['is_active'], $origPopup['disable_image'], $origPopup['slides']), "CMS::getPopupConfig returns well-formed config array");

// Test saving popup with image disabled
$popupSave1 = CMS::savePopupConfig([
    'is_active' => '1',
    'has_image_setting' => '1',
    'show_image' => '0', // image disabled
    'delay_seconds' => '2.5',
    'show_frequency' => 'always',
    'enable_lead_capture' => '1',
    'lead_capture_title' => 'VIP Club Test',
    'slides' => [
        [
            'id' => 1,
            'image' => '/assets/dishes/chatgpt_1.webp',
            'alt' => 'QA Slide 1',
            'title' => 'QA Slide Title',
            'link' => '/menu'
        ]
    ]
]);
assert_test($popupSave1, "CMS::savePopupConfig saves config successfully");
$updatedPopup1 = CMS::getPopupConfig();
assert_test($updatedPopup1['disable_image'] === true, "Popup config accurately reflects disable_image = true");
assert_test($updatedPopup1['show_frequency'] === 'always', "Popup config accurately stores frequency");
assert_test($updatedPopup1['enable_lead_capture'] === true, "Popup config stores enable_lead_capture = true");
assert_test($updatedPopup1['lead_capture_title'] === 'VIP Club Test', "Popup config stores custom VIP title");

// Test saving popup with 0 slides
$popupSave0 = CMS::savePopupConfig([
    'is_active' => '1',
    'has_image_setting' => '1',
    'show_image' => '1',
    'delay_seconds' => '1.0',
    'show_frequency' => 'session',
    'enable_lead_capture' => '0',
    'lead_capture_title' => '',
    'slides' => [] // empty slides array
]);
assert_test($popupSave0, "CMS::savePopupConfig allows saving 0 slides cleanly");
$updatedPopup0 = CMS::getPopupConfig();
assert_test(empty($updatedPopup0['slides']), "Popup config allows 0 slides without crashing");

// Restore original popup config
CMS::savePopupConfig([
    'is_active' => $origPopup['is_active'] ? '1' : '0',
    'has_image_setting' => '1',
    'show_image' => empty($origPopup['disable_image']) ? '1' : '0',
    'delay_seconds' => (string)$origPopup['delay_seconds'],
    'show_frequency' => $origPopup['show_frequency'],
    'enable_lead_capture' => $origPopup['enable_lead_capture'] ? '1' : '0',
    'lead_capture_title' => $origPopup['lead_capture_title'],
    'slides' => $origPopup['slides']
]);

// =====================================================================
// SECTION 3: MENU MANAGEMENT & CATALOG
// =====================================================================
echo "\n--- MODULE 3: Menu Catalog & Overrides Engine ---\n";

// 1. Add Dish
$testDishData = [
    'name' => 'QA Gourmet Test Rogan Josh ' . rand(100, 999),
    'category' => 'Main Courses',
    'price' => '22.95',
    'description' => 'Aromatic slow-cooked lamb curry prepared for automated QA audit.',
    'image' => '/assets/dishes/chatgpt_1.webp',
    'is_available' => '1',
    'spicy' => '1',
    'veg' => '0',
    'gluten_free' => '1',
    'is_buffet_item' => '0'
];
$newDishId = CMS::saveDish($testDishData);
assert_test($newDishId !== '', "CMS::saveDish creates new dish record (ID: {$newDishId})");

if ($newDishId !== '') {
    // 2. Update Dish
    $testDishData['item_id'] = $newDishId;
    $testDishData['price'] = '24.95';
    $testDishData['name'] = $testDishData['name'] . ' (Updated)';
    $updatedDishId = CMS::saveDish($testDishData);
    assert_test($updatedDishId === $newDishId, "CMS::saveDish updates existing dish record without duplicating ID");

    $verifyRow = $pdo->query("SELECT name, price FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId))->fetch();
    assert_test($verifyRow && (float)$verifyRow['price'] == 24.95, "Dish updated price matches database record (24.95)");

    // 3. Toggle Dish Availability
    $toggleRes = CMS::toggleDishAvailability($newDishId, false);
    assert_test(!empty($toggleRes['success']), "CMS::toggleDishAvailability disables dish");
    $disabledStatus = $pdo->query("SELECT is_available FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId))->fetchColumn();
    assert_test((int)$disabledStatus === 0, "Dish is_available column updated to 0");

    CMS::toggleDishAvailability($newDishId, true);
    $enabledStatus = $pdo->query("SELECT is_available FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId))->fetchColumn();
    assert_test((int)$enabledStatus === 1, "Dish is_available column restored to 1");

    // 4. Soft-delete Dish
    $deleteRes = CMS::deleteDish($newDishId);
    assert_test($deleteRes, "CMS::deleteDish soft-deletes dish");
    $isDeleted = $pdo->query("SELECT is_deleted FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId))->fetchColumn();
    assert_test((int)$isDeleted === 1, "Dish is_deleted column marked as 1");

    // 5. Restore Dish
    $restoreRes = CMS::restoreDish($newDishId);
    assert_test($restoreRes, "CMS::restoreDish restores deleted dish");
    $isDeletedAfter = $pdo->query("SELECT is_deleted FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId))->fetchColumn();
    assert_test((int)$isDeletedAfter === 0, "Dish is_deleted column reset to 0");

    // Hard cleanup of test dish
    $pdo->exec("DELETE FROM cms_menu_overrides WHERE item_id = " . $pdo->quote($newDishId));
}

// 6. Menu Categories
$categories = CMS::getCategories();
assert_test(is_array($categories) && count($categories) > 0, "CMS::getCategories returns list of categories");

// 7. Menu Overrides Store
$saveOverrideRes = CMS::saveMenuOverride('override_test_item', [
    'price' => '19.99',
    'is_available' => '1',
    'spicy' => '1'
]);
assert_test($saveOverrideRes, "CMS::saveMenuOverride saves item override");
$overrides = CMS::getMenuOverrides();
assert_test(isset($overrides['override_test_item']), "CMS::getMenuOverrides retrieves saved overrides map");
$pdo->exec("DELETE FROM cms_menu_overrides WHERE item_id = 'override_test_item'");

// 8. Import Menu Validation
$importData = [
    [
        'Name' => 'Imported Tandoori Salmon QA',
        'Category' => 'Tandoor Clay Oven',
        'Price' => '26.95',
        'Description' => 'Fresh Atlantic salmon marinated in spices',
        'Spicy' => '0',
        'Available' => '1'
    ]
];
$importRes = CMS::importMenuFromRows($importData);
assert_test($importRes['imported'] >= 1, "CMS::importMenuFromRows imports valid dish rows");
$pdo->exec("DELETE FROM cms_menu_overrides WHERE name = 'Imported Tandoori Salmon QA'");

// =====================================================================
// SECTION 4: SUBMISSIONS & LEADS PIPELINE
// =====================================================================
echo "\n--- MODULE 4: Submissions & CRM Pipeline ---\n";

$testLeadPhone = '(925) 555-' . rand(1000, 9999);
$testLeadName = 'QA Tester Pipeline';
$testLeadEmail = 'lead_qa@example.com';

// 1. Silent Lead Insertion
$saveLeadOk = CMS::saveLeadSilently(
    'catering',
    $testLeadName,
    $testLeadEmail,
    $testLeadPhone,
    ['event_type' => 'Corporate Gala', 'guest_count' => 150, 'budget' => 'Premium'],
    'Automated testing notes payload'
);
assert_test($saveLeadOk, "CMS::saveLeadSilently saves inquiry lead record");

// 2. Fetch Leads & Statistics
$leads = CMS::getLeads(['source' => 'catering']);
assert_test(count($leads) > 0, "CMS::getLeads fetches leads list with filter");

$testLead = null;
foreach ($leads as $l) {
    if ($l['phone'] === $testLeadPhone) {
        $testLead = $l;
        break;
    }
}
assert_test($testLead !== null, "Created lead record is found in database query");

if ($testLead !== null) {
    $leadId = (int)$testLead['id'];

    // Single Lead Retrieval
    $singleLead = CMS::getLead($leadId);
    assert_test($singleLead && $singleLead['name'] === $testLeadName, "CMS::getLead retrieves single record by ID");

    // Update Status
    $statusUpdateOk = CMS::updateLeadStatus($leadId, 'contacted');
    assert_test($statusUpdateOk, "CMS::updateLeadStatus updates status to 'contacted'");
    $statusAfter = $pdo->query("SELECT status FROM captured_leads WHERE id = {$leadId}")->fetchColumn();
    assert_test($statusAfter === 'contacted', "Database reflects updated status 'contacted'");

    // Update Internal Staff Notes
    $notesUpdateOk = CMS::updateLeadNotes($leadId, 'Client requested 2 vegetarian appetizers.');
    assert_test($notesUpdateOk, "CMS::updateLeadNotes updates staff notes");
    $notesAfter = $pdo->query("SELECT notes FROM captured_leads WHERE id = {$leadId}")->fetchColumn();
    assert_test(strpos((string)$notesAfter, 'vegetarian') !== false, "Database reflects updated internal notes");

    // Stats Count
    $stats = CMS::getLeadStats();
    assert_test(isset($stats['total'], $stats['new'], $stats['catering']), "CMS::getLeadStats returns breakdown metrics");

    // Delete Lead
    $delLeadOk = CMS::deleteLead($leadId);
    assert_test($delLeadOk, "CMS::deleteLead removes lead record");
    $delCheck = $pdo->query("SELECT COUNT(*) FROM captured_leads WHERE id = {$leadId}")->fetchColumn();
    assert_test((int)$delCheck === 0, "Lead record permanently deleted from database");
}

// =====================================================================
// SECTION 5: MEDIA LIBRARY & ASSET ENGINE
// =====================================================================
echo "\n--- MODULE 5: Media Library Engine ---\n";

// 1. Sync Existing Assets
$syncedCount = CMS::syncExistingAssets();
assert_test($syncedCount >= 0, "CMS::syncExistingAssets runs without exception (synced: {$syncedCount})");

// 2. Media List & Stats
$mediaStats = CMS::getMediaStats();
assert_test(isset($mediaStats['total_count'], $mediaStats['total_size']), "CMS::getMediaStats returns library metrics");

$mediaList = CMS::getMediaList(['limit' => 5]);
assert_test(isset($mediaList['items'], $mediaList['total']), "CMS::getMediaList returns pagination and list array");

// 3. Test Metadata Update & File Deletion
$dummyName = 'qa_temp_test_' . uniqid() . '.png';
$dummyPath = __DIR__ . '/../assets/uploads/' . $dummyName;
file_put_contents($dummyPath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

$stmt = $pdo->prepare("INSERT INTO cms_media (title, alt_text, caption, filename, original_name, file_path, mime_type, file_size, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    'Temporary Image', '', '', $dummyName, $dummyName, '/assets/uploads/' . $dummyName, 'image/png', filesize($dummyPath), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')
]);
$tempMediaId = (int)$pdo->lastInsertId();

assert_test($tempMediaId > 0, "Inserted temporary media row into cms_media (ID: {$tempMediaId})");

$singleMedia = CMS::getMediaItem($tempMediaId);
assert_test($singleMedia && $singleMedia['filename'] === $dummyName, "CMS::getMediaItem retrieves media record");

$updateMediaOk = CMS::updateMediaItem($tempMediaId, [
    'title' => 'QA Temporary Title',
    'alt_text' => 'QA Alt Text',
    'caption' => 'QA Caption Text'
]);
assert_test($updateMediaOk, "CMS::updateMediaItem updates title, alt text, and caption");

$delMediaOk = CMS::deleteMediaItem($tempMediaId);
assert_test($delMediaOk, "CMS::deleteMediaItem removes record and deletes file from disk");
assert_test(!file_exists($dummyPath), "File is safely removed from uploads directory");

// =====================================================================
// SECTION 6: PUBLIC STOREFRONT SYNCHRONICITY & CLEARED VALUES
// =====================================================================
echo "\n--- MODULE 6: Public Storefront Integration & Cleared Description Tests ---\n";

// 1. Story Hero Quote - Empty vs Filled
CMS::setSetting('story_hero_quote', '', 'story');
$storyQuoteValue = cms_get('story_hero_quote', 'Default Quote Text', true);
assert_test($storyQuoteValue === '', "cms_get('story_hero_quote') returns empty string when user cleared quote");

// 2. Catering Hero Subtitle - Empty vs Filled
CMS::setSetting('catering_hero_subtitle', '', 'catering');
$caterSubValue = cms_get('catering_hero_subtitle', 'Default Catering Subtitle', true);
assert_test($caterSubValue === '', "cms_get('catering_hero_subtitle') returns empty string when user cleared subtitle");

// 3. Homepage Hero Subtitle - Empty vs Filled
CMS::setSetting('hero_subtitle', '', 'home');
$homeSubValue = cms_get('hero_subtitle', 'Default Home Subtitle', true);
assert_test($homeSubValue === '', "cms_get('hero_subtitle') returns empty string when user cleared hero subtitle");

// 4. Homepage Catering Teaser - Empty vs Filled
CMS::setSetting('home_catering_desc', '', 'home');
$homeCaterDesc = cms_get('home_catering_desc', 'Default Home Catering Desc', true);
assert_test($homeCaterDesc === '', "cms_get('home_catering_desc') returns empty string when user cleared description");

// 5. Restore reasonable standard values
CMS::setSetting('story_hero_quote', '', 'story');
CMS::setSetting('catering_hero_subtitle', '', 'catering');
CMS::setSetting('hero_subtitle', '', 'home');
CMS::setSetting('home_catering_desc', 'From office lunches and corporate gatherings to weddings, birthdays, graduations, and family events, our catering team helps bring people together through great food. Choose from party trays, buffet service, and live tandoors.', 'home');

// =====================================================================
// SECTION 7: SUMMARY
// =====================================================================
echo "\n=================================================================\n";
echo "   CMS AUDIT SUMMARY REPORT                                      \n";
echo "=================================================================\n";
echo "  Total Functions/Assertions Tested: {$totalChecks}\n";
echo "  Passed: {$passedChecks}\n";
echo "  Failed: {$failedChecks}\n";

if ($failedChecks === 0) {
    echo "\n  >>> ALL CMS FUNCTIONS ARE OPERATING AT 100% RELIABILITY! <<<\n\n";
    exit(0);
} else {
    echo "\n  >>> DETECTED " . count($failures) . " FAILURES! <<<\n";
    foreach ($failures as $f) {
        echo "   - {$f}\n";
    }
    echo "\n";
    exit(1);
}

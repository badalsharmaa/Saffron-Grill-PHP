<?php
/**
 * Saffron Grill — Central CMS Helper
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

class CMS {
    // ----------------------------------------------------------------------
    // Settings Management
    // ----------------------------------------------------------------------

    public static function getSetting(string $key, ?string $default = null): ?string {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT setting_value FROM cms_settings WHERE setting_key = ? LIMIT 1");
            $stmt->execute([$key]);
            $val = $stmt->fetchColumn();
            return ($val !== false && $val !== null) ? (string)$val : $default;
        } catch (Exception $e) {
            error_log('CMS::getSetting error: ' . $e->getMessage());
            return $default;
        }
    }

    public static function getAllSettings(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $rows = $pdo->query("SELECT setting_key, setting_value, setting_group FROM cms_settings ORDER BY setting_group ASC, setting_key ASC")->fetchAll();
            $map = [];
            foreach ($rows as $r) {
                $map[$r['setting_key']] = $r['setting_value'];
            }
            return $map;
        } catch (Exception $e) {
            error_log('CMS::getAllSettings error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getSettingsByGroup(string $group): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM cms_settings WHERE setting_group = ?");
            $stmt->execute([$group]);
            $rows = $stmt->fetchAll();
            $map = [];
            foreach ($rows as $r) {
                $map[$r['setting_key']] = $r['setting_value'];
            }
            return $map;
        } catch (Exception $e) {
            error_log('CMS::getSettingsByGroup error: ' . $e->getMessage());
            return [];
        }
    }

    public static function setSetting(string $key, ?string $value, string $group = 'general'): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO cms_settings (setting_key, setting_value, setting_group, updated_at) 
                VALUES (?, ?, ?, ?)
                ON CONFLICT(setting_key) DO UPDATE SET 
                    setting_value = excluded.setting_value,
                    setting_group = excluded.setting_group,
                    updated_at = excluded.updated_at");
            return $stmt->execute([$key, $value, $group, $now]);
        } catch (Exception $e) {
            error_log('CMS::setSetting error: ' . $e->getMessage());
            return false;
        }
    }

    // ----------------------------------------------------------------------
    // Popup Configuration
    // ----------------------------------------------------------------------

    public static function getPopupConfig(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->query("SELECT * FROM cms_popups ORDER BY id ASC LIMIT 1");
            $cfg = $stmt->fetch();
            if ($cfg) {
                $slides = json_decode($cfg['slides_json'] ?? '[]', true);
                if (!is_array($slides)) {
                    $slides = [];
                }
                return [
                    'id' => (int)$cfg['id'],
                    'is_active' => (bool)$cfg['is_active'],
                    'delay_seconds' => (float)$cfg['delay_seconds'],
                    'show_frequency' => (string)($cfg['show_frequency'] ?? 'session'),
                    'disable_image' => (bool)($cfg['disable_image'] ?? 0),
                    'enable_lead_capture' => (bool)($cfg['enable_lead_capture'] ?? 0),
                    'lead_capture_title' => (string)($cfg['lead_capture_title'] ?? 'Get Special Offers & 10% Off'),
                    'slides' => $slides
                ];
            }
        } catch (Exception $e) {
            error_log('CMS::getPopupConfig error: ' . $e->getMessage());
        }

        return [
            'id' => 1,
            'is_active' => true,
            'delay_seconds' => 1.5,
            'show_frequency' => 'session',
            'disable_image' => false,
            'enable_lead_capture' => false,
            'lead_capture_title' => 'Join Saffron VIP Club for Exclusive Offers',
            'slides' => [
                [
                    'id' => 1,
                    'image' => '/assets/hero2-first-frame.jpg',
                    'alt' => 'Daily Grand Lunch Buffet Feast',
                    'title' => 'Daily Grand Lunch Buffet',
                    'link' => '/menu'
                ]
            ]
        ];
    }

    public static function savePopupConfig(array $data): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $isActive = !empty($data['is_active']) ? 1 : 0;
            if (isset($data['has_image_setting'])) {
                $disableImage = !empty($data['show_image']) ? 0 : 1;
            } elseif (isset($data['disable_image'])) {
                $disableImage = !empty($data['disable_image']) ? 1 : 0;
            } elseif (isset($data['show_image'])) {
                $disableImage = !empty($data['show_image']) ? 0 : 1;
            } else {
                $disableImage = 0;
            }
            $delay = (float)($data['delay_seconds'] ?? 1.5);
            $frequency = in_array($data['show_frequency'] ?? '', ['always', 'session', 'once']) ? $data['show_frequency'] : 'session';
            $enableLeadCapture = !empty($data['enable_lead_capture']) ? 1 : 0;
            $leadTitle = trim((string)($data['lead_capture_title'] ?? 'Get Special Offers & 10% Off'));

            $slides = [];
            if (!empty($data['slides']) && is_array($data['slides'])) {
                foreach ($data['slides'] as $s) {
                    if (!empty($s['image']) || !empty($s['title'])) {
                        $slides[] = [
                            'id' => !empty($s['id']) ? (int)$s['id'] : count($slides) + 1,
                            'image' => trim((string)($s['image'] ?? '')),
                            'alt' => trim((string)($s['alt'] ?? '')),
                            'title' => trim((string)($s['title'] ?? '')),
                            'link' => trim((string)($s['link'] ?? '/menu'))
                        ];
                    }
                }
            }

            $slidesJson = json_encode($slides, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $now = date('Y-m-d H:i:s');

            $count = (int)$pdo->query("SELECT COUNT(*) FROM cms_popups")->fetchColumn();
            if ($count === 0) {
                $stmt = $pdo->prepare("INSERT INTO cms_popups (is_active, delay_seconds, show_frequency, slides_json, disable_image, enable_lead_capture, lead_capture_title, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                return $stmt->execute([$isActive, $delay, $frequency, $slidesJson, $disableImage, $enableLeadCapture, $leadTitle, $now]);
            } else {
                $stmt = $pdo->prepare("UPDATE cms_popups SET is_active = ?, delay_seconds = ?, show_frequency = ?, slides_json = ?, disable_image = ?, enable_lead_capture = ?, lead_capture_title = ?, updated_at = ? WHERE id = (SELECT id FROM cms_popups ORDER BY id ASC LIMIT 1)");
                return $stmt->execute([$isActive, $delay, $frequency, $slidesJson, $disableImage, $enableLeadCapture, $leadTitle, $now]);
            }
        } catch (Exception $e) {
            error_log('CMS::savePopupConfig error: ' . $e->getMessage());
            return false;
        }
    }

    // ----------------------------------------------------------------------
    // Menu Overrides & Dishes Management
    // ----------------------------------------------------------------------

    public static function getMenuOverrides(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $rows = $pdo->query("SELECT * FROM cms_menu_overrides")->fetchAll();
            $map = [];
            foreach ($rows as $r) {
                $map[(string)$r['item_id']] = [
                    'item_id' => (string)$r['item_id'],
                    'name' => $r['name'],
                    'category' => $r['category'],
                    'description' => $r['description'],
                    'image' => $r['image'],
                    'price' => (float)($r['price'] ?? 0),
                    'is_available' => (bool)($r['is_available'] ?? 1),
                    'spicy' => (bool)($r['spicy'] ?? 0),
                    'veg' => (bool)($r['veg'] ?? 0),
                    'gluten_free' => (bool)($r['gluten_free'] ?? 0),
                    'is_buffet_item' => (bool)($r['is_buffet_item'] ?? 0),
                    'is_deleted' => (bool)($r['is_deleted'] ?? 0),
                    'is_custom' => (bool)($r['is_custom'] ?? 0),
                    'updated_at' => $r['updated_at']
                ];
            }
            return $map;
        } catch (Exception $e) {
            error_log('CMS::getMenuOverrides error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getNextDishId(): int {
        try {
            $pdo = CMSDatabase::getConnection();
            $maxDb = 0;
            $rows = $pdo->query("SELECT item_id FROM cms_menu_overrides")->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $idVal) {
                if (is_numeric($idVal) && (int)$idVal > $maxDb) {
                    $maxDb = (int)$idVal;
                }
            }
            return max($maxDb, 1000) + 1;
        } catch (Exception $e) {
            return 1001;
        }
    }

    public static function saveDish(array $data): string {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');

            $itemId = trim((string)($data['item_id'] ?? ''));
            $isCustom = 0;
            if ($itemId === '' || $itemId === '0') {
                $itemId = (string)self::getNextDishId();
                $isCustom = 1;
            }

            $name = trim((string)($data['name'] ?? ''));
            $category = trim((string)($data['category'] ?? 'Appetizers'));
            $description = trim((string)($data['description'] ?? ''));
            $image = trim((string)($data['image'] ?? ''));
            $price = (float)($data['price'] ?? 0);
            $isAvailable = !empty($data['is_available']) ? 1 : 0;
            $spicy = !empty($data['spicy']) ? 1 : 0;
            $veg = !empty($data['veg']) ? 1 : 0;
            $glutenFree = !empty($data['gluten_free']) ? 1 : 0;
            $isBuffet = !empty($data['is_buffet_item']) ? 1 : 0;

            if ($name === '') {
                return '';
            }

            $stmt = $pdo->prepare("INSERT INTO cms_menu_overrides 
                (item_id, name, category, description, image, price, is_available, spicy, veg, gluten_free, is_buffet_item, is_deleted, is_custom, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?)
                ON CONFLICT(item_id) DO UPDATE SET
                    name = excluded.name,
                    category = excluded.category,
                    description = excluded.description,
                    image = excluded.image,
                    price = excluded.price,
                    is_available = excluded.is_available,
                    spicy = excluded.spicy,
                    veg = excluded.veg,
                    gluten_free = excluded.gluten_free,
                    is_buffet_item = excluded.is_buffet_item,
                    is_deleted = 0,
                    updated_at = excluded.updated_at");

            $stmt->execute([
                $itemId, $name, $category, $description, $image, $price,
                $isAvailable, $spicy, $veg, $glutenFree, $isBuffet, $isCustom, $now
            ]);

            return $itemId;
        } catch (Exception $e) {
            error_log('CMS::saveDish error: ' . $e->getMessage());
            return '';
        }
    }

    public static function deleteDish(string $itemId): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO cms_menu_overrides (item_id, is_deleted, updated_at) 
                VALUES (?, 1, ?)
                ON CONFLICT(item_id) DO UPDATE SET is_deleted = 1, updated_at = excluded.updated_at");
            return $stmt->execute([$itemId, $now]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function restoreDish(string $itemId): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("UPDATE cms_menu_overrides SET is_deleted = 0, updated_at = ? WHERE item_id = ?");
            return $stmt->execute([$now, $itemId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function toggleDishAvailability(string $itemId, bool $enable): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $val = $enable ? 1 : 0;

            $stmt = $pdo->prepare("INSERT INTO cms_menu_overrides (item_id, is_available, updated_at)
                VALUES (?, ?, ?)
                ON CONFLICT(item_id) DO UPDATE SET is_available = excluded.is_available, updated_at = excluded.updated_at");
            $stmt->execute([$itemId, $val, $now]);

            return ['success' => true, 'is_available' => $enable];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function saveMenuOverride(string $itemId, array $data): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');

            $price = isset($data['price']) ? (float)$data['price'] : 0.0;
            $avail = !empty($data['is_available']) ? 1 : 0;
            $spicy = !empty($data['spicy']) ? 1 : 0;
            $veg = !empty($data['veg']) ? 1 : 0;
            $gf = !empty($data['gluten_free']) ? 1 : 0;

            $stmt = $pdo->prepare("INSERT INTO cms_menu_overrides 
                (item_id, price, is_available, spicy, veg, gluten_free, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON CONFLICT(item_id) DO UPDATE SET
                    price = excluded.price,
                    is_available = excluded.is_available,
                    spicy = excluded.spicy,
                    veg = excluded.veg,
                    gluten_free = excluded.gluten_free,
                    updated_at = excluded.updated_at");

            return $stmt->execute([$itemId, $price, $avail, $spicy, $veg, $gf, $now]);
        } catch (Exception $e) {
            return false;
        }
    }

    // ----------------------------------------------------------------------
    // Form Submissions & Leads Management
    // ----------------------------------------------------------------------

    public static function saveLeadSilently(
        string $source,
        ?string $name,
        ?string $email,
        ?string $phone,
        array $details = [],
        ?string $ip = null
    ): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $clientIp = $ip ?: ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

            $stmt = $pdo->prepare("INSERT INTO captured_leads (source, name, email, phone, details_json, ip_address, created_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'new')");
            return $stmt->execute([
                $source,
                $name ? strip_tags(trim($name)) : null,
                $email ? filter_var(trim($email), FILTER_SANITIZE_EMAIL) : null,
                $phone ? strip_tags(trim($phone)) : null,
                json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                $clientIp,
                $now
            ]);
        } catch (Exception $e) {
            error_log('CMS::saveLeadSilently failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function getLeads(array $filters = []): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $where = [];
            $params = [];

            if (!empty($filters['source']) && $filters['source'] !== 'all') {
                if ($filters['source'] === 'contact') {
                    $where[] = "source IN ('contact', 'contact_message')";
                } elseif ($filters['source'] === 'reservation' || $filters['source'] === 'reservations') {
                    $where[] = "source IN ('reservation', 'table_reservation')";
                } elseif ($filters['source'] === 'catering') {
                    $where[] = "source IN ('catering', 'catering_inquiry')";
                } elseif ($filters['source'] === 'popup') {
                    $where[] = "source IN ('popup', 'popup_lead')";
                } else {
                    $where[] = "source = ?";
                    $params[] = $filters['source'];
                }
            }

            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                $where[] = "status = ?";
                $params[] = $filters['status'];
            }

            if (!empty($filters['search'])) {
                $term = '%' . trim($filters['search']) . '%';
                $where[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ? OR details_json LIKE ? OR notes LIKE ?)";
                $params[] = $term;
                $params[] = $term;
                $params[] = $term;
                $params[] = $term;
                $params[] = $term;
            }

            $sql = "SELECT * FROM captured_leads";
            if (!empty($where)) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }
            $sql .= " ORDER BY created_at DESC";

            if (!empty($filters['limit'])) {
                $sql .= " LIMIT " . (int)$filters['limit'];
                if (!empty($filters['offset'])) {
                    $sql .= " OFFSET " . (int)$filters['offset'];
                }
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();

            foreach ($rows as &$r) {
                $r['details'] = json_decode($r['details_json'] ?? '{}', true) ?: [];
            }
            unset($r);

            return $rows;
        } catch (Exception $e) {
            error_log('CMS::getLeads error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getLead(int $id): ?array {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM captured_leads WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                $row['details'] = json_decode($row['details_json'] ?? '{}', true) ?: [];
                return $row;
            }
        } catch (Exception $e) {
            error_log('CMS::getLead error: ' . $e->getMessage());
        }
        return null;
    }

    public static function getLeadStats(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $total = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads")->fetchColumn();
            $new = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE status = 'new'")->fetchColumn();
            $reservations = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE source IN ('reservation', 'table_reservation')")->fetchColumn();
            $catering = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE source IN ('catering', 'catering_inquiry')")->fetchColumn();
            $contact = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE source IN ('contact', 'contact_message')")->fetchColumn();
            $popup = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE source IN ('popup', 'popup_lead')")->fetchColumn();

            $totalGuests = 0;
            $catStmt = $pdo->query("SELECT details_json FROM captured_leads WHERE source IN ('catering', 'catering_inquiry', 'reservation', 'table_reservation')");
            while ($row = $catStmt->fetch()) {
                $d = json_decode($row['details_json'] ?? '{}', true);
                if (is_array($d)) {
                    $g = (int)($d['Guests'] ?? $d['guests'] ?? $d['party_size'] ?? 0);
                    $totalGuests += $g;
                }
            }

            return [
                'total' => $total,
                'new' => $new,
                'reservations' => $reservations,
                'catering' => $catering,
                'contact' => $contact,
                'popup' => $popup,
                'total_guests' => $totalGuests
            ];
        } catch (Exception $e) {
            error_log('CMS::getLeadStats error: ' . $e->getMessage());
            return [
                'total' => 0, 'new' => 0, 'reservations' => 0, 'catering' => 0, 'contact' => 0, 'popup' => 0, 'total_guests' => 0
            ];
        }
    }

    public static function getNewLeadsCount(): int {
        try {
            $pdo = CMSDatabase::getConnection();
            return (int)$pdo->query("SELECT COUNT(*) FROM captured_leads WHERE status = 'new'")->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function updateLeadStatus(int $id, string $status): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("UPDATE captured_leads SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function updateLeadNotes(int $id, string $notes): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("UPDATE captured_leads SET notes = ? WHERE id = ?");
            return $stmt->execute([$notes, $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteLead(int $id): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("DELETE FROM captured_leads WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function exportLeadsCsv(array $filters = []): void {
        $leads = self::getLeads($filters);
        $filename = 'saffron_grill_submissions_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // UTF-8 BOM
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, [
            'ID', 'Date', 'Type/Source', 'Status', 'Client Name', 'Email', 'Phone', 'Guests', 'Key Details', 'Internal Staff Notes', 'IP Address'
        ], ',', '"', "\\");

        foreach ($leads as $l) {
            $d = $l['details'] ?? [];
            $guests = $d['Guests'] ?? $d['guests'] ?? $d['party_size'] ?? '';
            $detailsFormatted = [];
            foreach ($d as $k => $v) {
                if ($k === 'Guests' || $k === 'guests') continue;
                if (is_scalar($v) && (string)$v !== '') {
                    $detailsFormatted[] = "{$k}: {$v}";
                }
            }

            fputcsv($out, [
                $l['id'],
                $l['created_at'],
                ucfirst(str_replace('_', ' ', $l['source'])),
                ucfirst($l['status']),
                $l['name'] ?? '',
                $l['email'] ?? '',
                $l['phone'] ?? '',
                $guests,
                implode(' | ', $detailsFormatted),
                $l['notes'] ?? '',
                $l['ip_address'] ?? ''
            ], ',', '"', "\\");
        }

        fclose($out);
        exit;
    }

    // ----------------------------------------------------------------------
    // Category Management
    // ----------------------------------------------------------------------

    public static function getCategories(): array {
        $settingJson = self::getSetting('custom_categories');
        if (!empty($settingJson)) {
            $decoded = json_decode($settingJson, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // Default Saffron Grill Categories
        return [
            ['id' => 'salads-appetizers', 'name' => 'Salads & Appetizers', 'icon' => 'utensils', 'description' => 'Crisp chaats and flavorful street starters.'],
            ['id' => 'clay-oven', 'name' => 'Tandoor Clay Oven Appetizers', 'icon' => 'sparkles', 'description' => 'Sizzling tandoori kebabs, paneer tikka, and meats.'],
            ['id' => 'non-veg-entrees', 'name' => 'Non-Veg Entrées', 'icon' => 'utensils', 'description' => 'Butter chicken, lamb curries, and seafood specialties.'],
            ['id' => 'veg-entrees', 'name' => 'Veg Entrées', 'icon' => 'sparkles', 'description' => 'Rich paneer curries, dal makhani, and slow-cooked vegetables.'],
            ['id' => 'sides', 'name' => 'Sides', 'icon' => 'menu', 'description' => 'Raita, chutneys, papadum, and accompaniments.'],
            ['id' => 'rice-biryani', 'name' => 'Rice & Biryani', 'icon' => 'utensils', 'description' => 'Royal Hyderabadi dum biryani and fragrant basmati rice.'],
            ['id' => 'tandoor-breads', 'name' => 'Breads from Tandoor', 'icon' => 'menu', 'description' => 'Freshly baked garlic naans, rotis, and kulchas.'],
            ['id' => 'desserts', 'name' => 'Desserts', 'icon' => 'sparkles', 'description' => 'Warm gulab jamun, royal rasmalai, and sweet treats.'],
            ['id' => 'drinks', 'name' => 'Drinks', 'icon' => 'utensils', 'description' => 'Mango lassi, spiced chai, and beverages.'],
        ];
    }

    public static function saveCategories(array $categories): bool {
        $clean = [];
        foreach ($categories as $cat) {
            $name = trim((string)($cat['name'] ?? ''));
            if ($name !== '') {
                $id = !empty($cat['id']) ? trim((string)$cat['id']) : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
                $clean[] = [
                    'id' => $id,
                    'name' => $name,
                    'icon' => trim((string)($cat['icon'] ?? 'utensils')),
                    'description' => trim((string)($cat['description'] ?? ''))
                ];
            }
        }
        return self::setSetting('custom_categories', json_encode($clean, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'menu');
    }

    // ----------------------------------------------------------------------
    // Menu CSV & JSON Import / Export
    // ----------------------------------------------------------------------

    public static function exportMenuCsv(): void {
        require_once dirname(__DIR__, 2) . '/data/menu.php';
        global $MENU_ITEMS;

        $filename = 'saffron_grill_menu_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, ['ID', 'Name', 'Category', 'Price', 'Description', 'Image', 'Available', 'Spicy', 'Vegetarian', 'Gluten Free', 'Buffet Item'], ',', '"', "\\");

        $items = $MENU_ITEMS ?? [];
        foreach ($items as $it) {
            fputcsv($out, [
                $it['id'] ?? '',
                $it['name'] ?? '',
                $it['category'] ?? '',
                number_format((float)($it['price'] ?? 0), 2, '.', ''),
                $it['description'] ?? '',
                $it['image'] ?? '',
                !empty($it['is_available']) ? '1' : '0',
                !empty($it['spicy']) ? '1' : '0',
                !empty($it['veg']) ? '1' : '0',
                !empty($it['gluten_free']) ? '1' : '0',
                !empty($it['is_buffet_item']) ? '1' : '0',
            ], ',', '"', "\\");
        }

        fclose($out);
        exit;
    }

    public static function exportMenuJson(): void {
        require_once dirname(__DIR__, 2) . '/data/menu.php';
        global $MENU_ITEMS, $CATEGORIES;

        $filename = 'saffron_grill_menu_' . date('Ymd_His') . '.json';

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo json_encode([
            'generated_at' => date('Y-m-d H:i:s'),
            'categories' => $CATEGORIES ?? [],
            'items' => $MENU_ITEMS ?? []
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function importMenuFromRows(array $rows): array {
        $count = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $name = trim((string)($row['Name'] ?? $row['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $id = trim((string)($row['ID'] ?? $row['id'] ?? ''));
            $priceRaw = $row['Price'] ?? $row['price'] ?? 0;
            $price = (float)preg_replace('/[^0-9.]/', '', (string)$priceRaw);

            $saveData = [
                'item_id' => $id,
                'name' => $name,
                'category' => trim((string)($row['Category'] ?? $row['category'] ?? 'Appetizers')),
                'description' => trim((string)($row['Description'] ?? $row['description'] ?? '')),
                'image' => trim((string)($row['Image'] ?? $row['image'] ?? '')),
                'price' => $price,
                'is_available' => isset($row['Available']) ? (!empty($row['Available']) ? 1 : 0) : 1,
                'spicy' => !empty($row['Spicy']) || !empty($row['spicy']) ? 1 : 0,
                'veg' => !empty($row['Vegetarian']) || !empty($row['veg']) ? 1 : 0,
                'gluten_free' => !empty($row['Gluten Free']) || !empty($row['gluten_free']) ? 1 : 0,
                'is_buffet_item' => !empty($row['Buffet Item']) || !empty($row['is_buffet_item']) ? 1 : 0
            ];

            $resId = self::saveDish($saveData);
            if ($resId !== '') {
                $count++;
            } else {
                $errors[] = "Row " . ($index + 1) . " ({$name}) failed to import.";
            }
        }

        return ['imported' => $count, 'errors' => $errors];
    }

    // ----------------------------------------------------------------------
    // WordPress-Style Media Library
    // ----------------------------------------------------------------------

    public static function getMediaList(array $filters = []): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $where = [];
            $params = [];

            if (!empty($filters['search'])) {
                $s = '%' . trim($filters['search']) . '%';
                $where[] = "(title LIKE ? OR filename LIKE ? OR original_name LIKE ? OR alt_text LIKE ?)";
                $params[] = $s; $params[] = $s; $params[] = $s; $params[] = $s;
            }

            if (!empty($filters['mime'])) {
                if ($filters['mime'] === 'image') {
                    $where[] = "mime_type LIKE 'image/%'";
                } elseif ($filters['mime'] === 'document') {
                    $where[] = "(mime_type LIKE '%pdf%' OR mime_type LIKE '%document%' OR mime_type LIKE '%sheet%')";
                }
            }

            if (!empty($filters['month'])) {
                $where[] = "strftime('%Y-%m', created_at) = ?";
                $params[] = $filters['month'];
            }

            $countSql = "SELECT COUNT(*) FROM cms_media";
            if (!empty($where)) {
                $countSql .= " WHERE " . implode(" AND ", $where);
            }
            $countStmt = $pdo->prepare($countSql);
            $countStmt->execute($params);
            $totalCount = (int)$countStmt->fetchColumn();

            $page = max(1, (int)($filters['page'] ?? 1));
            $limit = max(1, (int)($filters['limit'] ?? 48));
            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM cms_media";
            if (!empty($where)) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }
            $sql .= " ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $items = $stmt->fetchAll();

            foreach ($items as &$item) {
                $item['formatted_size'] = self::formatBytes((int)$item['file_size']);
                $item['url'] = $item['file_path'];
                $item['is_image'] = str_starts_with((string)$item['mime_type'], 'image/');
            }
            unset($item);

            return [
                'items' => $items,
                'total' => $totalCount,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => ceil($totalCount / $limit)
            ];
        } catch (Exception $e) {
            error_log('CMS::getMediaList error: ' . $e->getMessage());
            return ['items' => [], 'total' => 0, 'page' => 1, 'limit' => 48, 'total_pages' => 1];
        }
    }

    public static function getMediaMonths(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $rows = $pdo->query("SELECT DISTINCT strftime('%Y-%m', created_at) as month FROM cms_media WHERE created_at IS NOT NULL ORDER BY month DESC")->fetchAll(PDO::FETCH_COLUMN);
            $months = [];
            foreach ($rows as $m) {
                if ($m) {
                    $date = DateTime::createFromFormat('Y-m', $m);
                    $months[] = [
                        'value' => $m,
                        'label' => $date ? $date->format('F Y') : $m
                    ];
                }
            }
            return $months;
        } catch (Exception $e) {
            return [];
        }
    }

    public static function getMediaItem(int $id): ?array {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM cms_media WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item) {
                $item['formatted_size'] = self::formatBytes((int)$item['file_size']);
                $item['url'] = $item['file_path'];
                return $item;
            }
        } catch (Exception $e) {}
        return null;
    }

    public static function updateMediaItem(int $id, array $data): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("UPDATE cms_media SET title = ?, alt_text = ?, caption = ?, updated_at = ? WHERE id = ?");
            return $stmt->execute([
                trim((string)($data['title'] ?? '')),
                trim((string)($data['alt_text'] ?? '')),
                trim((string)($data['caption'] ?? '')),
                $now,
                $id
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteMediaItem(int $id): bool {
        try {
            $pdo = CMSDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT file_path FROM cms_media WHERE id = ?");
            $stmt->execute([$id]);
            $rel = $stmt->fetchColumn();

            if ($rel) {
                $abs = dirname(__DIR__, 2) . '/' . ltrim($rel, '/');
                if (file_exists($abs) && is_file($abs)) {
                    @unlink($abs);
                }
            }

            $delStmt = $pdo->prepare("DELETE FROM cms_media WHERE id = ?");
            return $delStmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function processUploadedMedia(array $file): array {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'File upload error code: ' . $file['error']];
        }

        if ($file['size'] > 15 * 1024 * 1024) {
            return ['success' => false, 'error' => 'File size exceeds maximum 15MB limit.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowedMimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            'application/pdf' => 'pdf'
        ];

        if (!isset($allowedMimes[$mime])) {
            return ['success' => false, 'error' => 'Unsupported file type (' . $mime . '). Allowed: JPG, PNG, WEBP, GIF, PDF.'];
        }

        $ext = $allowedMimes[$mime];
        $uploadDir = dirname(__DIR__, 2) . '/assets/uploads';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $cleanOrig = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanOrig = preg_replace('/[^a-zA-Z0-9_\-]+/', '_', $cleanOrig);
        $filename = 'sg_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(4)), 0, 6) . '.' . $ext;
        $destPath = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            return ['success' => false, 'error' => 'Failed to save file to uploads folder. Check permissions.'];
        }

        $webPath = '/assets/uploads/' . $filename;
        $width = 0; $height = 0;
        if (str_starts_with($mime, 'image/')) {
            $dims = @getimagesize($destPath);
            if ($dims) {
                $width = $dims[0];
                $height = $dims[1];
            }
        }

        $pdo = CMSDatabase::getConnection();
        $now = date('Y-m-d H:i:s');
        $title = ucwords(str_replace(['_', '-'], ' ', $cleanOrig));

        $stmt = $pdo->prepare("INSERT INTO cms_media 
            (title, alt_text, caption, filename, original_name, file_path, thumb_path, mime_type, file_size, width, height, folder, created_at, updated_at)
            VALUES (?, '', '', ?, ?, ?, ?, ?, ?, ?, ?, 'uploads', ?, ?)");
        $stmt->execute([
            $title, $filename, $file['name'], $webPath, $webPath, $mime, $file['size'], $width, $height, $now, $now
        ]);

        $newId = (int)$pdo->lastInsertId();

        return [
            'success' => true,
            'item' => [
                'id' => $newId,
                'title' => $title,
                'filename' => $filename,
                'file_path' => $webPath,
                'url' => $webPath,
                'mime_type' => $mime,
                'file_size' => $file['size'],
                'formatted_size' => self::formatBytes($file['size']),
                'width' => $width,
                'height' => $height,
                'created_at' => $now
            ]
        ];
    }

    public static function syncExistingAssets(): int {
        $pdo = CMSDatabase::getConnection();
        $baseDir = dirname(__DIR__, 2);
        $targetDirs = [
            $baseDir . '/assets' => '/assets/',
            $baseDir . '/assets/uploads' => '/assets/uploads/'
        ];

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf'];
        $existingPaths = $pdo->query("SELECT file_path FROM cms_media")->fetchAll(PDO::FETCH_COLUMN);
        $existingMap = array_flip($existingPaths);

        $now = date('Y-m-d H:i:s');
        $insStmt = $pdo->prepare("INSERT INTO cms_media 
            (title, alt_text, caption, filename, original_name, file_path, thumb_path, mime_type, file_size, width, height, folder, created_at, updated_at)
            VALUES (?, '', '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $synced = 0;
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        foreach ($targetDirs as $absDir => $webPrefix) {
            if (!is_dir($absDir)) continue;
            $files = scandir($absDir);
            foreach ($files as $f) {
                if ($f === '.' || $f === '..' || str_starts_with($f, '.')) continue;
                $full = $absDir . '/' . $f;
                if (!is_file($full)) continue;

                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExts, true)) continue;

                $webPath = $webPrefix . $f;
                if (isset($existingMap[$webPath])) continue;

                $mime = $finfo->file($full) ?: 'application/octet-stream';
                $size = filesize($full);
                $width = 0; $height = 0;
                if (str_starts_with($mime, 'image/')) {
                    $dims = @getimagesize($full);
                    if ($dims) {
                        $width = $dims[0];
                        $height = $dims[1];
                    }
                }

                $title = ucwords(str_replace(['_', '-'], ' ', pathinfo($f, PATHINFO_FILENAME)));
                $folder = str_contains($webPrefix, 'uploads') ? 'uploads' : 'general';

                $insStmt->execute([
                    $title, $f, $f, $webPath, $webPath, $mime, $size, $width, $height, $folder, $now, $now
                ]);
                $existingMap[$webPath] = true;
                $synced++;
            }
        }

        return $synced;
    }

    public static function getMediaStats(): array {
        try {
            $pdo = CMSDatabase::getConnection();
            $totalCount = (int)$pdo->query("SELECT COUNT(*) FROM cms_media")->fetchColumn();
            $imageCount = (int)$pdo->query("SELECT COUNT(*) FROM cms_media WHERE mime_type LIKE 'image/%'")->fetchColumn();
            $totalSize = (int)$pdo->query("SELECT SUM(file_size) FROM cms_media")->fetchColumn();

            return [
                'total_count' => $totalCount,
                'image_count' => $imageCount,
                'total_size' => $totalSize,
                'formatted_size' => self::formatBytes($totalSize)
            ];
        } catch (Exception $e) {
            return ['total_count' => 0, 'image_count' => 0, 'total_size' => 0, 'formatted_size' => '0 B'];
        }
    }

    public static function formatBytes(int $bytes, int $precision = 1): string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

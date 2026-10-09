<?php
/**
 * Saffron Grill — CMS Database Layer (SQLite)
 */

require_once __DIR__ . '/config.php';

class CMSDatabase {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            $dbPath = CMS_DB_PATH;
            $dir = dirname($dbPath);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }

            try {
                self::$pdo = new PDO('sqlite:' . $dbPath);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                // Enable foreign keys and WAL mode for high concurrency
                self::$pdo->exec('PRAGMA journal_mode = WAL;');
                self::$pdo->exec('PRAGMA foreign_keys = ON;');

                // Run schema creation and initial seeds
                self::initialize();
            } catch (PDOException $e) {
                error_log('CMS DB Error: ' . $e->getMessage());
                die('Database connection error. Please ensure the data directory is writable.');
            }
        }

        return self::$pdo;
    }

    private static function initialize(): void {
        $pdo = self::$pdo;

        // 1. CMS Users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cms_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            role TEXT DEFAULT 'staff',
            status TEXT DEFAULT 'pending',
            created_at TEXT NOT NULL,
            updated_at TEXT NOT NULL
        )");

        // Safe auto-migration for existing users table
        $userCols = [
            'role' => "TEXT DEFAULT 'staff'",
            'status' => "TEXT DEFAULT 'pending'"
        ];
        foreach ($userCols as $colName => $colDef) {
            try {
                $pdo->exec("ALTER TABLE cms_users ADD COLUMN {$colName} {$colDef}");
            } catch (Exception $e) {}
        }

        // Ensure root admin user always has super_admin role and active status
        try {
            $pdo->exec("UPDATE cms_users SET role = 'super_admin', status = 'active' WHERE id = 1 OR username = 'admin'");
        } catch (Exception $e) {}

        // 2. Settings table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cms_settings (
            setting_key TEXT PRIMARY KEY,
            setting_value TEXT,
            setting_group TEXT NOT NULL,
            updated_at TEXT NOT NULL
        )");

        // 3. Popup configuration table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cms_popups (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            is_active INTEGER DEFAULT 1,
            delay_seconds REAL DEFAULT 1.5,
            show_frequency TEXT DEFAULT 'session',
            slides_json TEXT NOT NULL,
            enable_lead_capture INTEGER DEFAULT 0,
            lead_capture_title TEXT DEFAULT 'Get Special Offers & 10% Off',
            updated_at TEXT NOT NULL
        )");

        // 4. Menu overrides table
        $pdo->exec("CREATE TABLE IF NOT EXISTS cms_menu_overrides (
            item_id TEXT PRIMARY KEY,
            name TEXT,
            category TEXT,
            description TEXT,
            image TEXT,
            price REAL,
            is_available INTEGER DEFAULT 1,
            spicy INTEGER DEFAULT 0,
            veg INTEGER DEFAULT 0,
            gluten_free INTEGER DEFAULT 0,
            is_buffet_item INTEGER DEFAULT 0,
            is_deleted INTEGER DEFAULT 0,
            is_custom INTEGER DEFAULT 0,
            updated_at TEXT NOT NULL
        )");

        // 5. Contact Form Submissions & Lead Storage
        $pdo->exec("CREATE TABLE IF NOT EXISTS captured_leads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            source TEXT NOT NULL,
            name TEXT,
            email TEXT,
            phone TEXT,
            details_json TEXT,
            ip_address TEXT,
            created_at TEXT NOT NULL,
            status TEXT DEFAULT 'new',
            notes TEXT
        )");

        $leadCols = [
            'status' => "TEXT DEFAULT 'new'",
            'notes' => "TEXT"
        ];
        foreach ($leadCols as $colName => $colDef) {
            try {
                $pdo->exec("ALTER TABLE captured_leads ADD COLUMN {$colName} {$colDef}");
            } catch (Exception $e) {}
        }

        // 6. Media Library & Asset Manager
        $pdo->exec("CREATE TABLE IF NOT EXISTS cms_media (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            alt_text TEXT DEFAULT '',
            caption TEXT DEFAULT '',
            filename TEXT NOT NULL,
            original_name TEXT NOT NULL,
            file_path TEXT NOT NULL,
            thumb_path TEXT,
            mime_type TEXT NOT NULL,
            file_size INTEGER NOT NULL,
            width INTEGER DEFAULT 0,
            height INTEGER DEFAULT 0,
            folder TEXT DEFAULT 'general',
            created_at TEXT NOT NULL,
            updated_at TEXT NOT NULL
        )");
        $pdo->exec("CREATE INDEX IF NOT EXISTS idx_cms_media_created ON cms_media(created_at DESC)");
        $pdo->exec("CREATE INDEX IF NOT EXISTS idx_cms_media_mime ON cms_media(mime_type)");

        // 7. Seed initial admin user if empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM cms_users");
        if ((int)$stmt->fetchColumn() === 0) {
            $adminUser = getenv('ADMIN_USERNAME') ?: 'admin';
            $adminPass = getenv('ADMIN_PASSWORD') ?: 'SaffronAdmin2026!';
            $adminEmail = getenv('ADMIN_EMAIL') ?: 'gosaffrongrill@gmail.com';
            $initialPassword = password_hash($adminPass, PASSWORD_BCRYPT);
            $now = date('Y-m-d H:i:s');
            $ins = $pdo->prepare("INSERT INTO cms_users (username, password_hash, name, email, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'super_admin', 'active', ?, ?)");
            $ins->execute([
                $adminUser,
                $initialPassword,
                'Saffron Grill Admin',
                $adminEmail,
                $now,
                $now
            ]);
        }

        // 8. Legacy Data Migration from saffron_crm.db if captured_leads is empty
        $legacyDbFile = dirname(__DIR__) . '/admin/data/saffron_crm.db';
        $leadCount = (int)$pdo->query("SELECT COUNT(*) FROM captured_leads")->fetchColumn();
        if ($leadCount === 0 && file_exists($legacyDbFile) && realpath($legacyDbFile) !== realpath(CMS_DB_PATH)) {
            try {
                $legacyPdo = new PDO('sqlite:' . $legacyDbFile);
                $legacyPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

                // Migrate Reservations
                $resRows = $legacyPdo->query("SELECT * FROM reservations ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($resRows)) {
                    $insRes = $pdo->prepare("INSERT INTO captured_leads (source, name, email, phone, details_json, ip_address, created_at, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    foreach ($resRows as $r) {
                        $details = [
                            'Booking Code' => $r['booking_code'] ?? '',
                            'Guests' => (int)($r['party_size'] ?? 2),
                            'Reservation Date' => $r['reservation_date'] ?? '',
                            'Reservation Time' => $r['reservation_time'] ?? '',
                            'Seating Area' => $r['seating_area'] ?? 'Main Dining',
                            'Special Requests' => $r['special_requests'] ?? '',
                            'UTM Source' => $r['utm_source'] ?? '',
                            'UTM Campaign' => $r['utm_campaign'] ?? ''
                        ];
                        $insRes->execute([
                            'reservation',
                            $r['guest_name'] ?? null,
                            $r['email'] ?? null,
                            $r['phone'] ?? null,
                            json_encode($details, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                            $r['ip_address'] ?? '127.0.0.1',
                            $r['created_at'] ?? date('Y-m-d H:i:s'),
                            $r['status'] ?? 'new',
                            $r['special_requests'] ?? null
                        ]);
                    }
                }

                // Migrate Catering Leads
                $leadRows = $legacyPdo->query("SELECT * FROM leads ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($leadRows)) {
                    $insLead = $pdo->prepare("INSERT INTO captured_leads (source, name, email, phone, details_json, ip_address, created_at, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    foreach ($leadRows as $l) {
                        $src = (!empty($l['event_type']) && stripos($l['event_type'], 'contact') !== false) ? 'contact' : 'catering';
                        $details = [
                            'Lead Code' => $l['lead_code'] ?? '',
                            'Event Type' => $l['event_type'] ?? 'Catering',
                            'Event Date' => $l['event_date'] ?? '',
                            'Guests' => (int)($l['guest_count'] ?? 50),
                            'Package' => $l['package_type'] ?? '',
                            'Budget' => $l['budget_estimate'] ?? '',
                            'Venue Location' => $l['venue_location'] ?? '',
                            'Notes' => $l['special_notes'] ?? '',
                            'UTM Campaign' => $l['utm_campaign'] ?? ''
                        ];
                        $insLead->execute([
                            $src,
                            $l['client_name'] ?? null,
                            $l['email'] ?? null,
                            $l['phone'] ?? null,
                            json_encode($details, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                            $l['ip_address'] ?? '127.0.0.1',
                            $l['created_at'] ?? date('Y-m-d H:i:s'),
                            $l['status'] ?? 'new',
                            $l['special_notes'] ?? null
                        ]);
                    }
                }
            } catch (Exception $e) {
                error_log('Legacy migration notice: ' . $e->getMessage());
            }
        }

        // 9. Seed default promotional popup if empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM cms_popups");
        if ((int)$stmt->fetchColumn() === 0) {
            $defaultSlides = [
                [
                    'id' => 1,
                    'image' => '/assets/hero2-first-frame.jpg',
                    'alt' => 'Saffron Grill Daily Lunch Buffet Feast',
                    'title' => 'Daily Grand Lunch Buffet',
                    'link' => '/menu'
                ]
            ];
            $now = date('Y-m-d H:i:s');
            $ins = $pdo->prepare("INSERT INTO cms_popups (is_active, delay_seconds, show_frequency, slides_json, enable_lead_capture, lead_capture_title, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $ins->execute([
                1,
                1.5,
                'session',
                json_encode($defaultSlides, JSON_UNESCAPED_SLASHES),
                0,
                'Join Saffron VIP Club for Exclusive Offers',
                $now
            ]);
        }

        // 10. Seed default Saffron Grill site settings if empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM cms_settings");
        if ((int)$stmt->fetchColumn() === 0) {
            $defaults = [
                // Announcement Bar
                ['announcement_enabled', '1', 'announcement'],
                ['announcement_text', '✨ Daily Grand Lunch Buffet: $19.99 Weekdays & $21.99 Weekends with Fresh Naan & Tandoori Sizzlers!', 'announcement'],
                ['announcement_link', '/menu', 'announcement'],
                ['announcement_bg_color', '#C5A059', 'announcement'],

                // Hero & Branding
                ['hero_badge', 'Regal Indian Gastronomy · San Ramon', 'hero'],
                ['hero_title_line1', 'A Symphony of', 'hero'],
                ['hero_title_line2', 'Indian Heritage', 'hero'],
                ['hero_title_line3', 'and Royal Flavors', 'hero'],
                ['hero_subtitle', 'Experience royal tandoori sizzlers, slow-simmered curries, artisanal fresh naans, and our celebrated daily lunch buffet in the Tri-Valley.', 'hero'],
                ['hero_btn_primary_text', 'Explore Menu', 'hero'],
                ['hero_btn_primary_link', '/menu', 'hero'],
                ['hero_btn_secondary_text', 'Book a Table', 'hero'],
                ['hero_btn_secondary_link', '/reserve', 'hero'],

                // Buffet Settings
                ['buffet_enabled', '1', 'buffet'],
                ['buffet_weekday_price', '$19.99', 'buffet'],
                ['buffet_weekday_hours', 'Mon–Fri: 11:30 AM – 3:00 PM', 'buffet'],
                ['buffet_weekend_price', '$21.99', 'buffet'],
                ['buffet_weekend_hours', 'Sat–Sun: 12:00 PM – 3:30 PM', 'buffet'],
                ['dinner_hours', 'Daily: 5:00 PM – 10:00 PM', 'buffet'],
                ['buffet_paused', '0', 'restaurant_status'],
                ['dinner_closed', '0', 'restaurant_status'],
                ['restaurant_closed_message', 'Online ordering is temporarily paused. Our dining room is currently welcoming guests.', 'restaurant_status'],

                // Location & Contact
                ['restaurant_address', '3191 Crow Canyon Pl, Ste D, San Ramon, CA 94583', 'locations'],
                ['restaurant_phone_primary', '(925) 846-3077', 'locations'],
                ['restaurant_phone_alt', '(925) 369-4696', 'locations'],
                ['contact_email', 'gosaffrongrill@gmail.com', 'contact'],
                ['catering_email', 'gosaffrongrill@gmail.com', 'contact'],
                ['google_maps_url', 'https://maps.google.com/?cid=7708573752697881186', 'locations'],
                ['ordering_url', 'https://order.boons.io/site/saffron-grill/390/y', 'general'],

                // Social Links
                ['instagram_url', 'https://www.instagram.com/saffrongrillrestaurant', 'social'],
                ['facebook_url', 'https://www.facebook.com/profile.php?id=61590010434038', 'social'],
                ['yelp_url', 'https://www.yelp.com/biz/saffron-grill-san-ramon', 'social'],

                // Catering Section
                ['catering_hero_title', 'Royal Feasts for Unforgettable Celebrations', 'catering'],
                ['catering_hero_subtitle', 'Bespoke live tandoori catering, executive corporate lunches, weddings, and private banquets across San Ramon, Dublin, Pleasanton, and the Bay Area.', 'catering'],
                ['catering_stat1_num', '500+', 'catering'],
                ['catering_stat1_label', 'Events Catered', 'catering'],
                ['catering_stat2_num', '20+', 'catering'],
                ['catering_stat2_label', 'Signature Curries', 'catering'],
                ['catering_stat3_num', '100%', 'catering'],
                ['catering_stat3_label', 'Fresh Clay Tandoor', 'catering'],

                // Policies
                ['privacy_updated', 'September 2026', 'policies'],
                ['terms_updated', 'September 2026', 'policies'],
            ];

            $now = date('Y-m-d H:i:s');
            $ins = $pdo->prepare("INSERT INTO cms_settings (setting_key, setting_value, setting_group, updated_at) VALUES (?, ?, ?, ?)");
            foreach ($defaults as $row) {
                $ins->execute([$row[0], $row[1], $row[2], $now]);
            }
        }
    }
}

<?php
/**
 * Saffron Grill - Versioned Database Migrations & Initial Data Seeder
 */

function migrate_schema_if_needed(PDO $pdo, string $driver = 'sqlite'): void {
    static $migrated = false;
    if ($migrated) return;

    $isMysql = ($driver === 'mysql');
    $autoInc = $isMysql ? 'INT AUTO_INCREMENT PRIMARY KEY' : 'INTEGER PRIMARY KEY AUTOINCREMENT';
    $timestamp = $isMysql ? 'DATETIME DEFAULT CURRENT_TIMESTAMP' : 'DATETIME DEFAULT CURRENT_TIMESTAMP';

    // 1. Settings Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        setting_key VARCHAR(100) PRIMARY KEY,
        setting_value TEXT,
        setting_group VARCHAR(50) DEFAULT 'general',
        description VARCHAR(255),
        updated_at $timestamp
    )");

    // 2. Admins Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id $autoInc,
        username VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        email VARCHAR(150),
        role VARCHAR(50) DEFAULT 'admin',
        last_login DATETIME,
        created_at $timestamp
    )");

    // 3. Table Reservations Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS reservations (
        id $autoInc,
        booking_code VARCHAR(32) UNIQUE,
        guest_name VARCHAR(150) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        email VARCHAR(150),
        party_size INT NOT NULL DEFAULT 2,
        reservation_date DATE NOT NULL,
        reservation_time VARCHAR(20) NOT NULL,
        seating_area VARCHAR(50) DEFAULT 'Main Dining',
        special_requests TEXT,
        status VARCHAR(30) DEFAULT 'pending',
        gclid VARCHAR(150),
        utm_source VARCHAR(100),
        utm_medium VARCHAR(100),
        utm_campaign VARCHAR(100),
        ip_address VARCHAR(45),
        created_at $timestamp,
        updated_at $timestamp
    )");

    // 4. Catering & Event Leads Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS leads (
        id $autoInc,
        lead_code VARCHAR(32) UNIQUE,
        client_name VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        event_type VARCHAR(100),
        event_date DATE,
        guest_count INT DEFAULT 50,
        package_type VARCHAR(100),
        budget_estimate VARCHAR(50),
        venue_location VARCHAR(200),
        special_notes TEXT,
        status VARCHAR(30) DEFAULT 'new',
        gclid VARCHAR(150),
        gbraid VARCHAR(150),
        wbraid VARCHAR(150),
        utm_source VARCHAR(100),
        utm_medium VARCHAR(100),
        utm_campaign VARCHAR(100),
        ip_address VARCHAR(45),
        created_at $timestamp,
        updated_at $timestamp
    )");

    // 5. Menu Categories Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu_categories (
        id $autoInc,
        slug VARCHAR(100) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        display_order INT DEFAULT 0,
        description VARCHAR(255),
        is_active INT DEFAULT 1
    )");

    // 6. Menu Items Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu_items (
        id $autoInc,
        category_slug VARCHAR(100) NOT NULL,
        name VARCHAR(150) NOT NULL,
        description TEXT,
        price DECIMAL(8, 2) NOT NULL DEFAULT 0.00,
        is_vegetarian INT DEFAULT 0,
        is_vegan INT DEFAULT 0,
        is_gluten_free INT DEFAULT 0,
        is_spicy INT DEFAULT 0,
        is_buffet_item INT DEFAULT 0,
        is_popular INT DEFAULT 0,
        image_url VARCHAR(255),
        display_order INT DEFAULT 0,
        is_available INT DEFAULT 1,
        created_at $timestamp
    )");

    // 7. Consent Logs Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS consent_logs (
        id $autoInc,
        visitor_id VARCHAR(64),
        consent_status VARCHAR(20) NOT NULL,
        ad_storage VARCHAR(20),
        analytics_storage VARCHAR(20),
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at $timestamp
    )");

    // Seed default admin if table is empty
    $adminCheck = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($adminCheck == 0) {
        $adminUser = getenv('ADMIN_USERNAME') ?: 'admin';
        $adminPass = getenv('ADMIN_PASSWORD') ?: 'SaffronAdmin2026!';
        $adminEmail = getenv('ADMIN_EMAIL') ?: 'gosaffrongrill@gmail.com';
        $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash, email, role) VALUES (?, ?, ?, 'superadmin')");
        $stmt->execute([$adminUser, password_hash($adminPass, PASSWORD_BCRYPT), $adminEmail]);
    }

    // Seed default settings if empty
    $settingsCheck = $pdo->query("SELECT COUNT(*) FROM settings")->fetchColumn();
    if ($settingsCheck == 0) {
        $defaultSettings = [
            'site_name' => 'Saffron Grill',
            'site_tagline' => 'Authentic Indian Cuisine & Lunch Buffet · San Ramon, CA',
            'contact_phone' => '(925) 846-3077',
            'contact_phone_alt' => '(925) 369-4696',
            'contact_email' => 'gosaffrongrill@gmail.com',
            'address_street' => '3191 Crow Canyon Pl, Ste D',
            'address_city' => 'San Ramon',
            'address_state' => 'CA',
            'address_zip' => '94583',
            'geo_lat' => '37.7663',
            'geo_lng' => '-121.9745',
            'buffet_weekday_price' => '$19.99',
            'buffet_weekday_hours' => 'Mon–Fri: 11:30 AM – 3:00 PM',
            'buffet_weekend_price' => '$21.99',
            'buffet_weekend_hours' => 'Sat–Sun: 12:00 PM – 3:30 PM',
            'dinner_hours' => 'Daily: 5:00 PM – 10:00 PM',
            'announcement_banner' => '✨ Daily Grand Lunch Buffet: $19.99 Weekdays & $21.99 Weekends with Fresh Naan & Tandoori Sizzlers!',
            'announcement_active' => '1',
            'gtm_container_id' => '',
            'min_catering_guests' => '25'
        ];

        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, setting_group) VALUES (?, ?, 'general')");
        foreach ($defaultSettings as $k => $v) {
            $stmt->execute([$k, $v]);
        }
    }

    // Seed Menu Categories and Menu Items if empty
    $catCheck = $pdo->query("SELECT COUNT(*) FROM menu_categories")->fetchColumn();
    if ($catCheck == 0) {
        $categories = [
            ['slug' => 'appetizers', 'name' => 'Appetizers & Chaat', 'order' => 1],
            ['slug' => 'tandoori', 'name' => 'Tandoori Sizzlers & Kebabs', 'order' => 2],
            ['slug' => 'chicken-curries', 'name' => 'Chicken Specialties', 'order' => 3],
            ['slug' => 'lamb-goat', 'name' => 'Lamb & Goat Curries', 'order' => 4],
            ['slug' => 'seafood', 'name' => 'Seafood Delicacies', 'order' => 5],
            ['slug' => 'vegetarian', 'name' => 'Vegetarian & Paneer', 'order' => 6],
            ['slug' => 'biryani-rice', 'name' => 'Biryani & Fragrant Rice', 'order' => 7],
            ['slug' => 'tandoori-breads', 'name' => 'Artisanal Naan & Breads', 'order' => 8],
            ['slug' => 'desserts', 'name' => 'Royal Desserts', 'order' => 9],
            ['slug' => 'beverages', 'name' => 'Beverages & Lassi', 'order' => 10],
        ];
        $catStmt = $pdo->prepare("INSERT INTO menu_categories (slug, name, display_order) VALUES (?, ?, ?)");
        foreach ($categories as $c) {
            $catStmt->execute([$c['slug'], $c['name'], $c['order']]);
        }

        // Check if menu JSON file exists to seed full items
        $jsonFile = dirname(dirname(__DIR__)) . '/menu/Saffron_Grill_Menu.json';
        if (file_exists($jsonFile)) {
            $jsonData = json_decode(file_get_contents($jsonFile), true);
            if (is_array($jsonData)) {
                $itemStmt = $pdo->prepare("INSERT INTO menu_items 
                    (category_slug, name, description, price, is_vegetarian, is_spicy, is_popular, display_order) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                $order = 1;
                foreach ($jsonData as $sectionName => $items) {
                    // Map section name to slug
                    $secLower = strtolower($sectionName);
                    $slug = 'appetizers';
                    if (strpos($secLower, 'tandoor') !== false) $slug = 'tandoori';
                    elseif (strpos($secLower, 'chicken') !== false) $slug = 'chicken-curries';
                    elseif (strpos($secLower, 'lamb') !== false || strpos($secLower, 'goat') !== false) $slug = 'lamb-goat';
                    elseif (strpos($secLower, 'sea') !== false || strpos($secLower, 'fish') !== false || strpos($secLower, 'prawn') !== false) $slug = 'seafood';
                    elseif (strpos($secLower, 'veg') !== false || strpos($secLower, 'paneer') !== false) $slug = 'vegetarian';
                    elseif (strpos($secLower, 'biryani') !== false || strpos($secLower, 'rice') !== false) $slug = 'biryani-rice';
                    elseif (strpos($secLower, 'bread') !== false || strpos($secLower, 'naan') !== false) $slug = 'tandoori-breads';
                    elseif (strpos($secLower, 'dessert') !== false || strpos($secLower, 'sweet') !== false) $slug = 'desserts';
                    elseif (strpos($secLower, 'drink') !== false || strpos($secLower, 'beverage') !== false || strpos($secLower, 'lassi') !== false) $slug = 'beverages';

                    if (is_array($items)) {
                        foreach ($items as $item) {
                            $name = $item['name'] ?? ($item['title'] ?? 'Dish');
                            $desc = $item['description'] ?? ($item['desc'] ?? '');
                            $priceRaw = $item['price'] ?? 14.99;
                            $price = (float)preg_replace('/[^0-9.]/', '', (string)$priceRaw);
                            if ($price <= 0) $price = 14.99;
                            $isVeg = (!empty($item['veg']) || stripos($name, 'paneer') !== false || stripos($name, 'samosa') !== false || stripos($name, 'dal') !== false) ? 1 : 0;
                            $isSpicy = (!empty($item['spicy']) || stripos($desc, 'spicy') !== false || stripos($desc, 'chili') !== false) ? 1 : 0;
                            $isPopular = ($order % 3 == 0) ? 1 : 0;

                            $itemStmt->execute([$slug, $name, $desc, $price, $isVeg, $isSpicy, $isPopular, $order++]);
                        }
                    }
                }
            }
        }
        
        // If still 0 items, seed signature essentials
        $itemCount = $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
        if ($itemCount == 0) {
            $essentials = [
                ['appetizers', 'Samosa Trio', 'Crispy spiced potato and green pea pastries served with tamarind and mint chutneys.', 8.99, 1, 0, 1],
                ['appetizers', 'Lahsuni Gobi', 'Crispy cauliflower florets tossed in garlic chilli glaze with scallions.', 11.99, 1, 1, 1],
                ['tandoori', 'Saffron Tandoori Chicken', 'Chicken marinated in saffron yogurt, toasted spices, roasted in clay tandoor.', 18.99, 0, 1, 1],
                ['tandoori', 'Paneer Tikka Sizzler', 'Cottage cheese cubes marinated in ajwain spices, grilled with bell peppers and onions.', 17.99, 1, 0, 1],
                ['tandoori', 'Tandoori Jumbo Prawns', 'Wild ocean prawns marinated in mustard oil, roasted cumin and lemon zest.', 22.99, 0, 1, 1],
                ['chicken-curries', 'Butter Chicken (Murgh Makhani)', 'Tender tandoori chicken simmered in a velvety tomato-cream sauce with fenugreek.', 18.99, 0, 0, 1],
                ['chicken-curries', 'Chicken Tikka Masala', 'Charcoal-grilled chicken breast pieces in a rich, spiced onion-tomato gravy.', 18.99, 0, 1, 1],
                ['lamb-goat', 'Kashmiri Rogan Josh', 'Slow-cooked lamb shank in Kashmiri red chilies, fennel seed, and cardamom.', 20.99, 0, 1, 1],
                ['lamb-goat', 'Traditional Goat Curry', 'Tender bone-in goat simmered with ginger, garlic, and whole garam masala.', 20.99, 0, 1, 1],
                ['vegetarian', 'Paneer Tikka Masala', 'Charred cottage cheese cubes in spiced onion-tomato gravy with cream.', 16.99, 1, 0, 1],
                ['vegetarian', 'Dal Makhani', 'Slow-simmered black lentils cooked overnight with cream, butter, and mild spices.', 15.99, 1, 0, 1],
                ['vegetarian', 'Palak Paneer', 'Fresh spinach puree tempered with garlic, cumin, and soft paneer cubes.', 16.99, 1, 0, 1],
                ['biryani-rice', 'Hyderabadi Dum Chicken Biryani', 'Fragrant basmati rice layered with marinated chicken, saffron, and mint.', 18.99, 0, 1, 1],
                ['biryani-rice', 'Nawabi Vegetable Biryani', 'Garden fresh vegetables cooked with aromatic herbs and basmati rice.', 15.99, 1, 0, 1],
                ['tandoori-breads', 'Garlic Butter Naan', 'Freshly baked tandoori flatbread topped with minced garlic and cilantro.', 4.49, 1, 0, 1],
                ['tandoori-breads', 'Tandoori Roti', 'Whole wheat unleavened flatbread baked in the clay oven.', 3.49, 1, 0, 0],
                ['desserts', 'Warm Gulab Jamun', 'Golden milk dough dumplings soaked in cardamom and rose water syrup.', 6.99, 1, 0, 1],
                ['desserts', 'Royal Rasmalai', 'Soft cottage cheese patties in sweetened saffron cardamom milk and pistachios.', 7.99, 1, 0, 1],
                ['beverages', 'Mango Lassi', 'Chilled sweet yogurt smoothie blended with Alphonso mango pulp.', 4.99, 1, 0, 1]
            ];
            $stmt = $pdo->prepare("INSERT INTO menu_items (category_slug, name, description, price, is_vegetarian, is_spicy, is_popular) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($essentials as $item) {
                $stmt->execute($item);
            }
        }
    }

    $migrated = true;
}

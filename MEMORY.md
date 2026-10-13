# Saffron Grill (PHP) — Engineering & Deployment Memory

> **Purpose:** Reference manual and persistent memory for the development, architecture, testing, and deployment workflow of Saffron Grill (`https://saffrongrillrestaurant.com`).

---

## 1. Project Overview & Environments

| Component | Specification |
|---|---|
| **Production Domain** | `https://saffrongrillrestaurant.com` |
| **Hosting Infrastructure** | Hostinger Cloud (Apache 2.4, PHP 8.2+) |
| **SSH Host Alias** | `calcuttacb` (`77.37.61.237:65002`) |
| **Remote Webroot** | `domains/saffrongrillrestaurant.com/public_html` *(Note: default `~/public_html` upon SSH points to `hiraya.digital`)* |
| **Remote Private Dir** | `domains/saffrongrillrestaurant.com/private` |
| **Backup Storage** | `domains/saffrongrillrestaurant.com/deploy-backups` |
| **Git Repository** | `https://github.com/badalsharmaa/Saffron-Grill-PHP.git` (`origin/main`) |
| **Database Architecture** | Dual SQLite 3: `admin/data/saffron_crm.db` (CRM Bookings, Catering Leads, Master Menu) and `private/cms.db` (CMS Settings, Page Customizer Values, Promotional Popups, Menu Overrides, Media Library, Multi-Role Users) |
| **Menu Dataset** | `data/menu.json` (mirrored in `assets/menu.json` & `menu/Saffron_Grill_Menu.json`, 82 items / 9 categories) |

---

## 2. Core Architecture & Routing

### Clean URL Routing via `.htaccess`
All client requests route through Apache `.htaccess` to the central dispatcher:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ api/index.php?path=$1 [QSA,L]
```

### Central Gateway (`api/index.php`)
- **API Endpoints:** `/api/health`, `/api/menu`, `/api/reservation`, `/api/catering`
- **Clean Pages:** `/`, `/menu`, `/catering`, `/story`, `/contact`, `/reserve`, `/privacy-policy`, `/terms`
- **Legacy Redirects (301 Permanent):**
  - `/buffet` and `/buffet.php` redirect to `/menu` (the standalone buffet page was retired).
  - `/sitemap` redirects to `/sitemap.xml`.
- **Admin Portal:** `/admin/` and `/admin/login.php`
- **Static Asset Fallback:** Serves assets directly with appropriate MIME types if rewritten.

### Dynamic Configuration (`config/config.php`)
- Reads dynamic settings from the SQLite `settings` table with in-memory caching.
- Fallback defaults defined in `config/restaurant_data.php`.
- Key constants:
  - `ORDER_ONLINE_URL`: `https://order.boons.io/site/saffron-grill/390/y`
  - `PHONE_PRIMARY`, `PHONE_TEL`, `CONTACT_EMAIL`, `RESTAURANT_ADDRESS`
  - `BUFFET_WEEKDAY_PRICE` ($19.99), `BUFFET_WEEKEND_PRICE` ($21.99)
  - `GTM_CONTAINER_ID`

---

## 3. Critical Codebase Rules & Gotchas

### Dual Asset Mirroring (Crucial!)
The codebase maintains scripts and styles in **both** root and `/assets`:
- `styles.css` ⇄ `assets/styles.css`
- `app.js` ⇄ `assets/app.js`
> **Rule:** Whenever modifying `styles.css` or `app.js`, **always copy or sync** to the counterpart in `/assets/` (e.g., `cp styles.css assets/styles.css`).

### Navigation & Footer Synchronization
- **Navigation Header:** Defined in both `includes/nav.php` (used by modular pages) and inline `<nav class="nav" id="nav">` blocks on standalone pages (`index.php`, `menu.php`, `catering.php`, `story.php`, `contact.php`).
- **Footer Structure:**
  - Modular pages (`reserve.php`, `privacy-policy.php`, `terms.php`, `404.php`) include `includes/footer.php`.
  - Standalone pages (`index.php`, `menu.php`, etc.) have inline `<footer>` blocks.
  - **Policy on Admin & Sitemap Links:** "Admin Login" (`/admin.php`) is provided in the bottom utilities row of public footers across all templates (`index.php`, `menu.php`, `catering.php`, `story.php`, `contact.php`, and `includes/footer.php`) for quick access to the CMS portal. `sitemap.xml` is exposed to search engines via `robots.txt`.
  - Whenever updating header or footer elements, update **both** `includes/` and all standalone pages to ensure site-wide parity.

### Clean URL Policy for All Buttons and Internal Anchors
- **Strict Rule:** Never link buttons (`.btn`), hero CTAs, card actions, or in-content anchor tags to `.php` script filenames (`menu.php`, `catering.php`, `contact.php#reserve`, `index.php`, `privacy-policy.php`).
- **Standardized Clean Targets:**
  - Homepage / Return Home: `/` (never `index.php`)
  - Dine-In Menu: `/menu` (never `menu.php`)
  - Table Reservations: `/reserve` (never `contact.php#reserve` or `reserve.php`)
  - Catering Inquiry: `/catering` or `/catering#inquiry-section` (never `catering.php#inquiry-section`)
  - Our Story: `/story` (never `story.php`)
  - Contact & Location: `/contact` (never `contact.php`)
  - Legal & Compliance: `/privacy-policy` and `/terms` (never `privacy-policy.php` or `terms.php`)


### Popup Modals (`#sgPopup` & `#promoModal`)
- Modal markup lives at the bottom of standalone pages (`#sgPopup`) and in `includes/promo_modal.php` (`#promoModal`).
- **Layout Requirements:**
  - Action buttons ("Reserve a Table" and "Explore Menu") **must remain in one row** across all viewport sizes (`.sgp-actions { display: flex; flex-direction: row; flex-wrap: nowrap; }`).
  - Action buttons must have **identical sizes** (`.sgp-actions .btn { flex: 1 1 0; min-width: 0; height: 48px; }`).
  - The modal panel must have **consistent, uniform padding** (`.sgp-inner { padding: clamp(28px, 5vw, 38px); }`).
- Close button uses class `.sgp-close` with a crisp 14×14 diagonal cross SVG and hover rotation.

### OpenGraph & Social Sharing Card
- Recommended social image is a 1200×630 OpenGraph card centered on royal dark plum background:
  - `assets/social_image.png` (1200×630, primary PNG)
  - `assets/social_image.webp` (1200×630, modern WebP)
  - Root `social_image.png` (mirrored for root crawlers)
  - `assets/social_image_original.png` (high-res square master asset)
- All pages declare `og:image`, `og:image:width: 1200`, `og:image:height: 630`, and `twitter:image`.

### UI Form Contrast & Scrollbar Styling
- **Contact Page Form Contrast:** `#contact-form-section .reserve-card` uses `rgba(22, 7, 20, 0.96)` background with `backdrop-filter: blur(16px)` and subtle background mandala opacity (`0.015`) to ensure effortless text legibility.
- **Desktop Scrollbar Suppression:** Desktop scrollbars in reservation modal/forms are hidden using `scrollbar-width: none;` and `::-webkit-scrollbar { display: none; }` to maintain smooth, uncluttered aesthetics.

### Dynamic Asset Cache-Busting via `filemtime` (Crucial for CSS/JS Updates!)
- Hostinger CDN (`server: hcdn`) and Apache `mod_expires` enforce a **30-day client cache** (`max-age=2592000`) on static CSS and JS.
- Without a query parameter, browsers and CDN edge nodes will not download modified stylesheets or scripts.
- **Rules:**
  - Standalone pages (`index.php`, `menu.php`, `catering.php`, etc.) must link CSS/JS with `filemtime`:
    ```html
    <link rel="stylesheet" href="styles.css?v=<?= filemtime(__DIR__ . '/styles.css') ?>" />
    <script src="app.js?v=<?= filemtime(__DIR__ . '/app.js') ?>"></script>
    <script src="popup.js?v=<?= filemtime(__DIR__ . '/popup.js') ?>"></script>
    ```
  - The `asset()` helper in `config/config.php` automatically appends `?v=<filemtime>` to all generated asset URLs.

### Obsolete Remote `index.html` Prevention
- Never leave a static `index.html` (e.g. Under Maintenance) in `public_html`. Under default Apache `DirectoryIndex`, Apache prioritizes `index.html` over `index.php`, causing visitors to see an outdated placeholder.
- `cli/safe_deploy.php` automatically executes `rm -f "{$remoteWebRoot}/index.html"` during every deployment.

### Menu Architecture & Dietary Badges
- **Canonical Dataset:** The master Dine-In Menu contains **82 dishes across 9 categories**, defined in `data/menu.json` and mirrored in `assets/menu.json` and `menu/Saffron_Grill_Menu.json`.
- **Categories:** Salads & Appetizers (10), Tandoor Clay Oven Appetizers (9), Non-Veg Entrées (12), Veg Entrées (14), Sides (4), Desserts (7), Drinks (11), Rice & Biryani (5), Breads from Tandoor (10).
- **Dietary Badges:** Standardized CSS classes for dietary tags:
  - `.tag-veg` (Vegetarian)
  - `.tag-nonveg` (Non-Vegetarian)
  - `.tag-vegan` (Vegan)
  - `.tag-gf` (Gluten Free)
  - `.tag-nuts` (Contains Nuts)
  - `.tag-df` (Dairy Free)
  - `.tag-spice` (Spicy)
- **Database Synchronization:** `cli/sync_menu_from_json.php` synchronizes `menu_categories` and `menu_items` tables in `admin/data/saffron_crm.db` locally and in production. The API endpoint `/api/menu` dynamically serves these dishes.

---

## 4. Standard Operational Workflow

### Step 1: Making Code Modifications
1. Implement features or fixes.
2. If modifying CSS or JS, sync root with `assets/`:
   ```bash
   cp styles.css assets/styles.css
   cp app.js assets/app.js
   ```

### Step 2: Syntax Validation
Always run PHP syntax validation on all touched files:
```bash
for f in index.php catering.php contact.php menu.php story.php reserve.php config/config.php includes/nav.php includes/footer.php includes/promo_modal.php; do
  php -l "$f" || exit 1
done
```

### Step 3: Run Automated QA Crawler Suite
Execute the crawler test suite to verify routing, redirects, static assets, database, form submissions, security firewall, and admin session:
```bash
php tests/qa_automated_crawler.php
```
> **Expectation:** `100%` tests pass before deploying.

### Step 4: XML Sitemap & Menu Synchronization
- **Sitemap Maintenance:** If pages or image assets are added/modified, regenerate the sitemap:
  ```bash
  php cli/generate_sitemap.php
  ```
- **Menu Maintenance:** If dishes, pricing, or descriptions are updated:
  1. Update `data/menu.json` (and mirror to `assets/menu.json` and `menu/Saffron_Grill_Menu.json`).
  2. Sync the SQLite database locally:
     ```bash
     php cli/sync_menu_from_json.php
     ```

### Step 5: Safe Production Deployment (SSH / Rsync)
Deploy verified files to the Hostinger cloud server:
```bash
php cli/safe_deploy.php --deploy
```
*(If menu dataset changed, run `ssh calcuttacb "php domains/saffrongrillrestaurant.com/cli/sync_menu_from_json.php"` after deploying to update remote SQLite tables).*
**What the deploy script does automatically:**
1. Connects to `calcuttacb` via SSH.
2. Creates an archive snapshot in `domains/saffrongrillrestaurant.com/deploy-backups/`.
3. Synchronizes verified webroot files via `rsync` with strict exclusions (`.git`, logs, tests, temp files).
4. Synchronizes `/cli` and `/private` directories outside webroot.
5. Hardens remote file permissions (`chmod 0600` on `.env`, `chmod 0775` on `admin/data/`) and cleans retired scripts (`rm -f buffet.php`).
6. Executes remote database migrations.
7. Executes real-time curl checks for HTTP 200 on all primary routes, verifies 301 redirects, and confirms `.env` is 403 Forbidden.

### Step 6: Version Control Sync
Commit and push changes to GitHub:
```bash
git add -A
git commit -m "feat/fix: descriptive message"
git push origin main
```

---

## 5. Security & CRM Admin Access

- **Admin Login Endpoint:** `https://saffrongrillrestaurant.com/admin/login.php`
- **Session Security:** Cookie-based session validation (`auth.php`), rate limiting, CSRF protection, and honeypot spam traps on all public lead forms.
- **Firewall Rules:** `.htaccess` blocks public web access to `.env`, `.env.production`, `.git`, `.gitignore`, `*.db`, and `/private/`.

---

## 6. Analytics & Search Console Tracking (48-Hour Review Checklist)

| Component | Identifier / Detail | Status |
|---|---|---|
| **Google Analytics (GA4)** | `G-B5FSX73C4M` | Deployed live to all pages & verified |
| **Sitemap URL** | `https://saffrongrillrestaurant.com/sitemap.xml` | Submitted in Google Search Console |
| **GSC Verification** | DNS TXT Record via Hostinger (`aurora.dns-parking.com` / `nebula.dns-parking.com`) | Configured |
| **Consent Mode** | Google Consent Mode v2 (Strict Default: Denied, Custom Banner update) | Active |

### ⏰ 48-Hour Review Action Item (Scheduled: September 25, 2026)
Standard reports and search crawl indexes take 24–48 hours to fully populate. After 48 hours, verify:
1. **Google Search Console**:
   - Check **Indexing > Sitemaps**: Confirm `sitemap.xml` status shows `Success` and all valid URLs are discovered.
   - Check **Indexing > Pages**: Ensure no crawl errors or unintended `noindex` blocks.
2. **Google Analytics 4 (GA4)**:
   - Check **Reports > Lifecycle > Acquisition (Traffic Acquisition)**: Confirm organic search, direct, and referral traffic data are registering.
   - Check **Admin > Product Links > Search Console Links**: Ensure the link to Search Console is active so Google Search queries show in GA4.

---

## 7. SEO, GEO & AI Readiness Architecture

### Strict Design Constraint: Zero Visual/DOM Layout Changes
- **Policy:** Any SEO, GEO, or AI readiness enhancement MUST be strictly confined to metadata, `<head>` tags, JSON-LD `<script type="application/ld+json">` schemas, canonical tags, clean internal link attributes, `robots.txt`, and AI context text manifests.
- **Forbidden:** Never add visible sections, change layouts, alter CSS styling, modify visible typography, or adjust colors for SEO purposes.

### Technical SEO & Clean Canonical Parity
- **Clean Canonical Tags:** All public pages declare clean canonical tags without `.php` extensions:
  - `/` (Homepage)
  - `/menu` (Dine-In Menu)
  - `/catering` (Catering Services & Packages)
  - `/contact` (Location, Hours, Inquiries & FAQ)
  - `/story` (About Us & Heritage)
  - `/reserve` (Table Reservations)
  - `/privacy-policy` & `/terms`
- **Internal Clean Linking:** All internal links in `<header>`, `<nav>`, mobile navigation drawers, footer explore menus, hero and in-page CTA buttons, card actions, reservation CTAs, and popup buttons MUST link to clean URLs without `.php` extensions. 100% of internal button and anchor links site-wide are verified to use clean URLs.
- **Search Engine Directives:** Standardized robots meta across all pages:
  `<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />` to maximize eligibility for rich media snippets and Google Discover.

### Central SEO & Schema Engine (`includes/seo.php`)
- `get_restaurant_schema_entity()`: Produces the canonical Schema.org `Restaurant` entity including:
  - Exact geocoordinates (`37.7663`, `-121.9745`) and address (2005 Crow Canyon Pl, STE 144, San Ramon, CA 94583).
  - Business hours, price range (`$$`), accepted currencies (`USD`), payment methods (`Cash`, `Credit Card`).
  - Authoritative `sameAs` citations: Yelp, Boons ordering, Instagram, Facebook, and Google Maps CID.
  - Complete `areaServed` coverage (San Ramon, Danville, Dublin, Pleasanton, Blackhawk, Alamo, Livermore, Walnut Creek, Tri-Valley, East Bay).
- `get_full_menu_schema()`: Dynamically compiles all **82 dishes across 9 categories** directly from `data/menu.json` into a Schema.org `Menu` graph with individual `MenuItem` objects, pricing, descriptions, and dietary property tags (`VegetarianDiet`, `VeganDiet`, `GlutenFreeDiet`, `HalalDiet`).
- `get_breadcrumbs_schema()`: Emits a structured `BreadcrumbList` matching the exact navigation hierarchy on every subpage.
- `get_ai_discovery_head_tags()`: Injects `<link rel="alternate">` tags in `<head>` declaring `/llms.txt`, `/llms-full.txt`, and `/restaurant-facts.json`.

### GEO & Local Search Optimization
- **Tri-Valley Local Footprint:** Explicitly targets high-intent local queries across San Ramon, Danville, Dublin, Pleasanton, and East Bay.
- **High-Intent FAQ Schema:** Embedded on `/contact` via `FAQPage` schema addressing the most frequent local queries:
  - Exact restaurant location & Crow Canyon Commons parking availability.
  - Daily lunch buffet schedule (Tue–Sun, 11:30 AM – 2:30 PM) and pricing ($19.99 weekday / $21.99 weekend).
  - 100% Zabihah Halal certified meat sourcing.
  - Dedicated vegetarian and vegan options.
  - Event catering capabilities and advance reservation policies.

### AI Engine Optimization (AEO / GEO) & Bot Crawlers
- **Crawler Permissions (`robots.txt`):** Modern generative search and answer engines are explicitly granted crawl access:
  - OpenAI: `OAI-SearchBot` (ChatGPT Search citation engine), `GPTBot`, `ChatGPT-User`
  - Perplexity: `PerplexityBot`
  - Anthropic: `ClaudeBot`
  - Google: `Google-Extended`
  - Apple: `Applebot`, `Applebot-Extended`
  - Amazon & Meta: `Amazonbot`, `meta-externalagent`
  - Crawl Aggregators: `CCBot`, `Bytespider`, `cohere-ai`
- **Knowledge Manifests:**
  - `llms.txt`: Adheres to the llmstxt.org specification, linking clean URLs and core restaurant services.
  - `llms-full.txt`: 100-line comprehensive knowledge base detailing menu categories, signature dishes, buffet schedule, catering tiers, dietary standards, and FAQ library.
  - `restaurant-facts.json`: Structured, machine-readable facts schema with coordinates, citations, and services for immediate AI extraction.
- **Verification Protocol:** Verified via `tests/qa_automated_crawler.php` (50/50 tests passing) and deployed via `cli/safe_deploy.php --deploy`.

---

## 8. Custom CMS Architecture & Administration

### Directory Index & Routing
- Accessing `/admin/` or `/admin` invokes `/admin/index.php`, which seamlessly bridges to the central admin router [`admin.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin.php).
- Legacy CRM modules (`admin/reservations.php`, `admin/menu_manager.php`, `admin/export.php`) operate within the same authenticated perimeter.

### Unified Session Management (`CMSAuth`)
- **Session Name:** Standardized across the entire application as `saffron_admin_session` via [`config/config.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/config/config.php) and [`admin/config.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin/config.php).
- **Bidirectional Session Bridge:**
  - Logging in via [`admin/login.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin/login.php) sets legacy CRM session keys (`saffron_admin_id`, `saffron_admin_user`, `saffron_admin_role`) and unified CMS keys (`cms_logged_in`, `cms_user_id`, `cms_username`, `cms_role`, `cms_status`, `cms_initiated`).
  - [`CMSAuth::check()`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin/auth.php#L43-L58) dynamically synchronizes CRM and CMS keys, preventing split-brain session desynchronization.
  - Session regeneration (`session_regenerate_id`) is strictly guarded to avoid dropping active sessions during redirects.
- **Role-Based Access Control (RBAC):**
  - Roles: `super_admin` (full permissions, user management, configuration) and `staff` (day-to-day operations, lead management).
  - Statuses: `active` and `suspended` (suspended users are denied login immediately).

### Database Partitioning
1. **`admin/data/saffron_crm.db`**:
   - `admins`: Legacy staff and administrator credentials.
   - `reservations`: Public table booking submissions with attribution metadata (`gclid`, UTM parameters).
   - `leads`: Full catering proposal inquiries.
   - `menu_items` & `menu_categories`: Relational dish catalog.
   - `settings`: Global key-value operational flags.
2. **`private/cms.db`**:
   - `cms_users`: Multi-role CMS accounts with hashed passwords and audit timestamps.
   - `cms_settings`: Page customizer overrides and global site customizations.
   - `cms_popups`: Configuration for promotional announcements and lead capture modals.
   - `cms_menu_overrides`: Live price, description, and availability overrides without altering canonical data.
   - `captured_leads`: Unified lead inbox for submissions captured across the site.
   - `cms_media`: Uploaded assets, metadata, alt text, and thumbnail tracking.

---

## 9. Promotional Popup Engine & Lead Capture Modal

- **Controller & Views:** Managed in CMS via `admin/views/pages.php` (Tab: Promotional Popup).
- **Frontend Presentation:** Rendered by [`includes/popup.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/includes/popup.php) and triggered by [`popup.js`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/popup.js).
- **Configurable Attributes (`cms_popups`):**
  - `is_active`: Global toggle to enable/disable the popup modal.
  - `delay_seconds`: Trigger delay (0–60 seconds).
  - `frequency`: Display frequency (`once_per_session`, `always`, `every_24h`).
  - `disable_image`: Boolean toggle allowing the banner image to be suppressed completely.
  - `enable_lead_capture`: Renders an embedded VIP coupon/discount capture form.
  - `slides`: JSON array of flyer slide objects (`image_url`, `headline`, `subline`, `badge_text`).
- **Zero-Slide Pure Modal Support:**
  - The customizer allows saving 0 flyer slides when the restaurant wants a pure lead capture modal or text-only announcement.
  - The frontend automatically transitions to a clean single-column layout without layout shift or console errors.

---

## 10. Storefront Synchronicity & Null/Empty Content Rules

- **The `cms_get()` Contract (`api/cms_helper.php`):**
  - Signature: `cms_get(string $key, mixed $default = null, bool $refresh = false): mixed`
  - **Empty String Retention:** If an administrator explicitly clears an input in the CMS (e.g. removes a hero quote or subtitle), `cms_get()` returns `""` rather than falling back to `$default`.
  - Fallback defaults are only returned when the key does not exist in `cms_settings`.
- **Conditional Template Rendering:**
  - When rendering optional CMS content on public storefront templates ([`story.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/story.php), [`catering.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/catering.php), [`index.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/index.php)), elements MUST be guarded with `trim(...) !== ''`:
    ```php
    <?php $heroQuote = cms_get('story_hero_quote', ''); ?>
    <?php if (trim((string)$heroQuote) !== ''): ?>
      <blockquote class="story-quote"><?= e($heroQuote) ?></blockquote>
    <?php endif; ?>
    ```
  - This ensures that clearing text in the CMS cleanly removes the entire DOM element, preventing empty quotes, blank headers, or awkward spacing on the live website.

---

## 11. Testing Harness & Quality Assurance Suites

The project maintains two comprehensive automated test suites providing 100% test coverage with zero mock data.

### Suite 1: Deep Functional CMS Test Suite (`tests/cms_comprehensive_suite.php`)
Executes **68 automated assertions** against internal CMS engines and `private/cms.db`:
- **Module 1 (CMSAuth):** CSRF generation & validation, bad login rejection, super admin checks, user creation, role modification, suspension/activation, password resets, profile edits, user deletion.
- **Module 2 (Settings & Popups):** Key-value persistence, empty-string retention, popup config saving, `disable_image` flag, frequency persistence, zero slides support.
- **Module 3 (Menu Catalog):** Dish creation, price updates, availability toggling, soft deletes, dish restoration, categories retrieval, menu overrides, batch CSV import.
- **Module 4 (Submissions & Leads):** Silent lead ingestion, filtered lead querying, status transitions, staff notes updates, lead metrics, permanent lead deletion.
- **Module 5 (Media Engine):** Media syncing, stats computation, pagination, metadata updates, safe file deletion.
- **Module 6 (Storefront Sync):** Empty string verification for story quotes, catering subtitles, hero subtitles, and teaser descriptions.

**Run Command:**
```bash
php tests/cms_comprehensive_suite.php
```
*(Passing: 68/68, 100% PASS)*

### Suite 2: Comprehensive System Audit (`tests/comprehensive_system_audit.php`)
Executes **59 automated checks** testing live HTTP routes, firewall, CRM, and CLI workers:
- **Section 1:** Clean URL routing and HTTP 200/301/404 verification.
- **Section 2:** Security firewall blocking sensitive files (`.env`, `.git`, `.htaccess`, `saffron_crm.db`, `smtp-config.php`).
- **Section 3:** Static asset & media availability.
- **Section 4:** AI context manifests (`restaurant-facts.json`, `llms.txt`, JSON-LD schema, Google Consent Mode v2).
- **Section 5:** AJAX table reservation pipeline, lead attribution (`gclid`, UTMs), honeypot bot trap.
- **Section 6:** Admin authentication, dashboard KPI metrics, table reservation status transition, menu item creation via curl, CSV export generation.
- **Section 7:** CLI conversion exporter (`cli/export_conversions.php`) and database backup worker (`cli/db_backup.php`).

**Run Command:**
```bash
php tests/comprehensive_system_audit.php
```
*(Passing: 59/59, 100% PASS)*

---

## 12. PHP 8.5+ Modernization & CSV Standards

- **`fputcsv()` Escape Parameter:**
  - Starting in PHP 8.5, the `$escape` parameter in `fputcsv()` is mandatory; omitting it triggers a `PHP Deprecated` warning.
  - All CSV export routines across the codebase explicitly pass all 5 arguments:
    ```php
    fputcsv($outputHandle, $rowArray, ',', '"', "\\");
    ```
  - Standardized across:
    - [`admin/export.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin/export.php) (Reservations and Leads export)
    - [`admin/helpers/CMS.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/admin/helpers/CMS.php) (`exportLeadsCsv` and `exportMenuCsv`)
    - [`cli/export_conversions.php`](file:///Users/badalsharma/Work/Saffron-Grill-PHP/cli/export_conversions.php) (Google Ads offline conversions sync)

---

## 13. CMS Customizer & Desktop Workspace Architecture

### Live 3-Panel Visual Page Customizer (`/admin.php?page=pages&edit=...`)
Inspired by the modern StreetBeat customizer UX:
1. **Left Section Tree:** Quick accordion navigation through all page sections (hero, announcement, spotlight, catering, etc.) with active state indicators and 2-way viewport sync.
2. **Center Form Controls:** Real-time form fields with unsaved change detection, always-enabled "Save Changes" action with AJAX endpoint (`/admin.php?action=save_page_customizer`), and inline visual toasts.
3. **Right Interactive Live Preview:**
   - Multi-device viewport toggling (Desktop 100%, Tablet 768px, Mobile 375px) with iframe sandboxing.
   - Real-time `postMessage` protocol: form field inputs stream changes instantly into the iframe DOM without page reload.
   - Section scrolling sync: clicking a section card in panel 1 or 2 immediately scrolls the live iframe to the corresponding `#sectionId`.

### Collapsible Desktop Sidebar Rail (`.sidebar-collapsed`)
- **Desktop Collapse Toggle (`min-width: 901px`):**
  - Allows staff to collapse the 260px left sidebar into a sleek 72px icon-only rail for a maximized workspace (particularly useful during page customization and menu editing).
  - Toggled via the top header button (`#sidebarToggle`), dedicated sidebar collapse icon (`#sidebarCollapseDesktop`), or keyboard shortcuts (`⌘[` / `Ctrl+[` and `⌘B` / `Ctrl+B`).
  - Text labels, section headings, and the search input hide smoothly; navigation squircles, badge counters, and profile avatars remain centered with hover tooltips.
  - **State Persistence & Anti-Flicker:** Collapse state is persisted in `localStorage.getItem('sg_sidebar_collapsed')`. An inline pre-hydration script in `<head>` (`admin/views/components/header.php`) injects `sidebar-is-collapsed` onto `<html>` before DOM render to eliminate layout flash.




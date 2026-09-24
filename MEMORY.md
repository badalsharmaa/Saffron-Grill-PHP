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
| **Database** | SQLite 3 (`admin/data/saffron_crm.db`), seeded via `admin/includes/schema.php` & `cli/sync_menu_from_json.php` |
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
  - **Policy on Admin & Sitemap Links:** "Staff Login" (`/admin/login.php`) and "Sitemap" (`/sitemap.xml`) links are **intentionally hidden** from all public visible footers. `sitemap.xml` is exposed to search engines via `robots.txt`, and staff access `/admin/login.php` directly.
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



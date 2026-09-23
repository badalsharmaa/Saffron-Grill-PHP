# Saffron Grill (PHP) — Engineering & Deployment Memory

> **Purpose:** Reference manual and persistent memory for the development, architecture, testing, and deployment workflow of Saffron Grill (`https://saffrongrillrestaurant.com`).

---

## 1. Project Overview & Environments

| Component | Specification |
|---|---|
| **Production Domain** | `https://saffrongrillrestaurant.com` |
| **Hosting Infrastructure** | Hostinger Cloud (Apache 2.4, PHP 8.2+) |
| **SSH Host Alias** | `calcuttacb` (`77.37.61.237:65002`) |
| **Remote Webroot** | `domains/saffrongrillrestaurant.com/public_html` |
| **Remote Private Dir** | `domains/saffrongrillrestaurant.com/private` |
| **Backup Storage** | `domains/saffrongrillrestaurant.com/deploy-backups` |
| **Git Repository** | `https://github.com/badalsharmaa/Saffron-Grill-PHP.git` (`origin/main`) |
| **Database** | SQLite 3 (`admin/data/saffron_crm.db`), schema migrated via `admin/data/schema.sql` |

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

### Step 4: XML Sitemap Maintenance
If pages or image assets are added/modified, regenerate the sitemap:
```bash
php cli/generate_sitemap.php
```

### Step 5: Safe Production Deployment (SSH / Rsync)
Deploy verified files to the Hostinger cloud server:
```bash
php cli/safe_deploy.php --deploy
```
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

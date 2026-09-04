# 🌶️ Saffron Grill — Enterprise PHP & Management CRM

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B%20%7C%208.2%2B%20%7C%208.5-blue.svg)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-SQLite%20%7C%20MySQL%20(Dual--Driver)-orange.svg)](https://www.sqlite.org/)
[![AI Ready](https://img.shields.io/badge/AI%20Ready-llms.txt%20%7C%20Schema.org-green.svg)](https://llmstxt.org/)
[![License](https://img.shields.io/badge/License-Proprietary-red.svg)]()

A modern, full-stack, enterprise-grade PHP application and CRM management system built for **Saffron Grill** (Authentic Indian Cuisine · San Ramon, CA).

Featuring luxury visual aesthetics, 100% GSAP animations, a dual-driver database engine, Google Consent Mode v2, ad conversion attribution tracking, AI-native search discoverability, and an administrative CRM portal.

---

## 📸 Key Highlights & Features

### 1. 🎨 Luxury Frontend & Visual Fidelity
- **GSAP & Web Components**: Retains all original GSAP scroll-triggered animations, interactive video carousels, dish marquee tickers, and custom `<image-slot>` components.
- **Brand Aesthetic**: Saffron Gold (`#eab308`), Warm Cream (`#FDFBF7`), and Deep Plum (`#260e22`) with editorial typography (`Cinzel`, `Cormorant Garamond`, `Jost`).
- **Dynamic Restaurant Status**: Live Pacific-time open/closed detector for Daily Lunch Buffet ($19.99 Weekdays / $21.99 Weekends) and Dinner Service.

### 2. 🗄️ Dual-Driver Database & Migration Engine
- **Zero-Config Local Development**: Automatically connects to a self-contained SQLite database (`admin/data/saffron_crm.db`).
- **Enterprise MySQL in Production**: Seamlessly switches to MySQL via `.env` (`DB_DRIVER=mysql`).
- **Idempotent Versioned Migrations**: Automated schema builder initializing tables for `reservations`, `leads`, `menu_items`, `menu_categories`, `settings`, `admins`, and `consent_logs`.

### 3. 💼 Executive Admin CRM & Management Portal (`/admin`)
- **Custom Vector SVG Design**: Built with clean, minimalist vector icons throughout.
- **Analytics Dashboard**: Real-time KPI counters (Total Bookings, Active Catering Inquiries, Live Dishes, Today's Bookings).
- **Table Reservations Manager**: Complete lifecycle status workflow (`Pending` $\rightarrow$ `Confirmed` $\rightarrow$ `Seated` $\rightarrow$ `Cancelled`).
- **Catering Lead Pipeline**: Event tracker with guest counts, package selections (Silver, Gold, Imperial), budget calculation, and customer contact tools.
- **Live Menu CMS**: Add dishes, adjust pricing, and toggle dietary tags (`VEG`, `NON-VEG`, `SPICY`, `STAR`).
- **Live Settings Editor**: Instant updates to phone numbers, operating hours, and top promotional banner.
- **CSV Data Export**: Single-click downloads for accounting, offline reporting, and Google Ads offline conversion synchronization.

### 4. 🤖 SEO, Hyper-Local GEO & AI Search Readiness
- **AI Agent Discovery**: Includes [`llms.txt`](llms.txt), [`llms-full.txt`](llms-full.txt), and [`restaurant-facts.json`](restaurant-facts.json) optimized for ChatGPT Search, Claude, Perplexity, Gemini, and Google AI Overviews.
- **Structured Schema.org JSON-LD**: Comprehensive rich snippets for `Restaurant`, `PostalAddress`, `OpeningHoursSpecification`, `FAQPage`, and `Menu`.
- **Hyper-Local GEO Meta Tags**: Exact coordinates (`37.7663; -121.9745`), region (`US-CA`), and place name (`San Ramon, California`).
- **Robots.txt & Sitemap**: Crawler rules welcoming search engines and AI crawlers (`GPTBot`, `ClaudeBot`, `PerplexityBot`, `Googlebot`).

### 5. 🛡️ Security, Attribution & Compliance
- **Google Consent Mode v2**: Strict default `denied` state, client-side cookie consent banner, and backend sync endpoint (`consent-sync.php`).
- **Ad Attribution Pipeline**: Captures `gclid`, `gbraid`, `wbraid`, and full `utm_*` parameters on leads and reservations.
- **Spam Defense**: Honeypot traps (`website_hp`) silently isolate automated bot submissions without database pollution.
- **Security Firewall**: Router and `.htaccess` block access to `.env`, `.git`, SQLite databases, and `private/` directories with `HTTP 403 Forbidden`.

---

## 📂 Project Directory Structure

```
.
├── .env.example / .env         # Environment configuration
├── .htaccess                   # Production Apache rewrite rules & security headers
├── router.php                  # Local development CLI server router & security firewall
├── index.php                   # Homepage with live buffet status & dish highlights
├── story.php                   # Heritage, three pillars & culinary philosophy
├── buffet.php                  # Lunch buffet pricing & schedule
├── menu.php                    # Database-driven menu with dietary filters & search
├── catering.php                # Catering packages & custom event inquiry form
├── contact.php                 # Directions, location map, hours & contact form
├── reserve.php                 # Dedicated table booking page with instant confirmation
├── privacy-policy.php          # CCPA & GDPR compliant privacy policy
├── terms.php                   # Terms of service and dining policies
├── 404.php                     # Custom branded 404 error page
├── send-mail.php               # Unified form processor, honeypot & lead recorder
├── consent-sync.php            # Consent Mode v2 attribution sync endpoint
├── sitemap.xml                 # XML sitemap with geo & image metadata
├── robots.txt                  # Search engine and AI crawler directives
├── llms.txt                    # Compact AI context for LLMs
├── llms-full.txt               # Comprehensive restaurant specifications for AI
├── restaurant-facts.json       # Machine-readable JSON schema
│
├── config/
│   ├── config.php              # Global configuration, helper functions & dynamic settings
│   └── restaurant_data.php     # Static fallbacks, contacts, catering tiers
│
├── includes/
│   ├── header.php              # Meta tags, Consent Mode v2, JSON-LD Schema
│   ├── nav.php                 # Sticky navigation & mobile drawer
│   ├── reservation_modal.php   # Reusable AJAX booking modal
│   ├── promo_modal.php         # Daily buffet promotion popup
│   ├── consent_banner.php      # Interactive cookie consent banner
│   └── footer.php              # Footer, business hours & tracking scripts
│
├── admin/                      # Enterprise Admin CRM & CMS Portal
│   ├── index.php               # KPI Analytics Dashboard
│   ├── reservations.php        # Table booking ledger & status updater
│   ├── leads.php               # Catering proposals & lead CRM
│   ├── menu_manager.php        # Live Menu CMS
│   ├── settings.php            # Live configuration editor
│   ├── login.php               # Staff login with password hashing & Quick Fill
│   ├── logout.php              # Session destruction
│   ├── export.php              # CSV export engine
│   ├── data/saffron_crm.db     # SQLite database instance (auto-migrated)
│   └── includes/
│       ├── auth.php            # Session guards & CSRF verification
│       ├── db.php              # Dual-driver PDO connector (SQLite & MySQL)
│       ├── schema.php          # Idempotent versioned schema migrations
│       ├── admin_header.php    # Admin layout with custom SVG icons
│       └── admin_footer.php    # Admin footer
│
├── api/
│   ├── index.php               # Universal REST API gateway (/api/health)
│   └── menu.php                # Categorized dish JSON endpoint (/api/menu)
│
├── private/                    # Protected server boundary (HTTP 403 Forbidden)
│   ├── smtp-config.php         # SMTP credentials
│   ├── backups/                # Automated database backups
│   └── logs/                   # System error & conversion logs
│
├── cli/                        # Background workers & cron utilities
│   ├── export_conversions.php  # Offline conversion uploader for Google Ads
│   └── db_backup.php           # Scheduled database backup runner
│
└── tests/                      # Automated Verification Suite
    ├── comprehensive_system_audit.php  # 59-point automated system audit
    ├── test_db_migrations.php          # Database schema & migration test
    ├── test_lead_pipeline.php          # Form processing & honeypot test
    └── test_endpoints.php              # HTTP status & route test
```

---

## 🚀 Getting Started Locally

### 1. Prerequisites
- **PHP 8.1+** (PHP 8.2 or 8.5 recommended) with `pdo`, `pdo_sqlite`, `curl`, and `mbstring` extensions.

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/badalsharmaa/Saffron-Grill-PHP.git
cd Saffron-Grill-PHP

# Copy environment variables
cp .env.example .env
```

### 3. Start Local Development Server
```bash
php -S 0.0.0.0:8088 router.php
```

### 4. Access the Application
- **Public Website**: [http://localhost:8088](http://localhost:8088)
- **Menu**: [http://localhost:8088/menu](http://localhost:8088/menu)
- **Catering**: [http://localhost:8088/catering](http://localhost:8088/catering)
- **Contact & Map**: [http://localhost:8088/contact](http://localhost:8088/contact)
- **Admin CRM**: [http://localhost:8088/admin](http://localhost:8088/admin)
- **AI Context**: [http://localhost:8088/llms.txt](http://localhost:8088/llms.txt)
- **JSON Facts API**: [http://localhost:8088/restaurant-facts.json](http://localhost:8088/restaurant-facts.json)

---

## 🔑 Default Staff Credentials

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Superadmin (Production)** | `admin` *(or `gosaffrongrill@gmail.com`)* | `SaffronAdmin2026!` |
| **Superadmin (Quick Dev)** | `admin` | `admin123` |

*(Tip: Click the **⚡ Quick Fill Credentials** button on the login screen for instant sign-in).*

---

## 🧪 Running Automated Tests

Execute the 59-point comprehensive test suite verifying all routes, database operations, form workflows, and security assertions:

```bash
php tests/comprehensive_system_audit.php
```

Individual test suites:
```bash
php tests/test_endpoints.php      # Verify all 22+ HTTP endpoints & status codes
php tests/test_db_migrations.php  # Verify schema creation & seed tables
php tests/test_lead_pipeline.php  # Verify honeypots, GCLID attribution & bookings
```

---

## ⚙️ Cron Jobs & Background Workers

Add the following entries to your server crontab (`crontab -e`):

```bash
# Export Google Ads offline conversions every hour
0 * * * * /usr/bin/php /path/to/Saffron-Grill-PHP/cli/export_conversions.php >> /path/to/Saffron-Grill-PHP/private/logs/conversions.log 2>&1

# Run nightly database backup at 2:00 AM
0 2 * * * /usr/bin/php /path/to/Saffron-Grill-PHP/cli/db_backup.php >> /path/to/Saffron-Grill-PHP/private/logs/backup.log 2>&1
```

---

## 📜 Production Deployment Notes

1. **Apache / Nginx**: Set document root to the project directory. The included `.htaccess` file handles clean URLs and security rules automatically on Apache/LiteSpeed.
2. **Environment**: Update `.env` with production MySQL credentials (`DB_DRIVER=mysql`), SMTP configuration, and Google Tag Manager container ID.
3. **Database Migrations**: Automatic on first request; no manual SQL imports required.

---

## 📄 License
Proprietary — Developed for Saffron Grill San Ramon.

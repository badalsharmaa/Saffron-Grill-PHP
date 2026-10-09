<?php
/**
 * Saffron Grill — CMS Login & Team Portal
 * Styled with luxury hospitality split-screen layout
 */

require_once __DIR__ . '/../helpers/AdminIcons.php';

// Generate lightweight math puzzle for bot prevention
$num1 = rand(2, 8);
$num2 = rand(2, 8);
$_SESSION['cms_puzzle_answer'] = $num1 + $num2;

$flash = cms_get_flash();
$mode = $_GET['mode'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mode === 'register' ? 'Staff Registration' : 'CMS Portal Sign In' ?> — Saffron Grill</title>
    <link rel="icon" type="image/png" href="/assets/emblem.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #C5A059;
            --primary-hover: #B38E46;
            --navy: #0B0F17;
            --cream: #FAF7F2;
            --gold: #D97706;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #F8F9FA;
            color: var(--navy);
            min-height: 100vh;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Left Side: Brand Imagery & Royal Gastronomy */
        .login-hero {
            flex: 1.1;
            background: linear-gradient(135deg, rgba(11, 15, 23, 0.94) 0%, rgba(197, 160, 89, 0.82) 100%),
                        url('/assets/hero2-first-frame.jpg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 4rem;
            position: relative;
            color: #FFFFFF;
        }

        .hero-top-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 6px 14px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 13px;
            font-weight: 600;
            width: fit-content;
        }

        .hero-center-content {
            max-width: 480px;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 46px;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1rem;
            color: #FFFFFF;
        }

        .hero-subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.6;
        }

        .hero-footer-stats {
            display: flex;
            gap: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-stat-item h4 {
            font-size: 22px;
            font-weight: 800;
            color: #FDE68A;
        }

        .hero-stat-item p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Right Side: Clean Form Card */
        .login-pane {
            flex: 0.9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            background: #FFFFFF;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .brand-header {
            margin-bottom: 2rem;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.25rem;
        }

        .brand-emblem {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #FAF7F2;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .brand-emblem img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
        }

        .brand-tag {
            font-size: 11.5px;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .page-heading {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .page-subheading {
            font-size: 14px;
            color: #64748B;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding: 0 14px 0 42px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #FFFFFF;
            font-family: inherit;
            font-size: 14px;
            color: var(--navy);
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.18);
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        .challenge-box {
            background: #FAF7F2;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .challenge-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
        }

        .challenge-badge {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 700;
            color: var(--gold);
        }

        .challenge-input {
            width: 70px;
            height: 38px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
        }

        .submit-btn {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #C5A059 0%, #D97706 100%);
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(197, 160, 89, 0.3);
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(197, 160, 89, 0.4);
        }

        .alert-flash {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FEE2E2;
            color: #B91C1C;
        }

        .alert-success {
            background: #ECFDF5;
            border: 1px solid #D1FAE5;
            color: #047857;
        }

        .mode-switch-row {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 13.5px;
            color: #64748B;
        }

        .mode-switch-link {
            color: var(--gold);
            font-weight: 700;
            text-decoration: none;
        }

        .mode-switch-link:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .login-hero {
                display: none;
            }
            .login-pane {
                flex: 1;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Hero branding panel -->
        <div class="login-hero">
            <div class="hero-top-badge">
                <?= AdminIcons::get('sparkles', 14) ?>
                <span>Saffron Grill Executive Portal</span>
            </div>

            <div class="hero-center-content">
                <h1 class="hero-title">Regal Gastronomy &amp; Operations</h1>
                <p class="hero-subtitle">
                    Central administrative control center for table reservations, catering inquiries, menu curation, and digital storefront publishing across San Ramon.
                </p>
            </div>

            <div class="hero-footer-stats">
                <div class="hero-stat-item">
                    <h4>Daily Feast</h4>
                    <p>Lunch Buffet &amp; Dinner</p>
                </div>
                <div class="hero-stat-item">
                    <h4>San Ramon</h4>
                    <p>Crow Canyon Plaza</p>
                </div>
                <div class="hero-stat-item">
                    <h4>Secure</h4>
                    <p>Role-Based Access</p>
                </div>
            </div>
        </div>

        <!-- Form pane -->
        <div class="login-pane">
            <div class="login-card">
                <div class="brand-header">
                    <div class="brand-logo-wrap">
                        <div class="brand-emblem">
                            <img src="/assets/emblem.png" alt="Saffron Grill">
                        </div>
                        <div>
                            <div class="brand-name">Saffron Grill</div>
                            <div class="brand-tag">Administration CMS</div>
                        </div>
                    </div>

                    <?php if ($mode === 'register'): ?>
                        <h2 class="page-heading">Staff Registration</h2>
                        <p class="page-subheading">Submit your staff account for administrator review</p>
                    <?php else: ?>
                        <h2 class="page-heading">Sign In to CMS</h2>
                        <p class="page-subheading">Enter your administrative credentials to continue</p>
                    <?php endif; ?>
                </div>

                <?php if ($flash): ?>
                    <div class="alert-flash alert-<?= e($flash['type']) ?>">
                        <?= AdminIcons::get($flash['type'] === 'error' ? 'x_circle' : 'check_circle', 16) ?>
                        <span><?= e($flash['message']) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($mode === 'register'): ?>
                    <!-- Registration Form -->
                    <form method="POST" action="/admin.php?action=register">
                        <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">

                        <div class="form-group">
                            <label class="form-label" for="regName">Full Name</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('users', 16) ?></span>
                                <input type="text" id="regName" name="name" class="form-input" placeholder="e.g. Chef / Manager" required autocomplete="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="regEmail">Email Address</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('mail', 16) ?></span>
                                <input type="email" id="regEmail" name="email" class="form-input" placeholder="name@saffrongrill.com" required autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="regUsername">Desired Username</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('shield', 16) ?></span>
                                <input type="text" id="regUsername" name="username" class="form-input" placeholder="choose_username" required autocomplete="username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="regPassword">Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('lock', 16) ?></span>
                                <input type="password" id="regPassword" name="password" class="form-input" placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="regConfirm">Confirm Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('lock', 16) ?></span>
                                <input type="password" id="regConfirm" name="confirm_password" class="form-input" placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Bot Challenge Math Puzzle -->
                        <div class="challenge-box">
                            <div>
                                <div class="challenge-label">Security Verification</div>
                                <div style="font-size: 12px; color: #64748B;">Solve math problem to verify:</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="challenge-badge"><?= $num1 ?> + <?= $num2 ?> = ?</span>
                                <input type="number" name="bot_challenge" class="challenge-input" required placeholder="Ans">
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Register Staff Account</span>
                            <?= AdminIcons::get('arrow_right', 16) ?>
                        </button>

                        <div class="mode-switch-row">
                            Already have an account? <a href="/admin/" class="mode-switch-link">Sign In</a>
                        </div>
                    </form>
                <?php else: ?>
                    <!-- Sign In Form -->
                    <form method="POST" action="/admin.php?action=login">
                        <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">

                        <div class="form-group">
                            <label class="form-label" for="loginUser">Username or Email</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('users', 16) ?></span>
                                <input type="text" id="loginUser" name="username" class="form-input" placeholder="admin or email" required autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="loginPass">Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon"><?= AdminIcons::get('lock', 16) ?></span>
                                <input type="password" id="loginPass" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                                    <?= AdminIcons::get('eye', 16) ?>
                                </button>
                            </div>
                        </div>

                        <!-- Bot Challenge Math Puzzle -->
                        <div class="challenge-box">
                            <div>
                                <div class="challenge-label">Security Challenge</div>
                                <div style="font-size: 12px; color: #64748B;">Solve simple math challenge:</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="challenge-badge"><?= $num1 ?> + <?= $num2 ?> = ?</span>
                                <input type="number" name="bot_challenge" class="challenge-input" required placeholder="Ans">
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Authenticate &amp; Enter CMS</span>
                            <?= AdminIcons::get('arrow_right', 16) ?>
                        </button>

                        <div class="mode-switch-row">
                            New restaurant staff member? <a href="/admin/?mode=register" class="mode-switch-link">Request Access</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var input = document.getElementById('loginPass');
            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';
            }
        }
    </script>
</body>
</html>

<?php
/**
 * Saffron Grill - Protected Server Mailer Configuration
 * (Isolated from public docroot access)
 */

return [
    'driver' => getenv('MAIL_DRIVER') ?: 'mail',
    'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
    'port' => (int)(getenv('SMTP_PORT') ?: 587),
    'username' => getenv('SMTP_USER') ?: 'gosaffrongrill@gmail.com',
    'password' => getenv('SMTP_PASS') ?: '',
    'encryption' => getenv('SMTP_SECURE') ?: 'tls',
    'from_email' => 'no-reply@saffrongrillrestaurant.com',
    'from_name' => 'Saffron Grill Notifications',
];

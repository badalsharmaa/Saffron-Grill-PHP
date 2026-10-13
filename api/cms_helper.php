<?php
/**
 * Saffron Grill — Frontend CMS Bridge Helper
 * Safe, zero-overhead helper functions for public templates
 */

if (!function_exists('cms_get')) {
    function cms_get(string $key, $default = null, bool $refresh = false) {
        static $settingsCache = null;
        if ($settingsCache === null || $refresh) {
            $helperFile = __DIR__ . '/../admin/helpers/CMS.php';
            if (file_exists($helperFile)) {
                require_once $helperFile;
                $settingsCache = CMS::getAllSettings();
            } else {
                $settingsCache = [];
            }
        }

        return (array_key_exists($key, $settingsCache) && $settingsCache[$key] !== null) ? (string)$settingsCache[$key] : $default;
    }
}

if (!function_exists('cms_popup_config')) {
    function cms_popup_config(): array {
        static $popupCache = null;
        if ($popupCache === null) {
            $helperFile = __DIR__ . '/../admin/helpers/CMS.php';
            if (file_exists($helperFile)) {
                require_once $helperFile;
                $popupCache = CMS::getPopupConfig();
            } else {
                $popupCache = [
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
                            'alt' => 'Daily Grand Lunch Buffet',
                            'title' => 'Daily Grand Lunch Buffet',
                            'link' => '/menu'
                        ]
                    ]
                ];
            }
        }
        return $popupCache;
    }
}

if (!function_exists('cms_menu_overrides')) {
    function cms_menu_overrides(): array {
        static $overridesCache = null;
        if ($overridesCache === null) {
            $helperFile = __DIR__ . '/../admin/helpers/CMS.php';
            if (file_exists($helperFile)) {
                require_once $helperFile;
                $overridesCache = CMS::getMenuOverrides();
            } else {
                $overridesCache = [];
            }
        }
        return $overridesCache;
    }
}

if (!function_exists('saffron_clean_hours')) {
    function saffron_clean_hours($val) {
        if (!is_string($val)) return (string)$val;
        return trim(preg_replace('/^(?:mon(?:day)?|tue(?:sday)?|wed(?:nesday)?|thu(?:rsday)?|fri(?:day)?|sat(?:urday)?|sun(?:day)?|\s|[–\-,])+:?\s*/iu', '', trim($val)));
    }
}

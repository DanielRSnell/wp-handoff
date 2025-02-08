<?php

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/core/helpers.php';
require_once __DIR__ . '/includes/core/ThemeSetup.php';
require_once __DIR__ . '/includes/core/Security.php';
require_once __DIR__ . '/includes/core/Performance.php';

// Initialize theme
ThemeSetup::getInstance();
Security::getInstance();
Performance::getInstance();

// Initialize editor if ACF is available
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('advanced-custom-fields-pro/acf.php') || is_plugin_active('advanced-custom-fields/acf.php')) {
    require_once __DIR__ . '/includes/editor/controller.php';
}

// Load ACF field configurations
if (function_exists('acf_add_local_field_group')) {
    require_once __DIR__ . '/src/component-field.php';
    require_once __DIR__ . '/includes/fields/sync-settings.php';
}

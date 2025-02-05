<?php

require_once __DIR__ . '/vendor/autoload.php';

use Timber\Timber;

/**
 * Initialize Timber
 */
Timber::init();

/**
 * Set Timber views directory
 */
Timber::$dirname = ['src/views'];

/**
 * Load Timber locations if Timber is active
 */
if (class_exists('Timber')) {
    require_once __DIR__ . '/includes/timber/locations.php';
}

/**
 * Include Component Fields
 */
if (function_exists('acf_add_local_field_group')) {
    require_once __DIR__ . '/src/component-field.php';
}

/**
 * Load editor configurations
 */
require_once __DIR__ . '/includes/editor/admin/configure/pages.php';

/**
 * Load editor
 */
require_once __DIR__ . '/includes/editor/editor.php';

/**
 * Set up template directory
 */
add_filter('template_include', function($template) {
    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
        return get_template_directory() . '/includes/editor/views/editor.php';
    }
    
    if (is_page()) {
        return get_template_directory() . '/templates/page.php';
    }
    
    return $template;
}, 999);

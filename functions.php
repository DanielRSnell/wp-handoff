<?php

require_once __DIR__ . '/vendor/autoload.php';

use Timber\Timber;

Timber::init();
Timber::$dirname = ['src/views'];

if (class_exists('Timber')) {
    require_once __DIR__ . '/includes/timber/locations.php';
}

if (function_exists('acf_add_local_field_group')) {
    require_once __DIR__ . '/src/component-field.php';
}

require_once __DIR__ . '/includes/editor/admin/configure/pages.php';
require_once __DIR__ . '/includes/editor/admin/builder/init.php';
require_once __DIR__ . '/includes/fields/sync-settings.php';
require_once __DIR__ . '/includes/editor/editor.php';
require_once __DIR__ . '/src/router/controller.php';

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
});

function add_inter_font_admin()
{
    wp_enqueue_style('inter-font', 'https://rsms.me/inter/inter.css', [], null);

    $custom_css = "
        html, body, input, select, textarea, button, td, th, p, h1, h2, h3, h4, h5, h6, a {
            font-family: 'Inter'!important;
        }
       body.wp-admin,
       .wp-admin input,
       .wp-admin select,
       .wp-admin textarea,
       .wp-admin button {
           font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
       }
   ";

    wp_add_inline_style('admin-bar', $custom_css);
}
add_action('admin_enqueue_scripts', 'add_inter_font_admin');

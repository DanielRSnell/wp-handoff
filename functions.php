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
require_once __DIR__ . '/src/templates/router/controller.php';

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

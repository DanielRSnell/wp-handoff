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

add_filter('template_include', function ($template) {
    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
        return get_template_directory() . '/includes/editor/views/editor.php';
    }

    $template_type = get_field('template_type');
    
    if ($template_type) {
        $custom_template = get_posts([
            'post_type' => 'layout',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => 'template_type',
                    'value' => $template_type,
                    'compare' => '='
                ]
            ]
        ]);

        if ($custom_template) {
            return get_template_directory() . '/templates/dynamic.php';
        }
    }

    if (is_page()) {
        return get_template_directory() . '/templates/page.php';
    }

    return $template;
}, 999);

add_action('after_setup_theme', function() {
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
        'script'
    ]);
});

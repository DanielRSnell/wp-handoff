<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

// Load AJAX handlers first since they don't depend on post type registration
require_once __DIR__ . '/ajax/location-types.php';
require_once __DIR__ . '/ajax/location-items.php';
require_once __DIR__ . '/ajax/preview-options.php';

// Enqueue scripts
add_action('acf/input/admin_enqueue_scripts', function () {
    wp_enqueue_script(
        'location-controls',
        get_template_directory_uri() . '/includes/editor/admin/builder/assets/js/location-controls.js',
        ['jquery', 'acf-input'],
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'preview-controls',
        get_template_directory_uri() . '/includes/editor/admin/builder/assets/js/preview-controls.js',
        ['jquery', 'acf-input'],
        '1.0.0',
        true
    );
});

// Register field group after init
add_action('acf/init', function () {
    // Load field definitions inside the hook
    $location_fields = require_once __DIR__ . '/fields/location.php';
    $preview_fields  = require_once __DIR__ . '/fields/preview.php';

    acf_add_local_field_group([
        'key'                   => 'group_template_settings',
        'title'                 => 'Template Settings',
        'fields'                => [
            [
                'key'       => 'field_template_tabs',
                'label'     => 'Template Settings',
                'name'      => 'template_tabs',
                'type'      => 'tabs',
                'placement' => 'top',
                'endpoint'  => 0,
            ],
            [
                'key'       => 'field_location_tab',
                'label'     => 'Location',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],
            $location_fields,
            [
                'key'       => 'field_preview_tab',
                'label'     => 'Preview',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],
            $preview_fields,
        ],
        'location'              => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'layout',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'side',
        'style'                 => 'seamless',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
    ]);
});

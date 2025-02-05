<?php

if (function_exists('acf_add_options_page')) {
    $parent = acf_add_options_page([
        'page_title' => 'Builder',
        'menu_title' => 'Builder',
        'menu_slug' => 'builder-settings',
        'capability' => 'manage_options',
        'position' => 2,
        'icon_url' => 'dashicons-editor-kitchensink',
        'redirect' => true,
        'autoload' => true
    ]);

    acf_add_options_sub_page([
        'page_title' => 'Dynamic Layouts',
        'menu_title' => 'Dynamic Layouts',
        'parent_slug' => 'builder-settings',
        'menu_slug' => 'dynamic-layouts',
    ]);
}

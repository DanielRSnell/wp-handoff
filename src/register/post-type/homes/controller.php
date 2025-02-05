<?php

return [
    'post_type' => 'homes',
    'args' => [
        'labels' => [
            'name' => 'Homes',
            'singular_name' => 'Home',
            'add_new' => 'Add New Home',
            'add_new_item' => 'Add New Home',
            'edit_item' => 'Edit Home',
            'new_item' => 'New Home',
            'view_item' => 'View Home',
            'search_items' => 'Search Homes',
            'not_found' => 'No homes found',
            'not_found_in_trash' => 'No homes found in Trash',
            'all_items' => 'All Homes',
            'archives' => 'Home Archives',
            'attributes' => 'Home Attributes',
            'menu_name' => 'Homes',
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'homes'],
        'menu_icon' => 'dashicons-admin-home',
        'menu_position' => 5,
        'taxonomies' => ['bedrooms'],
        'show_in_graphql' => true,
        'graphql_single_name' => 'home',
        'graphql_plural_name' => 'homes',
    ]
];

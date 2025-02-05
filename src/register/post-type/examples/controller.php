<?php

return [
    'post_type' => 'examples',
    'args' => [
        'labels' => [
            'name' => 'Examples',
            'singular_name' => 'Examples',
            'add_new' => 'Add New Examples',
            'add_new_item' => 'Add New Examples',
            'edit_item' => 'Edit Examples',
            'new_item' => 'New Examples',
            'view_item' => 'View Examples',
            'search_items' => 'Search Examples',
            'not_found' => 'No examples found',
            'not_found_in_trash' => 'No examples found in Trash',
            'all_items' => 'All Examples',
            'archives' => 'Examples Archives',
            'attributes' => 'Examples Attributes',
            'menu_name' => 'Examples'
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'examples'],
        'menu_icon' => 'dashicons-admin-post',
        'menu_position' => 5,
        'show_in_graphql' => true,
        'graphql_single_name' => 'examples',
        'graphql_plural_name' => 'examples'
    ]
];

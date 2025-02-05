<?php

return [
    'post_type' => '{{lowercase_name}}',
    'args' => [
        'labels' => [
            'name' => '{{menu_name}}',
            'singular_name' => '{{menu_name}}',
            'add_new' => 'Add New {{menu_name}}',
            'add_new_item' => 'Add New {{menu_name}}',
            'edit_item' => 'Edit {{menu_name}}',
            'new_item' => 'New {{menu_name}}',
            'view_item' => 'View {{menu_name}}',
            'search_items' => 'Search {{plural_name}}',
            'not_found' => 'No {{lowercase_plural_name}} found',
            'not_found_in_trash' => 'No {{lowercase_plural_name}} found in Trash',
            'all_items' => 'All {{plural_name}}',
            'archives' => '{{menu_name}} Archives',
            'attributes' => '{{menu_name}} Attributes',
            'menu_name' => '{{plural_name}}'
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => '{{lowercase_plural_name}}'],
        'menu_icon' => 'dashicons-admin-post',
        'menu_position' => 5,
        'show_in_graphql' => true,
        'graphql_single_name' => '{{lowercase_name}}',
        'graphql_plural_name' => '{{lowercase_plural_name}}'
    ]
];

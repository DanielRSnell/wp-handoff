<?php

return [
    'taxonomy' => 'bedrooms',
    'object_type' => ['homes'],
    'args' => [
        'labels' => [
            'name' => 'Bedrooms',
            'singular_name' => 'Bedroom',
            'search_items' => 'Search Bedrooms',
            'all_items' => 'All Bedrooms',
            'parent_item' => 'Parent Bedroom',
            'parent_item_colon' => 'Parent Bedroom:',
            'edit_item' => 'Edit Bedroom',
            'update_item' => 'Update Bedroom',
            'add_new_item' => 'Add New Bedroom',
            'new_item_name' => 'New Bedroom Name',
            'menu_name' => 'Bedrooms',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'bedrooms'],
        'show_in_rest' => true,
        'show_in_graphql' => true,
        'graphql_single_name' => 'bedroom',
        'graphql_plural_name' => 'bedrooms',
    ]
];

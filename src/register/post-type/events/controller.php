<?php

return [
    'post_type' => 'events',
    'args' => [
        'labels' => [
            'name' => 'Events',
            'singular_name' => 'Events',
            'add_new' => 'Add New Events',
            'add_new_item' => 'Add New Events',
            'edit_item' => 'Edit Events',
            'new_item' => 'New Events',
            'view_item' => 'View Events',
            'search_items' => 'Search Events',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'all_items' => 'All Events',
            'archives' => 'Events Archives',
            'attributes' => 'Events Attributes',
            'menu_name' => 'Events'
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'events'],
        'menu_icon' => 'dashicons-admin-post',
        'menu_position' => 5,
        'show_in_graphql' => true,
        'graphql_single_name' => 'events',
        'graphql_plural_name' => 'events'
    ]
];

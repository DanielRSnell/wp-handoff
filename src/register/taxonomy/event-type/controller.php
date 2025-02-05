<?php

return [
    'taxonomy' => 'eventtype',
    'object_type' => ['post'],
    'args' => [
        'labels' => [
            'name' => 'Event Type',
            'singular_name' => 'Event Type',
            'search_items' => 'Search Event Types',
            'all_items' => 'All Event Types',
            'parent_item' => 'Parent Event Type',
            'parent_item_colon' => 'Parent Event Type:',
            'edit_item' => 'Edit Event Type',
            'update_item' => 'Update Event Type',
            'add_new_item' => 'Add New Event Type',
            'new_item_name' => 'New Event Type Name',
            'menu_name' => 'Event Types'
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'event-types'],
        'show_in_rest' => true,
        'show_in_graphql' => true,
        'graphql_single_name' => 'eventtype',
        'graphql_plural_name' => 'event-types'
    ]
];

<?php

return [
    'taxonomy' => '{{lowercase_name}}',
    'object_type' => ['post'],
    'args' => [
        'labels' => [
            'name' => '{{menu_name}}',
            'singular_name' => '{{menu_name}}',
            'search_items' => 'Search {{plural_name}}',
            'all_items' => 'All {{plural_name}}',
            'parent_item' => 'Parent {{menu_name}}',
            'parent_item_colon' => 'Parent {{menu_name}}:',
            'edit_item' => 'Edit {{menu_name}}',
            'update_item' => 'Update {{menu_name}}',
            'add_new_item' => 'Add New {{menu_name}}',
            'new_item_name' => 'New {{menu_name}} Name',
            'menu_name' => '{{plural_name}}'
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => '{{lowercase_plural_name}}'],
        'show_in_rest' => true,
        'show_in_graphql' => true,
        'graphql_single_name' => '{{lowercase_name}}',
        'graphql_plural_name' => '{{lowercase_plural_name}}'
    ]
];

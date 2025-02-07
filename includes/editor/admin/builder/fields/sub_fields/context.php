<?php

return [
    [
        'key' => 'field_context_type',
        'label' => 'Context Type',
        'name' => 'context_type',
        'type' => 'select',
        'required' => 1,
        'choices' => [
            'front_page' => 'Front Page',
            'blog_index' => 'Blog Index',
            '404' => '404 Page',
            'search' => 'Search Results',
            'date_archive' => 'Date Archive',
            'author_archive' => 'Author Archive',
            'post_type' => 'Post Type',
            'taxonomy' => 'Taxonomy',
            'hook' => 'Custom Hook',
            'route' => 'Custom Route'
        ],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'template'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_taxonomy_type',
        'label' => 'Select Taxonomy',
        'name' => 'taxonomy_type',
        'type' => 'select',
        'choices' => [],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_context_type',
                    'operator' => '==',
                    'value' => 'taxonomy'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_taxonomy_display_context',
        'label' => 'Display Context',
        'name' => 'taxonomy_display_context',
        'type' => 'select',
        'choices' => [
            'archive' => 'Archive/List',
            'single' => 'Single Term'
        ],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_context_type',
                    'operator' => '==',
                    'value' => 'taxonomy'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_post_type',
        'label' => 'Post Type',
        'name' => 'post_type',
        'type' => 'select',
        'choices' => [],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_context_type',
                    'operator' => '==',
                    'value' => 'post_type'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_display_context',
        'label' => 'Display Context',
        'name' => 'display_context',
        'type' => 'select',
        'choices' => [
            'singular' => 'Singular',
            'archive' => 'Archive'
        ],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_context_type',
                    'operator' => '==',
                    'value' => 'post_type'
                ]
            ]
        ]
    ]
];

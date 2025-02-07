<?php

return [
    [
        'key' => 'field_context_type',
        'label' => 'Context Type',
        'name' => 'context_type',
        'type' => 'select',
        'required' => 1,
        'choices' => [
            'post_type' => 'Post Type',
            'taxonomy' => 'Taxonomy',
            'woocommerce' => 'WooCommerce',
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
        'key' => 'field_post_type',
        'label' => 'Post Type',
        'name' => 'post_type',
        'type' => 'select',
        'choices' => [], // Will be populated dynamically
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

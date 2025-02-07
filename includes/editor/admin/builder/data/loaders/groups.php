<?php

function get_location_groups() {
    return [
        'layout' => [
            'header' => [
                'label' => 'Header',
                'description' => 'Site header layout'
            ],
            'footer' => [
                'label' => 'Footer',
                'description' => 'Site footer layout'
            ],
            'template' => [
                'label' => 'Template',
                'description' => 'Content template layout'
            ],
            'block' => [
                'label' => 'Block',
                'description' => 'Reusable block layout'
            ],
            'admin' => [
                'label' => 'Admin',
                'description' => 'Admin page layout'
            ]
        ],
        'context' => [
            'post_type' => [
                'label' => 'Post Type',
                'description' => 'Content type specific layout'
            ],
            'taxonomy' => [
                'label' => 'Taxonomy',
                'description' => 'Taxonomy specific layout'
            ],
            'woocommerce' => [
                'label' => 'WooCommerce',
                'description' => 'WooCommerce specific layout'
            ],
            'hook' => [
                'label' => 'Custom Hook',
                'description' => 'Layout for specific action hook'
            ],
            'route' => [
                'label' => 'Custom Route',
                'description' => 'Layout for custom URL pattern'
            ]
        ]
    ];
}

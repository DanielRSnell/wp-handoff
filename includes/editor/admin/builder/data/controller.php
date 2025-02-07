<?php

require_once __DIR__ . '/loaders/post-types.php';
require_once __DIR__ . '/loaders/taxonomies.php';
require_once __DIR__ . '/loaders/groups.php';

function get_all_location_data() {
    return [
        'post_types' => get_location_post_types(),
        'taxonomies' => get_location_taxonomies(),
        'groups' => get_location_groups(),
        'conditions' => [
            'is_front_page',
            'is_home',
            'is_single',
            'is_archive',
            'is_post_type_archive',
            'is_tax',
            'is_author',
            'is_category',
            'is_tag',
            'is_page',
            'is_singular',
            'is_search',
            'is_404',
            'is_shop',          // WooCommerce
            'is_product',       // WooCommerce
            'is_cart',         // WooCommerce
            'is_checkout',     // WooCommerce
            'is_account_page'  // WooCommerce
        ]
    ];
}

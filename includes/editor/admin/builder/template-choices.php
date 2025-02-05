<?php

function get_dynamic_template_choices() {
    $choices = [];

    $post_types = get_post_types([
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true
    ], 'objects');

    $singular_choices = [];
    foreach ($post_types as $post_type) {
        if ($post_type->name !== 'attachment') {
            $singular_choices["single_{$post_type->name}"] = "Single {$post_type->labels->name}";
        }
    }
    if (!empty($singular_choices)) {
        $choices['Singular'] = $singular_choices;
    }

    $archive_choices = get_archive_choices();
    if (!empty($archive_choices)) {
        $choices['Archive'] = $archive_choices;
    }

    $choices['Specialty'] = [
        'front_page' => 'Front Page',
        'blog_index' => 'Blog Posts Index',
        'search' => 'Search Results',
        '404' => '404 Not Found',
        'custom_loop' => 'Custom Post Loop'
    ];

    if (class_exists('WooCommerce')) {
        $choices['WooCommerce'] = get_woocommerce_choices();
    }

    return $choices;
}

function get_archive_choices() {
    $choices = [];
    
    $taxonomies = get_taxonomies([
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true
    ], 'objects');

    foreach ($taxonomies as $taxonomy) {
        $choices["taxonomy_{$taxonomy->name}"] = "{$taxonomy->labels->name} Archive";
    }

    return $choices;
}

function get_woocommerce_choices() {
    if (!class_exists('WooCommerce')) return [];

    return [
        'Shop Pages' => [
            'wc_shop' => 'Shop Main Page',
            'wc_product_category' => 'Product Category Archive',
            'wc_product_tag' => 'Product Tag Archive',
            'wc_product_attribute' => 'Product Attribute Archive'
        ],
        'Single Product' => [
            'wc_product' => 'Single Product',
            'wc_product_variation' => 'Product Variation'
        ],
        'Account Pages' => [
            'wc_account_dashboard' => 'Account Dashboard',
            'wc_account_orders' => 'Orders Page',
            'wc_account_downloads' => 'Downloads Page',
            'wc_account_addresses' => 'Addresses Page',
            'wc_account_payment_methods' => 'Payment Methods Page',
            'wc_account_edit' => 'Account Details Page'
        ],
        'Checkout Flow' => [
            'wc_cart' => 'Cart Page',
            'wc_checkout' => 'Checkout Page',
            'wc_order_received' => 'Order Received Page',
            'wc_order_tracking' => 'Order Tracking Page'
        ]
    ];
}

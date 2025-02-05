<?php

require_once __DIR__ . '/loaders/post-types.php';
require_once __DIR__ . '/loaders/taxonomies.php';
require_once __DIR__ . '/loaders/groups.php';

function get_all_location_data()
{
    $post_type_data = get_location_post_types();
    $taxonomy_data  = get_location_taxonomies();

    return [
        'groups' => get_location_groups(),
        'types'  => array_merge(
            $post_type_data['types'],
            $taxonomy_data['types']
        ),
        'items'  => array_merge(
            $post_type_data['items'],
            $taxonomy_data['items']
        ),
    ];
}

function register_types_and_taxonomies_endpoint()
{
    register_rest_route('custom/v1', '/types-and-taxonomies', [
        'methods'             => 'GET',
        'callback'            => 'get_types_and_taxonomies',
        'permission_callback' => '__return_true',
    ]);
}
add_action('rest_api_init', 'register_types_and_taxonomies_endpoint');

function get_all_types_and_taxonomies()
{
    $types = [];

    // Get all public post types
    $post_types = get_post_types([
        'public'              => true,
        'exclude_from_search' => false,
    ], 'objects');

    // Remove attachments
    if (isset($post_types['attachment'])) {
        unset($post_types['attachment']);
    }

    // Build post types
    foreach ($post_types as $post_type) {
        $key         = "post_type_{$post_type->name}";
        $types[$key] = $post_type->labels->name ?? $post_type->label;

        // Add archive version if supported
        if (! empty($post_type->has_archive)) {
            $types["{$key}_archive"] = sprintf('%s Archive', $post_type->labels->name ?? $post_type->label);
        }
    }

    // Get all public taxonomies
    $taxonomies = get_taxonomies([
        'public'       => true,
        'show_in_rest' => true,
    ], 'objects');

    // Remove post formats if needed
    if (isset($taxonomies['post_format'])) {
        unset($taxonomies['post_format']);
    }

    // Build taxonomies
    foreach ($taxonomies as $tax) {
        $key         = "taxonomy_{$tax->name}";
        $types[$key] = $tax->labels->name ?? $tax->label;
    }

    return $types;
}

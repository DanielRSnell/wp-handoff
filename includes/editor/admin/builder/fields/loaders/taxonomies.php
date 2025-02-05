<?php

function get_location_taxonomies() {
    $taxonomies = get_taxonomies([
        'public' => true,
        'show_ui' => true
    ], 'objects');

    $type_options = [];
    $items = [];

    foreach ($taxonomies as $tax) {
        $key = "taxonomy_{$tax->name}";
        $type_options[$key] = $tax->label;

        $terms = get_terms([
            'taxonomy' => $tax->name,
            'hide_empty' => false
        ]);

        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $items["{$tax->name}_term_{$term->slug}"] = [
                    'title' => $term->name,
                    'id' => $term->term_id,
                    'type' => $tax->name
                ];
            }
        }
    }

    return [
        'types' => $type_options,
        'items' => $items
    ];
}

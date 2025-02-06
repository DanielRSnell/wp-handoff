<?php

use Timber\Timber;

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

// Get the layout template for single posts
$custom_template = get_posts([
    'post_type' => 'layout',
    'posts_per_page' => 1,
    'meta_query' => [
        [
            'key' => 'template_type',
            'value' => 'single_post',
            'compare' => '='
        ]
    ]
]);

if ($custom_template) {
    $template_id = $custom_template[0]->ID;
    $components = get_field('components', $template_id) ?: [];

    $processed_components = [];
    foreach($components as $component) {
        $type = $component['acf_fc_layout'] ?? null;
        $style = $component['style'] ?? null;
        
        if ($type && $style) {
            $component_data = apply_filters("wp_handoff_component_{$type}_data", $component);
            
            $processed_components[] = [
                'type' => $type,
                'style' => $style,
                'data' => $component_data
            ];
        }
    }

    $context['components'] = $processed_components;
}

Timber::render('@core/base.twig', $context);

<?php

use Timber\Timber;

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

$components = get_field('components', $timber_post->ID) ?: [];

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

Timber::render('@core/base.twig', $context);

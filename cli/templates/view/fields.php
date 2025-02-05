<?php

/**
 * Component Fields Configuration
 * 
 * This file defines the fields available in the component.
 * The fields will be displayed in the ACF flexible content editor.
 * 
 * Available field types:
 * - text
 * - textarea
 * - wysiwyg
 * - image
 * - gallery
 * - select
 * - checkbox
 * - radio
 * - true_false
 * - link
 * - post_object
 * - relationship
 * - taxonomy
 * - user
 * - google_map
 * - date_picker
 * - color_picker
 * - message
 * - tab
 * - group
 * - repeater
 * - flexible_content
 */

// Get available variants for the style selector
$variants_dir = __DIR__ . '/variants';
$variants = array_filter(glob($variants_dir . '/*.twig'), 'is_file');

$choices = [];
foreach ($variants as $variant) {
    $name = basename($variant, '.twig');
    $label = ucwords(str_replace('-', ' ', $name));
    $choices[$name] = $label;
}

return [
    /**
     * Style Selector
     * Automatically populated based on variant templates in the variants directory
     */
    [
        'key' => 'field_{{lowercase_name}}_style',
        'label' => 'Style',
        'name' => 'style',
        'type' => 'select',
        'choices' => $choices,
        'required' => 1,
    ],

    /**
     * Example Fields
     * Uncomment and modify these example fields as needed
     */
    
    /*
    // Title Field
    [
        'key' => 'field_{{lowercase_name}}_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text',
        'required' => 1,
    ],

    // Content Field
    [
        'key' => 'field_{{lowercase_name}}_content',
        'label' => 'Content',
        'name' => 'content',
        'type' => 'wysiwyg',
        'tabs' => 'visual',
        'toolbar' => 'full',
        'media_upload' => 1,
    ],

    // Query Fields Example
    [
        'key' => 'field_{{lowercase_name}}_query',
        'label' => 'Query Settings',
        'name' => 'query',
        'type' => 'group',
        'sub_fields' => [
            [
                'key' => 'field_{{lowercase_name}}_post_type',
                'label' => 'Post Type',
                'name' => 'post_type',
                'type' => 'select',
                'choices' => [
                    'post' => 'Posts',
                    'page' => 'Pages',
                    // Add custom post types here
                ],
            ],
            [
                'key' => 'field_{{lowercase_name}}_posts_per_page',
                'label' => 'Posts Per Page',
                'name' => 'posts_per_page',
                'type' => 'number',
                'default_value' => 10,
            ],
        ],
    ],
    */
];

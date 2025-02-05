<?php

return [
    [
        'key' => 'group_theme_settings',
        'title' => 'Theme Settings',
        'fields' => [
            [
                'key' => 'field_theme_branding',
                'label' => 'Branding',
                'name' => 'branding',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_theme_logo',
                        'label' => 'Logo',
                        'name' => 'logo',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ],
                    [
                        'key' => 'field_theme_favicon',
                        'label' => 'Favicon',
                        'name' => 'favicon',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ],
                ],
            ],
            [
                'key' => 'field_theme_colors',
                'label' => 'Colors',
                'name' => 'colors',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_theme_primary_color',
                        'label' => 'Primary Color',
                        'name' => 'primary_color',
                        'type' => 'color_picker',
                    ],
                    [
                        'key' => 'field_theme_secondary_color',
                        'label' => 'Secondary Color',
                        'name' => 'secondary_color',
                        'type' => 'color_picker',
                    ],
                    [
                        'key' => 'field_theme_accent_color',
                        'label' => 'Accent Color',
                        'name' => 'accent_color',
                        'type' => 'color_picker',
                    ],
                ],
            ],
            [
                'key' => 'field_theme_typography',
                'label' => 'Typography',
                'name' => 'typography',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_theme_heading_font',
                        'label' => 'Heading Font',
                        'name' => 'heading_font',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_theme_body_font',
                        'label' => 'Body Font',
                        'name' => 'body_font',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'key' => 'field_theme_social',
                'label' => 'Social Media',
                'name' => 'social',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_theme_facebook',
                        'label' => 'Facebook URL',
                        'name' => 'facebook',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'field_theme_twitter',
                        'label' => 'Twitter URL',
                        'name' => 'twitter',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'field_theme_instagram',
                        'label' => 'Instagram URL',
                        'name' => 'instagram',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'field_theme_linkedin',
                        'label' => 'LinkedIn URL',
                        'name' => 'linkedin',
                        'type' => 'url',
                    ],
                ],
            ],
            [
                'key' => 'field_theme_scripts',
                'label' => 'Custom Scripts',
                'name' => 'scripts',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_theme_header_scripts',
                        'label' => 'Header Scripts',
                        'name' => 'header_scripts',
                        'type' => 'textarea',
                        'instructions' => 'Add custom scripts to header (before closing head tag)',
                    ],
                    [
                        'key' => 'field_theme_footer_scripts',
                        'label' => 'Footer Scripts',
                        'name' => 'footer_scripts',
                        'type' => 'textarea',
                        'instructions' => 'Add custom scripts to footer (before closing body tag)',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-settings',
                ],
            ],
        ],
    ],
];

<?php

return [
    [
        'key' => 'field_accordion_title',
        'label' => 'Block Title',
        'name' => 'title',
        'type' => 'text',
        'instructions' => 'Main title for the accordion section',
        'required' => 1,
    ],
    [
        'key' => 'field_accordion_description',
        'label' => 'Description',
        'name' => 'description',
        'type' => 'textarea',
        'instructions' => 'Optional description text below the title',
        'rows' => 2,
    ],
    [
        'key' => 'field_accordion_items',
        'label' => 'Accordion Items',
        'name' => 'items',
        'type' => 'repeater',
        'required' => 1,
        'min' => 1,
        'layout' => 'block',
        'button_label' => 'Add Accordion Item',
        'sub_fields' => [
            [
                'key' => 'field_accordion_item_title',
                'label' => 'Item Title',
                'name' => 'title',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_accordion_item_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'required' => 1,
            ],
            [
                'key' => 'field_accordion_item_icon',
                'label' => 'Icon',
                'name' => 'icon',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                    'alert' => 'Alert',
                    'check' => 'Check',
                    'info' => 'Info',
                    'question' => 'Question',
                    'settings' => 'Settings',
                ],
                'default_value' => 'none',
            ],
        ],
    ],
    [
        'key' => 'field_accordion_style',
        'label' => 'Style',
        'name' => 'style',
        'type' => 'select',
        'choices' => [
            'default' => 'Default',
            'bordered' => 'Bordered',
            'minimal' => 'Minimal'
        ],
        'default_value' => 'default',
    ],
];

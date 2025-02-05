<?php

return [
    [
        'key' => 'field_quote_style',
        'label' => 'Style',
        'name' => 'style',
        'type' => 'select',
        'choices' => [
            'default' => 'Default',
            'bordered' => 'Bordered',
            'minimal' => 'Minimal'
        ],
        'default_value' => 'default',
        'required' => 1,
    ],
    [
        'key' => 'field_quote_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text',
        'required' => 1,
    ],
    [
        'key' => 'field_quote_content',
        'label' => 'Content',
        'name' => 'content',
        'type' => 'wysiwyg',
        'tabs' => 'visual',
        'toolbar' => 'full',
        'media_upload' => 1,
        'required' => 1,
    ],
];

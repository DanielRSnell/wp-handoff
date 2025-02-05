<?php

return [
    [
        'key' => 'field_{{lowercase_name}}_style',
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
        'key' => 'field_{{lowercase_name}}_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text',
        'required' => 1,
    ],
    [
        'key' => 'field_{{lowercase_name}}_content',
        'label' => 'Content',
        'name' => 'content',
        'type' => 'wysiwyg',
        'tabs' => 'visual',
        'toolbar' => 'full',
        'media_upload' => 1,
        'required' => 1,
    ],
];

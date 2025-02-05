<?php

return [
    [
        'key' => 'group_{{lowercase_name}}_taxonomy',
        'title' => '{{name}} Details',
        'fields' => [
            [
                'key' => 'field_{{lowercase_name}}_icon',
                'label' => 'Icon',
                'name' => 'icon',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ],
            [
                'key' => 'field_{{lowercase_name}}_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => '{{lowercase_name}}',
                ],
            ],
        ],
    ],
];

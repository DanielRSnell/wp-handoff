<?php

return [
    [
        'key' => 'group_bedroom_taxonomy',
        'title' => 'Bedroom Details',
        'fields' => [
            [
                'key' => 'field_bedroom_icon',
                'label' => 'Icon',
                'name' => 'icon',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ],
            [
                'key' => 'field_bedroom_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_bedroom_average_size',
                'label' => 'Average Room Size',
                'name' => 'average_size',
                'type' => 'text',
                'instructions' => 'e.g., "12\' x 14\'"',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'bedrooms',
                ],
            ],
        ],
    ],
];

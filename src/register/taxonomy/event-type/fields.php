<?php

return [
    [
        'key' => 'group_eventtype_taxonomy',
        'title' => 'EventType Details',
        'fields' => [
            [
                'key' => 'field_eventtype_icon',
                'label' => 'Icon',
                'name' => 'icon',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ],
            [
                'key' => 'field_eventtype_description',
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
                    'value' => 'eventtype',
                ],
            ],
        ],
    ],
];

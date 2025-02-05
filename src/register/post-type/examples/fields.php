<?php

return [
    [
        'key' => 'group_examples',
        'title' => 'Examples Details',
        'fields' => [
            [
                'key' => 'field_examples_details',
                'label' => 'Details',
                'name' => 'details',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    // Add your fields here
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'examples',
                ],
            ],
        ],
    ],
];

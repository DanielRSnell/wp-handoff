<?php

return [
    [
        'key' => 'group_events',
        'title' => 'Events Details',
        'fields' => [
            [
                'key' => 'field_events_details',
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
                    'value' => 'events',
                ],
            ],
        ],
    ],
];

<?php

return [
    [
        'key' => 'group_{{lowercase_name}}',
        'title' => '{{name}} Details',
        'fields' => [
            [
                'key' => 'field_{{lowercase_name}}_details',
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
                    'value' => '{{lowercase_name}}',
                ],
            ],
        ],
    ],
];

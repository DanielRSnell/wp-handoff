<?php

return [
    [
        'key' => 'group_{{lowercase_name}}',
        'title' => '{{name}}',
        'fields' => [
            [
                'key' => 'field_{{lowercase_name}}_settings',
                'label' => 'Settings',
                'name' => 'settings',
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
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => '{{lowercase_name}}',
                ],
            ],
        ],
    ],
];

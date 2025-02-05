<?php

return [
    [
        'key' => 'group_homesettings',
        'title' => 'HomeSettings',
        'fields' => [
            [
                'key' => 'field_homesettings_settings',
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
                    'value' => 'homesettings',
                ],
            ],
        ],
    ],
];

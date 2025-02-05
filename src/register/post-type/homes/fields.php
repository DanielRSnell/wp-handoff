<?php

return [
    [
        'key' => 'group_homes',
        'title' => 'Home Details',
        'fields' => [
            [
                'key' => 'field_home_price',
                'label' => 'Price',
                'name' => 'price',
                'type' => 'number',
                'required' => 1,
                'min' => 0,
                'step' => 1,
            ],
            [
                'key' => 'field_home_square_feet',
                'label' => 'Square Feet',
                'name' => 'square_feet',
                'type' => 'number',
                'required' => 1,
                'min' => 0,
            ],
            [
                'key' => 'field_home_bathrooms',
                'label' => 'Bathrooms',
                'name' => 'bathrooms',
                'type' => 'number',
                'required' => 1,
                'min' => 0,
                'step' => 0.5,
            ],
            [
                'key' => 'field_home_gallery',
                'label' => 'Gallery',
                'name' => 'gallery',
                'type' => 'gallery',
                'return_format' => 'array',
            ],
            [
                'key' => 'field_home_features',
                'label' => 'Features',
                'name' => 'features',
                'type' => 'repeater',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key' => 'field_home_feature_name',
                        'label' => 'Feature',
                        'name' => 'feature',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'key' => 'field_home_location',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'google_map',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'homes',
                ],
            ],
        ],
    ],
];

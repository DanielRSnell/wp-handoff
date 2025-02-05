<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

require_once __DIR__ . '/template-choices.php';

acf_add_local_field_group([
    'key'                   => 'group_template_settings',
    'title'                 => 'Template Settings',
    'fields'                => [
        [
            'key'               => 'field_template_type',
            'label'             => 'Location Rules',
            'name'              => 'template_type',
            'type'              => 'select',
            'instructions'      => '',
            'required'          => 1,
            'conditional_logic' => 0,
            'wrapper'           => [
                'width' => '',
                'class' => 'template-type-selector',
                'id'    => '',
            ],
            'choices'           => get_dynamic_template_choices(),
            'default_value'     => '',
            'allow_null'        => 0,
            'multiple'          => 0,
            'ui'                => 1,
            'return_format'     => 'value',
            'placeholder'       => 'Select a template type',
            'ajax'              => 0,
        ],
    ],
    'location'              => [
        [
            [
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'layout',
            ],
        ],
    ],
    'menu_order'            => 0,
    'position'              => 'side',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen'        => '',
    'active'                => true,
    'description'           => '',
]);

add_filter('acf/load_field/name=template_type', function ($field) {
    $field['choices']  = get_dynamic_template_choices();
    $field['multiple'] = 0;
    return $field;
});

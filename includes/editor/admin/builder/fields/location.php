<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

require_once __DIR__ . '/data.php';

add_action('admin_enqueue_scripts', function () {
    if (get_current_screen()->post_type === 'layout') {
        wp_localize_script('acf-input', 'locationOptions', get_all_location_data());
    }
});

$options = get_all_location_data();

return [
    'key'          => 'field_location_rules',
    'label'        => 'Location Rules',
    'name'         => 'location_rules',
    'type'         => 'repeater',
    'instructions' => 'Add location rules to use this layout in the site theme.',
    'required'     => 1,
    'min'          => 1,
    'layout'       => 'block',
    'button_label' => 'Add Location Rule',
    'sub_fields'   => [
        [
            'key'           => 'field_rule_group',
            'label'         => 'Group',
            'name'          => 'group',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => $options['groups'],
            'default_value' => '',
            'ui'            => 1,
            'return_format' => 'value',
            'placeholder'   => 'Select Group',
        ],
        [
            'key'           => 'field_rule_type',
            'label'         => 'Type',
            'name'          => 'type',
            'type'          => 'select',
            'required'      => 0,
            'choices'       => get_all_types_and_taxonomies(),
            'default_value' => '',
            'ui'            => 1,
            'return_format' => 'value',
            'placeholder'   => 'Select Type',
            'wrapper'       => [
                'class' => 'rule-type-field',
            ],
        ],
        [
            'key'           => 'field_rule_mode',
            'label'         => 'Mode',
            'name'          => 'mode',
            'type'          => 'select',
            'required'      => 0,
            'choices'       => [
                'all'     => 'All',
                'include' => 'Include',
                'exclude' => 'Exclude',
            ],
            'default_value' => 'all',
            'ui'            => 1,
            'return_format' => 'value',
            'placeholder'   => 'Select Mode',
            'wrapper'       => [
                'class' => 'rule-mode-field',
            ],
        ],
        [
            'key'           => 'field_rule_items',
            'label'         => 'Items',
            'name'          => 'items',
            'type'          => 'select',
            'required'      => 0,
            'choices'       => array_combine(
                array_map(function ($item) {return $item['id'];}, $options['items']),
                array_map(function ($item) {return $item['title'];}, $options['items'])
            ),
            'default_value' => [],
            'ui'            => 1,
            'multiple'      => 1,
            'return_format' => 'value',
            'placeholder'   => 'Select Items',
            'wrapper'       => [
                'class' => 'rule-items-field',
            ],
        ],
    ],
];

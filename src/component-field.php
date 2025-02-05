<?php

if (function_exists('acf_add_local_field_group')):

// Get all component directories in the views folder
    $components_dir = __DIR__ . '/views';
    $components     = array_filter(glob($components_dir . '/*'), 'is_dir');

    $layouts = [];

// Dynamically build layouts from each component
    foreach ($components as $component_path) {
        $component_name  = basename($component_path);
        $fields_file     = $component_path . '/fields.php';
        $controller_file = $component_path . '/controller.php';

        // Load controller if exists
        if (file_exists($controller_file)) {
            require_once $controller_file;
        }

        if (file_exists($fields_file)) {
            $layouts["layout_{$component_name}"] = [
                'key'        => "layout_{$component_name}",
                'name'       => $component_name,
                'label'      => ucfirst($component_name),
                'display'    => 'block',
                'sub_fields' => require $fields_file,
            ];
        }
    }

    acf_add_local_field_group([
        'key'                   => 'group_components',
        'title'                 => 'Components',
        'fields'                => [
            [
                'key'          => 'field_components_flexible',
                'label'        => 'Components',
                'name'         => 'components',
                'type'         => 'flexible_content',
                'layouts'      => $layouts,
                'button_label' => 'Add Component',
                'min'          => 1,
            ],
        ],
        'location'              => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'page',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'layout',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
    ]);

endif;

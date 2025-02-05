<?php

function register_block_fields() {
    $blocks_path = get_stylesheet_directory() . '/src/blocks';
    if (!is_dir($blocks_path)) return;

    $block_dirs = glob($blocks_path . '/*', GLOB_ONLYDIR);
    foreach ($block_dirs as $block_dir) {
        $fields_file = $block_dir . '/fields.php';
        $block_name = basename($block_dir);
        
        if (file_exists($fields_file)) {
            $fields = require $fields_file;
            
            if (!empty($fields)) {
                acf_add_local_field_group([
                    'key' => 'group_block_' . $block_name,
                    'title' => ucwords(str_replace('-', ' ', $block_name)),
                    'fields' => $fields,
                    'location' => [
                        [
                            [
                                'param' => 'block',
                                'operator' => '==',
                                'value' => 'acf/' . $block_name,
                            ],
                        ],
                    ],
                    'menu_order' => 0,
                    'position' => 'normal',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => '',
                    'active' => true,
                    'show_in_rest' => true,
                ]);
            }
        }
    }
}

function register_acf_blocks() {
    $blocks_path = get_stylesheet_directory() . '/src/blocks';
    if (!is_dir($blocks_path)) return;

    $block_categories = [];
    $block_dirs = glob($blocks_path . '/*', GLOB_ONLYDIR);

    foreach ($block_dirs as $block_dir) {
        $block_json_file = $block_dir . '/block.json';
        if (file_exists($block_json_file)) {
            $block_data = json_decode(file_get_contents($block_json_file), true);
            if (!empty($block_data['category'])) {
                $block_categories[$block_data['category']] = true;
            }
        }
    }

    add_filter('block_categories_all', function ($categories) use ($block_categories) {
        foreach (array_keys($block_categories) as $category) {
            $categories[] = [
                'slug' => sanitize_title($category),
                'title' => ucwords(str_replace('-', ' ', $category)),
                'icon' => null,
            ];
        }
        return array_unique($categories, SORT_REGULAR);
    });

    foreach ($block_dirs as $block_dir) {
        if (file_exists($block_dir . '/block.json')) {
            register_block_type($block_dir);
        }
    }
}

add_action('acf/init', 'register_block_fields');
add_action('init', 'register_acf_blocks');

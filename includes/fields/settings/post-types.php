<?php

function register_custom_post_types() {
    $post_types_dir = get_stylesheet_directory() . '/src/register/post-type';
    if (!is_dir($post_types_dir)) return;

    $post_type_dirs = glob($post_types_dir . '/*', GLOB_ONLYDIR);
    
    foreach ($post_type_dirs as $post_type_dir) {
        $controller_file = $post_type_dir . '/controller.php';
        $fields_file = $post_type_dir . '/fields.php';
        
        // Register Post Type
        if (file_exists($controller_file)) {
            $post_type = require $controller_file;
            if (is_array($post_type) && isset($post_type['post_type']) && isset($post_type['args'])) {
                register_post_type($post_type['post_type'], $post_type['args']);
            }
        }

        // Register Fields
        if (file_exists($fields_file)) {
            $field_groups = require $fields_file;
            if (is_array($field_groups)) {
                // Handle both single field group and array of field groups
                $field_groups = isset($field_groups['key']) ? [$field_groups] : $field_groups;
                
                foreach ($field_groups as $field_group) {
                    if (is_array($field_group) && isset($field_group['key']) && !empty($field_group['fields'])) {
                        acf_add_local_field_group($field_group);
                    }
                }
            }
        }
    }
}

add_action('init', 'register_custom_post_types');

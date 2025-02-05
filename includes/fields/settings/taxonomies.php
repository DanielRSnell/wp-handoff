<?php

function register_custom_taxonomies() {
    $taxonomies_dir = get_stylesheet_directory() . '/src/register/taxonomy';
    if (!is_dir($taxonomies_dir)) return;

    $taxonomy_dirs = glob($taxonomies_dir . '/*', GLOB_ONLYDIR);
    
    foreach ($taxonomy_dirs as $taxonomy_dir) {
        $controller_file = $taxonomy_dir . '/controller.php';
        $fields_file = $taxonomy_dir . '/fields.php';
        
        // Register Taxonomy
        if (file_exists($controller_file)) {
            $taxonomy = require $controller_file;
            if (is_array($taxonomy) && isset($taxonomy['taxonomy']) && isset($taxonomy['object_type']) && isset($taxonomy['args'])) {
                register_taxonomy(
                    $taxonomy['taxonomy'],
                    $taxonomy['object_type'],
                    $taxonomy['args']
                );
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

add_action('init', 'register_custom_taxonomies');

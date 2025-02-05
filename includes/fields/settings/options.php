<?php

function register_options_pages() {
    $options_dir = get_stylesheet_directory() . '/src/register/options';
    if (!is_dir($options_dir)) return;

    $option_dirs = glob($options_dir . '/*', GLOB_ONLYDIR);
    
    foreach ($option_dirs as $option_dir) {
        $controller_file = $option_dir . '/controller.php';
        $fields_file = $option_dir . '/fields.php';
        
        if (file_exists($controller_file)) {
            $options_config = require $controller_file;
            if (is_array($options_config)) {
                acf_add_options_page($options_config);
            }
        }

        if (file_exists($fields_file)) {
            $fields = require $fields_file;
            foreach ($fields as $field_group) {
                if (!empty($field_group['fields'])) {
                    acf_add_local_field_group($field_group);
                }
            }
        }
    }
}

add_action('acf/init', 'register_options_pages');

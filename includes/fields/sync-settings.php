<?php

/* Check for ACF of don't follow through with any of the following */

// Set up ACF JSON save points
function my_acf_json_save_point($path)
{
    return get_stylesheet_directory() . '/src/json-store';
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

// Set up ACF JSON load points
function my_acf_json_load_point($paths)
{
    $paths[] = get_stylesheet_directory() . '/src/json-store';
    return $paths;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

// Customize ACF JSON save paths
function custom_acf_json_save_paths($paths, $post)
{
    $directory = get_stylesheet_directory() . '/src/json-local';

    switch ($post['type']) {
        case 'acf-field-group':
            if (isset($post['location']) && is_array($post['location'])) {
                foreach ($post['location'] as $location_group) {
                    foreach ($location_group as $location_rule) {
                        if ($location_rule['param'] === 'blocks' && $location_rule['operator'] === '==') {
                            $paths = [$directory . '/blocks'];
                            return $paths;
                        }
                    }
                }
            }
            $paths = [$directory . '/fields'];
            break;
        case 'acf-post-type':
            $paths = [$directory . '/post-types'];
            break;
        case 'acf-taxonomy':
            $paths = [$directory . '/taxonomy'];
            break;
        case 'acf-ui-options-page':
            $paths = [$directory . '/options'];
            break;
    }

    return $paths;
}
add_filter('acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2);

// Customize ACF JSON filenames
function custom_acf_json_filename($filename, $post, $load_path)
{
    $filename = str_replace(
        [' ', '_'],
        ['-', '-'],
        strtolower($post['title'])
    );

    return $filename . '.json';
}
add_filter('acf/json/save_file_name', 'custom_acf_json_filename', 10, 3);

/* Register all the blocks using src/blocks/block-name with the file strcuture.

also extract all the categories into a unique array of string and register all of those block categories */

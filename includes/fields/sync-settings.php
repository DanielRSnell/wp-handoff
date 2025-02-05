<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * ACF JSON Save/Load Configuration
 */

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

// Customize ACF JSON save paths based on field type
function custom_acf_json_save_paths($paths, $post)
{
    $directory = get_stylesheet_directory() . '/src/json-store';

    switch ($post['type']) {
        case 'acf-field-group':
            if (isset($post['location']) && is_array($post['location'])) {
                foreach ($post['location'] as $location_group) {
                    foreach ($location_group as $location_rule) {
                        if ($location_rule['param'] === 'block' && $location_rule['operator'] === '==') {
                            return [$directory . '/blocks'];
                        }
                    }
                }
            }
            return [$directory . '/fields'];

        case 'acf-post-type':
            return [$directory . '/post-types'];

        case 'acf-taxonomy':
            return [$directory . '/taxonomy'];

        case 'acf-ui-options-page':
            return [$directory . '/options'];
    }

    return $paths;
}
add_filter('acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2);

/**
 * Block Registration
 */

function register_acf_blocks()
{
    $blocks_path = get_stylesheet_directory() . '/src/blocks';
    if (! is_dir($blocks_path)) {
        return;
    }

    // Get all block categories
    $categories = [];
    $block_dirs = glob($blocks_path . '/*', GLOB_ONLYDIR);

    foreach ($block_dirs as $block_dir) {
        $block_json_file = $block_dir . '/block.json';
        if (file_exists($block_json_file)) {
            $block_data = json_decode(file_get_contents($block_json_file), true);
            if (isset($block_data['category'])) {
                $categories[$block_data['category']] = true;
            }
        }
    }

    // Register block categories
    add_filter('block_categories_all', function ($cats) use ($categories) {
        foreach (array_keys($categories) as $category) {
            $cats[] = [
                'slug'  => sanitize_title($category),
                'title' => ucwords(str_replace('-', ' ', $category)),
                'icon'  => null,
            ];
        }
        return $cats;
    });

    // Register blocks
    foreach ($block_dirs as $block_dir) {
        $block_json_file = $block_dir . '/block.json';
        if (file_exists($block_json_file)) {
            // TODO: Fixed The Following
            // This should register the path to each block, not the JSON file specifically
            register_block_type($block_json_file);
        }
    }
}
add_action('init', 'register_acf_blocks');

/**
 * Register Post Types
 */
function register_custom_post_types()
{
    $post_types_dir = get_stylesheet_directory() . '/src/register/post-type';
    if (! is_dir($post_types_dir)) {
        return;
    }

    $post_type_files = glob($post_types_dir . '/*.php');
    foreach ($post_type_files as $file) {
        require_once $file;
    }
}
add_action('init', 'register_custom_post_types');

/**
 * Register Taxonomies
 */
function register_custom_taxonomies()
{
    $taxonomies_dir = get_stylesheet_directory() . '/src/register/taxonomy';
    if (! is_dir($taxonomies_dir)) {
        return;
    }

    $taxonomy_files = glob($taxonomies_dir . '/*.php');
    foreach ($taxonomy_files as $file) {
        require_once $file;
    }
}
add_action('init', 'register_custom_taxonomies');

/**
 * Register Options Pages
 */
function register_options_pages()
{
    $options_dir = get_stylesheet_directory() . '/src/register/options';
    if (! is_dir($options_dir)) {
        return;
    }

    $options_files = glob($options_dir . '/*.php');
    foreach ($options_files as $file) {
        require_once $file;
    }
}
add_action('acf/init', 'register_options_pages');

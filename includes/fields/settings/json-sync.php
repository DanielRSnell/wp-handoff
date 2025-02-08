<?php

function my_acf_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/json-store';
    if (!is_dir($path)) {
        wp_mkdir_p($path);
    }
    return $path;
}

function my_acf_json_load_point($paths)
{
    $paths[] = get_stylesheet_directory() . '/json-store';
    return array_unique($paths);
}

function custom_acf_json_save_paths($paths, $post)
{
    $directory = get_stylesheet_directory() . '/json-store';

    $subdirs = [
        'blocks' => ['param' => 'block'],
        'fields' => ['type' => 'acf-field-group'],
        'post-types' => ['type' => 'acf-post-type'],
        'taxonomy' => ['type' => 'acf-taxonomy'],
        'options' => ['type' => 'acf-ui-options-page'],
    ];

    foreach ($subdirs as $subdir => $conditions) {
        $full_path = $directory . '/' . $subdir;
        if (!is_dir($full_path)) {
            wp_mkdir_p($full_path);
        }
    }

    if ($post['type'] === 'acf-field-group' && !empty($post['location'])) {
        foreach ($post['location'] as $location_group) {
            foreach ($location_group as $location_rule) {
                if ($location_rule['param'] === 'block' && $location_rule['operator'] === '==') {
                    return [$directory . '/blocks'];
                }
            }
        }
        return [$directory . '/fields'];
    }

    foreach ($subdirs as $subdir => $conditions) {
        if (isset($conditions['type']) && $post['type'] === $conditions['type']) {
            return [$directory . '/' . $subdir];
        }
    }

    return $paths;
}

function sync_acf_fields()
{
    $groups = acf_get_local_field_groups();
    foreach ($groups as $group) {
        $key = $group['key'];
        $path = get_stylesheet_directory() . '/json-store';

        if (isset($group['location'][0][0]['param']) && $group['location'][0][0]['param'] === 'block') {
            $path .= '/blocks';
        } else {
            $path .= '/fields';
        }

        if (!is_dir($path)) {
            wp_mkdir_p($path);
        }

        $file = $path . '/' . $key . '.json';
        $json = acf_prepare_field_group_for_export($group);
        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));
    }
}

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
add_filter('acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2);
add_action('acf/update_field_group', 'sync_acf_fields');
add_action('acf/delete_field_group', 'sync_acf_fields');

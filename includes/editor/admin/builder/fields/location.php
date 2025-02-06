<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

require_once get_template_directory() . '/includes/editor/admin/builder/data/controller.php';

add_action('admin_enqueue_scripts', function () {
    if (get_current_screen()->post_type === 'layout') {
        wp_localize_script('acf-input', 'locationOptions', get_all_location_data());
    }
});

$options = get_all_location_data();

// Change from Repeater to Group

/**
 * Location Rules Field
 * Select Template Type (Post Type, Taxonomy, Options Page, Woocommerce Options (everything that is a is_ function, also include Custom Hooks, and Custom Route) - This will be used for the router, it will check for a Layout that matches is_{$type}() and then use that layout's components, with render.php callback.
 */
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
    'sub_fields'   => [],
];

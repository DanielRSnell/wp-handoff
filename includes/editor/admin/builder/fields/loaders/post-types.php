<?php

function get_location_post_types()
{
    // Get all public post types - same as the API endpoint
    $post_types = get_post_types([
        'public'              => true,
        'exclude_from_search' => false,
    ], 'objects');

    // Remove attachments
    if (isset($post_types['attachment'])) {
        unset($post_types['attachment']);
    }

    // Debug: Let's see what post types we're starting with
    error_log('Initial Post Types: ' . print_r(array_keys($post_types), true));

    $type_options = [];
    $items        = [];

    // Build type_options first - exactly like we get from the API
    foreach ($post_types as $post_type) {
        $key                = "post_type_{$post_type->name}";
        $type_options[$key] = $post_type->labels->name ?? $post_type->label;

        // Add archive version if supported
        if (! empty($post_type->has_archive)) {
            $type_options["{$key}_archive"] = sprintf('%s Archive', $post_type->labels->name ?? $post_type->label);
        }

        // Debug: Log each post type as we process it
        error_log(sprintf(
            'Processing post type: %s, Key: %s, Label: %s',
            $post_type->name,
            $key,
            $type_options[$key]
        ));
    }

    // Debug: Log the type options we built
    error_log('Type Options Built: ' . print_r($type_options, true));

    // Now build items separately - this doesn't affect type_options
    foreach ($post_types as $post_type) {
        $posts = get_posts([
            'post_type'        => $post_type->name,
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        ]);

        foreach ($posts as $post) {
            $items["{$post_type->name}_post_{$post->post_name}"] = [
                'title' => $post->post_title,
                'id'    => $post->ID,
                'type'  => $post_type->name,
            ];
        }
    }

    // Debug: Final counts
    error_log(sprintf(
        'Final Counts - Types: %d, Items: %d',
        count($type_options),
        count($items)
    ));

    return [
        'types' => $type_options,
        'items' => $items,
    ];
}

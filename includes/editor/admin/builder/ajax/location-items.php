<?php

add_action('wp_ajax_load_location_items', function() {
    $group = $_POST['group'] ?? '';
    $type = $_POST['type'] ?? '';
    $choices = [];

    switch ($group) {
        case 'singular':
            $posts = get_posts([
                'post_type' => $type,
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            ]);
            foreach ($posts as $post) {
                $choices[] = [
                    'id' => $post->ID,
                    'text' => $post->post_title
                ];
            }
            break;

        case 'taxonomy':
            $terms = get_terms([
                'taxonomy' => $type,
                'hide_empty' => false
            ]);
            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $choices[] = [
                        'id' => $term->term_id,
                        'text' => $term->name
                    ];
                }
            }
            break;

        case 'author':
            $authors = get_users(['who' => 'authors']);
            foreach ($authors as $author) {
                $choices[] = [
                    'id' => $author->ID,
                    'text' => $author->display_name
                ];
            }
            break;
    }

    wp_send_json_success(['results' => $choices]);
});

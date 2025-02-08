<?php

add_action('wp_ajax_load_location_types', function() {
    $group = $_POST['group'] ?? '';
    $choices = [];

    switch ($group) {
        case 'archive':
            $post_types = get_post_types([
                'public' => true,
                'has_archive' => true
            ], 'objects');
            
            foreach ($post_types as $post_type) {
                $choices[] = [
                    'id' => $post_type->name,
                    'text' => $post_type->label . ' Archive'
                ];
            }
            break;

        case 'singular':
            $post_types = get_post_types(['public' => true], 'objects');
            foreach ($post_types as $post_type) {
                $choices[] = [
                    'id' => $post_type->name,
                    'text' => $post_type->label
                ];
            }
            break;

        case 'taxonomy':
            $taxonomies = get_taxonomies(['public' => true], 'objects');
            foreach ($taxonomies as $tax) {
                $choices[] = [
                    'id' => $tax->name,
                    'text' => $tax->label
                ];
            }
            break;

        case 'author':
            $choices[] = [
                'id' => 'author_archive',
                'text' => 'Author Archive'
            ];
            break;

        case 'date':
            $choices = [
                ['id' => 'date_archive', 'text' => 'Date Archive'],
                ['id' => 'year_archive', 'text' => 'Year Archive'],
                ['id' => 'month_archive', 'text' => 'Month Archive'],
                ['id' => 'day_archive', 'text' => 'Day Archive']
            ];
            break;

        case 'search':
            $choices[] = [
                'id' => 'search_results',
                'text' => 'Search Results'
            ];
            break;

        case 'special':
            $choices = [
                ['id' => 'front_page', 'text' => 'Front Page'],
                ['id' => 'home', 'text' => 'Blog Home'],
                ['id' => '404', 'text' => '404 Not Found'],
                ['id' => 'privacy_policy', 'text' => 'Privacy Policy']
            ];
            break;
    }

    wp_send_json_success(['results' => $choices]);
});

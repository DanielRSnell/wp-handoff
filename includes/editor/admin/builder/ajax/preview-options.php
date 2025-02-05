<?php

add_action('wp_ajax_load_preview_options', function() {
    $layout_id = $_POST['layout_id'] ?? 0;
    $options = [];
    
    if ($layout_id) {
        $location_rules = get_field('location_rules', $layout_id);
        
        if ($location_rules && is_array($location_rules)) {
            foreach ($location_rules as $rule) {
                $group = $rule['group'] ?? '';
                $type = $rule['type'] ?? '';
                $mode = $rule['mode'] ?? '';
                $items = $rule['items'] ?? [];

                switch ($group) {
                    case 'singular':
                        if ($mode === 'all') {
                            $query_args = [
                                'post_type' => $type,
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'post_status' => 'publish'
                            ];
                        } else {
                            $query_args = [
                                'post_type' => $type,
                                'post__in' => $items,
                                'posts_per_page' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'post_status' => 'publish'
                            ];
                        }

                        $posts = get_posts($query_args);
                        foreach ($posts as $post) {
                            $options[] = [
                                'id' => $post->ID,
                                'text' => $post->post_title . ' (' . $post->post_type . ')',
                                'url' => get_permalink($post->ID)
                            ];
                        }
                        break;

                    case 'archive':
                        if ($type) {
                            $url = get_post_type_archive_link($type);
                            if ($url) {
                                $post_type_obj = get_post_type_object($type);
                                $options[] = [
                                    'id' => 'archive_' . $type,
                                    'text' => $post_type_obj->label . ' Archive',
                                    'url' => $url
                                ];
                            }
                        }
                        break;

                    case 'taxonomy':
                        $query_args = [
                            'taxonomy' => $type,
                            'hide_empty' => false
                        ];

                        if ($mode !== 'all' && !empty($items)) {
                            $query_args['include'] = $items;
                        } else {
                            $query_args['number'] = 5;
                        }

                        $terms = get_terms($query_args);
                        if (!is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $url = get_term_link($term);
                                if (!is_wp_error($url)) {
                                    $options[] = [
                                        'id' => 'tax_' . $term->term_id,
                                        'text' => $term->name . ' (' . $term->taxonomy . ')',
                                        'url' => $url
                                    ];
                                }
                            }
                        }
                        break;

                    case 'special':
                        switch ($type) {
                            case 'front_page':
                                $options[] = [
                                    'id' => 'front_page',
                                    'text' => 'Front Page',
                                    'url' => home_url('/')
                                ];
                                break;
                            case 'home':
                                $options[] = [
                                    'id' => 'blog_home',
                                    'text' => 'Blog Home',
                                    'url' => get_permalink(get_option('page_for_posts'))
                                ];
                                break;
                            case '404':
                                $options[] = [
                                    'id' => '404',
                                    'text' => '404 Page',
                                    'url' => home_url('/404')
                                ];
                                break;
                        }
                        break;
                }
            }
        }
    }

    wp_send_json_success(['results' => array_values(array_unique($options, SORT_REGULAR))]);
});

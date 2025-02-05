<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

add_action('wp_ajax_load_preview_options', function() {
    $layout_id = $_POST['layout_id'] ?? 0;
    $options = [];
    
    if ($layout_id) {
        $location_rules = get_field('location_rules', $layout_id);
        
        if ($location_rules) {
            foreach ($location_rules as $rule) {
                $group = $rule['group'] ?? '';
                $type = $rule['type'] ?? '';
                $mode = $rule['mode'] ?? '';
                $items = $rule['items'] ?? [];

                switch ($group) {
                    case 'singular':
                        if ($mode === 'all') {
                            $posts = get_posts([
                                'post_type' => $type,
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ]);
                            foreach ($posts as $post) {
                                $options[] = [
                                    'id' => $post->ID,
                                    'text' => $post->post_title . ' (' . $post->post_type . ')',
                                    'url' => get_permalink($post->ID)
                                ];
                            }
                        } else {
                            foreach ($items as $post_id) {
                                $post = get_post($post_id);
                                if ($post) {
                                    $options[] = [
                                        'id' => $post->ID,
                                        'text' => $post->post_title . ' (' . $post->post_type . ')',
                                        'url' => get_permalink($post->ID)
                                    ];
                                }
                            }
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
                        if ($mode === 'all') {
                            $terms = get_terms([
                                'taxonomy' => $type,
                                'number' => 5,
                                'hide_empty' => false
                            ]);
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
                        } else {
                            foreach ($items as $term_id) {
                                $term = get_term($term_id);
                                if (!is_wp_error($term)) {
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
                        }
                        break;

                    case 'author':
                        if ($mode === 'all') {
                            $authors = get_users(['who' => 'authors', 'number' => 5]);
                            foreach ($authors as $author) {
                                $options[] = [
                                    'id' => 'author_' . $author->ID,
                                    'text' => $author->display_name . ' (Author)',
                                    'url' => get_author_posts_url($author->ID)
                                ];
                            }
                        } else {
                            foreach ($items as $author_id) {
                                $author = get_user_by('id', $author_id);
                                if ($author) {
                                    $options[] = [
                                        'id' => 'author_' . $author->ID,
                                        'text' => $author->display_name . ' (Author)',
                                        'url' => get_author_posts_url($author->ID)
                                    ];
                                }
                            }
                        }
                        break;

                    case 'date':
                        $year = date('Y');
                        $month = date('m');
                        switch ($type) {
                            case 'year_archive':
                                $options[] = [
                                    'id' => 'year_' . $year,
                                    'text' => $year . ' Archive',
                                    'url' => get_year_link($year)
                                ];
                                break;
                            case 'month_archive':
                                $options[] = [
                                    'id' => 'month_' . $year . $month,
                                    'text' => date('F Y') . ' Archive',
                                    'url' => get_month_link($year, $month)
                                ];
                                break;
                            case 'day_archive':
                                $day = date('d');
                                $options[] = [
                                    'id' => 'day_' . $year . $month . $day,
                                    'text' => date('F j, Y') . ' Archive',
                                    'url' => get_day_link($year, $month, $day)
                                ];
                                break;
                        }
                        break;

                    case 'search':
                        $options[] = [
                            'id' => 'search',
                            'text' => 'Search Results (Example)',
                            'url' => add_query_arg('s', 'example', home_url('/'))
                        ];
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
                            case 'privacy_policy':
                                $policy_page_id = get_option('wp_page_for_privacy_policy');
                                if ($policy_page_id) {
                                    $options[] = [
                                        'id' => 'privacy_' . $policy_page_id,
                                        'text' => 'Privacy Policy',
                                        'url' => get_permalink($policy_page_id)
                                    ];
                                }
                                break;
                        }
                        break;
                }
            }
        }
    }

    wp_send_json_success(['results' => array_values(array_unique($options, SORT_REGULAR))]);
});

add_action('acf/input/admin_footer', function() {
    ?>
    <script type="text/javascript">
    (function($) {
        if (typeof acf === 'undefined') return;

        var previewOptionsCache = {};

        function loadPreviewOptions($select) {
            var postId = $('#post_ID').val();
            
            if (previewOptionsCache[postId]) {
                updatePreviewSelect($select, previewOptionsCache[postId]);
                return;
            }
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load_preview_options',
                    layout_id: postId
                },
                beforeSend: function() {
                    $select.prop('disabled', true);
                    $select.empty().append('<option value="">Loading...</option>');
                },
                success: function(response) {
                    if (response.success && response.data.results) {
                        previewOptionsCache[postId] = response.data.results;
                        updatePreviewSelect($select, response.data.results);
                    }
                },
                error: function() {
                    $select.empty().append('<option value="">Error loading options</option>');
                },
                complete: function() {
                    $select.prop('disabled', false);
                }
            });
        }

        function updatePreviewSelect($select, options) {
            $select.empty().append('<option value="">- Select Preview Page -</option>');
            
            options.forEach(function(item) {
                $select.append($('<option></option>')
                    .attr('value', item.id)
                    .attr('data-url', item.url)
                    .text(item.text));
            });
        }

        function invalidatePreviewCache() {
            var postId = $('#post_ID').val();
            delete previewOptionsCache[postId];
        }

        acf.addAction('show_field/key=field_preview_tab', function(field) {
            var $select = field.$el.find('[data-key="field_preview_select"] select');
            loadPreviewOptions($select);
        });

        $(document).on('change', '[data-key="field_preview_select"] select', function() {
            var $selected = $(this).find('option:selected');
            var url = $selected.data('url') || '';
            $('[data-key="field_preview_url"] input').val(url);
        });

        acf.addAction('append_field/name=location_rules', function() {
            invalidatePreviewCache();
            var $select = $('[data-key="field_preview_select"] select');
            loadPreviewOptions($select);
        });

        $(document).on('change', '[data-key="field_rule_group"] select, [data-key="field_rule_type"] select, [data-key="field_rule_mode"] select, [data-key="field_rule_items"] select', function() {
            invalidatePreviewCache();
            var $select = $('[data-key="field_preview_select"] select');
            loadPreviewOptions($select);
        });
    })(jQuery);
    </script>

    <style>
    .preview-url-wrapper input {
        background: #f8f9fa;
        color: #666;
        cursor: not-allowed;
    }
    .preview-url-wrapper input:focus {
        background: #f8f9fa;
    }
    </style>
    <?php
});

return [
    [
        'key' => 'field_preview_select',
        'label' => 'Preview Page',
        'name' => 'preview_select',
        'type' => 'select',
        'instructions' => 'Select a page to preview this layout',
        'required' => 0,
        'choices' => [],
        'ui' => 1,
        'ajax' => 0,
        'return_format' => 'array',
        'placeholder' => '- Select Preview Page -'
    ],
    [
        'key' => 'field_preview_url',
        'label' => 'Preview URL',
        'name' => 'preview_url',
        'type' => 'text',
        'instructions' => 'The URL that will be used for preview',
        'required' => 0,
        'readonly' => 1,
        'wrapper' => [
            'class' => 'preview-url-wrapper'
        ]
    ]
];

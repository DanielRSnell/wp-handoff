<?php

namespace WPHandoff\Router;

class LayoutRegistrar {
    private $layouts = [];

    public function __construct() {
        // Register early to catch all possible hooks
        add_action('init', [$this, 'registerLayouts'], 5);
        add_action('admin_menu', [$this, 'registerAdminPages'], 5);
        add_action('wp', [$this, 'registerHooks']);
    }

    public function registerLayouts() {
        $this->layouts = $this->getLayoutsByType();
        
        // Register custom routes
        $this->registerCustomRoutes();
    }

    private function getLayoutsByType() {
        $layouts = get_posts([
            'post_type' => 'layout',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);

        $categorized = [
            'route' => [],
            'admin' => [],
            'block' => []
        ];

        foreach ($layouts as $layout) {
            $rules = get_field('location_rules', $layout->ID);
            
            if (!empty($rules['layout_type'])) {
                $type = $rules['layout_type'];
                if (isset($categorized[$type])) {
                    $categorized[$type][] = [
                        'id' => $layout->ID,
                        'rules' => $rules
                    ];
                }
            }
        }

        return $categorized;
    }

    private function registerCustomRoutes() {
        if (empty($this->layouts['route'])) return;

        add_action('init', function() {
            foreach ($this->layouts['route'] as $layout) {
                $rules = $layout['rules'];
                if (!empty($rules['route_pattern'])) {
                    add_rewrite_rule(
                        '^' . ltrim($rules['route_pattern'], '/') . '/?$',
                        'index.php?layout_id=' . $layout['id'],
                        'top'
                    );
                }
            }
        }, 10);

        // Register query var
        add_filter('query_vars', function($vars) {
            $vars[] = 'layout_id';
            return $vars;
        });
    }

    public function registerAdminPages() {
        if (empty($this->layouts['admin'])) return;

        foreach ($this->layouts['admin'] as $layout) {
            $rules = $layout['rules'];
            if (!empty($rules['admin_path'])) {
                $this->registerAdminPage($layout['id'], $rules);
            }
        }
    }

    private function registerAdminPage($layout_id, $rules) {
        $path = $rules['admin_path'];
        $title = get_the_title($layout_id);

        add_menu_page(
            $title,
            $title,
            'manage_options',
            'layout-' . $layout_id,
            function() use ($layout_id) {
                $this->renderAdminPage($layout_id);
            }
        );
    }

    private function renderAdminPage($layout_id) {
        $components = $this->getLayoutComponents($layout_id);
        
        // Get Timber context
        $context = \Timber\Timber::context();
        $context['components'] = $components;
        
        // Render admin page using Timber
        \Timber\Timber::render('@core/admin.twig', $context);
    }

    public function registerHooks() {
        if (empty($this->layouts['block'])) return;

        foreach ($this->layouts['block'] as $layout) {
            $rules = $layout['rules'];
            if (!empty($rules['hook_name'])) {
                $this->registerHook($layout['id'], $rules['hook_name']);
            }
        }
    }

    private function registerHook($layout_id, $hook_name) {
        add_action($hook_name, function() use ($layout_id) {
            $components = $this->getLayoutComponents($layout_id);
            
            // Get Timber context
            $context = \Timber\Timber::context();
            $context['components'] = $components;
            
            // Render hook content using Timber
            \Timber\Timber::render('@core/hook.twig', $context);
        });
    }

    private function getLayoutComponents($layout_id) {
        $components = [];
        $fields = get_fields($layout_id);
        
        if (!empty($fields['components'])) {
            foreach ($fields['components'] as $component) {
                $components[] = [
                    'type' => $component['acf_fc_layout'],
                    'style' => $component['style'] ?? 'default',
                    'data' => $component
                ];
            }
        }

        return $components;
    }
}

<?php

namespace WPHandoff\Router;

use Timber\Timber;
use WPHandoff\Router\Handlers\PageHandler;
use WPHandoff\Router\Handlers\FrontPageHandler;
use WPHandoff\Router\Handlers\SingularHandler;
use WPHandoff\Router\Handlers\ArchiveHandler;
use WPHandoff\Router\Handlers\TaxonomyHandler;
use WPHandoff\Router\Handlers\AuthorHandler;
use WPHandoff\Router\Handlers\SearchHandler;
use WPHandoff\Router\Handlers\NotFoundHandler;

class Controller {
    private $context;
    private $handlers = [];
    private $current_route;

    public function __construct() {
        $this->registerHandlers();
        $this->current_route = $this->getCurrentRoute();
    }

    private function getCurrentRoute() {
        $home_url = home_url();
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $route = str_replace($home_url, '', $current_url);
        
        // Remove query string but keep track of it
        $parts = explode('?', $route);
        return $parts[0];
    }

    private function registerHandlers() {
        $this->handlers = [
            new NotFoundHandler(),
            new PageHandler(),
            new FrontPageHandler(),
            new SingularHandler(),
            new ArchiveHandler(),
            new TaxonomyHandler(),
            new AuthorHandler(),
            new SearchHandler()
        ];
    }

    public function handle() {
        $this->context = Timber::context();
        
        // Check if we're in editor mode
        if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
            $this->handleEditorMode();
            return;
        }

        foreach ($this->handlers as $handler) {
            if ($handler->matches()) {
                // Handle pages
                if ($handler instanceof PageHandler) {
                    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
                        // Stay on the page for editing
                        $this->context['components'] = $handler->getComponents();
                        Timber::render('@editor/views/render-editor.php', $this->context);
                    } else {
                        $this->context['components'] = $handler->getComponents();
                        Timber::render('@core/base.twig', $this->context);
                    }
                    return;
                }
                
                // Handle layouts
                $layout = $handler->getLayout();
                if ($layout) {
                    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
                        // Redirect to layout editor with original route
                        $editor_url = add_query_arg([
                            'editor' => 'true',
                            'route' => $this->current_route
                        ], get_permalink($layout->ID));
                        wp_redirect($editor_url);
                        exit;
                    } else {
                        $this->context['components'] = $this->getLayoutComponents($layout);
                        Timber::render('@core/base.twig', $this->context);
                    }
                    return;
                }
            }
        }

        // If no handler matches, render 404
        $this->render404Fallback();
    }

    private function handleEditorMode() {
        // Check if we're on a layout post type
        if (get_post_type() === 'layout') {
            $layout = get_post();
            $this->context['components'] = $this->getLayoutComponents($layout);
            $this->context['original_route'] = isset($_GET['route']) ? $_GET['route'] : '';
            Timber::render('@editor/views/render-editor.php', $this->context);
            return;
        }

        // If we're on a page
        if (is_page()) {
            $handler = new PageHandler();
            $this->context['components'] = $handler->getComponents();
            $this->context['original_route'] = $this->current_route;
            Timber::render('@editor/views/render-editor.php', $this->context);
            return;
        }

        // Fallback - shouldn't reach here if redirects are working
        wp_redirect(admin_url());
        exit;
    }

    private function render404Fallback() {
        status_header(404);
        $this->context['error_code'] = '404';
        $this->context['error_message'] = 'This page could not be found.';
        nocache_headers();
        Timber::render('@core/404.twig', $this->context);
    }

    private function getLayoutComponents($layout) {
        $components = [];
        
        if ($layout) {
            $fields = get_fields($layout->ID);
            
            if (!empty($fields['components'])) {
                foreach ($fields['components'] as $component) {
                    $components[] = [
                        'type' => $component['acf_fc_layout'],
                        'style' => $component['style'] ?? 'default',
                        'data' => $component
                    ];
                }
            }
        }

        return $components;
    }
}

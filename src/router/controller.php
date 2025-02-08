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

    public function __construct() {
        $this->registerHandlers();
    }

    private function registerHandlers() {
        $this->handlers = [
            new NotFoundHandler(), // Move 404 handler first
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
        
        foreach ($this->handlers as $handler) {
            if ($handler->matches()) {
                // Special handling for 404s
                if ($handler instanceof NotFoundHandler) {
                    $layout = $handler->getLayout();
                    if ($layout) {
                        // If we have a 404 layout, use it
                        $this->context['components'] = $this->getLayoutComponents($layout);
                        Timber::render('@core/base.twig', $this->context);
                    } else {
                        // No 404 layout, use fallback template
                        $this->render404Fallback();
                    }
                    return;
                }
                
                // Handle pages
                if ($handler instanceof PageHandler) {
                    $this->context['components'] = $handler->getComponents();
                    Timber::render('@core/base.twig', $this->context);
                    return;
                }
                
                // Handle all other cases
                $layout = $handler->getLayout();
                if ($layout) {
                    $this->context['components'] = $this->getLayoutComponents($layout);
                    Timber::render('@core/base.twig', $this->context);
                    return;
                }
            }
        }

        // If no handler matches at all, render 404
        $this->render404Fallback();
    }

    private function render404Fallback() {
        status_header(404);
        $this->context['error_code'] = '404';
        $this->context['error_message'] = 'This page could not be found.';
        nocache_headers(); // Prevent caching of 404 pages
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

<?php

namespace WPHandoff\Router\Handlers;

class PageHandler extends BaseHandler {
    public function matches(): bool {
        return is_page();
    }

    public function getLayout() {
        // Pages don't need layouts, so we'll return null
        return null;
    }

    public function getComponents() {
        $page_id = get_the_ID();
        $components = [];
        
        $fields = get_fields($page_id);
        
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

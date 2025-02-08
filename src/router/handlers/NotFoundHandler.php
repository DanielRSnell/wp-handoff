<?php

namespace WPHandoff\Router\Handlers;

class NotFoundHandler extends BaseHandler {
    public function matches(): bool {
        return is_404();
    }

    public function getLayout() {
        $layouts = $this->queryLayouts([
            [
                'key' => 'location_rules_layout_type',
                'value' => 'template'
            ],
            [
                'key' => 'location_rules_context_type',
                'value' => '404'
            ]
        ]);

        return !empty($layouts) ? $layouts[0] : null;
    }
}

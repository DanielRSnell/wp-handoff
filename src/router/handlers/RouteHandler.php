<?php

namespace WPHandoff\Router\Handlers;

class RouteHandler extends BaseHandler {
    public function matches(): bool {
        return get_query_var('layout_id') !== '';
    }

    public function getLayout() {
        $layout_id = get_query_var('layout_id');
        return get_post($layout_id);
    }
}

<?php

namespace WPHandoff\Router\Handlers;

abstract class BaseHandler {
    abstract public function matches(): bool;
    abstract public function getLayout();

    protected function queryLayouts(array $meta_query) {
        return get_posts([
            'post_type' => 'layout',
            'posts_per_page' => 1,
            'meta_query' => $meta_query
        ]);
    }

    // Add default getComponents method that returns null
    public function getComponents() {
        return null;
    }
}

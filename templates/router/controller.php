<?php

add_filter('template_include', function ($template) {
    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
        return get_template_directory() . '/includes/editor/views/editor.php';
    }

    if (is_page()) {
        return get_template_directory() . '/templates/page.php';
    }

    return $template;
}, 999);

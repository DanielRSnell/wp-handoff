<?php

class Performance {
    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->cleanupHead();
        $this->optimizeScripts();
    }

    private function cleanupHead() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    private function optimizeScripts() {
        add_filter('script_loader_tag', function($tag, $handle) {
            $scripts_to_async = ['inter-font'];
            $scripts_to_defer = [];
            
            if (in_array($handle, $scripts_to_async)) {
                return str_replace(' src', ' async src', $tag);
            }
            
            if (in_array($handle, $scripts_to_defer)) {
                return str_replace(' src', ' defer src', $tag);
            }
            
            return $tag;
        }, 10, 2);
    }
}

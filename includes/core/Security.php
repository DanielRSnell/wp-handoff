<?php

class Security {
    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->setupHeaders();
        $this->disableXMLRPC();
        $this->removeVersionInfo();
        $this->disablePingbacks();
        $this->secureLogin();
    }

    private function setupHeaders() {
        add_action('send_headers', function() {
            if (!is_admin()) {
                header('X-Frame-Options: SAMEORIGIN');
                header('X-Content-Type-Options: nosniff');
                header('X-XSS-Protection: 1; mode=block');
                header('Referrer-Policy: strict-origin-when-cross-origin');
                
                if (ThemeSetup::isDebug() === false) {
                    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
                }
            }
        });
    }

    private function disableXMLRPC() {
        add_filter('xmlrpc_enabled', '__return_false');
    }

    private function removeVersionInfo() {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        add_filter('the_generator', '__return_empty_string');
    }

    private function disablePingbacks() {
        add_filter('xmlrpc_methods', function($methods) {
            unset($methods['pingback.ping']);
            return $methods;
        });

        add_action('wp_headers', function($headers) {
            unset($headers['X-Pingback']);
            return $headers;
        });
    }

    private function secureLogin() {
        add_filter('login_errors', function() {
            return 'Invalid login credentials.';
        });
    }
}

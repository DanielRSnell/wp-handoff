<?php

use Timber\Timber;
use WPHandoff\Router\LayoutRegistrar;

class ThemeSetup
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->initializeCore();
        $this->initializeRouter();
        $this->initializeThemeSupport();
        $this->initializeAdmin();
    }

    private function initializeCore()
    {
        Timber::init();
        Timber::$dirname = ['src/views'];

        if (class_exists('Timber')) {
            require_once get_template_directory() . '/includes/timber/locations.php';
            require_once get_template_directory() . '/includes/timber/twig-functions.php';
        }

        if (function_exists('acf_add_local_field_group')) {
            require_once get_template_directory() . '/src/component-field.php';
        }
    }

    private function initializeRouter()
    {
        add_action('after_setup_theme', function () {
            new LayoutRegistrar();
        });

        add_filter('template_include', function ($template) {
            if (is_admin() || wp_doing_ajax()) {
                return $template;
            }
            return get_template_directory() . '/router.php';
        }, 99);
    }

    private function initializeThemeSupport()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('menus');
            add_theme_support('html5', [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]);
            add_theme_support('custom-logo');
            add_theme_support('automatic-feed-links');
            add_theme_support('wp-block-styles');
            add_theme_support('align-wide');
            add_theme_support('responsive-embeds');
            add_theme_support('editor-styles');

            register_nav_menus([
                'primary' => __('Primary Menu', 'wp-handoff'),
                'footer' => __('Footer Menu', 'wp-handoff'),
            ]);
        });
    }

    private function initializeAdmin()
    {
        require_once get_template_directory() . '/includes/admin/configure/pages.php';
        require_once get_template_directory() . '/includes/admin/builder/init.php';
        require_once get_template_directory() . '/includes/fields/sync-settings.php';
        require_once get_template_directory() . '/includes/editor/controller.php';

        add_action('admin_enqueue_scripts', [$this, 'adminStyles']);
    }

    public function adminStyles()
    {
        wp_enqueue_style('inter-font', 'https://rsms.me/inter/inter.css', [], null);

        $custom_css = "
            html, body, input, select, textarea, button, td, th, p, h1, h2, h3, h4, h5, h6, a {
                font-family: 'Inter'!important;
            }
            body.wp-admin,
            .wp-admin input,
            .wp-admin select,
            .wp-admin textarea,
            .wp-admin button {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }
        ";

        wp_add_inline_style('admin-bar', $custom_css);
    }

    public function loadTextDomain()
    {
        load_theme_textdomain('wp-handoff', get_template_directory() . '/languages');
    }

    public static function isDebug(): bool
    {
        return defined('WP_DEBUG') && WP_DEBUG === true;
    }
}

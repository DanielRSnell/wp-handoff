<?php
namespace Umbral\Editor;

require_once __DIR__ . '/autoload.php';

use Umbral\Editor\Handlers\AssetsHandler;
use Umbral\Editor\Handlers\ContextHandler;
use Umbral\Editor\Handlers\SaveHandler;
use Umbral\Editor\Handlers\SettingsHandler;
use Umbral\Editor\Handlers\TemplateHandler;

class Editor
{
    private $version = '1.0.0';
    private static $instance = null;
    private $assets_handler;
    private $settings_handler;
    private $template_handler;
    private $save_handler;
    private $context_handler;
    private $styles_path;
    private $scripts_path;
    private $views_path;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->setupPaths();
        $this->initializeHandlers();
        $this->setupHooks();
    }

    private function setupPaths()
    {
        $this->styles_path = get_template_directory() . '/includes/editor/assets/styles';
        $this->scripts_path = get_template_directory() . '/includes/editor/assets/scripts';
    }

    private function initializeHandlers()
    {
        $this->assets_handler = new AssetsHandler($this, $this->version, $this->styles_path, $this->scripts_path);
        $this->settings_handler = new SettingsHandler($this);
        $this->template_handler = new TemplateHandler($this);
        $this->save_handler = new SaveHandler($this);
        $this->context_handler = new ContextHandler($this);
    }

    private function setupHooks()
    {
        add_action('init', [$this, 'init']);
        add_action('admin_enqueue_scripts', [$this->assets_handler, 'enqueueAssets']);
        add_action('wp_enqueue_scripts', [$this->assets_handler, 'enqueueFrontendAssets']);
        add_filter('template_include', [$this->template_handler, 'loadTemplate'], 999999);
        add_filter('show_admin_bar', [$this, 'hideAdminBar']);
        add_action('wp_ajax_editor_save', [$this->save_handler, 'handleSave']);
        add_filter('timber/context', [$this->context_handler, 'extendContext']);
        add_action('admin_head', [$this->assets_handler, 'addInlineStyles']);
        add_action('wp_head', [$this->assets_handler, 'addInlineStyles']);
    }

    public function init()
    {
        if (!function_exists('acf_form_head')) {
            return;
        }

        if ($this->isEditorMode() || $this->isPreviewMode()) {
            remove_all_actions('wp_head');
            remove_all_actions('wp_footer');
            acf_form_head();
            add_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_head', 'wp_print_styles', 8);
            add_action('wp_head', 'wp_print_head_scripts', 9);
            add_action('wp_head', 'wp_site_icon', 99);
            add_action('wp_head', [$this, 'addEditorMeta']);
        }

        $this->settings_handler->registerSettings();
    }

    public function addEditorMeta()
    {
        echo '<meta name="editor-version" content="' . esc_attr($this->version) . '">';
        echo '<meta name="editor-mode" content="' . ($this->isEditorMode() ? 'edit' : 'preview') . '">';
    }

    public function hideAdminBar($show)
    {
        if ($this->isEditorMode() || $this->isPreviewMode()) {
            return false;
        }
        return $show;
    }

    public function isEditorMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'true';
    }

    public function isPreviewMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'preview';
    }

    public function isLayoutScreen()
    {
        $screen = get_current_screen();
        return $screen && $screen->post_type === 'layout';
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getEditorStyles()
    {
        return $this->assets_handler->getEditorStyles();
    }

    public function getReturnUrl()
    {
        return $this->template_handler->getReturnUrl();
    }

    public function getCurrentUrl()
    {
        return $this->template_handler->getCurrentUrl();
    }

    public function getEditorSettings()
    {
        return $this->settings_handler->getSettings();
    }

    public function getContext()
    {
        return $this->context_handler->getEditorContext();
    }

    public function getStylesPath()
    {
        return $this->styles_path;
    }

    public function getScriptsPath()
    {
        return $this->scripts_path;
    }

    public function getViewsPath()
    {
        return $this->views_path;
    }

    public function getAssetsHandler()
    {
        return $this->assets_handler;
    }

    public function getSettingsHandler()
    {
        return $this->settings_handler;
    }

    public function getTemplateHandler()
    {
        return $this->template_handler;
    }

    public function getSaveHandler()
    {
        return $this->save_handler;
    }

    public function getContextHandler()
    {
        return $this->context_handler;
    }
}

return Editor::getInstance();

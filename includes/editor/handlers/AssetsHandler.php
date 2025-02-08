<?php
namespace Umbral\Editor\Handlers;

class AssetsHandler extends BaseHandler
{
    private $version;
    private $styles_path;
    private $scripts_path;

    public function __construct($editor, $version, $styles_path, $scripts_path)
    {
        parent::__construct($editor);
        $this->version = $version;
        $this->styles_path = $styles_path;
        $this->scripts_path = $scripts_path;
    }

    public function enqueueAssets($hook)
    {
        wp_enqueue_style(
            'wp-handoff-admin',
            get_template_directory_uri() . '/includes/editor/assets/styles/admin.css',
            [],
            $this->version
        );

        if ($this->isLayoutScreen()) {
            wp_enqueue_media();
            wp_enqueue_editor();
        }

        wp_enqueue_script(
            'wp-handoff-editor',
            get_template_directory_uri() . '/includes/editor/assets/scripts/editor.js',
            ['jquery', 'acf-input'],
            $this->version,
            true
        );

        wp_localize_script('wp-handoff-editor', 'wpHandoff', $this->getScriptData());
    }

    public function enqueueFrontendAssets()
    {
        if ($this->isEditorMode() || $this->isPreviewMode()) {
            wp_enqueue_style(
                'wp-handoff-frontend',
                get_template_directory_uri() . '/includes/editor/assets/styles/editor.css',
                [],
                $this->version
            );

            wp_enqueue_script(
                'wp-handoff-frontend',
                get_template_directory_uri() . '/includes/editor/assets/scripts/editor.js',
                ['jquery'],
                $this->version,
                true
            );
        }
    }

    public function getEditorStyles()
    {
        $styles = '';
        $style_files = [
            $this->styles_path . '/base/*.css',
            $this->styles_path . '/layout/*.css',
            $this->styles_path . '/fields/*.css',
            $this->styles_path . '/components/*.css',
        ];

        foreach ($style_files as $pattern) {
            $files = glob($pattern);
            if ($files) {
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        $styles .= file_get_contents($file) . "\n";
                    }
                }
            }
        }

        return $styles;
    }

    // addInlineStyles
    public function addInlineStyles()
    {
        echo '<style>' . $this->getEditorStyles() . '</style>';
    }

    private function getScriptData()
    {
        return [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_handoff_editor'),
            'isEditor' => $this->isEditorMode(),
            'isPreview' => $this->isPreviewMode(),
            'currentScreen' => get_current_screen()->id,
            'editorSettings' => $this->editor->getEditorSettings(),
            'returnUrl' => $this->editor->getReturnUrl(),
            'currentRoute' => isset($_GET['route']) ? $_GET['route'] : '',
            'postId' => get_the_ID(),
        ];
    }
}

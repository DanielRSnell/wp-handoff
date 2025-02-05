<?php

namespace Umbral\Editor;

class Editor {
    private $version = '1.0.0';
    private $styles_path;

    public function __construct() {
        $this->styles_path = get_template_directory() . '/includes/editor/assets/styles';
        add_action('init', [$this, 'init']);
    }

    public function init() {
        if ($this->isEditorMode()) {
            add_filter('show_admin_bar', '__return_false');
            add_filter('template_include', [$this, 'loadEditorTemplate']);
        }

        if ($this->isPreviewMode()) {
            add_filter('show_admin_bar', '__return_false');
        }
    }

    public function isEditorMode() {
        return isset($_GET['editor']) && $_GET['editor'] === 'true';
    }

    public function isPreviewMode() {
        return isset($_GET['editor']) && $_GET['editor'] === 'preview';
    }

    public function loadEditorTemplate() {
        return get_template_directory() . '/includes/editor/views/editor.php';
    }

    public function getEditorStyles() {
        return $this->concatenateStyles([
            $this->styles_path . '/base/*.css',
            $this->styles_path . '/layout/*.css',
            $this->styles_path . '/fields/*.css',
            $this->styles_path . '/components/*.css'
        ]);
    }

    private function concatenateStyles($patterns) {
        $styles = '';
        foreach ($patterns as $pattern) {
            $files = glob($pattern);
            foreach ($files as $file) {
                $styles .= file_get_contents($file) . "\n";
            }
        }
        return $styles;
    }
}

return new Editor();

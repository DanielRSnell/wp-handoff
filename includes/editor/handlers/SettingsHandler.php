<?php
namespace Umbral\Editor\Handlers;

class SettingsHandler extends BaseHandler {
    public function registerSettings() {
        register_setting('wp_handoff_editor', 'wp_handoff_editor_settings', [
            'type' => 'object',
            'default' => $this->getDefaultSettings(),
            'sanitize_callback' => [$this, 'sanitizeSettings'],
        ]);
    }

    public function getDefaultSettings() {
        return [
            'previewMode' => 'desktop',
            'showGrid' => true,
            'gridColumns' => 12,
            'gridGutter' => 20,
            'snapToGrid' => true,
            'showOutlines' => true,
            'showInspector' => true,
            'autoSave' => true,
            'autoSaveInterval' => 60,
            'theme' => 'system',
        ];
    }

    public function sanitizeSettings($settings) {
        $defaults = $this->getDefaultSettings();
        $sanitized = [];

        foreach ($defaults as $key => $default) {
            if (isset($settings[$key])) {
                switch (gettype($default)) {
                    case 'boolean':
                        $sanitized[$key] = (bool) $settings[$key];
                        break;
                    case 'integer':
                        $sanitized[$key] = (int) $settings[$key];
                        break;
                    case 'string':
                        $sanitized[$key] = sanitize_text_field($settings[$key]);
                        break;
                    default:
                        $sanitized[$key] = $default;
                }
            } else {
                $sanitized[$key] = $default;
            }
        }

        return $sanitized;
    }

    public function getSettings() {
        $settings = get_option('wp_handoff_editor_settings', $this->getDefaultSettings());
        return wp_parse_args($settings, $this->getDefaultSettings());
    }
}

<?php
namespace Umbral\Editor\Handlers;

use Timber\Timber;

class ContextHandler extends BaseHandler {
    public function getEditorContext() {
        $context = Timber::context();
        return $this->extendContext($context);
    }

    public function extendContext($context) {
        // Add editor-specific data
        $context['editor'] = [
            'is_editor_mode' => $this->isEditorMode(),
            'is_preview_mode' => $this->isPreviewMode(),
            'version' => $this->editor->getVersion(),
            'styles' => $this->editor->getEditorStyles(),
            'return_url' => $this->editor->getReturnUrl(),
            'current_route' => isset($_GET['route']) ? $_GET['route'] : '',
            'settings' => $this->editor->getEditorSettings(),
            'post_id' => get_the_ID(),
            'preview_url' => add_query_arg('editor', 'preview', $this->editor->getReturnUrl())
        ];

        // Add form settings
        $context['form'] = [
            'post_id' => get_the_ID(),
            'post_title' => false,
            'post_content' => false,
            'submit_value' => 'Update Page',
            'return' => add_query_arg('editor', 'true', $this->editor->getReturnUrl()),
            'html_submit_button' => '<input type="submit" class="acf-button button button-primary button-large" value="%s" />',
            'html_submit_spinner' => '<span class="acf-spinner"></span>',
            'form_attributes' => [
                'data-editor' => 'true',
                'data-post-id' => get_the_ID(),
                'data-return-url' => $this->editor->getReturnUrl(),
                'data-route' => isset($_GET['route']) ? $_GET['route'] : ''
            ]
        ];

        return $context;
    }
}

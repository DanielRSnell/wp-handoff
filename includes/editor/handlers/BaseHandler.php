<?php
namespace Umbral\Editor\Handlers;

abstract class BaseHandler {
    protected $editor;

    public function __construct($editor) {
        $this->editor = $editor;
    }

    protected function isEditorMode() {
        return $this->editor->isEditorMode();
    }

    protected function isPreviewMode() {
        return $this->editor->isPreviewMode();
    }

    protected function isLayoutScreen() {
        return $this->editor->isLayoutScreen();
    }
}

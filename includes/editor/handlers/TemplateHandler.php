<?php
namespace Umbral\Editor\Handlers;

use Timber\Timber;

class TemplateHandler extends BaseHandler
{
    private $template_loaded = false;
    private $context_handler;

    public function __construct($editor)
    {
        parent::__construct($editor);
        $this->context_handler = new ContextHandler($editor);
    }

    public function loadTemplate($template)
    {
        if ($this->template_loaded || (!$this->isEditorMode() && !$this->isPreviewMode())) {
            return $template;
        }

        global $wp_query;
        if (!isset($wp_query->post)) {
            $wp_query->post = get_post();
            $wp_query->setup_postdata($wp_query->post);
        }

        status_header(200);
        $wp_query->is_404 = false;

        if ($this->isEditorMode()) {
            acf_form_head();
            $context = $this->context_handler->getEditorContext();
            Timber::render('@core/editor.twig', $context);

        }

        return $template;
    }

    public function getCurrentUrl()
    {
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return strtok($current_url, '?');
    }

    public function getReturnUrl()
    {
        return isset($_GET['route']) ? home_url($_GET['route']) : get_permalink();
    }
}

<?php

namespace WPHandoff\Router\Handlers;

class AuthorHandler extends BaseHandler {
  public function matches(): bool {
    return is_author();
  }

  public function getLayout() {
    $layouts = $this->queryLayouts([
      [
        'key' => 'location_rules_layout_type',
        'value' => 'template'
      ],
      [
        'key' => 'location_rules_context_type',
        'value' => 'author_archive'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

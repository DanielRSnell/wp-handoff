<?php

namespace WPHandoff\Router\Handlers;

class FrontPageHandler extends BaseHandler {
  public function matches(): bool {
    return is_front_page();
  }

  public function getLayout() {
    $layouts = $this->queryLayouts([
      [
        'key' => 'location_rules_layout_type',
        'value' => 'template'
      ],
      [
        'key' => 'location_rules_context_type',
        'value' => 'front_page'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

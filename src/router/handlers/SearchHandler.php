<?php

namespace WPHandoff\Router\Handlers;

class SearchHandler extends BaseHandler {
  public function matches(): bool {
    return is_search();
  }

  public function getLayout() {
    $layouts = $this->queryLayouts([
      [
        'key' => 'location_rules_layout_type',
        'value' => 'template'
      ],
      [
        'key' => 'location_rules_context_type',
        'value' => 'search'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

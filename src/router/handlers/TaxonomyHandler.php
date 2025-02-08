<?php

namespace WPHandoff\Router\Handlers;

class TaxonomyHandler extends BaseHandler {
  public function matches(): bool {
    return is_tax();
  }

  public function getLayout() {
    $taxonomy = get_queried_object()->taxonomy;

    $layouts = $this->queryLayouts([
      [
        'key' => 'location_rules_layout_type',
        'value' => 'template'
      ],
      [
        'key' => 'location_rules_context_type',
        'value' => 'taxonomy'
      ],
      [
        'key' => 'location_rules_taxonomy_type',
        'value' => $taxonomy
      ],
      [
        'key' => 'location_rules_taxonomy_display_context',
        'value' => 'archive'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

<?php

namespace WPHandoff\Router\Handlers;

class SingularHandler extends BaseHandler {
  public function matches(): bool {
    return is_singular();
  }

  public function getLayout() {
    $post_type = get_post_type();
    $post_id = get_the_ID();

    $layouts = $this->queryLayouts([
      [
        'key' => 'location_rules_layout_type',
        'value' => 'template'
      ],
      [
        'key' => 'location_rules_context_type',
        'value' => 'post_type'
      ],
      [
        'key' => 'location_rules_post_type',
        'value' => $post_type
      ],
      [
        'key' => 'location_rules_display_context',
        'value' => 'singular'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

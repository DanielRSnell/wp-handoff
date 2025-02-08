<?php

namespace WPHandoff\Router\Handlers;

class ArchiveHandler extends BaseHandler {
  public function matches(): bool {
    return is_archive() && !is_tax() && !is_author();
  }

  public function getLayout() {
    $post_type = get_post_type();

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
        'value' => 'archive'
      ]
    ]);

    return !empty($layouts) ? $layouts[0] : null;
  }
}

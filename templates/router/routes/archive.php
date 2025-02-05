<?php

return [
  'name' => 'Archive',
  'template_type' => is_tax() || is_category() || is_tag() 
    ? 'taxonomy_' . get_queried_object()->taxonomy
    : 'archive_' . get_post_type(),
  'condition' => function() {
    return is_archive();
  }
];

<?php

return [
  'name' => 'Tag Archives',
  'template_type' => 'taxonomy_post_tag',
  'condition' => function() {
    return is_tag();
  }
];

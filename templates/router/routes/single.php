<?php

return [
  'name' => 'Single Post Types',
  'template_type' => 'single_' . get_post_type(),
  'condition' => function() {
    return is_singular();
  }
];

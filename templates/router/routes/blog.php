<?php

return [
  'name' => 'Blog Index',
  'template_type' => 'blog_index',
  'condition' => function() {
    return is_home();
  }
];

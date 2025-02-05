<?php

return [
  'name' => 'Blog Posts Index',
  'template_type' => 'blog_index',
  'condition' => function() {
    return is_home();
  }
];

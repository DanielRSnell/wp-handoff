<?php

return [
  'name' => 'Category Archives',
  'template_type' => 'taxonomy_category',
  'condition' => function() {
    return is_category();
  }
];

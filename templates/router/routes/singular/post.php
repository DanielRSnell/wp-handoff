<?php

return [
  'name' => 'Single Posts',
  'template_type' => 'single_post',
  'condition' => function() {
    return is_singular('post');
  }
];

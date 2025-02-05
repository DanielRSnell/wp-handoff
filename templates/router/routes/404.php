<?php

return [
  'name' => '404 Not Found',
  'template_type' => '404',
  'condition' => function() {
    return is_404();
  }
];

<?php

return [
  'name' => 'Front Page',
  'template_type' => 'front_page',
  'condition' => function() {
    return is_front_page();
  }
];

<?php

return [
  'name' => 'Pages',
  'template_type' => 'page',
  'condition' => function() {
    return is_page() && !is_front_page();
  }
];

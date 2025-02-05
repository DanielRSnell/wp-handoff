<?php

return [
  'name' => 'Search Results',
  'template_type' => 'search',
  'condition' => function() {
    return is_search();
  }
];

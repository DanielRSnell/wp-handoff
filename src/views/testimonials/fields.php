<?php

$variants_dir = __DIR__ . '/variants';
$variants = array_filter(glob($variants_dir . '/*.twig'), 'is_file');

$choices = [];
foreach ($variants as $variant) {
  $name = basename($variant, '.twig');
  $label = ucwords(str_replace('-', ' ', $name));
  $choices[$name] = $label;
}

return [
  [
    'key' => 'field_testimonial_style',
    'label' => 'Style',
    'name' => 'style',
    'type' => 'select',
    'choices' => $choices,
    'required' => 1,
  ],
  [
    'key' => 'field_testimonials_title',
    'label' => 'Title',
    'name' => 'title',
    'type' => 'text',
    'required' => 1,
  ],
  [
    'key' => 'field_testimonials_items',
    'label' => 'Testimonials',
    'name' => 'testimonials',
    'type' => 'repeater',
    'required' => 1,
    'min' => 1,
    'layout' => 'block',
    'sub_fields' => [
      [
        'key' => 'field_testimonial_quote',
        'label' => 'Quote',
        'name' => 'quote',
        'type' => 'textarea',
        'required' => 1,
      ],
      [
        'key' => 'field_testimonial_author',
        'label' => 'Author',
        'name' => 'author',
        'type' => 'text',
        'required' => 1,
      ],
      [
        'key' => 'field_testimonial_position',
        'label' => 'Position',
        'name' => 'position',
        'type' => 'text',
      ],
      [
        'key' => 'field_testimonial_image',
        'label' => 'Author Image',
        'name' => 'image',
        'type' => 'image',
        'return_format' => 'array',
      ],
    ],
  ],
];

# Taxonomies Directory

## Overview
This directory contains custom taxonomy registrations. Each taxonomy has its own directory with controller and fields files.

## Structure
```
taxonomy/
└── {taxonomy-name}/
    ├── controller.php  # Taxonomy registration
    └── fields.php      # Associated ACF fields
```

## Creating a New Taxonomy

1. Create a new directory:
```bash
mkdir -p taxonomy/your-taxonomy
```

2. Create controller.php:
```php
return [
    'taxonomy' => 'your-taxonomy',
    'object_type' => ['post-type'],
    'args' => [
        'labels' => [
            'name' => 'Your Terms',
            'singular_name' => 'Your Term',
            // ... other labels
        ],
        'hierarchical' => true,
        'show_in_rest' => true,
        // ... other arguments
    ]
];
```

3. Create fields.php:
```php
return [
    [
        'key' => 'group_your_taxonomy',
        'title' => 'Your Taxonomy Fields',
        'fields' => [
            // Field definitions
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'your-taxonomy',
                ],
            ],
        ],
    ]
];
```

## Best Practices
1. Use kebab-case for directory names
2. Consider hierarchical vs non-hierarchical
3. Plan term relationships carefully
4. Include REST API support when needed
5. Add proper field validation
6. Document relationship requirements

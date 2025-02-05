# Post Types Directory

## Overview
This directory contains custom post type registrations. Each post type has its own directory with controller and fields files.

## Structure
```
post-type/
└── {post-type-name}/
    ├── controller.php  # Post type registration
    └── fields.php      # Associated ACF fields
```

## Creating a New Post Type

1. Create a new directory:
```bash
mkdir -p post-type/your-post-type
```

2. Create controller.php:
```php
return [
    'post_type' => 'your-post-type',
    'args' => [
        'labels' => [
            'name' => 'Your Posts',
            'singular_name' => 'Your Post',
            // ... other labels
        ],
        'public' => true,
        'show_in_rest' => true,
        // ... other arguments
    ]
];
```

3. Create fields.php:
```php
return [
    [
        'key' => 'group_your_post_type',
        'title' => 'Your Post Type Fields',
        'fields' => [
            // Field definitions
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'your-post-type',
                ],
            ],
        ],
    ]
];
```

## Best Practices
1. Use kebab-case for directory names
2. Use clear, descriptive names
3. Include complete labels
4. Consider REST API support
5. Add proper field validation
6. Document special functionality

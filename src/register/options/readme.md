# Options Pages Directory

## Overview
This directory contains theme options page registrations. Each options page has its own directory with controller and fields files.

## Structure
```
options/
└── {options-name}/
    ├── controller.php  # Options page registration
    └── fields.php      # Associated ACF fields
```

## Creating a New Options Page

1. Create a new directory:
```bash
mkdir -p options/your-options
```

2. Create controller.php:
```php
return [
    'page_title' => 'Your Options',
    'menu_title' => 'Your Options',
    'menu_slug' => 'your-options',
    'capability' => 'manage_options',
    'position' => 2,
    'parent_slug' => '',
    'icon_url' => 'dashicons-admin-generic',
    'redirect' => false,
    'post_id' => 'your_options',
    'autoload' => true,
    'update_button' => 'Update Settings',
    'updated_message' => 'Settings updated',
];
```

3. Create fields.php:
```php
return [
    [
        'key' => 'group_your_options',
        'title' => 'Your Options Fields',
        'fields' => [
            // Field definitions
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'your-options',
                ],
            ],
        ],
    ]
];
```

## Best Practices
1. Use kebab-case for directory names
2. Group related options together
3. Use clear, descriptive labels
4. Consider performance with autoload
5. Add proper field validation
6. Document dependencies and requirements
7. Use appropriate capability requirements

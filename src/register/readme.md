# Registration Directory

## Overview
This directory contains all custom registrations for post types, taxonomies, and options pages. Each registration follows a consistent controller/fields pattern for better organization and maintainability.

## Structure
```
register/
├── post-type/          # Custom post type registrations
│   └── {name}/
│       ├── controller.php  # Post type registration logic
│       └── fields.php      # Associated ACF fields
├── taxonomy/           # Custom taxonomy registrations
│   └── {name}/
│       ├── controller.php  # Taxonomy registration logic
│       └── fields.php      # Associated ACF fields
└── options/           # Options page registrations
    └── {name}/
        ├── controller.php  # Options page registration logic
        └── fields.php      # Associated ACF fields
```

## Usage

### Creating a New Post Type
1. Create a new directory in `post-type/`
2. Add `controller.php` for registration logic
3. Add `fields.php` for ACF field definitions

### Creating a New Taxonomy
1. Create a new directory in `taxonomy/`
2. Add `controller.php` for registration logic
3. Add `fields.php` for ACF field definitions

### Creating a New Options Page
1. Create a new directory in `options/`
2. Add `controller.php` for registration logic
3. Add `fields.php` for ACF field definitions

## File Patterns

### Controller Pattern
```php
// controller.php
return [
    'post_type' => 'name',  // or 'taxonomy' => 'name' for taxonomies
    'args' => [
        // Registration arguments
    ]
];
```

### Fields Pattern
```php
// fields.php
return [
    [
        'key' => 'group_name',
        'title' => 'Field Group Title',
        'fields' => [
            // Field definitions
        ],
        'location' => [
            // Location rules
        ]
    ]
];
```

## Automatic Registration
All properly structured directories are automatically registered through the sync-settings system.

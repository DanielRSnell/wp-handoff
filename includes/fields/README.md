# Fields Directory

## Overview
This directory manages field registration, synchronization, and automation for the theme. It uses a modular approach to handle different types of fields and registrations.

## Structure
```
fields/
├── settings/           # Field registration modules
│   ├── blocks.php     # Block registration
│   ├── json-sync.php  # JSON synchronization
│   ├── options.php    # Options registration
│   ├── post-types.php # Post type registration
│   └── taxonomies.php # Taxonomy registration
└── sync-settings.php  # Main loader
```

## Modules

### blocks.php
- Handles block registration
- Manages block fields
- Processes block categories

### json-sync.php
- Manages JSON synchronization
- Handles save/load points
- Maintains directory structure

### options.php
- Registers options pages
- Handles options fields
- Manages options hierarchy

### post-types.php
- Registers custom post types
- Manages post type fields
- Handles post type relationships

### taxonomies.php
- Registers custom taxonomies
- Manages taxonomy fields
- Handles term relationships

## Usage
The system automatically:
1. Registers all blocks in `/src/blocks`
2. Registers all post types in `/src/register/post-type`
3. Registers all taxonomies in `/src/register/taxonomy`
4. Registers all options in `/src/register/options`
5. Syncs all field configurations to JSON

## Best Practices
1. Keep modules focused and single-purpose
2. Follow WordPress coding standards
3. Add proper error handling
4. Document complex functionality
5. Consider performance implications
6. Test registration order
7. Validate field configurations

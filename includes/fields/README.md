# Fields Configuration & Sync Settings

## Overview

This directory contains field-related configurations and synchronization settings for Advanced Custom Fields (ACF). The primary file `sync-settings.php` manages JSON synchronization, block registration, and automatic registration of post types, taxonomies, and options pages.

## Sync Settings Explained

### ACF JSON Synchronization

The sync system saves ACF field configurations as JSON files, providing several benefits:
- Version control for field configurations
- Faster load times compared to database storage
- Easy migration between environments
- Team collaboration without database syncing

#### Directory Structure

```
src/
└── json-store/
    ├── blocks/      # Block-specific field groups
    ├── fields/      # General field groups
    ├── post-types/  # Post type configurations
    ├── taxonomy/    # Taxonomy configurations
    └── options/     # Options page configurations
```

#### Save Points

Field configurations are automatically saved to appropriate directories based on their type:

```php
function my_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/src/json-store';
}
```

#### Load Points

The system loads field configurations from these directories:

```php
function my_acf_json_load_point($paths) {
    $paths[] = get_stylesheet_directory() . '/src/json-store';
    return $paths;
}
```

### Custom Save Paths

The system determines the appropriate save location based on field type:

- Block fields → `/json-store/blocks/`
- General fields → `/json-store/fields/`
- Post type configurations → `/json-store/post-types/`
- Taxonomy configurations → `/json-store/taxonomy/`
- Options page configurations → `/json-store/options/`

## Automatic Registration System

### Block Registration

Blocks are automatically registered from the `src/blocks` directory:

1. Scans for block.json files
2. Extracts and registers block categories
3. Registers each block with WordPress

```php
register_block_type($block_json_file);
```

### Post Types

Post types are automatically registered from `src/register/post-type/*.php`:

```php
function register_custom_post_types() {
    $post_types_dir = get_stylesheet_directory() . '/src/register/post-type';
    // Automatically requires and registers all post type files
}
```

### Taxonomies

Taxonomies are automatically registered from `src/register/taxonomy/*.php`:

```php
function register_custom_taxonomies() {
    $taxonomies_dir = get_stylesheet_directory() . '/src/register/taxonomy';
    // Automatically requires and registers all taxonomy files
}
```

### Options Pages

Options pages are automatically registered from `src/register/options/*.php`:

```php
function register_options_pages() {
    $options_dir = get_stylesheet_directory() . '/src/register/options';
    // Automatically requires and registers all options page files
}
```

## Usage

### Adding New Fields

1. Create fields in WordPress admin
2. Fields are automatically saved as JSON
3. Commit JSON files to version control

### Creating New Blocks

1. Create a new directory in `src/blocks`
2. Add `block.json` configuration
3. Add block-specific field groups
4. Block is automatically registered

### Adding Post Types/Taxonomies

1. Create PHP file in appropriate directory
2. Define registration configuration
3. System automatically registers on init

## Best Practices

1. **Version Control**
   - Always commit JSON files
   - Review field changes in pull requests
   - Document significant field updates

2. **Field Organization**
   - Use clear, consistent naming
   - Group related fields logically
   - Document complex field relationships

3. **Performance**
   - Keep field groups focused and minimal
   - Use conditional logic judiciously
   - Consider load time impact of complex fields

4. **Maintenance**
   - Regularly review and clean unused fields
   - Keep JSON files organized
   - Document custom functionality

## Troubleshooting

### Common Issues

1. **Fields Not Saving**
   - Check directory permissions
   - Verify save point filter is running
   - Check for PHP errors

2. **Fields Not Loading**
   - Verify JSON files exist
   - Check load point filter
   - Clear ACF cache

3. **Registration Issues**
   - Check file naming
   - Verify directory structure
   - Debug registration hooks

## Contributing

When adding or modifying sync functionality:

1. Document changes in this README
2. Follow WordPress coding standards
3. Test across different environments
4. Update version control
5. Communicate changes to team

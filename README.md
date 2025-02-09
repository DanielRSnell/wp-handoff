# WP Handoff Theme

A modern WordPress theme with component-based architecture and live editor for seamless client handoffs.

## Directory Structure

```
wp-handoff/
├── cli/                    # CLI tools for component generation
│   ├── create-view         # Create new view components
│   ├── handoff            # Main CLI script
│   └── templates/         # Component templates
├── includes/              # Core functionality
│   ├── admin/            # Admin interface customizations
│   ├── core/             # Core theme setup
│   ├── editor/           # Visual editor functionality
│   ├── fields/           # Field registrations
│   └── timber/           # Timber setup and functions
├── json-store/           # ACF JSON sync storage
│   ├── blocks/           # Block field configurations
│   ├── fields/           # General field configurations
│   ├── options/          # Options page configurations
│   ├── post-types/       # Post type configurations
│   └── taxonomy/         # Taxonomy configurations
├── src/                  # Source files
│   ├── assets/          # Theme assets (CSS, JS, images)
│   ├── blocks/          # Gutenberg blocks
│   ├── register/        # Registration files
│   │   ├── options/     # Options pages
│   │   ├── post-type/   # Custom post types
│   │   └── taxonomy/    # Custom taxonomies
│   ├── router/          # Routing system
│   └── views/           # View components
├── views/               # Core theme templates
│   └── core/           # Base templates
├── functions.php        # Theme functions
├── index.php           # Main template file
├── router.php          # Router initialization
└── style.css           # Theme stylesheet
```

## Key Components

### CLI Tools (`/cli`)
- Component generation utilities
- Templates for new components
- Standardized file structure creation

### Core (`/includes/core`)
- Theme setup and initialization
- Security features
- Performance optimizations
- WordPress integration

### Editor (`/includes/editor`)
- Visual page builder
- Live preview functionality
- Component management
- Layout controls

### Fields (`/includes/fields`)
- ACF field registration
- Field group organization
- JSON synchronization
- Field validation

### Router (`/src/router`)
- Dynamic routing system
- Layout matching
- Context handling
- Template loading

### Views (`/src/views`)
- Reusable components
- Template variants
- Component controllers
- Field definitions

### Blocks (`/src/blocks`)
- Custom Gutenberg blocks
- Block templates
- Block styles
- Block controllers

## Component Structure

Each component follows this structure:
```
component-name/
├── controller.php    # Data processing
├── fields.php       # Field definitions
├── variants/        # Template variants
│   └── default.twig # Default template
└── README.md        # Component documentation
```

## Development

### Creating Components
Use the CLI to generate new components:
```bash
./cli/handoff handoff:create
```

### Adding Fields
Fields are defined in `fields.php`:
```php
return [
    [
        'key' => 'field_example',
        'label' => 'Example Field',
        'name' => 'example',
        'type' => 'text'
    ]
];
```

### Creating Templates
Templates use Twig and are stored in `variants/`:
```twig
<div class="{{ component_name }}">
    <h2>{{ fields.title }}</h2>
    {{ fields.content }}
</div>
```

## Best Practices

1. Use CLI for component creation
2. Follow naming conventions
3. Document components
4. Use proper field validation
5. Keep templates modular
6. Maintain consistent styling
7. Write clean, documented code

## Requirements

- WordPress 6.0+
- PHP 8.0+
- ACF Pro
- Timber 2.0+

## License

MIT License - see LICENSE file for details

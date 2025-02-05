# Blocks Directory

## Overview
This directory contains Gutenberg blocks built with ACF. Each block has its own directory containing all necessary files for registration, styling, and functionality.

## Structure
```
blocks/
└── {block-name}/
    ├── block.json     # Block registration
    ├── fields.php     # ACF field definitions
    ├── block.twig     # Block template
    ├── styles.css     # Block styles
    └── components/    # Block components
        └── {component-name}.twig
```

## Creating a New Block

1. Create block directory:
```bash
mkdir -p blocks/your-block/components
```

2. Create block.json:
```json
{
    "name": "acf/your-block",
    "title": "Your Block",
    "description": "A custom block.",
    "category": "your-category",
    "icon": "block-default",
    "keywords": ["your", "keywords"],
    "acf": {
        "mode": "preview",
        "renderTemplate": "block.twig"
    },
    "supports": {
        "align": true,
        "mode": false,
        "jsx": true
    }
}
```

3. Create fields.php:
```php
return [
    [
        'key' => 'field_your_block_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text'
    ],
    // ... more fields
];
```

4. Create block.twig:
```twig
<div class="{{ block.classes }}">
    {% if fields.title %}
        <h2>{{ fields.title }}</h2>
    {% endif %}
</div>

<style>
    {# Block styles #}
</style>

<script>
    // Block functionality
</script>
```

## Best Practices
1. Use kebab-case for directory names
2. Keep components modular
3. Follow BEM naming in CSS
4. Include proper block supports
5. Add comprehensive field validation
6. Document block requirements
7. Consider block variations
8. Test responsive behavior

# Hero Component

## Overview
This component was generated using WP Handoff CLI. It provides a flexible, reusable hero component that can be customized through the WordPress admin.

## Structure
```
hero/
├── controller.php    # Data processing and modifications
├── fields.php       # ACF field definitions
├── variants/        # Template variants
│   └── default.twig # Default template
└── README.md        # This documentation
```

## Usage

### Basic Usage
The hero component can be added to any page through the flexible content field. Simply select "Hero" from the component list and configure its fields.

### Fields
Fields are defined in `fields.php`. By default, it includes:
- Style selector (automatically populated from variants)
- Example fields (commented out, uncomment and modify as needed)

### Data Flow
1. ACF collects field data
2. Controller processes the data (filter: `wp_handoff_component_hero_data`)
3. Processed data is passed to the template
4. Template renders the component

### Controller Usage
The controller allows you to modify component data before rendering. Common use cases:

```php
public function processData($data) {
    // Query posts
    $data['posts'] = new WP_Query([
        'post_type' => $data['post_type'],
        'posts_per_page' => $data['posts_per_page']
    ]);

    // Format dates
    $data['formatted_date'] = date('F j, Y', strtotime($data['date']));

    // Add computed values
    $data['is_featured'] = $data['price'] > 100;

    return $data;
}
```

### Template Usage
In your variant templates, you can access all fields and controller-modified data:

```twig
{# Access field data #}
{{ title }}

{# Access processed data #}
{% for post in posts %}
    {{ post.title }}
{% endfor %}

{# Use computed values #}
{% if is_featured %}
    <span class="featured-badge">Featured</span>
{% endif %}
```

## Variants
Variants allow different visual representations of the same component:

1. Create a new .twig file in the variants directory
2. The filename becomes the variant name in the style selector
3. Use BEM naming convention for CSS classes

## Best Practices
1. Keep controllers focused on data processing
2. Use meaningful field names
3. Document field purposes
4. Follow BEM naming in templates
5. Keep variants focused on presentation
6. Use responsive design
7. Comment your code

## Examples

### Adding Fields
```php
// fields.php
return [
    [
        'key' => 'field_hero_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text',
    ],
    // Add more fields...
];
```

### Processing Data
```php
// controller.php
public function processData($data) {
    $data['processed_title'] = strtoupper($data['title']);
    return $data;
}
```

### Template Usage
```twig
{# variants/custom.twig #}
<div class="hero">
    <h2>{{ processed_title }}</h2>
</div>
```

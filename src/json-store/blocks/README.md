# Block

This directory contains ACF field group definitions specific to blocks.

## Usage with @block Namespace

When creating block controllers or render callbacks, use the `@block` namespace to reference your Twig templates. For example:

```php
Timber::render('@block/block-name/block.twig', $context);
```

This ensures consistency across your theme and makes it easier to locate and manage block templates.

## Block Structure

Each block should follow this structure:

```
block-name/
├── block.json
├── block-controller.php
├── block.twig
└── components/
    ├── component-name.twig
    └── ...
```

- `block.json`: Defines the block's properties and settings.
- `block-controller.php`: Handles the block's PHP logic, sets up the Timber context, and provides default values using Faker.
- `block.twig`: Contains the block's main HTML structure using Twig templating.
- `components/`: Directory containing smaller, reusable Twig templates for the block.

## Example

Here's an example of how to structure your block files:

```php
// block-controller.php
use Faker\Factory;

$context = Timber::context();
$context['block'] = $block;
$context['fields'] = get_fields();

$faker = Factory::create();

if ($is_preview) {
    $defaults = [
        'title' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'gallery' => array_fill(0, 5, $faker->imageUrl(800, 600, 'nature', true)),
    ];

    $context['fields'] = array_merge($defaults, array_filter((array)$context['fields']));
}

Timber::render('@block/block-name/block.twig', $context);
```

```twig
{# block.twig #}
<div id="{{ block.id }}" class="block-name">
    {% include '@block/block-name/components/header.twig' %}
    {% include '@block/block-name/components/gallery.twig' %}
</div>
```

```twig
{# components/header.twig #}
<header class="block-header">
    <h2>{{ fields.title }}</h2>
    <p>{{ fields.description }}</p>
</header>
```

```twig
{# components/gallery.twig #}
<div class="block-gallery">
    {% for image in fields.gallery %}
        <img src="{{ image }}" alt="Gallery image {{ loop.index }}" />
    {% endfor %}
</div>
```

Remember to keep your block.twig files and components in the corresponding block directory under src/blocks/.

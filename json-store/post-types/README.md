# Post Types

This directory contains custom post type definitions.

When creating templates for custom post types, if the templates are located in the blocks directory, you can use the `@block` namespace:

```php
Timber::render('@block/post-type-template/template.twig', $context);
```

This maintains a consistent approach to template rendering throughout your theme.

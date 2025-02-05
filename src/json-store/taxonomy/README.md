# Taxonomy

This directory contains custom taxonomy definitions.

If you need to render templates associated with these taxonomies and the templates are located in the blocks directory, you can use the `@block` namespace:

```php
Timber::render('@block/taxonomy-template/template.twig', $context);
```

This ensures a consistent approach to template rendering across your theme.

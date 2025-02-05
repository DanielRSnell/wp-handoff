# Options

This directory contains ACF options page definitions.

If you need to render templates associated with these option pages and the templates are located in the blocks directory, you can use the `@block` namespace:

```php
Timber::render('@block/options-template/template.twig', $context);
```

This approach ensures consistency in how templates are referenced across your theme.

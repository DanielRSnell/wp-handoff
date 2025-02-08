# Fields

This directory contains ACF field group definitions that are not specific to blocks.

While these fields are not directly related to blocks, if you need to render templates associated with these fields, you can still use the `@block` namespace if the template is located in the blocks directory:

```php
Timber::render('@block/some-template/template.twig', $context);
```

This maintains consistency in your theme's template rendering approach.

# AwesomeBlock Block

## Structure
```
awesomeblock/
├── block.json         # Block registration
├── block.twig         # Main template
├── fields.php         # ACF fields
├── styles.css         # Block styles
└── components/        # Component templates
    └── example.twig   # Example component
```

## Usage
1. Block is automatically registered via `block.json`
2. Fields are registered via `fields.php`
3. Main template in `block.twig`
4. Styles in `styles.css`
5. Components in `components/`

## Development
- Use BEM naming: `.wp-block-acf-awesomeblock`
- Add components in `components/`
- Update styles in `styles.css`
- Modify fields in `fields.php`

## Production
1. Test all block variations
2. Verify responsive behavior
3. Check field validation
4. Test block alignment

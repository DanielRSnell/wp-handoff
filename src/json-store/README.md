# JSON Store Directory

## Overview
This directory stores ACF field configurations in JSON format, providing version control and improved performance for field management.

## Structure
```
json-store/
├── blocks/      # Block-specific field configurations
├── fields/      # General field group configurations
├── post-types/  # Post type field configurations
├── taxonomy/    # Taxonomy field configurations
└── options/     # Options page configurations
```

## Automatic Synchronization
- Field configurations are automatically saved here when updated in WordPress admin
- JSON files are loaded during initialization for better performance
- Changes can be version controlled and deployed across environments

## Best Practices
1. Always commit JSON files to version control
2. Review field changes in pull requests
3. Use JSON files as source of truth for field configurations
4. Don't modify JSON files directly - use WordPress admin

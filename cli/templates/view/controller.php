<?php

namespace WPHandoff\Components\{{name}};

/**
 * Component Controller for {{name}}
 * 
 * This controller allows you to modify the component data before it's passed to the template.
 * You can use this to:
 * - Execute queries based on field values
 * - Transform data
 * - Add additional data to the component
 * - Fetch external data
 * 
 * Example use cases:
 * 1. Query posts based on field selections
 * 2. Format dates or other data
 * 3. Fetch API data
 * 4. Add computed values
 * 
 * The filter 'wp_handoff_component_{{lowercase_name}}_data' receives the raw field data
 * and allows you to modify it before it reaches the template.
 */
class Controller {
    public function __construct() {
        add_filter('wp_handoff_component_{{lowercase_name}}_data', [$this, 'processData']);
    }

    /**
     * Process and modify component data
     * 
     * @param array $data Raw field data from ACF
     * @return array Modified data
     * 
     * Example modifications:
     * 
     * 1. Query posts based on field values:
     * if (!empty($data['post_type'])) {
     *     $data['queried_items'] = new WP_Query([
     *         'post_type' => $data['post_type'],
     *         'posts_per_page' => $data['posts_per_page'] ?? 10
     *     ]);
     * }
     * 
     * 2. Add computed values:
     * $data['formatted_date'] = date('F j, Y', strtotime($data['date']));
     * 
     * 3. Fetch external data:
     * if (!empty($data['api_endpoint'])) {
     *     $response = wp_remote_get($data['api_endpoint']);
     *     $data['api_data'] = wp_remote_retrieve_body($response);
     * }
     */
    public function processData($data) {
        // Example: Add current timestamp
        $data['generated_at'] = current_time('timestamp');
        
        // Add your data processing logic here
        
        return $data;
    }
}

return new Controller();

<?php

namespace WPHandoff\Components\Testimonials;

class Controller {
    public function __construct() {
        add_filter('wp_handoff_component_testimonials_data', [$this, 'processData']);
    }

    public function processData($data) {
        // Example of modifying/adding data
        $data['processed_date'] = current_time('timestamp');
        
        // You can add any additional data processing here
        return $data;
    }
}

return new Controller();

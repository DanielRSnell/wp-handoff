<?php

namespace WPHandoff\Router;

class Controller {
  private $routes = [];
  private $layout_rules = [];

  public function __construct() {
    $this->loadRoutes();
    $this->loadLayoutRules();
    add_filter('template_include', [$this, 'handleRequest'], 999);
  }

  private function loadRoutes() {
    $routes_dir = __DIR__ . '/routes';
    $route_groups = glob($routes_dir . '/*', GLOB_ONLYDIR);
    
    foreach ($route_groups as $group_dir) {
      $group_name = basename($group_dir);
      $route_files = glob($group_dir . '/*.php');
      
      foreach ($route_files as $file) {
        $route = require_once $file;
        // Add group information to route
        $route['group'] = $group_name;
        $route['file'] = basename($file);
        $this->routes[] = $route;
      }
    }

    // Sort routes by priority (if needed)
    usort($this->routes, function($a, $b) {
      return ($a['priority'] ?? 10) - ($b['priority'] ?? 10);
    });
  }

  private function loadLayoutRules() {
    $layouts = get_posts([
      'post_type' => 'layout',
      'posts_per_page' => -1,
      'fields' => 'ids'
    ]);

    foreach ($layouts as $layout_id) {
      $template_type = get_field('template_type', $layout_id);
      if ($template_type) {
        $this->layout_rules[$template_type] = $layout_id;
      }
    }
  }

  public function handleRequest($template) {
    // Skip if we're in editor mode
    if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
      return get_template_directory() . '/includes/editor/views/editor.php';
    }

    // Check each route
    foreach ($this->routes as $route) {
      if ($route['condition']()) {
        $template_type = $route['template_type'];
        
        // If template_type is a callback, execute it
        if (is_callable($template_type)) {
          $template_type = $template_type();
        }
        
        if (isset($this->layout_rules[$template_type])) {
          // Add the matched route info to global state for potential use in templates
          global $wp_handoff;
          $wp_handoff = $wp_handoff ?? [];
          $wp_handoff['current_route'] = [
            'name' => $route['name'],
            'group' => $route['group'],
            'template_type' => $template_type,
            'layout_id' => $this->layout_rules[$template_type]
          ];
          
          return get_template_directory() . '/templates/dynamic.php';
        }
        
        break;
      }
    }

    return $template;
  }

  public function getCurrentRoute() {
    global $wp_handoff;
    return $wp_handoff['current_route'] ?? null;
  }
}

return new Controller();

<?php

namespace WPHandoff\Router;

use Timber\Timber;

class Render {
  public static function view($template, $context = []) {
    // Merge with global context
    $context = array_merge(Timber::context(), $context);
    
    // Render template
    Timber::render($template, $context);
  }

  public static function partial($template, $context = []) {
    // For rendering partial templates
    Timber::render($template, $context);
  }

  public static function string($template, $context = []) {
    // Render template to string
    return Timber::compile($template, $context);
  }
}

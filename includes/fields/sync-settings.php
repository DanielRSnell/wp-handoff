<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

// Load all settings files
$settings_dir = __DIR__ . '/settings';
$settings_files = glob($settings_dir . '/*.php');

foreach ($settings_files as $file) {
    require_once $file;
}

<?php

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/core/helpers.php';  // Add this line
require_once __DIR__ . '/includes/core/ThemeSetup.php';
require_once __DIR__ . '/includes/core/Security.php';
require_once __DIR__ . '/includes/core/Performance.php';

// Initialize theme
ThemeSetup::getInstance();
Security::getInstance();
Performance::getInstance();

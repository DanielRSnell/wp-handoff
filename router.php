<?php

use WPHandoff\Router\Controller as Router;

// Initialize router if not already done
global $handoff_router;
if (!isset($handoff_router)) {
    $handoff_router = new Router();
}

// Handle the request
$handoff_router->handle();

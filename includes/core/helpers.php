<?php

if (!function_exists('get_current_url')) {
    function get_current_url() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
            "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}

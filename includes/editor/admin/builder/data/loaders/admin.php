<?php

function get_admin_pages() {
    global $menu, $submenu;
    
    $pages = [];
    
    // Core admin pages
    $core_pages = [
        'index.php' => 'Dashboard',
        'edit.php' => 'Posts',
        'upload.php' => 'Media',
        'edit.php?post_type=page' => 'Pages',
        'edit-comments.php' => 'Comments',
        'themes.php' => 'Appearance',
        'plugins.php' => 'Plugins',
        'users.php' => 'Users',
        'tools.php' => 'Tools',
        'options-general.php' => 'Settings'
    ];

    // Get all registered admin pages
    if (!empty($menu)) {
        foreach ($menu as $menu_item) {
            if (!empty($menu_item[2])) {
                $pages[$menu_item[2]] = $menu_item[0];
            }
        }
    }

    // Get all registered admin subpages
    if (!empty($submenu)) {
        foreach ($submenu as $parent => $menu_items) {
            foreach ($menu_items as $menu_item) {
                if (!empty($menu_item[2])) {
                    $pages[$menu_item[2]] = $menu_item[0];
                }
            }
        }
    }

    return [
        'core' => $core_pages,
        'registered' => $pages
    ];
}

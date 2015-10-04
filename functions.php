<?php

$path = dirname( __FILE__ );

require_once $path . '/mvc/require.php';

$admin_controller = new Bamboo_Admin_Controller();

$base_controller = new Bamboo_Base_Controller();

/* Sidebars */
$sidebars = array(
    array(
        'name'          => 'Sidebar Widgets',
        'id'            => 'sidebar1',
        'description'   => 'Widgets in this area will be shown on the right-hand side.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    )
);


/***** Custom Post Types ****/
$custom_post_types = array(
    array(
        'uname' => 'test',
        'name' => 'Test',
        'singular_name' => 'Test',
        'menu_name' => 'Test' ,
        'enable_post_thumbnail_support' => true,
        'menu_icon' => get_template_directory_uri().'/images/test.png'
    )
);

/***** Meta Boxes ****/
$metaboxes = array(
    array (
        'id' => 'Test Meta',
        'title' => 'Test Meta',
        'screen' =>'test',
        'context' => 'side',
        'priority' => 'high',
        'callback_args' => ''
    )
);

/*** Theme Supports ***/

$supports = array(
    'wp_nav_menu'
);

/*** Nav Menus ***/
$nav_menus = array(
    array(
        'id' => 'primary-menu',
        'name' => 'Primary Menu'
    ),
    array(
        'id' => 'top-menu',
        'name' => 'Top Menu'
    )
);

$settings['custom_post_types'] = $custom_post_types;
$settings['metaboxes'] = $metaboxes;
$settings['sidebars'] = $sidebars;
$settings['theme_supports'] = $supports;
$settings['nav_menus'] = $nav_menus;

$functions = new Bamboo_Functions($settings);

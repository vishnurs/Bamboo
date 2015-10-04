<?php

$path = get_template_directory();

$require = array(
    $path . '/twig/Twig/Autoloader.php',
    $path . '/mvc/config/class-config.php',
    $path . '/mvc/config/class-bamboo-twig-functions.php',
    $path . '/mvc/models/class-bamboo-functions.php',
    $path . '/mvc/config/class-wp-twig.php',
    $path . '/mvc/models/class-bamboo-admin-model.php',
    $path . '/mvc/models/class-bamboo-base-model.php',
    $path . '/mvc/controllers/class-bamboo-admin-controller.php',
    $path . '/mvc/controllers/class-bamboo-base-controller.php',
    $path . '/mvc/controllers/class-bamboo-theme-settings-controller.php',
    $path . '/mvc/inc/wp_bootstrap_navwalker.php'
);

foreach( $require as $value ) {
    require_once( $value );
}

?>

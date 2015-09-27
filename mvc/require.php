<?php

$path = get_template_directory();

$require = array(
    $path . '/twig/Twig/Autoloader.php',
    $path . '/mvc/config/class-config.php',
    $path . '/mvc/config/class-bmb-twig-functions.php',
    $path . '/mvc/model/class-bmb-functions.php',
    $path . '/mvc/config/class-wp-twig.php',
    $path . '/mvc/model/class-bmb-admin-model.php',
    $path . '/mvc/model/class-bmb-base-model.php',
    $path . '/mvc/controllers/class-bmb-admin-controller.php',
    $path . '/mvc/controllers/class-bmb-base-controller.php',
    $path . '/mvc/controllers/class-bmb-theme-settings-controller.php',
    $path . '/mvc/inc/wp_bootstrap_navwalker.php'
);

foreach( $require as $value ) {
    require_once( $value );
}

?>

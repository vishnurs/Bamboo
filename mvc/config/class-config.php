<?php


class Config {

    const VIEW_PATH = '/mvc/views/';
    const CACHE_PATH = '/twig/cache';
    const ENV = 'DEV';
    protected $template = '';
    protected $path, $twig;
    protected $domain = 'Bamboo';

    public function __construct($type) {
        Twig_Autoloader::register( true );
        $this->path = get_template_directory();
        $loader = new Twig_Loader_Filesystem( $this->path . self::VIEW_PATH . $type );
        $this->twig = new Twig_Environment( $loader, array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new Twig_Extension_Debug());
        $twig_functions = new Bamboo_Twig_Functions();
        foreach( $twig_functions->custom_functions as $func ){
            $this->twig->addFunction($func);
        }
    }

    public function render_template( $template_name, $template_variable = array() ) {
        $template_variable['wp'] = new WP_Twig();
        echo $this->twig->render( $template_name, $template_variable );
    }
}

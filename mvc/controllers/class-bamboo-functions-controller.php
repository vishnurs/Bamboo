<?php

class WPFrogs_Functions extends Config {
    private $sidebars;
    private $metaboxes;
    private $custom_post_types;
    private $metabox_controller;
    public function __construct($settings) {
        $this->metabox_controller = new WPFrogs_Metabox_Controller();
        if($settings) {
            $this->sidebars = $settings['sidebars'] ? $settings['sidebars'] : array();
            $this->metaboxes = $settings['metaboxes'] ? $settings['metaboxes'] : array();
            $this->custom_post_types = $settings['custom_post_types'] ? $settings['custom_post_types']
                                        : array();
        }

        /** Hooks **/
        add_action( 'wp_enqueue_scripts', array($this, 'wpfrogs_scripts') );
        add_action( 'init', array($this, 'wpfrogs_sidebars') );
        add_action( 'init', array($this, 'wpfrogs_custom_post_types') );
        foreach($this->metaboxes as $metabox) {
            add_action( 'save_post', array($this, 'save_post_'.$metabox['id'].'_meta_data') );
        }
        add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );

        if($settings['theme_supports']) {
            $this->wpfrogs_theme_supports($settings['theme_supports']);
        }

        if($settings['nav_menus']) {
            $this->wpfrogs_nav_menus($settings['nav_menus']);
        }

    }
    public function save_product_link_metabox_data($post_id) {
        //die('saving');
    }
    public function wpfrogs_scripts() {
        if(Config::ENV === 'DEV') {
            wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/css/bootstrap.min.css' );
            wp_enqueue_script( 'jquery', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.min.js' );
            wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js' );
            wp_enqueue_script( 'angular', get_template_directory_uri() . '/bower_components/angular/angular.min.css' );
        } else {
            wp_enqueue_style( 'lib-style', get_stylesheet_uri() . '/build/css/lib.css' );
            wp_enqueue_style( 'cus-style', get_stylesheet_uri() . '/build/css/app.css' );
            wp_enqueue_script( 'lib-script', get_stylesheet_uri() . '/build/js/lib.js' );
            wp_enqueue_script( 'cus-script', get_stylesheet_uri() . '/build/js/app.js' );
        }
    }

    private function wpfrogs_theme_supports($features) {
        foreach($features as $feature) {
            add_theme_support($feature);
        }
    }

    private function wpfrogs_nav_menus($nav_menus) {
        if (function_exists('wp_nav_menu')) {
            foreach($nav_menus as $nav_menu) {
                register_nav_menus(
                    array( $nav_menu['id'] => __( $nav_menu['name'], $this->domain ) )
                );
            }
        }
    }

    public function wpfrogs_sidebars() {
        foreach( $this->sidebars as $sidebar ) {
            $args = array(
                'name'          => __( $sidebar['name'], $this->domain ),
                'id'            => $sidebar['id'],
                'description'   => $sidebar['description'] ? __( $sidebar['description'], $this->domain ) : '',
                'class'         => $sidebar['class'] ? $sidebar['class'] : '',
                'before_widget' => $sidebar['before_widget'] ? $sidebar['before_widget'] : '',
                'after_widget'  => $sidebar['after_widget'] ? $sidebar['after_widget'] : '',
                'before_title'  => $sidebar['before_title'] ? $sidebar['before_title'] : '',
                'after_title'   => $sidebar['after_title'] ? $sidebar['before_title'] : ''
            );
            register_sidebar( $args );
        }
    }

    public function wpfrogs_custom_post_types() {
        foreach( $this->custom_post_types as $post_type) {
            if(!$post_type['uname'] || !$post_type['name']) {
                continue;
            }
            $labels = array(
                'name' => ucfirst($post_type['uname']),
                'singular_name' => $post_type['singular_name'] ?
                                    ucfirst($post_type['singular_name']) :
                                    ucfirst($post_type['name']),
                'add_new' => $post_type['menu_name'] ? 'Add ' . ucfirst($post_type['menu_name']) : 'Add ' .
                                ucfirst($post_type['name']),
                'all_items' => $post_type['menu_name'] ? $post_type['menu_name'] : $post_type['name'],
                'add_new_item' => $post_type['menu_name'] ?'Add new '.ucfirst($post_type['menu_name']) :
                                    'Add new ' . ucfirst($post_type['name']),
                'edit_item' => $post_type['menu_name'] ? 'Edit ' . ucfirst($post_type['menu_name']) : $post_type['name'],
                'new_item' => $post_type['menu_name'] ? 'New ' . ucfirst($post_type['menu_name']) : $post_type['name'],
                'view_item' => $post_type['menu_name'] ? 'View ' . ucfirst($post_type['menu_name']) : $post_type['name'],
                'search_items' => $post_type['menu_name'] ? 'Search ' . ucfirst($post_type['menu_name']) : $post_type['name'],
                'not_found' => $post_type['menu_name'] ? 'No ' . ucfirst($post_type['menu_name']) . ' found' : $post_type['name'],
                'not_found_in_trash' => $post_type['menu_name'] ? 'No ' . ucfirst($post_type['menu_name']) . ' found in trash' :
                                        $post_type['name'],
                'menu_name' => $post_type['menu_name'] ? ucfirst($post_type['menu_name']) : $post_type['name']
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'menu_position' => '',
                'supports' => $supports,
                'has_archive' => true,
            );

            register_post_type( $post_type['uname'], $args );

        }
    }

    public function add_meta_boxes() {
        if (!is_admin()) {
            return;
        }

        foreach ($this->metaboxes as $metabox) {
            if(!isset($metabox['id'], $metabox['title'])) {
                continue;
            }

            add_meta_box(
                $metabox['id'],
                $metabox['title'],
                array($this->metabox_controller, $metabox['id']),
                $metabox['screen'] ? $metabox['screen'] : NULL,
                $metabox['context'] ? $metabox['context'] : 'side',
                $metabox['callback_args'] ? $metabox['callback_args'] : NULL
            );
        }
    }

    public function save_post_product_link_meta_data($post_id) {

        if(!$this->check_metabox()) {
            return;
        }

        if ( ! isset( $_POST['product_link_meta'] ) ) {
            return;
        }
        $my_data = sanitize_text_field( $_POST['product_link_meta'] );

        update_post_meta( $post_id, 'product_link_meta_value', $my_data );
    }

    private function check_metabox() {

        if ( ! isset( $_POST['wpfrogs_meta_box_nonce'] ) ) {
            return false;
        }

        if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_save_meta_box_data' ) ) {
            return false;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return false;
        }

        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return false;
            }

        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return false;
            }
        }

        return true;
    }
}

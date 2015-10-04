<?php

class WPFrogs_Metabox_Controller extends WPFrogs_Admin_Controller {

    private $metabox_model;
    public function __construct() {
        parent::__construct( 'admin' );
        $this->metabox_model = new WPFrogs_Metabox_Model();
    }

    public function product_link($post) {
        $this->render_page('/metaboxes/product-link-meta-box.html',
                               $this->metabox_model->product_link($post) );


    }

    public function landing_link() {}


}

<?php

class WPFrogs_Metabox_Model extends WPFrogs_Admin_Model {

    public function __construct() {

    }

    public function product_link($post) {

        $product_link['nonce'] = wp_nonce_field( 'save_product_link_metabox_data',
                                                'wpfrogs_meta_box_nonce' );
        $product_link['value'] = get_post_meta( $post->ID, 'product_link_meta_value', true );

        return $product_link;
    }


}

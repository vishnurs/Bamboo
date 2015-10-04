<?php

/**
 * @author       Vishnu
 * @copyright    Copyright (c) 2015, WPFrogs, http://wpfrogs.com/
 * @version      0.1
 */

class WPFrogs_Base_Controller extends Config {


    public function __construct() {
        parent::__construct( 'front' );

    }

    public function index() {
        $this->render_page( 'index.html' );
    }

    public function author() {
        $this->render_page( 'author.html' );
    }

    public function archive() {
        $this->render_page( 'archive.html' );
    }

    public function single() {
        $this->render_page( 'single.html' );
    }

    public function search() {
        $this->render_page( 'search.html' );
    }

    public function page() {
        $this->render_page( 'page.html' );
    }

    public function category() {
        $this->render_page( 'category.html' );
    }

    public function four_not_four() {
        $this->render_page( '404.html' );
    }
}
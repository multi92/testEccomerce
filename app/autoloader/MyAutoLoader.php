<?php


class MyAutoLoader
{

    private $path;
    public function __construct($path) {
        $this->path = $path;
        spl_autoload_register( array($this, 'load') );
    }

    function load( $file ) {
        if (is_file($this->path . '/' . $file . '.php')) {
            require_once( $this->path . '/' . $file . '.php' );
        }
    }
}
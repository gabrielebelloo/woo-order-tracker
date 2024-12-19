<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

class Enqueue {

  function register() {
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ));
  }

  function enqueue() {
    wp_enqueue_style( 'style', PLUGIN_URL . '/assets/style.css' );
    wp_enqueue_script( 'script', PLUGIN_URL . 'assets/script.js' );
  }
}
<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

use \Src\Base\BaseController;

class Enqueue extends BaseController {

  function register() {
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ));
  }

  function enqueue() {
    wp_enqueue_style( 'style', $this->plugin_url . '/assets/style.css' );
    wp_enqueue_script( 'script', $this->plugin_url . 'assets/script.js' );
  }
}
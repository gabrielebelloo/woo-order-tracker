<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Pages;

class Admin {

  public function register() {
    add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
  }

  function add_admin_page() {
    add_menu_page(
      'Woo Order Tracker',
      'Woo Order Tracker',
      'manage_options',
      'woo_order_tracker',
      array( $this, 'index' ),
      'dashicons-airplane',
      110
    );
  }

  function index() {
    require_once PLUGIN_PATH . 'templates/index.php';
  }
}
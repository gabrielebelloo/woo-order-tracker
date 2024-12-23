<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Pages;

use \Src\Base\BaseController;

class Admin extends BaseController {

  public function register() {
    add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
    add_action( 'wp_ajax_save_settings', array( $this, 'save_settings' ) );
    add_action( 'wp_ajax_nopriv_save_settings', array( $this, 'save_settings' ) );
  }

  public function add_admin_page() {
    add_menu_page(
      'Woo Order Tracker Settings',
      'Woo Order Tracker',
      'manage_options',
      'woo_order_tracker',
      array( $this, 'render_page' ),
      'dashicons-airplane',
      40
    );
  }

  public function render_page() {
    require_once $this->plugin_path . 'templates/index.php';
  }

  public function save_settings() { 
    if ( ! check_ajax_referer( 'woo_order_tracker_nonce', 'nonce', false ) ) {
      wp_send_json_error( array( 'message' => 'Invalid nonce' ), 400 );
      return;
    }

    $order_tracking = isset( $_POST['order_tracking'] ) ? sanitize_text_field( wp_unslash( $_POST['order_tracking'] ) ) : '';
    $webhook_url = isset( $_POST['webhook_url'] ) ? esc_url_raw( wp_unslash( $_POST['webhook_url'] ) ) : '';

    update_option( 'woo_settings', array(
      'order_tracking' => $order_tracking,
      'webhook_url' => $webhook_url
    ));

    wp_send_json_success( array( 'message' => 'Settings saved.' ) );
  }
}
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

    error_log( print_r( $_POST, true ) );

    $order_tracking = isset( $_POST['order_tracking'] ) ? sanitize_text_field( wp_unslash( $_POST['order_tracking'] ) ) : '';
    $webhook_url = isset( $_POST['webhook_url'] ) ? esc_url_raw( wp_unslash( $_POST['webhook_url'] ) ) : '';

    error_log( 'order_tracking: ' . $order_tracking );
    error_log( 'webhook_url: ' . $webhook_url );

    update_option( 'woo_settings', array(
      'order_tracking' => $order_tracking,
      'webhook_url' => $webhook_url
    ));

    wp_send_json_success( array( 'message' => 'Settings saved.' ) );
  }

  /* public function add_custom_fields() {
    register_setting(
      'woo_settings_group',
      'woo_settings'
    );

    add_settings_section(
      'woo_settings_section',
      'Order Tracking Settings',
      '',
      'woo_order_tracker'
    );

    add_settings_field(
      'order_tracking',
      'Track orders',
      array( $this, 'order_tracking' ),
      'woo_order_tracker',
      'woo_settings_section',
      array(
        'label_for' => 'order_tracking',
        'class' => 'order_tracking_field'
      )
    );

    add_settings_field(
      'webhook_url',
      'Webhook Destination URL',
      array( $this, 'webhook_url' ),
      'woo_order_tracker',
      'woo_settings_section',
      array(
        'label_for' => 'webhook_url',
        'class' => 'webhook_url_field'
      )
    );
  }

  public function order_tracking() {
    $settings = get_option( 'woo_settings' );
    $value = isset( $settings['order_tracking'] ) ? $settings['order_tracking'] : 0;
    echo '<input type="checkbox" name="woo_settings[order_tracking]" value="1" ' . ( $value == 1 ? 'checked' : '' ) . '>';
  }

  public function webhook_url() { 
    $settings = get_option( 'woo_settings' );
    $value = isset( $settings['webhook_url'] ) ? $settings['webhook_url'] : '';
    echo '<input type="text" name="woo_settings[webhook_url]" value="' . $value . '" placeholder="https://your-webhook-url.com">';
  } */
}
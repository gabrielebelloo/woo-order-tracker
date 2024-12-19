<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Pages;

use \Src\Base\BaseController;

class Admin extends BaseController {

  public function register() {
    add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
    add_action( 'admin_init', array( $this, 'add_custom_fields' ) );
  }

  public function add_admin_page() {
    add_menu_page(
      'Woo Order Tracker Settings',
      'Woo Order Tracker',
      'manage_options',
      'woo_order_tracker',
      array( $this, 'index' ),
      'dashicons-airplane',
      40
    );
  }

  public function index() {
    require_once $this->plugin_path . 'templates/index.php';
  }

  public function add_custom_fields() {
    register_setting(
      'woo_options_group',
      'woo_options'
    );

    add_settings_section(
      'woo_options_section',
      'Order Tracking Options',
      '',
      'woo_order_tracker'
    );

    add_settings_field(
      'order_tracking',
      'Track orders',
      array( $this, 'order_tracking' ),
      'woo_order_tracker',
      'woo_options_section',
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
      'woo_options_section',
      array(
        'label_for' => 'webhook_url',
        'class' => 'webhook_url_field'
      )
    );
  }

  public function order_tracking() {
    $value = esc_attr( get_option( 'order_tracking' ) );
    echo '<input type="checkbox" name="woo_options[order_tracking]" value="1" ' . ( $value == 1 ? 'checked' : '' ) . '>';
  }

  public function webhook_url() { 
    $value = esc_attr( get_option( 'webhook_url' ) );
    echo '<input type="text" name="woo_options[webhook_url]" value="' . $value . '" placeholder="https://your-webhook-url.com">';
  }
}
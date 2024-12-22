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
    wp_enqueue_script( 'wp-element' );
    wp_enqueue_script( 'woo-order-tracker-admin', $this->plugin_url . '/build/main.js', array( 'wp-element' ), null, true );

    $settings = get_option( 'woo_settings' );
    $order_tracking = isset( $settings['order_tracking'] ) ? $settings['order_tracking'] : 0;
    $webhook_url = isset( $settings['webhook_url'] ) ? $settings['webhook_url'] : '';

    error_log( 'order_tracking: ' . $order_tracking );
    error_log( 'webhook_url: ' . $webhook_url );

    wp_localize_script( 'woo-order-tracker-admin', 'wooOrderTrackerSettings', array(
        'order_tracking' => $order_tracking,
        'webhook_url'    => $webhook_url,
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('woo_order_tracker_nonce'),
    ));
    
  }
}
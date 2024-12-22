<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

class WooWebhook {

  public $called_hooks;

  public function __construct() {
    $this->called_hooks = array();
  }

  public function register() {
    add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'send_order_webhook' ) );
    add_action( 'woocommerce_order_status_changed', array( $this, 'send_order_webhook' ) );
    add_action( 'woocommerce_order_status_cancelled', array( $this, 'send_order_webhook' ) );
    add_action( 'woocommerce_trash_order', array( $this, 'send_order_webhook' ) );
    add_action( 'woocommerce_order_note_added', array( $this, 'send_order_webhook' ) );
    add_action( 'woocommerce_order_status_completed', array( $this, 'send_order_webhook' ) );
  }

  public function send_order_webhook( $order_id ) {
    $called_hook = current_filter();

    if ( $called_hook == 'woocommerce_order_note_added' ) {
      $note = get_comment( $order_id );
      $order_id = $note->comment_post_ID;
    }

    error_log( $order_id );

    $settings = get_option( 'woo_settings' );

    if ( isset( $settings['order_tracking'] ) && !$this->called_hooks ) {
      $webhook_url = $settings['webhook_url'];
      $order = wc_get_order( $order_id ); 

      if ( !$order ) {
        error_log( "Order could not be found." );
        return;
      }

      $order_data = $order->get_data();

      error_log( $webhook_url );

      $response = wp_remote_post($webhook_url, array(
        'method' => 'POST',
        'body' => json_encode( $order_data ),
        'headers' => array(
          'Content-Type' => 'application/json'
        )
      ));

      error_log( json_encode( $response ) );
    }

    array_push( $this->called_hooks, current_filter() );
  }
}
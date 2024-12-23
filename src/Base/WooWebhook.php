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

    $settings = get_option( 'woo_settings' );

    error_log( print_r( $settings, true ) );
    
    if ( $settings['order_tracking'] === '1' && !$this->called_hooks ) {
      $webhook_url = $settings['webhook_url'];

      if ( $called_hook == 'woocommerce_order_note_added' ) {
        $note = get_comment( $order_id );
        if ( $note && isset( $note->comment_post_ID ) ) {
          $order_id = $note->comment_post_ID;
        } else {
          error_log( "Invalid note ID or comment not found: $order_id" );
          return;
        }
      }

      $order = wc_get_order( $order_id ); 

      if ( !$order ) {
        error_log( "Order could not be found." );
        return;
      }

      if ( !$settings['webhook_url'] ) {
        error_log( "Webhook URL not set in settings." );
        return;
      }

      $order_data = $order->get_data();

      $response = wp_remote_post($webhook_url, array(
        'method' => 'POST',
        'body' => json_encode( $order_data ),
        'headers' => array(
          'Content-Type' => 'application/json'
        )
      ));

      if ( is_wp_error( $response ) ) {
        error_log( $response->get_error_message() );
      } else {
        error_log( $response['body'] );
      }
    }

    array_push( $this->called_hooks, current_filter() );
  }
}
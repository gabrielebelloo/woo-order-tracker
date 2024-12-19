<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package WooOrderTracker
*/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  die;
}

$orders_trackings = get_posts( array( 'post_type' => 'book', 'numberposts' => -1 ) );

foreach( $orders_trackings as $order_tracking) {
  wp_delete_posts( $order_tracking->ID, true );
}

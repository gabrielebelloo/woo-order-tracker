<?php
/**
 * @package WooOrderTracker
 */
/*
Plugin Name: Woo Order Tracker
Plugin URI: https://github.com/gabrielebelloo
Description: This is a plugin for Wordpress and WooCommerce capable of tracking orders.
Version: 1.0.0
Author: Gabriele Bello
Author URI: https://www.linkedin.com/in/gabrielebello/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woo-order-tracker
*/

/*
Copyright (C) 2024  Bello Gabriele

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see
<https://www.gnu.org/licenses/>.
*/

if ( !defined( 'ABSPATH' ) ) {
  die;
}


class WooOrderTrackerPlugin {

  function __construct() {
    add_action( 'init', array( $this, 'register_order_tracking_cpt' ) );
  }

  function register() {
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ));

    add_action( 'admin_menu', array( $this, 'add_sidebar' ) );
  }

  function add_sidebar() {
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
    require_once plugin_dir_path( __FILE__ ) . 'templates/index.php';
  }

  function register_order_tracking_cpt() {
    register_post_type( 'order_tracking', ['public' => true, 'label' => 'Order Trackings'] );
  }

  function enqueue() {
    wp_enqueue_style( 'style', plugins_url( '/assets/style.css', __FILE__ ) );
    wp_enqueue_script( 'script', plugins_url( 'assets/script.js', __FILE__ ) );
  }
}


if ( class_exists( 'WooOrderTrackerPlugin' ) ) {
  $wooOrderTrackingPlugin = new WooOrderTrackerPlugin();
  $wooOrderTrackingPlugin->register();
}


// activation
require_once plugin_dir_path( __FILE__ ) . 'inc/plugin-activate.php';
register_activation_hook( __FILE__, array( 'PluginActivate', 'activate' ) );

// deactivation
require_once plugin_dir_path( __FILE__ ) . 'inc/plugin-deactivate.php';
register_deactivation_hook( __FILE__, array( 'PluginDeactivate', 'deactivate' ) );

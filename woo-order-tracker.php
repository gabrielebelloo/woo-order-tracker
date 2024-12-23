<?php
/**
 * @package WooOrderTracker
 */
/*
Plugin Name: Woo Order Tracker
Plugin URI: https://github.com/gabrielebelloo/woo-order-tracker
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

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
  require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// plugin activation
function activate_woo_plugin() {
  Src\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_woo_plugin' );

// plugin deactivation
function deactivate_woo_plugin() {
  Src\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_woo_plugin' );


if ( class_exists( 'Src\Init' ) ) {
  Src\Init::register_services();  
}
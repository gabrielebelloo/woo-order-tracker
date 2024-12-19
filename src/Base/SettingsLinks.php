<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

class SettingsLinks {

  protected $plugin;

  public function __construct() {
    $this->plugin = PLUGIN;
  }
  
  public function register() {
    add_filter( 'plugin_action_links_' . PLUGIN, array( $this, 'settings_link' ) );
  }

  public function settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=woo_order_tracker">Settings</a>';
    array_push( $links, $settings_link );
    return $links;
  }
}
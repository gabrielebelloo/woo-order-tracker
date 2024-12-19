<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

class BaseController {

  public $plugin;
  public $plugin_path;
  public $plugin_url;

  function __construct() {
    $plugin = plugin_basename( dirname( __FILE__, 3 ) );
    
    $this->plugin = $plugin . "/" . $plugin . ".php";
    $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
    $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
  }
}
<?php
/**
 * @package WooOrderTracker
 */
namespace Src\Base;

class Activate {
  
  public static function activate() {
    flush_rewrite_rules();
  }
}
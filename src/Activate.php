<?php
/**
 * @package WooOrderTracker
 */
namespace Src;

class Activate {
  public static function activate() {
    flush_rewrite_rules();
  }
}
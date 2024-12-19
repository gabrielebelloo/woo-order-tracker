<?php
/**
 * @package WooOrderTracker
 */
namespace Src;

class Deactivate {
  public static function deactivate() {
    flush_rewrite_rules();
  }
}
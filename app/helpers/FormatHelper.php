<?php
namespace App\Helpers;

class FormatHelper {
  public static function formatCurrency ($currency) {
    return number_format($currency, 0, ',', '.');
  }

  public static function formatDate($date, $format = 'd/m/Y'){
    return date($format, strtotime($date));
  }
}
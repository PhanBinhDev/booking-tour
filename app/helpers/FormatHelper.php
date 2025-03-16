<?php
namespace App\Helpers;

class FormatHelper {
  public static function formatCurrency ($currency) {
    return number_format($currency, 0, ',', '.');
  }
}
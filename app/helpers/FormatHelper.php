<?php

namespace App\Helpers;

class FormatHelper
{
  public static function formatCurrency($currency)
  {
    return number_format($currency, 0, ',', '.');
  }

  public static function formatDate($date, $format = 'd/m/Y')
  {
    return date($format, strtotime($date));
  }
  public static function formatPercent($a, $b)
  {
    return (self::formatCurrency($a) / self::formatCurrency($b)) * 100;
  }
}

<?php

namespace App\Helpers;

class UtilsHelper
{
  /**
   * Create a URL-friendly slug from a string
   * 
   * @param string $string The string to convert to a slug
   * @param int $maxLength Maximum length of the slug (optional)
   * @return string The formatted slug
   */
  public static function createSlug($string, $maxLength = 100)
  {
    // Trim the string
    $string = trim($string);

    // Convert Vietnamese characters to their non-accented equivalents
    $string = self::removeVietnameseAccents($string);

    // Convert to lowercase
    $string = mb_strtolower($string, 'UTF-8');

    // Remove special characters
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);

    // Replace spaces with hyphens
    $string = preg_replace('/[\s-]+/', '-', $string);

    // Trim hyphens from beginning and end
    $string = trim($string, '-');

    // Truncate to max length if specified
    if ($maxLength > 0 && strlen($string) > $maxLength) {
      $string = substr($string, 0, $maxLength);

      // Don't break in the middle of a word
      if (($pos = strrpos($string, '-')) !== false) {
        $string = substr($string, 0, $pos);
      }
    }

    // Ensure we still have a slug after processing
    if (empty($string)) {
      return 'post-' . date('Y-m-d-His');
    }

    return $string;
  }

  /**
   * Remove Vietnamese accents/diacritics from a string
   * 
   * @param string $string The string containing Vietnamese characters
   * @return string The string with Vietnamese characters converted to ASCII equivalents
   */
  public static function removeVietnameseAccents($string)
  {
    $replacements = [
      // Vietnamese vowels with diacritics
      '/[àáạảãâầấậẩẫăằắặẳẵ]/u' => 'a',
      '/[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/u' => 'A',
      '/[èéẹẻẽêềếệểễ]/u' => 'e',
      '/[ÈÉẸẺẼÊỀẾỆỂỄ]/u' => 'E',
      '/[ìíịỉĩ]/u' => 'i',
      '/[ÌÍỊỈĨ]/u' => 'I',
      '/[òóọỏõôồốộổỗơờớợởỡ]/u' => 'o',
      '/[ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/u' => 'O',
      '/[ùúụủũưừứựửữ]/u' => 'u',
      '/[ÙÚỤỦŨƯỪỨỰỬỮ]/u' => 'U',
      '/[ỳýỵỷỹ]/u' => 'y',
      '/[ỲÝỴỶỸ]/u' => 'Y',
      '/[đ]/u' => 'd',
      '/[Đ]/u' => 'D',

      // Other common accented characters (non-Vietnamese)
      '/[äåæ]/u' => 'a',
      '/[ÄÅÆ]/u' => 'A',
      '/[ç]/u' => 'c',
      '/[Ç]/u' => 'C',
      '/[ïî]/u' => 'i',
      '/[ÏÎ]/u' => 'I',
      '/[ñ]/u' => 'n',
      '/[Ñ]/u' => 'N',
      '/[öø]/u' => 'o',
      '/[ÖØ]/u' => 'O',
      '/[üû]/u' => 'u',
      '/[ÜÛ]/u' => 'U',
      '/[ÿ]/u' => 'y',
      '/[Ÿ]/u' => 'Y'
    ];

    return preg_replace(array_keys($replacements), array_values($replacements), $string);
  }

  /**
   * Generate a random string
   * 
   * @param int $length Length of the random string
   * @return string Random string
   */
  public static function randomString($length = 10)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $string;
  }

  /**
   * Check if a slug already exists and append a number if it does
   * 
   * @param string $slug Base slug
   * @param callable $checkFunction Function to check if slug exists
   * @return string Unique slug
   */
  public static function uniqueSlug($slug, $checkFunction)
  {
    $originalSlug = $slug;
    $counter = 1;

    // Keep checking and incrementing until we find a slug that doesn't exist
    while ($checkFunction($slug)) {
      $slug = $originalSlug . '-' . $counter;
      $counter++;
    }

    return $slug;
  }
}
<?php
namespace App\Helpers;

class UrlHelper {
    /**
     * Tạo URL đến tài nguyên công khai
     */
    public static function asset($path) {
        return ASSETS_URL . '/' . ltrim($path, '/');
    }
    
    /**
     * Tạo URL đến CSS
     */
    public static function css($filename) {
        return CSS_URL . '/' . ltrim($filename, '/');
    }

    /**
     * Tạo URL đến JS
     */
    public static function js($filename) {
        return JS_URL . '/' . ltrim($filename, '/');
    }

    /**
     * Tạo URL đến hình ảnh
     */
    public static function image($filename) {
        return IMAGES_URL . '/' . ltrim($filename, '/');
    }
    /**
     * Tạo URL đến route
     */
    public static function route($path = '') {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}
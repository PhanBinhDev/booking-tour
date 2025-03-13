<?php
namespace App\Helpers;

class Session {
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    
    public static function flash($key, $value = null) {
        if($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return $value;
        }
        
        if(isset($_SESSION['_flash'][$key])) {
            $value = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $value;
        }
        
        return null;
    }
    
    public static function hasFlash($key) {
        return isset($_SESSION['_flash'][$key]);
    }
    
    public static function clearFlash() {
        unset($_SESSION['_flash']);
    }
}
<?php

namespace App\Helpers;

class UrlHelper
{
    /**
     * Tạo URL đến tài nguyên công khai
     */
    public static function asset($path)
    {
        // Extract the path portion from ASSETS_URL
        $urlParts = parse_url(ASSETS_URL);
        $basePath = isset($urlParts['path']) ? rtrim($urlParts['path'], '/') : '';

        // Use protocol detection
        $protocol = self::getProtocol();
        $host = $_SERVER['HTTP_HOST'];

        return "$protocol://$host$basePath/" . ltrim($path, '/');
    }

    /**
     * Tạo URL đến CSS
     */
    public static function css($filename)
    {
        // Extract the path portion from CSS_URL
        $urlParts = parse_url(CSS_URL);
        $basePath = isset($urlParts['path']) ? rtrim($urlParts['path'], '/') : '';

        // Use protocol detection
        $protocol = self::getProtocol();
        $host = $_SERVER['HTTP_HOST'];

        return "$protocol://$host$basePath/" . ltrim($filename, '/');
    }

    /**
     * Tạo URL đến JS
     */
    public static function js($filename)
    {
        // Extract the path portion from JS_URL
        $urlParts = parse_url(JS_URL);
        $basePath = isset($urlParts['path']) ? rtrim($urlParts['path'], '/') : '';

        // Use protocol detection
        $protocol = self::getProtocol();
        $host = $_SERVER['HTTP_HOST'];

        return "$protocol://$host$basePath/" . ltrim($filename, '/');
    }

    /**
     * Tạo URL đến hình ảnh
     */
    public static function image($filename)
    {
        // Extract the path portion from IMAGES_URL
        $urlParts = parse_url(IMAGES_URL);
        $basePath = isset($urlParts['path']) ? rtrim($urlParts['path'], '/') : '';

        // Use protocol detection
        $protocol = self::getProtocol();
        $host = $_SERVER['HTTP_HOST'];

        return "$protocol://$host$basePath/" . ltrim($filename, '/');
    }
    /**
     * Tạo URL đến route
     */
    public static function route($path = '')
    {
        // Determine the correct protocol
        $protocol = self::getProtocol();

        // Get the server host
        $host = $_SERVER['HTTP_HOST'];

        // Get the base path from the PUBLIC_URL constant, without the protocol and host
        $publicUrlParts = parse_url(PUBLIC_URL);
        $basePath = isset($publicUrlParts['path']) ? rtrim($publicUrlParts['path'], '/') : '';

        // Ensure path doesn't start with a slash for proper URL construction
        $path = ltrim($path, '/');

        // Construct the URL using the detected protocol
        return "$protocol://$host$basePath/$path";
    }

    /**
     * Detect the correct protocol (http or https)
     */
    private static function getProtocol()
    {
        // Default protocol
        $protocol = 'http';

        // Check standard HTTPS
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $protocol = 'https';
        }

        // Check for Cloudflare headers
        if (isset($_SERVER['HTTP_CF_VISITOR'])) {
            $visitor = json_decode($_SERVER['HTTP_CF_VISITOR'], true);
            if (isset($visitor['scheme']) && $visitor['scheme'] === 'https') {
                $protocol = 'https';
            }
        }

        // Check for X-Forwarded-Proto header (used by many proxies including Cloudflare)
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $protocol = 'https';
        }

        return $protocol;
    }

    /**
     * Build a query string preserving current parameters while overriding specified ones
     * 
     * @param array $params Parameters to override
     * @return string The resulting query string
     */
    public static function buildQueryString($params = [])
    {
        $query = $_GET;

        foreach ($params as $key => $value) {
            $query[$key] = $value;
        }

        return '?' . http_build_query($query);
    }

    /**
     * Tạo URL đầy đủ đến route (bao gồm protocol và host)
     * 
     * @param string $path Đường dẫn
     * @return string URL đầy đủ
     */
    public static function getFullUrl($path = '')
    {
        // Xác định protocol chính xác
        $protocol = self::getProtocol();

        // Lấy server host
        $host = $_SERVER['HTTP_HOST'];

        // Lấy base path từ PUBLIC_URL, không bao gồm protocol và host
        $publicUrlParts = parse_url(PUBLIC_URL);
        $basePath = isset($publicUrlParts['path']) ? rtrim($publicUrlParts['path'], '/') : '';

        // Đảm bảo path không bắt đầu bằng dấu / để tạo URL đúng
        $path = ltrim($path, '/');

        // Xây dựng URL sử dụng protocol đã xác định
        return "$protocol://$host$basePath/$path";
    }
}

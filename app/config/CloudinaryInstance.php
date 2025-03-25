<?php
// filepath: c:\xampp\htdocs\project\app\config\CloudinaryInstance.php

namespace App\Config;

use Cloudinary\Configuration\Configuration;

class CloudinaryInstance
{
    private static $instance = null;
    private static $isSetup = false;

    /**
     * Thiết lập cấu hình Cloudinary và trả về instance
     * 
     * @return Cloudinary|null Instance của Cloudinary hoặc null nếu có lỗi
     */
    public static function setup()
    {
        // Nếu đã thiết lập và instance tồn tại, trả về luôn
        if (self::$isSetup && self::$instance !== null) {
            return self::$instance;
        }

        // Kiểm tra các biến môi trường
        if (
            empty($_ENV['CLOUDINARY_CLOUD_NAME']) ||
            empty($_ENV['CLOUDINARY_API_KEY']) ||
            empty($_ENV['CLOUDINARY_API_SECRET'])
        ) {
            error_log('Cloudinary configuration missing. Please check your .env file.');
            return null;
        }

        try {
            // Cấu hình Cloudinary
            $config = [
                'cloud' => [
                    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                    'api_key' => $_ENV['CLOUDINARY_API_KEY'],
                    'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
                ],
                'url' => [
                    'secure' => false
                ]
            ];

            // Tạo instance mới và lưu vào static property
            Configuration::instance($config);

            self::$instance = new Cloudinary();
            self::$isSetup = true;

            return self::$instance;
        } catch (\Exception $e) {
            error_log('Cloudinary setup error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy instance của Cloudinary, tạo mới nếu chưa có
     * 
     * @return Cloudinary|null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            return self::setup();
        }
        return self::$instance;
    }

    /**
     * Kiểm tra xem Cloudinary đã được cấu hình thành công chưa
     * 
     * @return bool
     */
    public static function isConfigured()
    {
        return self::$isSetup && self::$instance !== null;
    }
}

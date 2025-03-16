<?php
namespace App\Config;
use Cloudinary\Configuration\Configuration;

class CloudinaryInstance {
    public static function setup() {
       Configuration::instance([
            'cloud' => [
                'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                'api_key' => $_ENV['CLOUDINARY_API_KEY'],
                'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }
}
<?php

namespace App\Helpers;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Cloudinary;

class CloudinaryHelper
{

    /**
     * Upload hình ảnh lên Cloudinary
     * 
     * @param string $filePath Đường dẫn tới file tạm thời
     * @param array $options Các tùy chọn upload
     * @return array Kết quả từ Cloudinary
     */
    public static function uploadImage($filePath, $options = [])
    {
        $uploadApi = new UploadApi();
        return $uploadApi->upload($filePath, $options);
    }

    /**
     * Xóa hình ảnh từ Cloudinary
     * 
     * @param string $publicId Public ID của hình ảnh 
     * @return array Kết quả từ Cloudinary
     */
    public static function deleteImage($publicId)
    {
        $uploadApi = new UploadApi();
        return $uploadApi->destroy($publicId);
    }

    /**
     * Lấy thông tin hình ảnh từ Cloudinary
     * 
     * @param string $publicId Public ID của hình ảnh
     * @return array Thông tin hình ảnh
     */
    public static function getImageInfo($publicId)
    {
        $adminApi = new AdminApi();
        return $adminApi->asset($publicId);
    }

    /**
     * Tạo URL chuyển đổi hình ảnh
     * 
     * @param string $publicId Public ID của hình ảnh
     * @param array $options Các tùy chọn chuyển đổi
     * @return string URL hình ảnh đã được chuyển đổi
     */
    public static function getImageUrl($publicId, $options = [])
    {
        $cloudinary = new \Cloudinary\Cloudinary();
        return (string) $cloudinary->image($publicId)->toUrl($options);
        // return $cloudinary->image($publicId)->resize($options)->toUrl();
    }
}

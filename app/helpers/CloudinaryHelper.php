<?php

namespace App\Helpers;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use App\Config\CloudinaryInstance;
use App\Models\Image;

class CloudinaryHelper
{

    /**
     * Tải lên một file ảnh lên Cloudinary
     * 
     * @param string $filePath Đường dẫn đến file tạm thời
     * @param string $folder Thư mục trên Cloudinary (ví dụ: 'tours', 'locations')
     * @param array $options Tùy chọn upload bổ sung
     * @return array Kết quả từ Cloudinary API
     */
    public static function upload($filePath, $folder = null, $options = []) {
        $prefix = 'booking_travel';

        // Đảm bảo Cloudinary đã được cấu hình
        CloudinaryInstance::setup();
        
        // Thiết lập các tùy chọn mặc định
        $uploadOptions = [
            'resource_type' => 'image',
            'unique_filename' => true,
            'overwrite' => false
        ];
        
        // Thêm folder nếu được chỉ định
        if ($folder) {
            $uploadOptions['folder'] =  $prefix . '/' . $folder;
        }
        
        // Gộp các tùy chọn bổ sung
        $uploadOptions = array_merge($uploadOptions, $options);
        
        // Thực hiện upload
        $uploadApi = new UploadApi();
        return $uploadApi->upload($filePath, $uploadOptions);
    }
    
    /**
     * Tải lên ảnh và lưu thông tin vào cơ sở dữ liệu
     * 
     * @param string $filePath Đường dẫn đến file tạm thời
     * @param array $imageData Dữ liệu ảnh (title, description, alt_text, etc.)
     * @param string $folder Thư mục trên Cloudinary
     * @param int $userId ID của người dùng tải lên
     * @return int|false ID của bản ghi ảnh hoặc false nếu thất bại
     */
    public static function uploadAndSave($filePath, $imageData, $folder = 'general', $userId = null) {
        $imageModel = new Image();
        
        try {
            // $imageModel->beginTransaction();
            // Upload lên Cloudinary
            $result = self::upload($filePath, $folder);
            
            // Lấy thông tin từ file gốc
            $fileInfo = pathinfo($filePath);
            $fileSize = filesize($filePath);
            
            // Tạo mảng dữ liệu để lưu vào DB
            $data = [
                'title' => $imageData['title'] ?? $fileInfo['filename'],
                'description' => $imageData['description'] ?? null,
                'file_name' => $result['original_filename'],
                'file_path' => $result['secure_url'],
                'file_size' => $fileSize,
                'file_type' => $result['format'],
                'width' => $result['width'],
                'height' => $result['height'],
                'alt_text' => $imageData['alt_text'] ?? $imageData['title'] ?? $fileInfo['filename'],
                'cloudinary_id' => $result['public_id'],
                'cloudinary_url' => $result['secure_url'],
                'category' => $folder,
                'user_id' => $userId
            ];
            
            // Lưu vào cơ sở dữ liệu
            $imageModel = new Image();
            return $imageModel->create($data);
            
        } catch (\Exception $e) {
            // Xử lý lỗi và ghi log
            error_log('Cloudinary upload error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy URL của ảnh dựa vào tên file và thư mục
     * 
     * @param string $folder Thư mục trên Cloudinary
     * @param string $fileName Tên file
     * @param array $transformations Các biến đổi ảnh (resize, crop...)
     * @return string URL của ảnh
     */
    public static function getImageUrl($folder, $fileName, $transformations = []) {
        CloudinaryInstance::setup();
        
        // Xây dựng public_id từ folder và fileName
        $publicId = $folder ? $folder . '/' . pathinfo($fileName, PATHINFO_FILENAME) : pathinfo($fileName, PATHINFO_FILENAME);
        
        // Tạo URL sử dụng Cloudinary SDK
        $cloudinaryUrl = 'https://res.cloudinary.com/' . $_ENV['CLOUDINARY_CLOUD_NAME'] . '/image/upload/';
        
        // Thêm các biến đổi nếu có
        if (!empty($transformations)) {
            $transformString = '';
            foreach ($transformations as $key => $value) {
                $transformString .= $key . '_' . $value . ',';
            }
            $transformString = rtrim($transformString, ',');
            $cloudinaryUrl .= $transformString . '/';
        }
        
        // Thêm public_id
        $cloudinaryUrl .= $publicId;
        
        return $cloudinaryUrl;
    }
    
    /**
     * Lấy URL của ảnh từ Cloudinary ID
     * 
     * @param string $cloudinaryId Cloudinary public_id
     * @param array $transformations Các biến đổi ảnh
     * @return string URL của ảnh
     */
    public static function getUrlFromId($cloudinaryId, $transformations = []) {
        CloudinaryInstance::setup();
        
        // Tạo URL cơ bản
        $cloudinaryUrl = 'https://res.cloudinary.com/' . $_ENV['CLOUDINARY_CLOUD_NAME'] . '/image/upload/';
        
        // Thêm các biến đổi nếu có
        if (!empty($transformations)) {
            $transformString = '';
            foreach ($transformations as $key => $value) {
                $transformString .= $key . '_' . $value . ',';
            }
            $transformString = rtrim($transformString, ',');
            $cloudinaryUrl .= $transformString . '/';
        }
        
        // Thêm public_id
        $cloudinaryUrl .= $cloudinaryId;
        
        return $cloudinaryUrl;
    }
    
    /**
     * Xóa ảnh từ Cloudinary và cơ sở dữ liệu
     * 
     * @param string $cloudinaryId Cloudinary public_id
     * @return bool Kết quả xóa
     */
    public static function delete($cloudinaryId) {
        try {
            // Xóa ảnh từ Cloudinary
            $uploadApi = new UploadApi();
            $result = $uploadApi->destroy($cloudinaryId);
            
            if ($result['result'] === 'ok') {
                // Xóa từ cơ sở dữ liệu
                $imageModel = new Image();
                return $imageModel->deleteWhere('cloudinary_id', $cloudinaryId);
            }
            
            return false;
        } catch (\Exception $e) {
            error_log('Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy danh sách ảnh trong một thư mục
     * 
     * @param string $folder Tên thư mục
     * @param int $maxResults Số lượng kết quả tối đa
     * @return array Danh sách ảnh
     */
    public static function getFolderImages($folder, $maxResults = 100) {
        try {
            $adminApi = new AdminApi();
            $result = $adminApi->assets([
                'type' => 'upload',
                'prefix' => $folder . '/',
                'max_results' => $maxResults
            ]);
            
            return $result['resources'];
        } catch (\Exception $e) {
            error_log('Cloudinary folder search error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Tạo một đường dẫn ảnh placeholder khi ảnh không tồn tại
     * 
     * @param int $width Chiều rộng
     * @param int $height Chiều cao
     * @param string $text Văn bản hiển thị
     * @return string URL placeholder
     */
    public static function getPlaceholder($width = 300, $height = 200, $text = 'No Image') {
        // Sử dụng Cloudinary để tạo placeholder
        CloudinaryInstance::setup();
        
        $options = [
            'width' => $width,
            'height' => $height,
            'background' => 'f2f2f2',
            'color' => '999999',
            'text' => $text
        ];
        
        return self::getImageUrl('placeholders', 'blank', $options);
    }


    
}
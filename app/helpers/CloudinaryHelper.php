<?php

namespace App\Helpers;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use App\Config\CloudinaryInstance;
use App\Models\BaseModel;
use App\Models\Image;
use Cloudinary\Transformation\Resize;

class CloudinaryHelper extends BaseModel
{

    /**
     * Tải lên một file ảnh lên Cloudinary
     * 
     * @param string $filePath Đường dẫn đến file tạm thời
     * @param string $folder Thư mục trên Cloudinary (ví dụ: 'tours', 'locations')
     * @param array $options Tùy chọn upload bổ sung
     * @return array Kết quả từ Cloudinary API
     */
    public static function upload($filePath, $folder = null, $options = [])
    {
        $prefix = 'booking_travel';
        // Đảm bảo Cloudinary đã được cấu hình
        CloudinaryInstance::setup();

        // Đảm bảo Cloudinary đã được cấu hình

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
    public static function uploadAndSave($filePath, $imageData, $folder = 'general', $userId = null)
    {
        $imageModel = new Image();

        try {
            // Bắt đầu transaction nếu model hỗ trợ
            if (method_exists($imageModel, 'beginTransaction')) {
                $imageModel->db->beginTransaction();
            }

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
            $imageId = $imageModel->create($data);

            // Nếu lưu thành công và có transaction, commit
            if ($imageId && method_exists($imageModel, 'commit')) {
                $imageModel->db->commit();
            }

            return $imageId;
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            if (method_exists($imageModel, 'rollback')) {
                $imageModel->db->rollback();
            }

            // Nếu đã upload lên Cloudinary nhưng lưu DB thất bại, xóa ảnh khỏi Cloudinary
            if (isset($result) && isset($result['public_id'])) {
                try {
                    $uploadApi = new UploadApi();
                    $uploadApi->destroy($result['public_id']);
                } catch (\Exception $deleteEx) {
                    // Ghi log lỗi khi xóa ảnh
                    error_log('Failed to delete image from Cloudinary after DB error: ' . $deleteEx->getMessage());
                }
            }

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
    public static function getImageUrl($folder, $fileName, $transformations = [])
    {
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
    public static function getUrlFromId($cloudinaryId, $transformations = [])
    {
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
    public static function deleteImage($cloudinaryId)
    {
        $imageModel = new Image();

        try {
            // Bắt đầu transaction nếu model hỗ trợ
            if (method_exists($imageModel, 'beginTransaction')) {
                $imageModel->db->beginTransaction();
            }

            // Xóa từ cơ sở dữ liệu trước
            $dbResult = $imageModel->deleteWhere('cloudinary_id', $cloudinaryId);

            if ($dbResult) {
                // Sau khi xóa thành công từ DB, xóa từ Cloudinary
                $uploadApi = new UploadApi();
                $result = $uploadApi->destroy($cloudinaryId);

                if ($result['result'] === 'ok') {
                    // Commit transaction nếu cả hai bước đều thành công
                    if (method_exists($imageModel, 'commit')) {
                        $imageModel->db->commit();
                    }
                    return true;
                } else {
                    // Nếu xóa từ Cloudinary thất bại, rollback DB
                    if (method_exists($imageModel, 'rollback')) {
                        $imageModel->db->rollback();
                    }
                    error_log('Failed to delete image from Cloudinary: ' . json_encode($result));
                    return false;
                }
            } else {
                // Nếu xóa từ DB thất bại
                if (method_exists($imageModel, 'rollback')) {
                    $imageModel->db->rollback();
                }
                return false;
            }
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            if (method_exists($imageModel, 'rollback')) {
                $imageModel->db->rollback();
            }
            error_log('Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa ảnh từ cơ sở dữ liệu và Cloudinary theo ID
     * 
     * @param int $imageId ID của ảnh trong cơ sở dữ liệu
     * @return bool Kết quả xóa
     */
    public static function deleteById($imageId)
    {
        $imageModel = new Image();

        try {
            // Lấy thông tin ảnh từ DB
            $image = $imageModel->getById($imageId);

            if (!$image || !isset($image['cloudinary_id'])) {
                return false;
            }

            // Sử dụng phương thức delete đã cải tiến
            return self::delete($image['cloudinary_id']);
        } catch (\Exception $e) {
            error_log('Delete image by ID error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật thông tin ảnh
     * 
     * @param int $imageId ID của ảnh
     * @param array $data Dữ liệu cập nhật
     * @return bool Kết quả cập nhật
     */
    public static function updateImage($imageId, $data)
    {
        $imageModel = new Image();

        try {
            // Bắt đầu transaction nếu model hỗ trợ
            if (method_exists($imageModel, 'beginTransaction')) {
                $imageModel->db->beginTransaction();
            }

            // Cập nhật trong cơ sở dữ liệu
            $result = $imageModel->update($imageId, $data);

            if ($result) {
                // Commit transaction nếu thành công
                if (method_exists($imageModel, 'commit')) {
                    $imageModel->db->commit();
                }
                return true;
            } else {
                // Rollback nếu thất bại
                if (method_exists($imageModel, 'rollback')) {
                    $imageModel->db->rollback();
                }
                return false;
            }
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            if (method_exists($imageModel, 'rollback')) {
                $imageModel->db->rollback();
            }
            error_log('Update image error: ' . $e->getMessage());
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
    public static function getFolderImages($folder, $maxResults = 100)
    {
        try {
            $prefix = 'booking_travel/';
            $adminApi = new AdminApi();
            $result = $adminApi->assets([
                'type' => 'upload',
                'prefix' =>  $prefix . $folder . '/',
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
    public static function getPlaceholder($width = 300, $height = 200, $text = 'No Image')
    {
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

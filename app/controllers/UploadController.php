<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CloudinaryHelper;

class UploadController extends BaseController
{
  public function uploadImage()
  {
    try {
      // Check if file was uploaded
      if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new \Exception('No file uploaded or upload error');
      }

      $file = $_FILES['image'];

      // Validate file type
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      if (!in_array($file['type'], $allowedTypes)) {
        throw new \Exception('Invalid file type. Only JPEG, PNG, GIF and WEBP are allowed.');
      }

      // Define folder as a simple string to avoid Array conversion issues
      $folderPath = 'news'; // Use a simple string for the folder path

      // Start output buffering to capture any warnings
      ob_start();

      // Upload to Cloudinary using the helper
      $cloudinaryResult = CloudinaryHelper::upload($file['tmp_name'], [
        'folder' => $folderPath,
        'resource_type' => 'image'
      ]);

      // Discard any warnings that might have been output
      ob_end_clean();

      if (!$cloudinaryResult || !isset($cloudinaryResult['secure_url'])) {
        throw new \Exception('Failed to upload image to Cloudinary');
      }

      // Create response in the format Editor.js expects
      $response = [
        'success' => 1,
        'file' => [
          'url' => $cloudinaryResult['secure_url']
        ]
      ];

      // Set proper content type and output JSON
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
    } catch (\Exception $e) {
      // Return error response
      $response = [
        'success' => 0,
        'message' => $e->getMessage()
      ];

      header('Content-Type: application/json');
      http_response_code(400);
      echo json_encode($response);
      exit;
    }
  }

  public function fetchImage()
  {
    try {
      $url = $_POST['url'] ?? '';

      if (empty($url)) {
        throw new \Exception('URL is required');
      }

      // Validate URL
      if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new \Exception('Invalid URL format');
      }

      // Start output buffering to capture any warnings
      ob_start();

      // Upload to Cloudinary
      $cloudinaryResult = CloudinaryHelper::upload($url, [
        'folder' => 'news_remote',
        'resource_type' => 'image'
      ]);

      // Discard any warnings
      ob_end_clean();

      if (!$cloudinaryResult || !isset($cloudinaryResult['secure_url'])) {
        throw new \Exception('Failed to upload image to Cloudinary');
      }

      // Create response in the format Editor.js expects
      $response = [
        'success' => 1,
        'file' => [
          'url' => $cloudinaryResult['secure_url']
        ]
      ];

      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
    } catch (\Exception $e) {
      $response = [
        'success' => 0,
        'message' => $e->getMessage()
      ];

      header('Content-Type: application/json');
      http_response_code(400);
      echo json_encode($response);
      exit;
    }
  }
}
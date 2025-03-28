<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Chỉnh sửa hình ảnh
      </h2>
      <p class="mt-1 text-gray-600">Cập nhật thông tin hình ảnh</p>
    </div>

    <div class="flex items-center space-x-3">
      <a href="<?= UrlHelper::route('admin/images') ?>"
        class="inline-flex items-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Quay lại
      </a>
    </div>
  </div>

  <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Image Preview -->
      <div class="flex flex-col items-center">
        <div
          class="w-full h-64 border border-gray-300 rounded-lg flex items-center justify-center overflow-hidden mb-4">
          <img src="<?= htmlspecialchars($image['cloudinary_url']) ?>" alt="<?= htmlspecialchars($image['alt_text']) ?>"
            class="max-h-full max-w-full object-contain">
        </div>

        <div class="bg-gray-50 p-4 rounded-lg w-full">
          <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
              <span class="text-gray-500">File:</span>
              <span class="ml-1 font-medium text-gray-700"><?= htmlspecialchars($image['file_name']) ?></span>
            </div>
            <div>
              <span class="text-gray-500">Kích thước:</span>
              <span class="ml-1 font-medium text-gray-700"><?= formatFileSize($image['file_size']) ?></span>
            </div>
            <div>
              <span class="text-gray-500">Kích thước ảnh:</span>
              <span class="ml-1 font-medium text-gray-700"><?= $image['width'] ?>x<?= $image['height'] ?> px</span>
            </div>
            <div>
              <span class="text-gray-500">Ngày tạo:</span>
              <span class="ml-1 font-medium text-gray-700"><?= date('d/m/Y', strtotime($image['created_at'])) ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Form -->
      <div>
        <form action="<?= UrlHelper::route('admin/images/update/' . $image['id']) ?>" method="POST">
          <input type="hidden" name="id" value="<?= $image['id'] ?>">

          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span
                class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($image['title']) ?>" required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          </div>

          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea id="description" name="description" rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"><?= htmlspecialchars($image['description'] ?? '') ?></textarea>
          </div>

          <div class="mb-4">
            <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
            <input type="text" id="alt_text" name="alt_text" value="<?= htmlspecialchars($image['alt_text'] ?? '') ?>"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          </div>

          <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
            <select id="category" name="category"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option value="general" <?= ($image['category'] ?? '') === 'general' ? 'selected' : '' ?>>Chung</option>
              <option value="tours" <?= ($image['category'] ?? '') === 'tours' ? 'selected' : '' ?>>Tour</option>
              <option value="locations" <?= ($image['category'] ?? '') === 'locations' ? 'selected' : '' ?>>Địa điểm
              </option>
              <option value="banner" <?= ($image['category'] ?? '') === 'banner' ? 'selected' : '' ?>>Banner</option>
            </select>
          </div>

          <div class="flex justify-end mt-6">
            <a href="<?= UrlHelper::route('admin/images') ?>"
              class="inline-flex items-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors mr-3">
              Hủy
            </a>
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Lưu thay đổi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
// Helper function to format file size
function formatFileSize($bytes) {
  if ($bytes === 0) return '0 Bytes';
  $k = 1024;
  $sizes = ['Bytes', 'KB', 'MB', 'GB'];
  $i = floor(log($bytes) / log($k));
  return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>
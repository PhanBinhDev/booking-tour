<?php

use App\Helpers\UrlHelper;

?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Tiêu đề trang -->
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Chỉnh Sửa Danh Mục Tour</h1>
      <p class="text-gray-600">Cập nhật thông tin danh mục tour</p>
    </div>

    <!-- Form chỉnh sửa danh mục -->
    <form action="<?= UrlHelper::route('admin/tours/updateCategory/' . $category['id']) ?>" method="POST"
      enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
      <input type="hidden" name="id" value="<?= $category['id'] ?>">

      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="col-span-2">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục <span
                class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($category['name'] ?? '') ?>"
              class="w-full border-2 focus:outline-none p-2 rounded-md border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
          </div>

          <div class="col-span-2">
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <div class="flex">
              <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($category['slug'] ?? '') ?>"
                class="w-full px-2.5 border-2 focus:outline-none rounded-md border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
              <button type="button" id="generate-slug"
                class="ml-2 inline-flex items-center px-3 py-2 border border-gray-150 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Tạo slug
              </button>
            </div>
            <p class="mt-1 text-xs text-gray-500">Để trống để tự động tạo từ tên danh mục</p>
          </div>

          <div class="col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea id="description" name="description" rows="3"
              class="w-full border-2 px-2 focus:outline-none rounded-md border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
          </div>

          <!-- Upload hình ảnh -->
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh danh mục</label>

            <!-- Hiển thị hình ảnh hiện tại nếu có -->
            <?php if (!empty($category['image'])): ?>
              <div class="mb-3">
                <p class="text-sm text-gray-500 mb-2">Hình ảnh hiện tại:</p>
                <img src="<?= $category['image'] ?>" name="image" alt="<?= $category['name'] ?>"
                  class="h-32 w-auto object-cover rounded border border-gray-200">
              </div>
            <?php endif; ?>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-150 border-dashed rounded-md">
              <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                  aria-hidden="true">
                  <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label for="image"
                    class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                    <span>Tải lên hình ảnh</span>
                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                  </label>
                  <p class="pl-1">hoặc kéo thả vào đây</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 5MB</p>
              </div>
            </div>
          </div>

          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select id="status" name="status"
              class="w-full border-2 focus:outline-none p-2 rounded-md border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
              <option value="active" <?= ($category['status'] ?? '') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
              <option value="inactive" <?= ($category['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Không hoạt
                động</option>
            </select>
          </div>

          <div>
            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục cha</label>
            <select id="parent_id" name="parent_id"
              class="w-full border-2 focus:outline-none p-2 rounded-md border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
              <option value="">-- Không có --</option>
              <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                  <?php if ($cat['id'] != $category['id']): // Không hiển thị danh mục hiện tại 
                  ?>
                    <option value="<?= $cat['id'] ?>" <?= ($category['parent_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($cat['name']) ?>
                    </option>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- Form actions -->
      <div class="px-6 py-4 bg-gray-50 text-right">
        <a href="<?= UrlHelper::route('admin/tours/categories') ?>"
          class="inline-flex items-center px-4 py-2 border border-gray-150 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 mr-2">
          <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
        <button type="submit"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
          <i class="fas fa-save mr-2"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const generateSlugBtn = document.getElementById('generate-slug');

    generateSlugBtn.addEventListener('click', () => {
      const name = nameInput.value;
      if (name) {
        const slug = name
          .toLowerCase()
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '')
          .replace(/[đĐ]/g, 'd')
          .replace(/[^a-z0-9\s]/g, '')
          .replace(/\s+/g, '-');

        slugInput.value = slug;
      }
    });

    // Image preview
    const imageInput = document.getElementById('image');
    imageInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          // Remove existing preview if any
          const existingPreview = document.querySelector('.preview-image');
          if (existingPreview) {
            existingPreview.remove();
          }

          // Create new preview
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'preview-image h-32 w-auto object-cover rounded border border-gray-200 mt-2';
          img.alt = 'Preview';

          // Insert after file input container
          const uploadContainer = imageInput.closest('div').parentNode;
          uploadContainer.appendChild(img);
        }
        reader.readAsDataURL(file);
      }
    });
  });
</script>
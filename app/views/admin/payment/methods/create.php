<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Thêm phương thức thanh toán
      </h2>
      <p class="mt-1 text-gray-600">Tạo phương thức thanh toán mới cho hệ thống</p>
    </div>

    <div>
      <a href="<?= UrlHelper::route('admin/payment/methods') ?>"
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Quay lại
      </a>
    </div>
  </div>

  <!-- Alert Messages -->
  <?php if(isset($_SESSION['error'])): ?>
  <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-red-700"><?= $_SESSION['error'] ?></p>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['error']); endif; ?>

  <!-- Payment Method Form -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <form action="<?= UrlHelper::route('admin/payment/methods/create') ?>" method="POST" enctype="multipart/form-data">
      <?php $this->createCSRFToken(); ?>

      <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Thông tin cơ bản</h3>
      </div>

      <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên phương thức thanh toán <span
                class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tên hiển thị của phương thức thanh toán</p>
          </div>

          <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Mã phương thức <span
                class="text-red-500">*</span></label>
            <input type="text" id="code" name="code" required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Mã duy nhất cho phương thức thanh toán (ví dụ: bank_transfer, paypal,
              momo)</p>
          </div>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
          <textarea id="description" name="description" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
          <p class="mt-1 text-sm text-gray-500">Mô tả ngắn gọn về phương thức thanh toán</p>
        </div>

        <div>
          <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
              <img id="logo-preview" src="/assets/images/placeholder-image.png" alt="Logo preview"
                class="max-w-full max-h-full p-1 hidden">
              <svg id="logo-placeholder" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div class="flex-1">
              <input type="file" id="logo" name="logo" accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <p class="mt-1 text-sm text-gray-500">Tải lên logo của phương thức thanh toán (định dạng: JPG, PNG, SVG)
              </p>
            </div>
          </div>
        </div>

        <div>
          <label for="instructions" class="block text-sm font-medium text-gray-700 mb-1">Hướng dẫn thanh toán</label>
          <textarea id="instructions" name="instructions" rows="5"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
          <p class="mt-1 text-sm text-gray-500">Hướng dẫn chi tiết cho khách hàng về cách sử dụng phương thức thanh toán
            này</p>
        </div>

        <div class="flex items-center">
          <input type="checkbox" id="is_active" name="is_active" value="1" checked
            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
          <label for="is_active" class="ml-2 block text-sm text-gray-700">Kích hoạt phương thức thanh toán</label>
        </div>
      </div>

      <div class="p-6 border-t border-gray-200">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Cấu hình nâng cao</h3>

        <div>
          <label for="config" class="block text-sm font-medium text-gray-700 mb-1">Cấu hình JSON</label>
          <textarea id="config" name="config" rows="8"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{}</textarea>
          <p class="mt-1 text-sm text-gray-500">Cấu hình bổ sung cho phương thức thanh toán (định dạng JSON)</p>
        </div>
      </div>

      <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Tạo phương thức thanh toán
        </button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Logo preview
  const logoInput = document.getElementById('logo');
  const logoPreview = document.getElementById('logo-preview');
  const logoPlaceholder = document.getElementById('logo-placeholder');

  logoInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        logoPreview.src = e.target.result;
        logoPreview.classList.remove('hidden');
        logoPlaceholder.classList.add('hidden');
      };

      reader.readAsDataURL(this.files[0]);
    }
  });

  // JSON validation for config field
  const configField = document.getElementById('config');

  configField.addEventListener('blur', function() {
    try {
      if (this.value.trim() !== '') {
        const json = JSON.parse(this.value);
        this.value = JSON.stringify(json, null, 2);
      }
    } catch (e) {
      alert('Cấu hình JSON không hợp lệ. Vui lòng kiểm tra lại.');
      this.focus();
    }
  });

  // Auto-generate code from name
  const nameField = document.getElementById('name');
  const codeField = document.getElementById('code');

  nameField.addEventListener('blur', function() {
    if (codeField.value === '' && this.value !== '') {
      // Convert name to lowercase, replace spaces with underscores, and remove special characters
      codeField.value = this.value
        .toLowerCase()
        .replace(/\s+/g, '_')
        .replace(/[^a-z0-9_]/g, '');
    }
  });
});
</script>
<?php
use App\Helpers\UrlHelper;
?>
<div class="bg-gray-50 min-h-screen py-8">
  <div class="container mx-auto px-4 max-w-4xl">
    <!-- Header Section -->
    <div
      class="bg-white rounded-xl shadow-sm p-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
          <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
          Chỉnh sửa vai trò
        </h2>
        <p class="mt-2 text-gray-500">Cập nhật thông tin cho vai trò này</p>
      </div>
      <a href="<?= UrlHelper::route('/admin/roles') ?>"
        class="bg-white border-2 border-gray-200 hover:border-teal-500 text-gray-700 hover:text-teal-600 transition-all duration-200 font-medium py-2 px-4 rounded-lg flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
            clip-rule="evenodd" />
        </svg>
        Quay lại danh sách
      </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
      <div class="border-b border-gray-200">
        <div class="px-6 py-4">
          <div class="flex items-center">
            <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">Thông tin vai trò</h3>
              <p class="text-gray-500 text-sm">
                Cập nhật thông tin chi tiết cho vai trò này
              </p>
            </div>
          </div>
        </div>
      </div>

      <form action="a<?= UrlHelper::route('/admin/roles/update' . $role['id']) ?>" method="POST" class="p-6">
        <?php $this->createCSRFToken(); ?>

        <?php if(isset($_SESSION['errors'])): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Đã xảy ra lỗi khi lưu vai trò</h3>
              <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                  <?php foreach($_SESSION['errors'] as $error): ?>
                  <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <?php unset($_SESSION['errors']); endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-green-800"><?= $_SESSION['success'] ?></p>
            </div>
          </div>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <div class="space-y-6">
          <!-- Tên vai trò -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên vai trò <span
                class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($role['name']) ?>" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
              placeholder="Nhập tên vai trò">
            <p class="mt-1 text-sm text-gray-500">Tên vai trò nên ngắn gọn và mô tả chính xác quyền hạn</p>
          </div>

          <!-- Mã vai trò -->
          <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Mã vai trò <span
                class="text-red-500">*</span></label>
            <input type="text" name="slug" id="slug" value="<?= htmlspecialchars($role['slug'] ?? '') ?>" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
              placeholder="Nhập mã vai trò">
            <p class="mt-1 text-sm text-gray-500">Mã vai trò chỉ chứa chữ cái, số và dấu gạch ngang (VD: admin, editor,
              content-manager)</p>
          </div>

          <!-- Mô tả -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
              placeholder="Nhập mô tả chi tiết về vai trò này"><?= htmlspecialchars($role['description'] ?? '') ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Mô tả chi tiết về vai trò và các quyền hạn chính</p>
          </div>

          <!-- Trạng thái -->
          <div>
            <div class="flex items-center">
              <input type="checkbox" name="is_active" id="is_active" value="1"
                <?= ($role['is_active'] ?? 1) ? 'checked' : '' ?>
                class="h-5 w-5 text-teal-500 border-gray-300 rounded focus:ring-teal-500">
              <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                Kích hoạt vai trò này
              </label>
            </div>
            <p class="mt-1 text-sm text-gray-500 ml-8">Vai trò không kích hoạt sẽ không được áp dụng cho người dùng</p>
          </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-between gap-4">
          <div>
            <?php if(isset($role['id']) && $role['id'] > 1): ?>
            <button type="button" onclick="confirmDelete(<?= $role['id'] ?>)"
              class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Xóa vai trò
            </button>
            <?php endif; ?>
          </div>
          <div class="flex items-center space-x-3">
            <a href="<?= UrlHelper::route('/admin/roles') ?>"
              class="px-5 py-2.5 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors duration-200">
              Hủy
            </a>
            <button type="submit"
              class="px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors duration-200 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Lưu thay đổi
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Phân quyền -->
    <div class="mt-6 bg-white rounded-xl shadow-sm overflow-hidden">
      <div class="border-b border-gray-200">
        <div class="px-6 py-4">
          <div class="flex items-center">
            <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">Phân quyền</h3>
              <p class="text-gray-500 text-sm">
                Quản lý các quyền được gán cho vai trò này
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <p class="text-gray-600">
              Vai trò này hiện có <span
                class="font-semibold text-teal-600"><?= isset($role['permissions_count']) ? $role['permissions_count'] : '0' ?></span>
              quyền được gán.
            </p>
          </div>
          <a href="<?= UrlHelper::route('/admin/roles/' . $role['id'] . '/permissions') ?>"
            class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            Quản lý quyền
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function confirmDelete(id) {
  if (confirm('Bạn có chắc chắn muốn xóa vai trò này? Hành động này không thể hoàn tác.')) {
    window.location.href = '<?= ADMIN_URL ?>/roles/delete/' + id;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Tự động tạo slug từ tên
  const nameInput = document.getElementById('name');
  const slugInput = document.getElementById('slug');

  if (nameInput && slugInput) {
    nameInput.addEventListener('input', function() {
      // Chỉ tự động tạo slug nếu người dùng chưa chỉnh sửa trường slug
      if (!slugInput.dataset.userEdited) {
        const slug = this.value
          .toLowerCase()
          .replace(/[^\w\s-]/g, '') // Loại bỏ ký tự đặc biệt
          .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
          .replace(/--+/g, '-') // Loại bỏ nhiều dấu gạch ngang liên tiếp
          .trim(); // Loại bỏ khoảng trắng đầu/cuối

        slugInput.value = slug;
      }
    });

    // Đánh dấu khi người dùng đã chỉnh sửa trường slug
    slugInput.addEventListener('input', function() {
      this.dataset.userEdited = 'true';
    });
  }
});
</script>
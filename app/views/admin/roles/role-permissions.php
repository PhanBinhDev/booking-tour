<?php
use App\Helpers\UrlHelper;
?>
<div class="bg-gray-50 min-h-screen py-8">
  <div class="container mx-auto px-4 max-w-6xl">
    <!-- Header Section -->
    <div
      class="bg-white rounded-xl shadow-sm p-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
          <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
          Phân quyền cho vai trò: <span class="text-teal-600 ml-2"><?= htmlspecialchars($role['name']) ?></span>
        </h2>
        <p class="mt-2 text-gray-500"><?= htmlspecialchars($role['description'] ?? '') ?></p>
      </div>
      <a href="<?= UrlHelper::route('/admin/roles') ?>"
        class="bg-white border-2 border-gray-200 hover:border-teal-500 text-gray-700 hover:text-teal-600 transition-all duration-200 font-medium py-2 px-4 rounded-lg flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
            clip-rule="evenodd" />
        </svg>
        Quay lại
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
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">Cấu hình quyền hạn</h3>
              <p class="text-gray-500 text-sm">
                Chọn các quyền mà vai trò này có thể thực hiện. Các quyền được phân nhóm theo danh mục.
              </p>
            </div>
          </div>
        </div>
      </div>

      <form action="<?= ADMIN_URL ?>/roles/<?= $role['id'] ?>/permissions" method="POST" class="p-6">
        <?php $this->createCSRFToken(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <?php foreach ($allPermissions as $category => $permissions): ?>
          <div class="border border-gray-200 rounded-lg hover:border-teal-200 transition-colors duration-200">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center">
              <span class="w-2 h-6 bg-teal-500 rounded-full mr-3"></span>
              <h4 class="font-medium text-gray-700">
                <?= ucfirst(str_replace('_', ' ', $category)) ?>
              </h4>
              <span class="ml-auto bg-gray-200 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                <?= count($permissions) ?>
              </span>
            </div>
            <div class="divide-y divide-gray-100">
              <?php foreach ($permissions as $permission): ?>
              <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                <label class="flex items-start cursor-pointer">
                  <div class="flex items-center h-5">
                    <input id="permission-<?= $permission['id'] ?>" name="permissions[]" type="checkbox"
                      value="<?= $permission['id'] ?>"
                      <?= in_array($permission['id'], $rolePermissionIds) ? 'checked' : '' ?>
                      class="h-5 w-5 text-teal-500 border-gray-300 rounded focus:ring-teal-500">
                  </div>
                  <div class="ml-3">
                    <span class="text-gray-700 font-medium block">
                      <?= htmlspecialchars($permission['name']) ?>
                    </span>
                    <?php if (!empty($permission['description'])): ?>
                    <p class="text-gray-500 text-sm mt-1"><?= htmlspecialchars($permission['description']) ?></p>
                    <?php endif; ?>
                  </div>
                </label>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div
          class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="flex items-center space-x-6">
            <button type="button" id="selectAllBtn" class="text-teal-600 hover:text-teal-800 flex items-center group">
              <span
                class="w-8 h-8 rounded-full bg-teal-50 group-hover:bg-teal-100 flex items-center justify-center mr-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </span>
              Chọn tất cả
            </button>
            <button type="button" id="deselectAllBtn" class="text-teal-600 hover:text-teal-800 flex items-center group">
              <span
                class="w-8 h-8 rounded-full bg-teal-50 group-hover:bg-teal-100 flex items-center justify-center mr-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </span>
              Bỏ chọn tất cả
            </button>
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
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Xử lý nút chọn tất cả
  document.getElementById('selectAllBtn').addEventListener('click', function() {
    document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
      checkbox.checked = true;
    });
  });

  // Xử lý nút bỏ chọn tất cả
  document.getElementById('deselectAllBtn').addEventListener('click', function() {
    document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
      checkbox.checked = false;
    });
  });
});
</script>
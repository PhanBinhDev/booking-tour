<?php

use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-700">Quản lý người dùng</h3>
    <a href="<?= UrlHelper::route('admin/users/create') ?>">
      <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-user-plus mr-2"></i> Thêm người dùng
      </button>
    </a>
  </div>

  <!-- Search and Filter Section -->
  <div
    class="bg-white rounded-xl shadow-md mb-6 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg">
    <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
      <h3 class="text-lg font-medium text-gray-700 flex items-center">
        <i class="fas fa-filter text-teal-500 mr-2"></i> Tìm kiếm và lọc người dùng
      </h3>
    </div>

    <form method="GET" action="<?= UrlHelper::route('admin/users/index') ?>" class="px-6 py-4">
      <!-- Filter Grid - Responsive Layout -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
        <!-- Role Filter -->
        <div class="filter-group">
          <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
            <i class="fas fa-user-tag text-teal-500 mr-1.5 text-xs"></i> Vai trò
          </label>
          <div class="relative">
            <select id="role_id" name="role_id"
              class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
              <option value="">Tất cả vai trò</option>
              <?php foreach ($roles as $role) { ?>
              <option value="<?= $role['id'] ?>" <?= ($filters['role_id'] == $role['id']) ? 'selected' : '' ?>>
                <?= $role['name'] ?>
              </option>
              <?php } ?>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
              <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </div>
          </div>
        </div>

        <!-- Status Filter -->
        <div class="filter-group">
          <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
            <i class="fas fa-circle text-teal-500 mr-1.5 text-xs"></i> Trạng thái
          </label>
          <div class="relative">
            <select id="status" name="status"
              class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
              <option value="">Tất cả trạng thái</option>
              <option value="active" <?= ($filters['status'] == 'active') ? 'selected' : '' ?>>
                <span>Hoạt động</span>
              </option>
              <option value="inactive" <?= ($filters['status'] == 'inactive') ? 'selected' : '' ?>>
                <span>Không hoạt động</span>
              </option>
              <option value="banned" <?= ($filters['status'] == 'banned') ? 'selected' : '' ?>>
                <span>Bị cấm</span>
              </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
              <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </div>
          </div>
        </div>

        <!-- Sort Order -->
        <div class="filter-group">
          <label for="sort" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
            <i class="fas fa-sort text-teal-500 mr-1.5 text-xs"></i> Sắp xếp theo
          </label>
          <div class="relative">
            <select id="sort" name="sort"
              class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
              <option value="created_at" <?= ($filters['sort'] == 'created_at') ? 'selected' : '' ?>>Ngày tạo</option>
              <option value="username" <?= ($filters['sort'] == 'username') ? 'selected' : '' ?>>Tên đăng nhập</option>
              <option value="last_login" <?= ($filters['sort'] == 'last_login') ? 'selected' : '' ?>>Đăng nhập cuối
              </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
              <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </div>
          </div>
        </div>

        <!-- Search Input -->
        <div class="filter-group">
          <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
            <i class="fas fa-search text-teal-500 mr-1.5 text-xs"></i> Tìm kiếm
          </label>
          <div class="relative">
            <input type="text" id="search" name="search" placeholder="Tên, email, username..."
              value="<?= $filters['search'] ?? '' ?>"
              class="w-full rounded-lg p-2.5 pl-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
            <?php if (!empty($filters['search'])): ?>
            <button type="button" onclick="document.getElementById('search').value = ''; this.form.submit();"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Filter Actions -->
      <div class="mt-5 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="w-full sm:w-auto flex items-center">
          <div class="relative">
            <select name="limit"
              class="rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 text-gray-700 appearance-none shadow-sm">
              <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10 người dùng</option>
              <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25 người dùng</option>
              <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50 người dùng</option>
              <option value="100" <?= ($pagination['per_page'] == 100) ? 'selected' : '' ?>>100 người dùng</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
              <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </div>
          </div>

          <!-- Show active filter count -->
          <?php
          $activeFilters = 0;
          if (!empty($filters['role_id'])) $activeFilters++;
          if (!empty($filters['status'])) $activeFilters++;
          if (!empty($filters['search'])) $activeFilters++;
          if (!empty($filters['sort']) && $filters['sort'] != 'created_at') $activeFilters++;
          ?>

          <?php if ($activeFilters > 0): ?>
          <div class="ml-3 text-sm text-gray-500">
            <span class="bg-teal-100 text-teal-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
              <?= $activeFilters ?> bộ lọc đang áp dụng
            </span>
          </div>
          <?php endif; ?>
        </div>

        <div class="w-full sm:w-auto flex gap-3">
          <a href="<?= UrlHelper::route('admin/users') ?>"
            class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center justify-center border border-gray-200">
            <i class="fas fa-sync-alt mr-2 text-gray-600"></i> Đặt lại
          </a>

          <button type="submit"
            class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 shadow-sm flex items-center justify-center">
            <i class="fas fa-filter mr-2"></i> Áp dụng
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Bảng danh sách người dùng -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thông
              tin</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vai
              trò</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng
              thái</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đăng
              nhập cuối</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao
              tác</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php
          // Calculate starting index based on pagination
          $startingIndex = ($pagination['current_page'] - 1) * $pagination['per_page'] + 1;

          if (!empty($users)):
            foreach ($users as $index => $user): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $startingIndex + $index ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <?php if (!empty($user['avatar'])): ?>
                  <img class="h-10 w-10 rounded-full" src="<?= $user['avatar'] ?>" alt="Avatar">
                  <?php else: ?>
                  <div class="h-10 w-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900"><?= $user['full_name'] ?? $user['username'] ?></div>
                  <div class="text-sm text-gray-500"><?= $user['username'] ?></div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $user['email'] ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getRoleBadgeClass($user['role_name']) ?>">
                <?= $user['role_name'] ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getStatusBadgeClass($user['status']) ?>">
                <?= ucfirst($user['status']) ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Chưa đăng nhập' ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="<?= UrlHelper::route('admin/users/detail/' . $user['id']) ?>">
                <button class="view-user-btn text-teal-600 hover:text-teal-900 mr-3" data-id="<?= $user['id'] ?>">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <a href="<?= UrlHelper::route('admin/users/edit/' . $user['id']) ?>">
                <button class="edit-user-btn text-indigo-600 hover:text-indigo-900 mr-3" data-id="<?= $user['id'] ?>">
                  <i class="fas fa-edit"></i>
                </button>
              </a>
            </td>
          </tr>
          <?php endforeach;
          else: ?>
          <tr>
            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Không có người dùng nào</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Phân trang -->
  <?php if ($pagination['total_pages'] > 1): ?>
  <div class="bg-white rounded-lg shadow-sm p-4 mt-6">
    <div class="flex flex-col md:flex-row justify-between items-center">
      <div class="flex items-center gap-4">
        <!-- Results info -->
        <p class="text-sm text-gray-700 mb-4 md:mb-0">
          Hiển thị <span class="font-medium"><?= $pagination['from'] ?></span>
          đến <span class="font-medium"><?= $pagination['to'] ?></span>
          trong <span class="font-medium"><?= $pagination['total'] ?></span> kết quả
        </p>

        <!-- Per page selector -->
        <div class="flex justify-end">
          <form action="<?= UrlHelper::route('admin/users/index') ?>" method="GET" class="flex items-center space-x-2">
            <!-- Preserve existing query parameters -->
            <?php foreach ($_GET as $key => $value): ?>
            <?php if ($key !== 'limit' && $key !== 'page'): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endif; ?>
            <?php endforeach; ?>

            <label for="limit" class="text-sm text-gray-600">Hiển thị:</label>
            <select id="limit" name="limit" onchange="this.form.submit()"
              class="form-select rounded-md border-gray-300 text-sm py-1 pl-2 pr-8 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
              <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10</option>
              <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25</option>
              <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50</option>
              <option value="100" <?= ($pagination['per_page'] == 100) ? 'selected' : '' ?>>100</option>
            </select>
          </form>
        </div>
      </div>

      <!-- Pagination links -->
      <div class="flex items-center space-x-1">
        <?php
          // Previous page link
          if ($pagination['has_prev_page']):
            $prevUrl = UrlHelper::route('admin/users/index') . '?' . http_build_query(array_merge(
              array_filter($filters),
              ['page' => $pagination['current_page'] - 1, 'limit' => $pagination['per_page']]
            ));
          ?>
        <a href="<?= $prevUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
          <i class="fas fa-chevron-left text-xs"></i>
        </a>
        <?php else: ?>
        <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
          <i class="fas fa-chevron-left text-xs"></i>
        </span>
        <?php endif; ?>

        <!-- Page number links -->
        <?php
          $visiblePages = 5; // Number of page links to show
          $startPage = max(1, min($pagination['current_page'] - floor($visiblePages / 2), $pagination['total_pages'] - $visiblePages + 1));
          $startPage = max(1, $startPage);
          $endPage = min($startPage + $visiblePages - 1, $pagination['total_pages']);

          for ($i = $startPage; $i <= $endPage; $i++):
            $pageUrl = UrlHelper::route('admin/users/index') . '?' . http_build_query(array_merge(
              array_filter($filters),
              ['page' => $i, 'limit' => $pagination['per_page']]
            ));
            $isCurrentPage = $i === $pagination['current_page'];
          ?>
        <?php if ($isCurrentPage): ?>
        <span class="px-3 py-1 rounded-md text-sm bg-teal-500 text-white font-medium">
          <?= $i ?>
        </span>
        <?php else: ?>
        <a href="<?= $pageUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
          <?= $i ?>
        </a>
        <?php endif; ?>
        <?php endfor; ?>

        <!-- Next page link -->
        <?php
          if ($pagination['has_next_page']):
            $nextUrl = UrlHelper::route('admin/users/index') . '?' . http_build_query(array_merge(
              array_filter($filters),
              ['page' => $pagination['current_page'] + 1, 'limit' => $pagination['per_page']]
            ));
          ?>
        <a href="<?= $nextUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
          <i class="fas fa-chevron-right text-xs"></i>
        </a>
        <?php else: ?>
        <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
          <i class="fas fa-chevron-right text-xs"></i>
        </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Modal xác nhận xóa người dùng -->
  <div id="deleteUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa</h3>
        <button id="closeDeleteModal" class="text-gray-400 hover:text-gray-500">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-4">
        <p class="text-gray-700">Bạn có chắc chắn muốn xóa người dùng <span id="deleteUserName"
            class="font-bold"></span>?</p>
        <p class="text-gray-500 text-sm mt-2">Hành động này không thể hoàn tác.</p>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
        <button type="button" id="cancelDeleteBtn"
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
          Hủy
        </button>
        <a id="confirmDeleteBtn" href="#"
          class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
          Xóa
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Helper functions -->
<?php
function getRoleBadgeClass($roleName)
{
  $classes = [
    'admin' => 'bg-red-100 text-red-800',
    'moderator' => 'bg-yellow-100 text-yellow-800',
    'editor' => 'bg-blue-100 text-blue-800',
    'user' => 'bg-green-100 text-green-800'
  ];

  return $classes[strtolower($roleName)] ?? 'bg-gray-100 text-gray-800';
}

function getStatusBadgeClass($status)
{
  $classes = [
    'active' => 'bg-green-100 text-green-800',
    'inactive' => 'bg-gray-100 text-gray-800',
    'banned' => 'bg-red-100 text-red-800'
  ];

  return $classes[$status] ?? 'bg-gray-100 text-gray-800';
}
?>

<!-- JavaScript cho các modal và chức năng -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Modal thêm người dùng
  const addUserBtn = document.getElementById('addUserBtn');
  const addUserModal = document.getElementById('addUserModal');
  const closeAddModal = document.getElementById('closeAddModal');
  const cancelAddBtn = document.getElementById('cancelAddBtn');

  addUserBtn.addEventListener('click', function() {
    addUserModal.classList.remove('hidden');
  });

  closeAddModal.addEventListener('click', function() {
    addUserModal.classList.add('hidden');
  });

  cancelAddBtn.addEventListener('click', function() {
    addUserModal.classList.add('hidden');
  });

  // Modal xóa người dùng
  const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
  const deleteUserModal = document.getElementById('deleteUserModal');
  const closeDeleteModal = document.getElementById('closeDeleteModal');
  const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const deleteUserName = document.getElementById('deleteUserName');

  deleteUserBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const userId = this.getAttribute('data-id');
      const username = this.getAttribute('data-name');

      deleteUserName.textContent = username;
      confirmDeleteBtn.href = `<?= ADMIN_URL ?>/users/${userId}/delete`;

      deleteUserModal.classList.remove('hidden');
    });
  });

  closeDeleteModal.addEventListener('click', function() {
    deleteUserModal.classList.add('hidden');
  });

  cancelDeleteBtn.addEventListener('click', function() {
    deleteUserModal.classList.add('hidden');
  });
});
</script>
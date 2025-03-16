<?php

use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;

?>
<div class="container px-6 py-8 mx-auto">
  <!-- Tiêu đề trang -->
  <h3 class="text-3xl font-bold text-gray-700">Dashboard</h3>
  <p class="mb-8 text-gray-500">Xin chào, <?= SessionHelper::get('username') ?>! Đây là tổng quan hệ thống của
    bạn.</p>

  <!-- Thẻ thống kê -->
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Thẻ tổng số người dùng -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
      <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
        <i class="fas fa-users text-xl"></i>
      </div>
      <div>
        <p class="mb-2 text-sm font-medium text-gray-600">Tổng người dùng</p>
        <p class="text-lg font-semibold text-gray-700"><?= $userCount ?></p>
      </div>
    </div>

    <!-- Thẻ tổng số vai trò -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
      <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
        <i class="fas fa-user-shield text-xl"></i>
      </div>
      <div>
        <p class="mb-2 text-sm font-medium text-gray-600">Tổng vai trò</p>
        <p class="text-lg font-semibold text-gray-700"><?= count($roles) ?></p>
      </div>
    </div>

    <!-- Thẻ tổng số hình ảnh -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
      <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
        <i class="fas fa-images text-xl"></i>
      </div>
      <div>
        <p class="mb-2 text-sm font-medium text-gray-600">Tổng hình ảnh</p>
        <p class="text-lg font-semibold text-gray-700"><?= $imageCount ?></p>
      </div>
    </div>

    <!-- Thẻ thông tin hệ thống -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
      <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full">
        <i class="fas fa-server text-xl"></i>
      </div>
      <div>
        <p class="mb-2 text-sm font-medium text-gray-600">Phiên bản</p>
        <p class="text-lg font-semibold text-gray-700">Di Travel 1.0</p>
      </div>
    </div>
  </div>

  <!-- Phần chính của dashboard -->
  <div class="grid gap-6 mb-8 md:grid-cols-2">
    <!-- Biểu đồ phân phối vai trò -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
      <h4 class="mb-4 font-semibold text-gray-800">Phân phối vai trò</h4>
      <div class="h-64 px-4">
        <canvas id="roleDistributionChart"></canvas>
      </div>
    </div>

    <!-- Danh sách vai trò và quyền -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
      <h4 class="mb-4 font-semibold text-gray-800">Vai trò và quyền</h4>
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                <th class="px-4 py-3">Vai trò</th>
                <th class="px-4 py-3">Số quyền</th>
                <th class="px-4 py-3">Thao tác</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <?php foreach ($roles as $role): ?>
                <tr class="text-gray-700">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                        <div
                          class="flex items-center justify-center w-8 h-8 rounded-full bg-<?= getRoleColor($role['name']) ?>-100 text-<?= getRoleColor($role['name']) ?>-500">
                          <i class="fas fa-<?= getRoleIcon($role['name']) ?>"></i>
                        </div>
                      </div>
                      <div>
                        <p class="font-semibold"><?= $role['name'] ?></p>
                        <p class="text-xs text-gray-600"><?= $role['description'] ?? 'Không có mô tả' ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                      <?= $role['permission_count'] ?> quyền
                    </span>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <a href="<?= PUBLIC_URL ?>/admin/roles/<?= $role['id'] ?>/permissions"
                      class="text-indigo-600 hover:text-indigo-900">
                      <i class="fas fa-key mr-1"></i> Phân quyền
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Liên kết nhanh -->
  <div class="grid gap-6 mb-8 md:grid-cols-3">
    <!-- Quản lý người dùng -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
      <a href="<?= PUBLIC_URL ?>/admin/users" class="block">
        <div class="flex items-center">
          <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
            <i class="fas fa-user-cog text-xl"></i>
          </div>
          <div>
            <h4 class="mb-1 text-xl font-semibold text-gray-700">Quản lý người dùng</h4>
            <p class="text-sm text-gray-600">Thêm, sửa, xóa người dùng</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Quản lý tour -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
      <a href="<?= UrlHelper::route('admin/tours') ?>" class="block">
        <div class="flex items-center">
          <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <i class="fas fa-map-marked-alt text-xl"></i>
          </div>
          <div>
            <h4 class="mb-1 text-xl font-semibold text-gray-700">Quản lý tour</h4>
            <p class="text-sm text-gray-600">Thêm, sửa, xóa tour du lịch</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Quản lý đặt tour -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
      <a href="<?= UrlHelper::route('admin/bookings') ?>" class="block">
        <div class="flex items-center">
          <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
            <i class="fas fa-calendar-check text-xl"></i>
          </div>
          <div>
            <h4 class="mb-1 text-xl font-semibold text-gray-700">Quản lý đặt tour</h4>
            <p class="text-sm text-gray-600">Xem và xử lý đơn đặt tour</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Hàm helper cho màu sắc và biểu tượng vai trò -->
<?php
function getRoleColor($roleName)
{
  $colors = [
    'admin' => 'red',
    'moderator' => 'yellow',
    'editor' => 'blue',
    'user' => 'green',
  ];

  return $colors[strtolower($roleName)] ?? 'gray';
}

function getRoleIcon($roleName)
{
  $icons = [
    'admin' => 'crown',
    'moderator' => 'shield-alt',
    'editor' => 'edit',
    'user' => 'user',
  ];

  return $icons[strtolower($roleName)] ?? 'user';
}
?>

<!-- Script cho biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu cho biểu đồ phân phối vai trò
    const roleLabels = <?= json_encode(array_column($roles, 'name')) ?>;
    const permissionCounts = <?= json_encode(array_column($roles, 'permission_count')) ?>;
    const roleColors = roleLabels.map(role => {
      const colors = {
        'admin': 'rgba(239, 68, 68, 0.7)',
        'moderator': 'rgba(245, 158, 11, 0.7)',
        'editor': 'rgba(59, 130, 246, 0.7)',
        'user': 'rgba(16, 185, 129, 0.7)'
      };
      return colors[role.toLowerCase()] || 'rgba(107, 114, 128, 0.7)';
    });

    // Tạo biểu đồ phân phối vai trò
    const roleCtx = document.getElementById('roleDistributionChart').getContext('2d');
    new Chart(roleCtx, {
      type: 'bar',
      data: {
        labels: roleLabels,
        datasets: [{
          label: 'Số quyền',
          data: permissionCounts,
          backgroundColor: roleColors,
          borderColor: roleColors.map(color => color.replace('0.7', '1')),
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  });
</script>
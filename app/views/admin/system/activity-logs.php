<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Nhật ký hệ thống
      </h2>
      <p class="mt-1 text-gray-600">Theo dõi các hoạt động trong hệ thống</p>
    </div>

    <div>
      <button id="clearFiltersBtn"
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        Xóa bộ lọc
      </button>
    </div>
  </div>

  <!-- Filter Form -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200">
      <h3 class="text-lg font-medium text-gray-800">Bộ lọc</h3>
    </div>
    <div class="p-4">
      <form action="<?= UrlHelper::route('admin/system/activity-logs') ?>" method="GET"
        class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
          <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
            placeholder="Tìm kiếm mô tả...">
        </div>

        <div>
          <label for="entity_type" class="block text-sm font-medium text-gray-700 mb-1">Loại đối tượng</label>
          <select id="entity_type" name="entity_type"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <option value="">Tất cả loại</option>
            <option value="invoice" <?= ($filters['entity_type'] ?? '') === 'invoice' ? 'selected' : '' ?>>Hóa đơn
            </option>
            <option value="transaction" <?= ($filters['entity_type'] ?? '') === 'transaction' ? 'selected' : '' ?>>Giao
              dịch</option>
            <option value="payment" <?= ($filters['entity_type'] ?? '') === 'payment' ? 'selected' : '' ?>>Thanh toán
            </option>
            <option value="refund" <?= ($filters['entity_type'] ?? '') === 'refund' ? 'selected' : '' ?>>Hoàn tiền
            </option>
            <option value="booking" <?= ($filters['entity_type'] ?? '') === 'booking' ? 'selected' : '' ?>>Đặt tour
            </option>
            <option value="users" <?= ($filters['entity_type'] ?? '') === 'users' ? 'selected' : '' ?>>Người dùng
            </option>
            <option value="system" <?= ($filters['entity_type'] ?? '') === 'system' ? 'selected' : '' ?>>Hệ thống
            </option>
          </select>
        </div>

        <div>
          <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Người dùng</label>
          <select id="user_id" name="user_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <option value="">Tất cả người dùng</option>
            <?php if(!empty($users)): ?>
            <?php foreach($users as $user): ?>
            <option value="<?= $user['id'] ?>" <?= ($filters['user_id'] ?? '') == $user['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($user['full_name']) ?>
            </option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <div>
          <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
          <input type="date" id="date_from" name="date_from"
            value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div>
          <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
          <input type="date" id="date_to" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div class="flex items-end">
          <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Lọc
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Activity Logs -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if(empty($logs['data'])): ?>
    <div class="p-8 text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-800">Không tìm thấy nhật ký hoạt động nào</h3>
      <p class="mt-2 text-gray-600">Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thời gian
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Người dùng
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Loại
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mã đối tượng
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mô tả
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              IP
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($logs['data'] as $log): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <?php if(!empty($log['user_id'])): ?>
              <div class="flex items-center">
                <div
                  class="flex-shrink-0 h-8 w-8 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 font-medium">
                  <?= strtoupper(substr($log['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="ml-3">
                  <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($log['user_name'] ?? 'N/A') ?>
                  </div>
                  <div class="text-xs text-gray-500">ID: <?= $log['user_id'] ?></div>
                </div>
              </div>
              <?php else: ?>
              <div class="flex items-center">
                <div
                  class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <div class="text-sm font-medium text-gray-900">Hệ thống</div>
                </div>
              </div>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                <?php
                switch($log['entity_type']) {
                  case 'invoice':
                    echo 'bg-purple-100 text-purple-800';
                    break;
                  case 'transaction':
                    echo 'bg-blue-100 text-blue-800';
                    break;
                  case 'payment':
                    echo 'bg-green-100 text-green-800';
                    break;
                  case 'refund':
                    echo 'bg-red-100 text-red-800';
                    break;
                  case 'booking':
                    echo 'bg-yellow-100 text-yellow-800';
                    break;
                  case 'user':
                    echo 'bg-indigo-100 text-indigo-800';
                    break;
                  case 'system':
                    echo 'bg-gray-100 text-gray-800';
                    break;
                  default:
                    echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php
                switch($log['entity_type']) {
                  case 'invoice':
                    echo 'Hóa đơn';
                    break;
                  case 'transaction':
                    echo 'Giao dịch';
                    break;
                  case 'payment':
                    echo 'Thanh toán';
                    break;
                  case 'refund':
                    echo 'Hoàn tiền';
                    break;
                  case 'booking':
                    echo 'Đặt tour';
                    break;
                  case 'user':
                    echo 'Người dùng';
                    break;
                  case 'system':
                    echo 'Hệ thống';
                    break;
                  default:
                    echo ucfirst($log['entity_type']);
                }
                ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= $log['entity_id'] ?>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900"><?= htmlspecialchars($log['description']) ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= htmlspecialchars($log['ip_address'] ?? 'N/A') ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if($logs['pagination']['total_pages'] > 1): ?>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-500">
          Hiển thị <?= $logs['pagination']['from'] ?> đến <?= $logs['pagination']['to'] ?> của
          <?= $logs['pagination']['total'] ?> nhật ký
        </div>
        <div class="flex space-x-2">
          <?php if($logs['pagination']['current_page'] > 1): ?>
          <a href="<?= UrlHelper::route('admin/system/activity-logs', array_merge($_GET, ['page' => $logs['pagination']['current_page'] - 1])) ?>"
            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md bg-white hover:bg-gray-50">
            Trước
          </a>
          <?php endif; ?>

          <?php for($i = 1; $i <= $logs['pagination']['total_pages']; $i++): ?>
          <?php if(
              $i == 1 || 
              $i == $logs['pagination']['total_pages'] || 
              ($i >= $logs['pagination']['current_page'] - 1 && $i <= $logs['pagination']['current_page'] + 1)
            ): ?>
          <a href="<?= UrlHelper::route('admin/system/activity-logs', array_merge($_GET, ['page' => $i])) ?>"
            class="inline-flex items-center px-3 py-1 border <?= $i == $logs['pagination']['current_page'] ? 'border-teal-500 bg-teal-50 text-teal-600' : 'border-gray-300 bg-white hover:bg-gray-50 text-gray-700' ?> text-sm font-medium rounded-md">
            <?= $i ?>
          </a>
          <?php elseif(
              ($i == 2 && $logs['pagination']['current_page'] > 3) || 
              ($i == $logs['pagination']['total_pages'] - 1 && $logs['pagination']['current_page'] < $logs['pagination']['total_pages'] - 2)
            ): ?>
          <span class="inline-flex items-center px-3 py-1 text-gray-500">...</span>
          <?php endif; ?>
          <?php endfor; ?>

          <?php if($logs['pagination']['current_page'] < $logs['pagination']['total_pages']): ?>
          <a href="<?= UrlHelper::route('admin/system/activity-logs', array_merge($_GET, ['page' => $logs['pagination']['current_page'] + 1])) ?>"
            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md bg-white hover:bg-gray-50">
            Tiếp
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Clear filters button
  document.getElementById('clearFiltersBtn').addEventListener('click', function() {
    window.location.href = '<?= UrlHelper::route('admin/system/activity-logs') ?>';
  });
});
</script>
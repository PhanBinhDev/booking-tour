<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Danh sách hoàn tiền
      </h2>
      <p class="mt-1 text-gray-600">Quản lý các yêu cầu hoàn tiền</p>
    </div>
  </div>

  <!-- Filter Form -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200">
      <h3 class="text-lg font-medium text-gray-800">Bộ lọc</h3>
    </div>
    <div class="p-4">
      <form action="<?= UrlHelper::route('admin/payment/refunds') ?>" method="GET"
        class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
          <input type="text" id="search" name="search" value="<?= htmlspecialchars($search ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
            placeholder="Mã hoàn tiền, tên khách hàng...">
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
          <select id="status" name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
            <option value="processing" <?= ($status ?? '') === 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
            <option value="completed" <?= ($status ?? '') === 'completed' ? 'selected' : '' ?>>Đã hoàn tiền</option>
            <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
          </select>
        </div>

        <div>
          <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
          <input type="date" id="date_from" name="date_from" value="<?= htmlspecialchars($dateFrom ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div>
          <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
          <input type="date" id="date_to" name="date_to" value="<?= htmlspecialchars($dateTo ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div class="md:col-span-4 flex justify-end">
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

  <!-- Alert Messages -->
  <?php if(isset($_SESSION['success'])): ?>
  <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-green-700"><?= $_SESSION['success'] ?></p>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['success']); endif; ?>

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

  <!-- Refunds List -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if(empty($refunds['data'])): ?>
    <div class="p-8 text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-800">Không tìm thấy yêu cầu hoàn tiền nào</h3>
      <p class="mt-2 text-gray-600">Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mã hoàn tiền
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thông tin thanh toán
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Số tiền
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Trạng thái
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Lý do
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Ngày yêu cầu
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thao tác
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($refunds['data'] as $refund): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($refund['refund_code']) ?></div>
              <?php if(!empty($refund['transaction_id'])): ?>
              <div class="text-xs text-gray-500">GD: <?= htmlspecialchars($refund['transaction_code'] ?? 'N/A') ?></div>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4">
              <?php if(!empty($refund['payment_id'])): ?>
              <div class="text-sm font-medium text-gray-900">Thanh toán #<?= htmlspecialchars($refund['payment_id']) ?>
              </div>
              <?php endif; ?>
              <?php if(!empty($refund['customer_name'])): ?>
              <div class="text-xs text-gray-500"><?= htmlspecialchars($refund['customer_name']) ?></div>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900"><?= number_format($refund['amount'], 0, ',', '.') ?>
                <?= htmlspecialchars($refund['currency']) ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                <?php
                switch($refund['status']) {
                  case 'completed':
                    echo 'bg-green-100 text-green-800';
                    break;
                  case 'pending':
                    echo 'bg-yellow-100 text-yellow-800';
                    break;
                  case 'processing':
                    echo 'bg-blue-100 text-blue-800';
                    break;
                  case 'rejected':
                    echo 'bg-red-100 text-red-800';
                    break;
                  default:
                    echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php
                switch($refund['status']) {
                  case 'completed':
                    echo 'Đã hoàn tiền';
                    break;
                  case 'pending':
                    echo 'Chờ xử lý';
                    break;
                  case 'processing':
                    echo 'Đang xử lý';
                    break;
                  case 'rejected':
                    echo 'Từ chối';
                    break;
                  default:
                    echo ucfirst($refund['status']);
                }
                ?>
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900 truncate max-w-xs">
                <?= htmlspecialchars(substr($refund['reason'], 0, 50)) ?><?= strlen($refund['reason']) > 50 ? '...' : '' ?>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= date('d/m/Y', strtotime($refund['created_at'])) ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-3">
                <a href="<?= UrlHelper::route('admin/payment/refunds/' . $refund['id']) ?>"
                  class="text-teal-600 hover:text-teal-900" title="Chi tiết">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </a>

                <?php if($refund['status'] === 'pending'): ?>
                <a href="<?= UrlHelper::route('admin/payment/refunds/process/' . $refund['id']) ?>"
                  class="text-blue-600 hover:text-blue-900" title="Xử lý">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                </a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if($refunds['pagination']['total_pages'] > 1): ?>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-500">
          Hiển thị <?= $refunds['pagination']['from'] ?> đến <?= $refunds['pagination']['to'] ?> của
          <?= $refunds['pagination']['total'] ?> yêu cầu hoàn tiền
        </div>
        <div class="flex space-x-2">
          <?php if($refunds['pagination']['has_prev_page']): ?>
          <a href="<?= UrlHelper::route('admin/payment/refunds', array_merge($_GET, ['page' => $refunds['pagination']['current_page'] - 1])) ?>"
            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md bg-white hover:bg-gray-50">
            Trước
          </a>
          <?php endif; ?>

          <?php for($i = 1; $i <= $refunds['pagination']['total_pages']; $i++): ?>
          <?php if(
              $i == 1 || 
              $i == $refunds['pagination']['total_pages'] || 
              ($i >= $refunds['pagination']['current_page'] - 1 && $i <= $refunds['pagination']['current_page'] + 1)
            ): ?>
          <a href="<?= UrlHelper::route('admin/payment/refunds', array_merge($_GET, ['page' => $i])) ?>"
            class="inline-flex items-center px-3 py-1 border <?= $i == $refunds['pagination']['current_page'] ? 'border-teal-500 bg-teal-50 text-teal-600' : 'border-gray-300 bg-white hover:bg-gray-50 text-gray-700' ?> text-sm font-medium rounded-md">
            <?= $i ?>
          </a>
          <?php elseif(
              ($i == 2 && $refunds['pagination']['current_page'] > 3) || 
              ($i == $refunds['pagination']['total_pages'] - 1 && $refunds['pagination']['current_page'] < $refunds['pagination']['total_pages'] - 2)
            ): ?>
          <span class="inline-flex items-center px-3 py-1 text-gray-500">...</span>
          <?php endif; ?>
          <?php endfor; ?>

          <?php if($refunds['pagination']['has_next_page']): ?>
          <a href="<?= UrlHelper::route('admin/payment/refunds', array_merge($_GET, ['page' => $refunds['pagination']['current_page'] + 1])) ?>"
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
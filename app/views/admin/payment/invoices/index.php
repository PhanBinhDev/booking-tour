<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Danh sách hóa đơn
      </h2>
      <p class="mt-1 text-gray-600">Quản lý hóa đơn thanh toán</p>
    </div>
  </div>

  <!-- Filter Form -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200">
      <h3 class="text-lg font-medium text-gray-800">Bộ lọc</h3>
    </div>
    <div class="p-4">
      <form action="<?= UrlHelper::route('admin/payment/invoices') ?>" method="GET"
        class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
          <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
            placeholder="Mã hóa đơn, tên khách hàng...">
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
          <select id="status" name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Chờ thanh toán
            </option>
            <option value="paid" <?= ($filters['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy
            </option>
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

        <div class="md:col-span-4 gap-2 flex justify-end">
          <a href="<?= UrlHelper::route('admin/payment/invoices') ?>"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Đặt lại
          </a>
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

  <!-- Invoices List -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <?php if(empty($invoices)): ?>
    <div class="p-8 text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-800">Không tìm thấy hóa đơn nào</h3>
      <p class="mt-2 text-gray-600">Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mã hóa đơn
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Khách hàng
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tổng tiền
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Trạng thái
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Phương thức
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Ngày tạo
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thao tác
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($invoices as $invoice): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($invoice['invoice_number']) ?></div>
              <?php if(!empty($invoice['transaction_code'])): ?>
              <div class="text-xs text-gray-500">GD: <?= htmlspecialchars($invoice['transaction_code']) ?></div>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($invoice['customer_name'] ?? 'N/A') ?>
              </div>
              <?php if(!empty($invoice['customer_email'])): ?>
              <div class="text-xs text-gray-500"><?= htmlspecialchars($invoice['customer_email']) ?></div>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900"><?= number_format($invoice['total_amount'], 0, ',', '.') ?>
                đ</div>
              <div class="text-xs text-gray-500">Thuế: <?= number_format($invoice['tax_amount'], 0, ',', '.') ?> đ</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                <?php
                switch($invoice['status']) {
                  case 'paid':
                    echo 'bg-green-100 text-green-800';
                    break;
                  case 'pending':
                    echo 'bg-yellow-100 text-yellow-800';
                    break;
                  case 'cancelled':
                    echo 'bg-red-100 text-red-800';
                    break;
                  default:
                    echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php
                switch($invoice['status']) {
                  case 'paid':
                    echo 'Đã thanh toán';
                    break;
                  case 'pending':
                    echo 'Chờ thanh toán';
                    break;
                  case 'cancelled':
                    echo 'Đã hủy';
                    break;
                  default:
                    echo ucfirst($invoice['status']);
                }
                ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                <?= htmlspecialchars($invoice['payment_method_name'] ?? $invoice['payment_method'] ?? 'N/A') ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= date('d/m/Y', strtotime($invoice['created_at'])) ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-3">
                <a href="<?= UrlHelper::route('admin/payment/invoices/' . $invoice['id']) ?>"
                  class="text-teal-600 hover:text-teal-900" title="Chi tiết">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </a>

                <a href="<?= UrlHelper::route('admin/payment/invoices/print/' . $invoice['id']) ?>" target="_blank"
                  class="text-blue-600 hover:text-blue-900" title="In hóa đơn">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                  </svg>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if($pagination['total_pages'] > 1): ?>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
      <div class="flex items-center justify-between">
        <div class="text-sm text-gray-500">
          Hiển thị <?= $pagination['from'] ?> đến <?= $pagination['to'] ?> của <?= $pagination['total'] ?> hóa đơn
        </div>
        <div class="flex space-x-2">
          <?php if($pagination['has_prev_page']): ?>
          <a href="<?= UrlHelper::route('admin/payment/invoices', array_merge($_GET, ['page' => $pagination['current_page'] - 1])) ?>"
            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md bg-white hover:bg-gray-50">
            Trước
          </a>
          <?php endif; ?>

          <?php for($i = 1; $i <= $pagination['total_pages']; $i++): ?>
          <?php if(
              $i == 1 || 
              $i == $pagination['total_pages'] || 
              ($i >= $pagination['current_page'] - 1 && $i <= $pagination['current_page'] + 1)
            ): ?>
          <a href="<?= UrlHelper::route('admin/payment/invoices', array_merge($_GET, ['page' => $i])) ?>"
            class="inline-flex items-center px-3 py-1 border <?= $i == $pagination['current_page'] ? 'border-teal-500 bg-teal-50 text-teal-600' : 'border-gray-300 bg-white hover:bg-gray-50 text-gray-700' ?> text-sm font-medium rounded-md">
            <?= $i ?>
          </a>
          <?php elseif(
              ($i == 2 && $pagination['current_page'] > 3) || 
              ($i == $pagination['total_pages'] - 1 && $pagination['current_page'] < $pagination['total_pages'] - 2)
            ): ?>
          <span class="inline-flex items-center px-3 py-1 text-gray-500">...</span>
          <?php endif; ?>
          <?php endfor; ?>

          <?php if($pagination['has_next_page']): ?>
          <a href="<?= UrlHelper::route('admin/payment/invoices', array_merge($_GET, ['page' => $pagination['current_page'] + 1])) ?>"
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
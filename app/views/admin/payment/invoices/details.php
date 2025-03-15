<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Chi tiết hóa đơn
      </h2>
      <p class="mt-1 text-gray-600">Mã hóa đơn: <?= htmlspecialchars($invoice['invoice_number']) ?></p>
    </div>

    <div class="flex items-center gap-3">
      <a href="<?= UrlHelper::route('admin/payment/invoices') ?>"
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Quay lại
      </a>

      <a href="<?= UrlHelper::route('admin/payment/invoices/print/' . $invoice['id']) ?>" target="_blank"
        class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        In hóa đơn
      </a>

      <?php if($invoice['status'] === 'pending'): ?>
      <form action="<?= UrlHelper::route('admin/payment/invoices/update-status/' . $invoice['id']) ?>" method="POST"
        class="inline-block">
        <?php $this->createCSRFToken(); ?>
        <input type="hidden" name="status" value="paid">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Đánh dấu đã thanh toán
        </button>
      </form>
      <?php endif; ?>

      <?php if($invoice['status'] === 'pending'): ?>
      <form action="<?= UrlHelper::route('admin/payment/invoices/update-status/' . $invoice['id']) ?>" method="POST"
        class="inline-block">
        <?php $this->createCSRFToken(); ?>
        <input type="hidden" name="status" value="cancelled">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          Hủy hóa đơn
        </button>
      </form>
      <?php endif; ?>

      <?php if(!empty($invoice['customer_email'])): ?>
      <form action="<?= UrlHelper::route('admin/payment/invoices/send-email/' . $invoice['id']) ?>" method="POST"
        class="inline-block">
        <?php $this->createCSRFToken(); ?>
        <button type="submit"
          class="inline-flex items-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
          Gửi qua email
        </button>
      </form>
      <?php endif; ?>
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

  <!-- Invoice Details -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Invoice Information -->
    <div class="md:col-span-2">
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Thông tin hóa đơn</h3>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
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
          </div>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin khách hàng</h4>
              <p class="text-gray-800 font-medium"><?= htmlspecialchars($invoice['customer_name'] ?? 'N/A') ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($invoice['customer_email'] ?? 'N/A') ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($invoice['customer_phone'] ?? 'N/A') ?></p>
              <?php if(!empty($invoice['customer_address'])): ?>
              <p class="text-gray-600"><?= htmlspecialchars($invoice['customer_address']) ?></p>
              <?php endif; ?>
            </div>

            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin thanh toán</h4>
              <p class="text-gray-800">Phương thức: <span
                  class="font-medium"><?= htmlspecialchars($invoice['payment_method_name'] ?? $invoice['payment_method'] ?? 'N/A') ?></span>
              </p>
              <p class="text-gray-800">Ngày tạo: <span
                  class="font-medium"><?= date('d/m/Y', strtotime($invoice['created_at'])) ?></span></p>
              <?php if(!empty($invoice['paid_at'])): ?>
              <p class="text-gray-800">Ngày thanh toán: <span
                  class="font-medium"><?= date('d/m/Y', strtotime($invoice['paid_at'])) ?></span></p>
              <?php endif; ?>
              <?php if(!empty($transaction)): ?>
              <p class="text-gray-800">Mã giao dịch: <span
                  class="font-medium"><?= htmlspecialchars($transaction['transaction_code']) ?></span></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Invoice Items -->
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-4">Chi tiết hóa đơn</h4>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Mô tả
                  </th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Số lượng
                  </th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Đơn giá
                  </th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Thành tiền
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php if(!empty($invoiceItems)): ?>
                <?php foreach($invoiceItems as $item): ?>
                <tr>
                  <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($item['name']) ?></div>
                    <?php if(!empty($item['description'])): ?>
                    <div class="text-xs text-gray-500"><?= htmlspecialchars($item['description']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                    <?= $item['quantity'] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                    <?= number_format($item['price'], 0, ',', '.') ?> đ
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                    <?= number_format($item['total'], 0, ',', '.') ?> đ
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                  <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">Thanh toán</div>
                    <?php if(!empty($booking)): ?>
                    <div class="text-xs text-gray-500">Đặt tour #<?= htmlspecialchars($booking['booking_number']) ?>
                    </div>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                    1
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                    <?= number_format($invoice['amount'], 0, ',', '.') ?> đ
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                    <?= number_format($invoice['amount'], 0, ',', '.') ?> đ
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
              <tfoot class="bg-gray-50">
                <tr>
                  <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                    Tạm tính
                  </td>
                  <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                    <?= number_format($invoice['amount'], 0, ',', '.') ?> đ
                  </td>
                </tr>
                <tr>
                  <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                    Thuế (<?= round(($invoice['tax_amount'] / $invoice['amount']) * 100) ?>%)
                  </td>
                  <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                    <?= number_format($invoice['tax_amount'], 0, ',', '.') ?> đ
                  </td>
                </tr>
                <tr>
                  <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-800">
                    Tổng cộng
                  </td>
                  <td class="px-6 py-3 text-right text-sm font-bold text-gray-800">
                    <?= number_format($invoice['total_amount'], 0, ',', '.') ?> đ
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <?php if(!empty($invoice['notes'])): ?>
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Ghi chú</h4>
          <p class="text-gray-600"><?= nl2br(htmlspecialchars($invoice['notes'])) ?></p>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar -->
    <div>
      <!-- Related Booking -->
      <?php if(!empty($booking)): ?>
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Thông tin đặt tour</h3>
        </div>

        <div class="p-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Mã đặt tour:</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($booking['booking_number']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Tour:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= htmlspecialchars($booking['tour_name'] ?? 'N/A') ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Ngày khởi hành:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= !empty($booking['departure_date']) ? date('d/m/Y', strtotime($booking['departure_date'])) : 'N/A' ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Số người:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= ($booking['adults'] ?? 0) + ($booking['children'] ?? 0) ?></span>
          </div>

          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Trạng thái:</span>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
              <?php
              switch($booking['status'] ?? '') {
                case 'confirmed':
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
              <?= htmlspecialchars(ucfirst($booking['status'] ?? 'N/A')) ?>
            </span>
          </div>

          <a href="<?= UrlHelper::route('admin/bookings/' . $booking['id']) ?>"
            class="w-full inline-flex items-center justify-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
            Xem chi tiết đặt tour
          </a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Related Transaction -->
      <?php if(!empty($transaction)): ?>
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Thông tin giao dịch</h3>
        </div>

        <div class="p-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Mã giao dịch:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= htmlspecialchars($transaction['transaction_code']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Số tiền:</span>
            <span class="text-sm font-medium text-gray-800"><?= number_format($transaction['amount'], 0, ',', '.') ?>
              đ</span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Phương thức:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= htmlspecialchars($transaction['payment_method']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Trạng thái:</span>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
              <?php
              switch($transaction['status']) {
                case 'completed':
                  echo 'bg-green-100 text-green-800';
                  break;
                case 'pending':
                  echo 'bg-yellow-100 text-yellow-800';
                  break;
                case 'failed':
                  echo 'bg-red-100 text-red-800';
                  break;
                default:
                  echo 'bg-gray-100 text-gray-800';
              }
              ?>">
              <?= htmlspecialchars(ucfirst($transaction['status'])) ?>
            </span>
          </div>

          <a href="<?= UrlHelper::route('admin/payment/transactions/' . $transaction['id']) ?>"
            class="w-full inline-flex items-center justify-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
            Xem chi tiết giao dịch
          </a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Activity Log -->
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Lịch sử hoạt động</h3>
        </div>

        <div class="p-4">
          <?php if(!empty($activities)): ?>
          <div class="space-y-4">
            <?php foreach($activities as $activity): ?>
            <div class="flex">
              <div class="flex-shrink-0 mr-3">
                <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-800"><?= htmlspecialchars($activity['description']) ?></p>
                <p class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <p class="text-sm text-gray-500">Chưa có hoạt động nào được ghi lại.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
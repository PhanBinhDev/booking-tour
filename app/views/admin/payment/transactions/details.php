<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Chi tiết giao dịch
      </h2>
      <p class="mt-1 text-gray-600">Mã giao dịch: <?= htmlspecialchars($transaction['transaction_code']) ?></p>
    </div>

    <div class="flex items-center gap-3">
      <a href="<?= UrlHelper::route('admin/payment/transactions') ?>"
        class="inline-flex items-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Quay lại
      </a>
      <?php if($transaction['status'] === 'pending'): ?>
      <form action="<?= UrlHelper::route('admin/payment/transactions/update-status/' . $transaction['id']) ?>"
        method="POST" class="inline-block">
        <?php $this->createCSRFToken(); ?>
        <input type="hidden" name="status" value="completed">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Xác nhận thanh toán
        </button>
      </form>

      <form action="<?= UrlHelper::route('admin/payment/transactions/update-status/' . $transaction['id']) ?>"
        method="POST" class="inline-block">
        <?php $this->createCSRFToken(); ?>
        <input type="hidden" name="status" value="failed">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          Đánh dấu thất bại
        </button>
      </form>
      <?php endif; ?>

      <?php if($transaction['status'] === 'completed' && empty($refunds)): ?>
      <a href="<?= UrlHelper::route('admin/payment/refunds/create?transaction_id=' . $transaction['id']) ?>"
        class="inline-flex items-center px-4 py-2 border bg-teal-500 text-white hover:bg-teal-600 font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
        </svg>
        Tạo yêu cầu hoàn tiền
      </a>
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

  <!-- Transaction Details -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Transaction Information -->
    <div class="md:col-span-2">
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Thông tin giao dịch</h3>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
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
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin khách hàng</h4>
              <p class="text-gray-800 font-medium"><?= htmlspecialchars($transaction['customer_name']) ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($transaction['customer_email']) ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($transaction['customer_phone'] ?? 'Không có') ?></p>
            </div>

            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin thanh toán</h4>
              <p class="text-gray-800">Số tiền: <span
                  class="font-medium"><?= number_format($transaction['amount'], 0, ',', '.') ?> đ</span></p>
              <p class="text-gray-800">Phương thức: <span
                  class="font-medium"><?= htmlspecialchars($transaction['payment_method']) ?></span></p>
              <p class="text-gray-800">Ngày giao dịch: <span
                  class="font-medium"><?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?></span></p>
              <?php if(!empty($transaction['updated_at']) && $transaction['status'] !== 'pending'): ?>
              <p class="text-gray-800">Ngày cập nhật: <span
                  class="font-medium"><?= date('d/m/Y H:i', strtotime($transaction['updated_at'])) ?></span></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php if(!empty($transaction['payment_data'])): ?>
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Dữ liệu thanh toán</h4>
          <pre
            class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 overflow-x-auto"><?= htmlspecialchars(json_encode(json_decode($transaction['payment_data']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        </div>
        <?php endif; ?>

        <?php if(!empty($transaction['notes'])): ?>
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Ghi chú</h4>
          <p class="text-gray-600"><?= nl2br(htmlspecialchars($transaction['notes'])) ?></p>
        </div>
        <?php endif; ?>
      </div>

      <!-- Refunds -->
      <?php if(!empty($refunds)): ?>
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-6">
        <div class="p-6 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Yêu cầu hoàn tiền</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Số tiền
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Lý do
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Trạng thái
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
              <?php foreach($refunds as $refund): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    #<?= $refund['id'] ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    <?= number_format($refund['amount'], 0, ',', '.') ?> đ
                  </div>
                  <div class="text-xs text-gray-500">
                    <?= round(($refund['amount'] / $transaction['amount']) * 100) ?>% của giao dịch
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 max-w-xs truncate">
                    <?= htmlspecialchars($refund['reason']) ?>
                  </div>
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
                      case 'rejected':
                        echo 'bg-red-100 text-red-800';
                        break;
                      default:
                        echo 'bg-gray-100 text-gray-800';
                    }
                    ?>">
                    <?= htmlspecialchars(ucfirst($refund['status'])) ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= date('d/m/Y H:i', strtotime($refund['created_at'])) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="<?= UrlHelper::route('admin/payment/refunds/' . $refund['id']) ?>"
                    class="text-teal-600 hover:text-teal-900">
                    Chi tiết
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>
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
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($booking['tour_name']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Ngày khởi hành:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= date('d/m/Y', strtotime($booking['departure_date'])) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Số người:</span>
            <span class="text-sm font-medium text-gray-800"><?= $booking['number_of_people'] ?></span>
          </div>

          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Trạng thái:</span>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
              <?php
              switch($booking['status']) {
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
              <?= htmlspecialchars(ucfirst($booking['status'])) ?>
            </span>
          </div>

          <a href="<?= UrlHelper::route('admin/bookings/' . $booking['id']) ?>"
            class="w-full inline-flex items-center justify-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
            Xem chi tiết đặt tour
          </a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Related Invoice -->
      <?php if(!empty($invoice)): ?>
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Hóa đơn</h3>
        </div>

        <div class="p-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Mã hóa đơn:</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($invoice['invoice_number']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Tổng tiền:</span>
            <span class="text-sm font-medium text-gray-800"><?= number_format($invoice['total_amount'], 0, ',', '.') ?>
              đ</span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Trạng thái:</span>
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
          </div>

          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Ngày tạo:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= date('d/m/Y', strtotime($invoice['created_at'])) ?></span>
          </div>

          <div class="flex flex-col space-y-2">
            <a href="<?= UrlHelper::route('admin/payment/invoices/' . $invoice['id']) ?>"
              class="w-full inline-flex items-center justify-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
              Xem chi tiết hóa đơn
            </a>

            <a href="<?= UrlHelper::route('admin/payment/invoices/print/' . $invoice['id']) ?>" target="_blank"
              class="w-full inline-flex items-center justify-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              In hóa đơn
            </a>
          </div>
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
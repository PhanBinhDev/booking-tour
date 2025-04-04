<?php

use App\Helpers\UrlHelper;

?>
<div class="container px-4 py-12 mx-auto max-w-7xl">
  <!-- Breadcrumbs -->
  <div class="flex items-center text-sm text-gray-500 mb-6">
    <a href="<?= UrlHelper::route('user/bookings') ?>" class="hover:text-blue-600">Đơn đặt tour</a>
    <span class="mx-2">/</span>
    <span class="font-medium text-gray-900">Chi tiết đơn đặt tour #<?= $booking['booking_number'] ?></span>
  </div>

  <!-- Status and Actions Bar -->
  <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col md:flex-row justify-between items-center">
    <div>
      <span class="text-lg font-semibold">Đơn đặt tour #<?= $booking['booking_number'] ?></span>
      <p class="text-gray-500 text-sm mt-1">Đặt ngày: <?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></p>
    </div>
    <div class="flex items-center space-x-3 mt-4 md:mt-0">
      <?php if ($booking['status'] === 'pending' || $booking['status'] === 'confirmed'): ?>
        <?php if (strtotime($tourDate['start_date']) > time()): ?>
          <a href="<?= UrlHelper::route('user/bookings/cancel/' . $booking['id']) ?>"
            class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded text-sm">
            Hủy đặt tour
          </a>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ($booking['status'] === 'pending' && $booking['payment_status'] === 'pending'): ?>
        <a href="<?= UrlHelper::route('payments/checkout/' . $booking['id']) ?>"
          class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded text-sm">
          Thanh toán ngay
        </a>
      <?php endif; ?>

      <a href="<?= UrlHelper::route('user/bookings') ?>"
        class="border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded text-sm">
        Quay lại
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Tour Details -->
    <div class="lg:col-span-2">
      <!-- Tour Info -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Thông tin tour</h2>

        <div class="flex flex-col md:flex-row">
          <!-- Tour Image -->
          <div class="md:w-1/3 mb-4 md:mb-0 md:pr-4">
            <img src="<?= $tour['featured_image'] ?? UrlHelper::asset('images/no-image.jpg') ?>"
              alt="<?= $tour['title'] ?>" class="w-full h-48 object-cover rounded">
          </div>

          <!-- Tour Details -->
          <div class="md:w-2/3">
            <h3 class="font-semibold text-lg"><?= $tour['title'] ?></h3>
            <p class="text-gray-500 mt-1">Mã tour: <?= $tour['tour_code'] ?? 'N/A' ?></p>

            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <p class="text-gray-500 text-sm">Ngày khởi hành:</p>
                <p class="font-medium"><?= date('d/m/Y', strtotime($tourDate['start_date'])) ?></p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Ngày kết thúc:</p>
                <p class="font-medium"><?= date('d/m/Y', strtotime($tourDate['end_date'])) ?></p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Số ngày:</p>
                <p class="font-medium"><?= $tour['duration'] ?? 'N/A' ?></p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Điểm đến:</p>
                <p class="font-medium"><?= $tour['location_name'] ?? 'N/A' ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Passenger Info -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Thông tin hành khách</h2>

        <?php if (!empty($passengers)): ?>
          <!-- Adults -->
          <?php
          $adults = array_filter($passengers, function ($p) {
            return $p['type'] === 'adult';
          });
          if (!empty($adults)):
          ?>
            <h3 class="font-medium mb-3">Người lớn (<?= count($adults) ?>)</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 mb-6">
                <thead>
                  <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày sinh
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hộ chiếu/CMND
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quốc tịch
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <?php foreach ($adults as $adult): ?>
                    <tr>
                      <td class="px-4 py-3 text-sm"><?= $adult['full_name'] ?></td>
                      <td class="px-4 py-3 text-sm">
                        <?= $adult['date_of_birth'] ? date('d/m/Y', strtotime($adult['date_of_birth'])) : 'N/A' ?>
                      </td>
                      <td class="px-4 py-3 text-sm"><?= $adult['passport_number'] ?? 'N/A' ?></td>
                      <td class="px-4 py-3 text-sm"><?= $adult['nationality'] ?? 'N/A' ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>

          <!-- Children -->
          <?php
          $children = array_filter($passengers, function ($p) {
            return $p['type'] === 'child';
          });
          if (!empty($children)):
          ?>
            <h3 class="font-medium mb-3">Trẻ em (<?= count($children) ?>)</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày sinh
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hộ chiếu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quốc tịch
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <?php foreach ($children as $child): ?>
                    <tr>
                      <td class="px-4 py-3 text-sm"><?= $child['full_name'] ?></td>
                      <td class="px-4 py-3 text-sm">
                        <?= $child['date_of_birth'] ? date('d/m/Y', strtotime($child['date_of_birth'])) : 'N/A' ?>
                      </td>
                      <td class="px-4 py-3 text-sm"><?= $child['passport_number'] ?? 'N/A' ?></td>
                      <td class="px-4 py-3 text-sm"><?= $child['nationality'] ?? 'N/A' ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <p class="text-gray-500">Không có thông tin hành khách</p>
        <?php endif; ?>
      </div>

      <!-- Special Requirements -->
      <?php if (!empty($booking['special_requirements'])): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <h2 class="text-xl font-semibold mb-4">Yêu cầu đặc biệt</h2>
          <p class="text-gray-700"><?= nl2br(htmlspecialchars($booking['special_requirements'])) ?></p>
        </div>
      <?php endif; ?>

      <!-- Payment History -->
      <?php if (!empty($paymentLogs)): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 lg:mb-0">
          <h2 class="text-xl font-semibold mb-4">Lịch sử thanh toán</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr class="bg-gray-50">
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sự kiện</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái
                  </th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($paymentLogs as $log): ?>
                  <tr>
                    <td class="px-4 py-3 text-sm"><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></td>
                    <td class="px-4 py-3 text-sm">
                      <?php
                      $eventLabels = [
                        'paid' => 'Thanh toán',
                        'checkout_session_created' => 'Tạo phiên thanh toán',
                        'payment_cancelled' => 'Hủy thanh toán',
                        'payment_error' => 'Lỗi thanh toán',
                        'payment_completed' => 'Hoàn tất thanh toán'
                      ];
                      echo $eventLabels[$log['event']] ?? $log['event'];
                      ?>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <?php
                      $statusClass = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'done' => 'bg-green-100 text-green-800',
                        'error' => 'bg-red-100 text-red-800',
                        'cancelled' => 'bg-gray-100 text-gray-800'
                      ];
                      $statusLabel = [
                        'pending' => 'Đang xử lý',
                        'done' => 'Hoàn tất',
                        'error' => 'Lỗi',
                        'cancelled' => 'Đã hủy'
                      ];
                      $class = $statusClass[$log['status']] ?? 'bg-gray-100 text-gray-800';
                      $label = $statusLabel[$log['status']] ?? $log['status'];
                      ?>
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $class ?>">
                        <?= $label ?>
                      </span>
                    </td>
                    <td class="px-4 py-3 text-sm"><?= $log['message'] ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Right Column: Booking and Payment Info -->
    <div class="lg:col-span-1">
      <!-- Booking Status -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Trạng thái đặt tour</h2>

        <div class="flex items-center justify-between mb-4">
          <span class="text-gray-600">Trạng thái:</span>
          <?php
          $statusClass = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800'
          ];
          $statusLabel = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'cancelled' => 'Đã hủy',
            'completed' => 'Hoàn tất'
          ];
          $class = $statusClass[$booking['status']] ?? 'bg-gray-100 text-gray-800';
          $label = $statusLabel[$booking['status']] ?? $booking['status'];
          ?>
          <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full <?= $class ?>">
            <?= $label ?>
          </span>
        </div>

        <!-- Thêm vào phần Booking Status nếu đơn đã bị hủy -->
        <?php if ($booking['status'] === 'cancelled'): ?>
          <div class="mt-4 pt-4 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Thông tin hủy tour</h3>

            <?php
            $cancellationData = json_decode($booking['cancellation_data'], true);
            $reasonLabels = [
              'change_plan' => 'Thay đổi kế hoạch cá nhân',
              'change_tour' => 'Muốn đổi sang tour khác',
              'schedule_conflict' => 'Bận công việc đột xuất',
              'health_issues' => 'Vấn đề sức khỏe',
              'financial_issues' => 'Vấn đề tài chính',
              'other' => 'Lý do khác'
            ];
            ?>

            <div class="flex justify-between items-center mb-2">
              <span class="text-gray-600">Lý do hủy:</span>
              <span
                class="font-medium"><?= $reasonLabels[$cancellationData['reason']] ?? $cancellationData['reason'] ?></span>
            </div>

            <?php if (!empty($cancellationData['notes'])): ?>
              <div class="flex justify-between items-start mb-2">
                <span class="text-gray-600">Ghi chú:</span>
                <span class="font-medium text-right"><?= nl2br(htmlspecialchars($cancellationData['notes'])) ?></span>
              </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-2">
              <span class="text-gray-600">Ngày hủy:</span>
              <span class="font-medium"><?= date('d/m/Y H:i', strtotime($cancellationData['cancelled_at'])) ?></span>
            </div>
          </div>
        <?php endif; ?>

        <div class="flex items-center justify-between">
          <span class="text-gray-600">Thanh toán:</span>
          <?php
          $paymentStatusClass = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800'
          ];
          $paymentStatusLabel = [
            'pending' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'refunded' => 'Hoàn tiền',
            'failed' => 'Thanh toán thất bại'
          ];
          $payClass = $paymentStatusClass[$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';
          $payLabel = $paymentStatusLabel[$booking['payment_status']] ?? $booking['payment_status'];
          ?>
          <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full <?= $payClass ?>">
            <?= $payLabel ?>
          </span>
        </div>
      </div>

      <!-- Payment Info -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Thông tin thanh toán</h2>

        <div class="border-b pb-4 mb-4">
          <div class="flex justify-between items-center mb-3">
            <span class="text-gray-600">Phương thức:</span>
            <span class="font-medium">
              <?php
              $paymentMethodLabels = [
                'stripe' => 'Thẻ tín dụng (Stripe)',
                'bank_transfer' => 'Chuyển khoản ngân hàng',
                'cash' => 'Tiền mặt',
                'vnpay' => 'VNPay',
                'momo' => 'Momo',
                'paypal' => 'PayPal'
              ];
              echo $paymentMethodLabels[$booking['payment_method']] ?? $booking['payment_method'];
              ?>
            </span>
          </div>

          <?php if ($payment): ?>
            <div class="flex justify-between items-center mb-3">
              <span class="text-gray-600">Mã giao dịch:</span>
              <span class="font-medium truncate"><?= $payment['transaction_id'] ?? 'N/A' ?></span>
            </div>

            <div class="flex justify-between items-center mb-3">
              <span class="text-gray-600">Ngày thanh toán:</span>
              <span class="font-medium">
                <?= $payment['payment_date'] ? date('d/m/Y H:i', strtotime($payment['payment_date'])) : 'N/A' ?>
              </span>
            </div>
          <?php endif; ?>
        </div>

        <!-- Price breakdown -->
        <div>
          <div class="flex justify-between items-center mb-3">
            <span class="text-gray-600">Người lớn:</span>
            <span class="font-medium"><?= $booking['adults'] ?> x
              <?= number_format($tourDate['price'] ?? $tour['price']) ?> VNĐ</span>
          </div>

          <?php if ($booking['children'] > 0): ?>
            <div class="flex justify-between items-center mb-3">
              <span class="text-gray-600">Trẻ em:</span>
              <span class="font-medium"><?= $booking['children'] ?> x
                <?= number_format(($tourDate['price'] ?? $tour['price']) * 0.7) ?> VNĐ</span>
            </div>
          <?php endif; ?>

          <div class="flex justify-between items-center mb-3 pt-3 border-t border-gray-200">
            <span class="text-gray-800 font-medium">Tổng cộng:</span>
            <span class="text-lg font-bold text-blue-600"><?= number_format($booking['total_price']) ?> VNĐ</span>
          </div>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Thông tin liên hệ</h2>

        <div class="mb-3">
          <p class="text-gray-600 text-sm">Người liên hệ:</p>
          <p class="font-medium"><?= $payment['payer_name'] ?? $currentUser['full_name'] ?></p>
        </div>

        <div class="mb-3">
          <p class="text-gray-600 text-sm">Email:</p>
          <p class="font-medium"><?= $payment['payer_email'] ?? $currentUser['email'] ?></p>
        </div>

        <div>
          <p class="text-gray-600 text-sm">Điện thoại:</p>
          <p class="font-medium"><?= $payment['payer_phone'] ?? $currentUser['phone'] ?? 'N/A' ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
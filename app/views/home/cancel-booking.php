<?php

use App\Helpers\UrlHelper;
?>
<div class="container px-4 py-12 mx-auto max-w-7xl">
  <!-- Breadcrumbs -->
  <div class="flex items-center text-sm text-gray-500 mb-6">
    <a href="<?= UrlHelper::route('user/bookings') ?>" class="hover:text-blue-600">Đơn đặt tour</a>
    <span class="mx-2">/</span>
    <a href="<?= UrlHelper::route('user/bookings/detail/' . $booking['id']) ?>" class="hover:text-blue-600">Chi tiết đặt
      tour</a>
    <span class="mx-2">/</span>
    <span class="font-medium text-gray-900">Hủy đặt tour</span>
  </div>

  <div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Xác nhận hủy đặt tour</h1>

    <div class="mb-8">
      <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-amber-800">Chính sách hoàn tiền</h3>
            <div class="mt-2 text-sm text-amber-700">
              <ul class="list-disc pl-5 space-y-1">
                <li>Hủy trước 30 ngày: hoàn 90% tiền tour</li>
                <li>Hủy trước 15-29 ngày: hoàn 70% tiền tour</li>
                <li>Hủy trước 7-14 ngày: hoàn 50% tiền tour</li>
                <li>Hủy trước 3-6 ngày: hoàn 30% tiền tour</li>
                <li>Hủy trước 1-2 ngày: hoàn 10% tiền tour</li>
                <li>Hủy trong ngày khởi hành: không hoàn tiền</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
      <!-- Tour info -->
      <div class="md:w-1/3">
        <h2 class="text-lg font-medium mb-4 border-b pb-2">Thông tin tour</h2>
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="font-medium"><?= htmlspecialchars($tour['title']) ?></h3>
          <p class="text-gray-600 text-sm mt-1">Mã đặt tour: <?= $booking['booking_number'] ?></p>

          <div class="mt-3 border-t border-gray-200 pt-3">
            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600 text-sm">Ngày khởi hành:</span>
              <span class="font-medium"><?= date('d/m/Y', strtotime($tourDate['start_date'])) ?></span>
            </div>

            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600 text-sm">Ngày kết thúc:</span>
              <span class="font-medium"><?= date('d/m/Y', strtotime($tourDate['end_date'])) ?></span>
            </div>

            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600 text-sm">Số người:</span>
              <span class="font-medium"><?= $booking['adults'] ?> người
                lớn<?= $booking['children'] ? ', ' . $booking['children'] . ' trẻ em' : '' ?></span>
            </div>

            <div class="flex justify-between items-center mb-1 pt-2 border-t border-gray-200">
              <span class="text-gray-600 text-sm">Tổng tiền:</span>
              <span class="font-medium"><?= number_format($booking['total_price']) ?> VNĐ</span>
            </div>

            <?php
            $daysUntilTour = floor((strtotime($tourDate['start_date']) - time()) / (60 * 60 * 24));
            $refundPercent = $daysUntilTour >= 30 ? 90 : ($daysUntilTour >= 15 ? 70 : ($daysUntilTour >= 7 ? 50 : ($daysUntilTour >= 3 ? 30 : ($daysUntilTour >= 1 ? 10 : 0))));
            $refundAmount = $booking['total_price'] * ($refundPercent / 100);
            ?>

            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600 text-sm">Hoàn tiền:</span>
              <span class="font-medium"><?= $refundPercent ?>% (<?= number_format($refundAmount) ?> VNĐ)</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Cancellation form -->
      <div class="md:w-2/3">
        <h2 class="text-lg font-medium mb-4 border-b pb-2">Thông tin hủy tour</h2>

        <form method="POST" action="<?= UrlHelper::route('user/bookings/cancel/' . $booking['id']) ?>">
          <div class="mb-4">
            <label for="cancel_reason" class="block text-sm font-medium text-gray-700 mb-1">Lý do hủy tour <span
                class="text-red-600">*</span></label>
            <select id="cancel_reason" name="cancel_reason" class="w-full border-gray-300 rounded-md shadow-sm p-2"
              required>
              <option value="">-- Chọn lý do --</option>
              <option value="change_plan">Thay đổi kế hoạch cá nhân</option>
              <option value="change_tour">Muốn đổi sang tour khác</option>
              <option value="schedule_conflict">Bận công việc đột xuất</option>
              <option value="health_issues">Vấn đề sức khỏe</option>
              <option value="financial_issues">Vấn đề tài chính</option>
              <option value="other">Lý do khác</option>
            </select>
          </div>

          <div class="mb-6">
            <label for="cancel_notes" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú bổ sung</label>
            <textarea id="cancel_notes" name="cancel_notes" rows="4"
              class="w-full border-gray-300 rounded-md shadow-sm p-2"
              placeholder="Nếu có thông tin bổ sung về lý do hủy tour, vui lòng điền tại đây"></textarea>
          </div>

          <div class="mb-6">
            <div class="flex items-center">
              <input id="cancellation_agreement" name="cancellation_agreement" type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
              <label for="cancellation_agreement" class="ml-2 block text-sm text-gray-900">
                Tôi đã đọc và đồng ý với <span class="font-medium">chính sách hủy tour</span> và hiểu rằng việc hoàn
                tiền sẽ tùy thuộc vào thời gian hủy.
              </label>
            </div>
          </div>

          <div class="flex justify-end space-x-3">
            <a href="<?= UrlHelper::route('user/bookings/detail/' . $booking['id']) ?>"
              class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-800">Quay lại</a>
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-white">Xác nhận hủy
              tour</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
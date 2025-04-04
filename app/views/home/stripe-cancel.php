<?php

use App\Helpers\UrlHelper;
?>
<div class="bg-gray-50 py-16">
  <div class="container max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <!-- Header section -->
      <div class="px-8 pt-8 pb-6 bg-gradient-to-r from-amber-500 to-amber-600">
        <div class="flex items-center justify-center">
          <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
        </div>
        <h1 class="text-white text-center text-3xl font-bold mt-4">Thanh toán bị hủy</h1>
        <p class="text-amber-100 text-center mt-2">Quá trình thanh toán của bạn đã bị hủy.</p>
      </div>

      <!-- Order details -->
      <div class="px-8 py-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">Thông tin đặt tour</h2>
          <div class="flex justify-between items-center">
            <p class="text-gray-600">Mã đặt tour:</p>
            <p class="font-medium text-gray-800"><?= $booking['booking_number'] ?></p>
          </div>
          <div class="flex justify-between items-center mt-2">
            <p class="text-gray-600">Ngày đặt:</p>
            <p class="font-medium text-gray-800"><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-4 mb-4">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">Chi tiết tour</h2>
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <h3 class="font-medium text-gray-800"><?= $tour['title'] ?></h3>
              <p class="text-gray-600 text-sm mt-1">Ngày đi: <?= date('d/m/Y', strtotime($tourDate['start_date'])) ?>
              </p>
              <p class="text-gray-600 text-sm">Ngày về: <?= date('d/m/Y', strtotime($tourDate['end_date'])) ?></p>
            </div>
            <div class="text-right">
              <p class="font-medium text-gray-800">
                <?= number_format($booking['total_price']) ?> VNĐ
              </p>
              <p class="text-gray-600 text-sm mt-1">
                <?= $booking['adults'] ?> người lớn, <?= $booking['children'] ?> trẻ em
              </p>
            </div>
          </div>
        </div>

        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">Thanh toán</h2>
          <div class="flex justify-between items-center">
            <p class="text-gray-600">Trạng thái:</p>
            <p class="bg-amber-100 text-amber-800 py-1 px-3 rounded-full text-sm font-medium">Chưa thanh toán</p>
          </div>
          <div class="flex justify-between items-center mt-2">
            <p class="text-gray-600">Tổng tiền:</p>
            <p class="font-medium text-gray-800"><?= number_format($booking['total_price']) ?> VNĐ</p>
          </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <p class="ml-3 text-gray-700">
              Đơn đặt tour của bạn vẫn được giữ lại. Bạn có thể thanh toán lại hoặc chọn phương thức thanh toán khác để
              hoàn tất đặt tour.
            </p>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-4">
          <a href="<?= UrlHelper::route('user/bookings/detail/' . $booking['id']) ?>"
            class="text-center block bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
            Xem chi tiết đặt tour
          </a>
          <a href="<?= UrlHelper::route('user/bookings') ?>"
            class="text-center block border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors">
            Xem tất cả đơn đặt tour
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
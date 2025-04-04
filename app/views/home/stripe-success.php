<?php

use App\Helpers\UrlHelper;
?>
<div class="bg-gray-50 py-16">
  <div class="container max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <!-- Header section -->
      <div class="px-8 pt-8 pb-6 bg-gradient-to-r from-teal-500 to-teal-600">
        <div class="flex items-center justify-center">
          <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-teal-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
        <h1 class="text-white text-center text-3xl font-bold mt-4">Thanh toán thành công!</h1>
        <p class="text-teal-100 text-center mt-2">Cảm ơn bạn đã đặt tour với chúng tôi.</p>
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
            <p class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Đã thanh toán</p>
          </div>
          <div class="flex justify-between items-center mt-2">
            <p class="text-gray-600">Phương thức:</p>
            <p class="font-medium text-gray-800">Stripe</p>
          </div>
          <div class="flex justify-between items-center mt-2">
            <p class="text-gray-600">Tổng tiền:</p>
            <p class="font-medium text-gray-800"><?= number_format($payment['amount']) ?> VNĐ</p>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-4">
          <a href="<?= UrlHelper::route('user/bookings/detail/' . $booking['id']) ?>"
            class="text-center block bg-teal-600 hover:bg-teal-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
            Xem chi tiết đặt tour
          </a>
          <a href="<?= UrlHelper::route('home') ?>"
            class="text-center block border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors">
            Quay lại trang chủ
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
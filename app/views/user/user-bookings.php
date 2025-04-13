<?php

use App\Helpers\UrlHelper;

$title = 'Danh sách đặt tour';
?>

<main class="min-h-screen bg-gray-50 py-8 px-4">
  <div class="max-w-5xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Đơn đặt tour của bạn</h1>
      <p class="text-gray-600 text-sm">Danh sách các tour du lịch bạn đã đặt</p>
    </div>

    <?php if (!empty($bookings)) { ?>
    <!-- Card-based layout thay vì bảng với nhiều cột -->
    <div class="grid gap-4">
      <?php foreach ($bookings as $booking) { ?>
      <div class="bg-white rounded-lg shadow-sm p-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <!-- Thông tin tour -->
        <div class="mb-4 md:mb-0">
          <div class="flex items-center mb-1">
            <span class="text-sm font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded mr-2">
              #<?= $booking['id'] ?>
            </span>
            <?php
                $paymentStatus = [
                  'paid' => 'bg-green-100 text-green-700',
                  'failed' => 'bg-red-100 text-red-700',
                  'pending' => 'bg-yellow-100 text-yellow-700'
                ][$booking['payment_status']] ?? 'bg-gray-100 text-gray-700';

                $paymentLabel = [
                  'paid' => 'Đã thanh toán',
                  'failed' => 'Thanh toán thất bại',
                  'pending' => 'Chờ thanh toán'
                ][$booking['payment_status']] ?? $booking['payment_status'];
                ?>
            <span class="px-2 py-0.5 text-xs font-medium rounded <?= $paymentStatus ?>">
              <?= $paymentLabel ?>
            </span>
          </div>

          <h3 class="font-medium text-gray-900">
            <a href="<?= UrlHelper::route('home/tour-details/' . $booking["tour_id"]) ?>" class="hover:text-teal-600">
              <?= $booking['title'] ?>
            </a>
          </h3>

          <div class="text-sm text-gray-500 mt-1">
            <?= $booking['start_date'] ?> - <?= $booking['end_date'] ?>
          </div>

          <div class="flex items-center gap-3 mt-2">
            <div class="text-sm text-gray-600">
              <?= $booking['adults'] ?> người
              lớn<?= $booking['children'] > 0 ? ', ' . $booking['children'] . ' trẻ em' : '' ?>
            </div>
            <div class="text-sm font-medium">
              <?= number_format($booking['total_price'], 0, ',', '.') ?> đ
            </div>
          </div>
        </div>

        <!-- Trạng thái và hành động -->
        <div>
          <?php
              $status = [
                'completed' => 'bg-green-100 text-green-700',
                'confirmed' => 'bg-blue-100 text-blue-700',
                'cancelled' => 'bg-red-100 text-red-700',
                'pending' => 'bg-yellow-100 text-yellow-700'
              ][$booking['status']] ?? 'bg-gray-100 text-gray-700';

              $label = [
                'completed' => 'Hoàn thành',
                'confirmed' => 'Đã xác nhận',
                'cancelled' => 'Đã huỷ',
                'pending' => 'Chờ xử lý'
              ][$booking['status']] ?? $booking['status'];
              ?>

          <div class="flex flex-wrap gap-2 justify-end">
            <span class="px-2 py-1 text-xs font-medium rounded <?= $status ?>">
              <?= $label ?>
            </span>

            <?php if ($booking['payment_status'] === 'pending') { ?>
            <a href="<?= UrlHelper::route('payment/process/' . $booking['id']) ?>"
              class="text-xs px-3 py-1 bg-teal-500 hover:bg-teal-600 text-white rounded">
              Thanh toán
            </a>
            <?php } ?>

            <?php if ($booking['status'] === 'pending') { ?>
            <a href="<?= UrlHelper::route('user/bookings/cancel/' . $booking['id']) ?>"
              class="text-xs px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded">
              Hủy
            </a>
            <?php } ?>

            <a href="<?= UrlHelper::route('user/bookings/detail/' . $booking['id']) ?>"
              class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded">
              Chi tiết
            </a>

            <?php if ($booking['status'] === 'completed') { ?>
            <a href="<?= UrlHelper::route('user/review/tour/' . $booking['tour_id']) ?>"
              class="text-xs px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded">
              Đánh giá
            </a>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } else { ?>
    <!-- Empty State đơn giản hơn -->
    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
      <div class="mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </div>
      <h3 class="text-lg font-medium text-gray-800 mb-2">Bạn chưa đặt tour nào</h3>
      <p class="text-gray-600 mb-4 text-sm">Khám phá và đặt tour để bắt đầu chuyến phiêu lưu</p>
      <a href="<?= UrlHelper::route('home/tours') ?>"
        class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-2 px-4 rounded text-sm inline-block">
        Khám phá tour
      </a>
    </div>
    <?php } ?>
  </div>
</main>
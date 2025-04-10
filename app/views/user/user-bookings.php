<?php

use App\Helpers\UrlHelper;

$title = 'Danh sách đặt tour';

?>
<main class="min-h-screen bg-gray-50 py-12 px-4">
  <div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Đơn đặt tour của bạn</h1>
      <p class="text-gray-600">Danh sách các tour du lịch bạn đã đặt</p>
    </div>

    <!-- Bảng danh sách đặt tour du lịch với scroll horizontal -->
    <?php if (!empty($bookings)) { ?>
      <div class="bg-white shadow-md rounded-xl overflow-hidden w-full">
        <div class="overflow-x-auto">
          <table class="booking-table min-w-full">
            <thead>
              <tr class="bg-gray-50 text-left">
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Mã đặt tour
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Thông tin tour
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Thời gian
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Số lượng
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Tổng tiền
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Thanh toán
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Trạng thái
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Ngày đặt
                </th>
                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                  Thao tác
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach ($bookings as $booking) { ?>
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-5 whitespace-nowrap">
                    <span class="text-sm font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">
                      #<?= $booking['id'] ?>
                    </span>
                  </td>
                  <td class="px-6 py-5">
                    <a href="<?= UrlHelper::route('home/tour-details/' . $booking["tour_id"]) ?>" class="group">
                      <div class="text-base font-medium text-gray-900 group-hover:text-teal-600 transition-colors">
                        <?= $booking['title'] ?>
                      </div>
                      <div class="text-sm text-gray-500"><?= $booking['duration'] ?></div>
                    </a>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex flex-col">
                      <div class="flex items-center text-sm font-medium text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?= $booking['start_date'] ?>
                      </div>
                      <div class="flex items-center mt-1 text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-400" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?= $booking['end_date'] ?>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex items-center text-sm font-medium text-gray-900">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                      <?= $booking['adults'] ?> người lớn
                    </div>
                    <?php if ($booking['children'] > 0) { ?>
                      <div class="flex items-center mt-1 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-purple-400" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <?= $booking['children'] ?> trẻ em
                      </div>
                    <?php } ?>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm font-semibold text-gray-900">
                      <?= number_format($booking['total_price'], 0, ',', '.') . ' đ' ?>
                    </div>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <?php
                    $statusClass = [
                      'paid' => 'bg-green-100 text-green-800',
                      'failed' => 'bg-red-100 text-red-800',
                      'pending' => 'bg-yellow-100 text-yellow-800'
                    ][$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';

                    $statusLabel = [
                      'paid' => 'Đã thanh toán',
                      'failed' => 'Thanh toán thất bại',
                      'pending' => 'Chờ thanh toán'
                    ][$booking['payment_status']] ?? $booking['payment_status'];
                    ?>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full <?= $statusClass ?>">
                      <?= $statusLabel ?>
                    </span>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <?php
                    $status = [
                      'completed' => 'bg-green-100 text-green-800',
                      'confirmed' => 'bg-blue-100 text-blue-800',
                      'cancelled' => 'bg-red-100 text-red-800',
                      'pending' => 'bg-yellow-100 text-yellow-800'
                    ][$booking['status']] ?? 'bg-gray-100 text-gray-800';

                    $label = [
                      'completed' => 'Hoàn thành',
                      'confirmed' => 'Đã xác nhận',
                      'cancelled' => 'Đã huỷ',
                      'pending' => 'Chờ xử lý'
                    ][$booking['status']] ?? $booking['status'];
                    ?>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full <?= $status ?>">
                      <?= $label ?>
                    </span>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm text-gray-600">
                      <?= $booking['created_at'] ?>
                    </div>
                  </td>
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex space-x-2">
                      <?php if ($booking['status'] === 'completed') { ?>
                        <!-- Đơn hoàn thành - Hiện nút đánh giá -->
                        <a href="<?= UrlHelper::route('user/review/tour/' . $booking['tour_id']) ?>"
                          class="flex items-center px-3 py-1.5 bg-purple-50 text-purple-600 rounded-md hover:bg-purple-100 transition-colors">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                          </svg>
                          Đánh giá
                        </a>
                      <?php } else if ($booking['payment_status'] === 'pending') { ?>
                        <!-- Đơn chưa thanh toán - Hiện nút thanh toán -->
                        <a href="<?= UrlHelper::route('payment/process/' . $booking['id']) ?>"
                          class="flex items-center px-3 py-1.5 bg-teal-50 text-teal-600 rounded-md hover:bg-teal-100 transition-colors">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg>
                          Thanh toán
                        </a>
                      <?php } ?>

                      <?php if ($booking['status'] === 'pending') { ?>
                        <!-- Đơn đang chờ xử lý - Cho phép hủy -->
                        <a href="<?= UrlHelper::route('user/bookings/cancel/' . $booking['id']) ?>"
                          class="flex items-center px-3 py-1.5 bg-gray-50 text-gray-600 rounded-md hover:bg-gray-100 transition-colors">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                          Hủy đơn
                        </a>
                      <?php } ?>

                      <!-- Xem chi tiết đơn (cho tất cả các trạng thái) -->
                      <a href="<?= UrlHelper::route('user/bookings/details/' . $booking['id']) ?>"
                        class="flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Chi tiết
                      </a>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php } else { ?>
      <!-- Empty State (Hiển thị khi không có đơn đặt tour) -->
      <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <div class="w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-teal-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Bạn chưa đặt tour nào</h3>
        <p class="text-gray-600 mb-6">Khám phá và đặt tour để bắt đầu chuyến phiêu lưu của bạn</p>
        <a href="<?= UrlHelper::route('home/tours') ?>"
          class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 inline-block">
          Khám phá tour
        </a>
      </div>
    <?php } ?>
  </div>
</main>

<style>
  /* Thêm style để làm đẹp bảng */
  .booking-table th {
    position: sticky;
    top: 0;
    background-color: #f9fafb;
    z-index: 10;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  }

  .booking-table {
    border-collapse: separate;
    border-spacing: 0;
  }

  @media (max-width: 768px) {
    .booking-table {
      font-size: 0.875rem;
    }
  }
</style>
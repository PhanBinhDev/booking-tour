<?php

use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;
?>

<div class="container px-6 py-8 mx-auto">
  <!-- Page Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Dashboard
      </h1>
      <p class="mt-1 text-gray-600">Xin chào, <?= SessionHelper::get('username') ?>! Đây là tổng quan hệ thống của bạn.
      </p>
    </div>

    <div class="mt-4 md:mt-0">
      <div class="flex items-center space-x-2 text-sm text-gray-600">
        <i class="fas fa-calendar-day"></i>
        <span><?= date('d/m/Y') ?></span>
      </div>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Users Stats -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-5">
        <div class="flex items-center">
          <div class="flex-shrink-0 p-3 rounded-full bg-blue-100 text-blue-500">
            <i class="fas fa-users text-xl"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Người dùng</h3>
            <p class="text-2xl font-semibold text-gray-800"><?= number_format($userCount) ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= UrlHelper::route('admin/users') ?>"
            class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
            <span>Quản lý người dùng</span>
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1"></div>
    </div>

    <!-- Tours Stats -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-5">
        <div class="flex items-center">
          <div class="flex-shrink-0 p-3 rounded-full bg-green-100 text-green-500">
            <i class="fas fa-route text-xl"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Tour du lịch</h3>
            <p class="text-2xl font-semibold text-gray-800"><?= number_format($tourCount) ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= UrlHelper::route('admin/tours') ?>"
            class="text-sm text-green-600 hover:text-green-800 flex items-center">
            <span>Quản lý tour</span>
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
    </div>

    <!-- Bookings Stats -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-5">
        <div class="flex items-center">
          <div class="flex-shrink-0 p-3 rounded-full bg-purple-100 text-purple-500">
            <i class="fas fa-calendar-check text-xl"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Đặt tour</h3>
            <p class="text-2xl font-semibold text-gray-800"><?= number_format($bookingCount) ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= UrlHelper::route('admin/bookings') ?>"
            class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
            <span>Quản lý đặt tour</span>
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1"></div>
    </div>

    <!-- Revenue Stats -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-5">
        <div class="flex items-center">
          <div class="flex-shrink-0 p-3 rounded-full bg-amber-100 text-amber-500">
            <i class="fas fa-coins text-xl"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Doanh thu</h3>
            <p class="text-2xl font-semibold text-gray-800"><?= FormatHelper::formatCurrency($totalRevenue) ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= UrlHelper::route('admin/payment/transactions') ?>"
            class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
            <span>Xem giao dịch</span>
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-1"></div>
    </div>

    <!-- News Stats -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-5">
        <div class="flex items-center">
          <div class="flex-shrink-0 p-3 rounded-full bg-teal-100 text-teal-500">
            <i class="fas fa-newspaper text-xl"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Tin tức</h3>
            <p class="text-2xl font-semibold text-gray-800"><?= number_format($newsCount) ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= UrlHelper::route('admin/news') ?>"
            class="text-sm text-teal-600 hover:text-teal-800 flex items-center">
            <span>Quản lý tin tức</span>
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-1"></div>
    </div>
  </div>

  <!-- Charts & Data Section -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Booking Status Chart -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Trạng thái đặt tour</h3>
        <div class="flex items-center mt-2 sm:mt-0">
          <form action="<?= UrlHelper::route('admin/dashboard') ?>" method="GET" class="flex items-center">
            <label for="year-select" class="mr-2 text-sm text-gray-600">Năm:</label>
            <select id="year-select" name="year"
              class="border border-gray-300 rounded-md text-sm py-1 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500"
              onchange="this.form.submit()">
              <?php foreach ($years as $year): ?>
                <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
              <?php endforeach; ?>
            </select>
          </form>
          <div class="ml-4 text-sm text-gray-500">Tổng: <?= number_format(array_sum($bookingStatusData)) ?></div>
        </div>
      </div>
      <div class="h-64">
        <canvas id="bookingStatusChart"></canvas>
      </div>
    </div>

    <!-- Revenue Chart -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Doanh thu theo tháng</h3>
        <div class="flex items-center mt-2 sm:mt-0">
          <span class="text-sm text-gray-500">Năm: <?= $selectedYear ?></span>
          <span class="ml-4 text-sm text-gray-500">Tổng:
            <?= FormatHelper::formatCurrency(array_sum($monthlyRevenueData)) ?></span>
        </div>
      </div>
      <div class="h-64">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>

    <!-- NEWS -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Lượt xem tin tức</h3>
        <div class="flex items-center mt-2 sm:mt-0">
          <span class="text-sm text-gray-500">Năm: <?= $selectedYear ?></span>
          <span class="ml-4 text-sm text-gray-500">Tổng: <?= number_format(array_sum($newsViewsData)) ?></span>
        </div>
      </div>
      <div class="h-64">
        <canvas id="newsViewsChart"></canvas>
      </div>
    </div>

    <!-- Popular Locations -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Địa điểm phổ biến</h3>
        <a href="<?= UrlHelper::route('admin/locations') ?>" class="text-sm text-teal-600 hover:text-teal-800">Xem tất
          cả</a>
      </div>

      <?php if (empty($popularLocations)): ?>
        <div class="text-center py-8 text-gray-500">
          <i class="fas fa-map-marker-alt text-3xl mb-2"></i>
          <p>Chưa có dữ liệu địa điểm</p>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <?php foreach ($popularLocations as $location): ?>
            <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
              <div class="w-12 h-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                <?php if (!empty($location['image'])): ?>
                  <img src="<?= $location['image'] ?>" alt="<?= $location['name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                  <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-map"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="ml-3">
                <h4 class="text-sm font-medium text-gray-800"><?= $location['name'] ?></h4>
                <div class="flex items-center mt-1 text-xs text-gray-500">
                  <i class="fas fa-route mr-1"></i>
                  <span><?= $location['tour_count'] ?> tour</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Recent Activities & Quick Access -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Bookings -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Đặt tour gần đây</h3>
        <a href="<?= UrlHelper::route('admin/bookings') ?>" class="text-sm text-teal-600 hover:text-teal-800">Xem tất
          cả</a>
      </div>

      <?php if (empty($recentBookings)): ?>
        <div class="text-center py-8 text-gray-500">
          <i class="fas fa-calendar-times text-3xl mb-2"></i>
          <p>Chưa có đơn đặt tour nào</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-left text-gray-500 border-b">
                <th class="pb-3 font-medium">Mã đặt tour</th>
                <th class="pb-3 font-medium">Khách hàng</th>
                <th class="pb-3 font-medium">Tour</th>
                <th class="pb-3 font-medium">Trạng thái</th>
                <th class="pb-3 font-medium">Ngày đặt</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentBookings as $booking): ?>
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                  <td class="py-3 font-medium"><?= $booking['booking_number'] ?></td>
                  <td class="py-3"><?= $booking['customer_name'] ?></td>
                  <td class="py-3 max-w-[200px] truncate"><?= $booking['tour_title'] ?></td>
                  <td class="py-3">
                    <span class="px-2 py-1 text-xs rounded-full <?= getStatusClass($booking['status']) ?>">
                      <?= getStatusLabel($booking['status']) ?>
                    </span>
                  </td>
                  <td class="py-3"><?= date('d/m/Y', strtotime($booking['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- Quick Access -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Truy cập nhanh</h3>

      <div class="grid grid-cols-1 gap-4">
        <!-- Tour Management -->
        <a href="<?= UrlHelper::route('admin/tours/create') ?>"
          class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
          <div class="p-2 rounded-md bg-green-100 text-green-600">
            <i class="fas fa-plus"></i>
          </div>
          <div class="ml-3">
            <h4 class="text-sm font-medium text-gray-800">Thêm tour mới</h4>
            <p class="text-xs text-gray-500">Tạo tour du lịch mới</p>
          </div>
        </a>

        <!-- Location Management -->
        <a href="<?= UrlHelper::route('admin/locations') ?>"
          class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
          <div class="p-2 rounded-md bg-blue-100 text-blue-600">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="ml-3">
            <h4 class="text-sm font-medium text-gray-800">Địa điểm</h4>
            <p class="text-xs text-gray-500">Quản lý địa điểm du lịch</p>
          </div>
        </a>

        <a href="<?= UrlHelper::route('admin/news/create') ?>"
          class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
          <div class="p-2 rounded-md bg-teal-100 text-teal-600">
            <i class="fas fa-newspaper"></i>
          </div>
          <div class="ml-3">
            <h4 class="text-sm font-medium text-gray-800">Tạo bài viết mới</h4>
            <p class="text-xs text-gray-500">Viết và đăng bài viết mới</p>
          </div>
        </a>

        <!-- Media Management -->
        <a href="<?= UrlHelper::route('admin/images') ?>"
          class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
          <div class="p-2 rounded-md bg-purple-100 text-purple-600">
            <i class="fas fa-images"></i>
          </div>
          <div class="ml-3">
            <h4 class="text-sm font-medium text-gray-800">Thư viện ảnh</h4>
            <p class="text-xs text-gray-500">Quản lý hình ảnh</p>
          </div>
        </a>

        <!-- Payment Management -->
        <a href="<?= UrlHelper::route('admin/payment/transactions') ?>"
          class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
          <div class="p-2 rounded-md bg-amber-100 text-amber-600">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <div class="ml-3">
            <h4 class="text-sm font-medium text-gray-800">Thanh toán</h4>
            <p class="text-xs text-gray-500">Quản lý giao dịch</p>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Popular Tours & Locations -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Popular Tours -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Tour phổ biến</h3>
        <a href="<?= UrlHelper::route('admin/tours') ?>" class="text-sm text-teal-600 hover:text-teal-800">Xem tất
          cả</a>
      </div>

      <?php if (empty($popularTours)): ?>
        <div class="text-center py-8 text-gray-500">
          <i class="fas fa-route text-3xl mb-2"></i>
          <p>Chưa có dữ liệu tour</p>
        </div>
      <?php else: ?>
        <div class="space-y-4">
          <?php foreach ($popularTours as $tour): ?>
            <div class="flex items-center border-b border-gray-100 pb-4">
              <div class="w-16 h-16 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                <?php if (!empty($tour['image'])): ?>
                  <img src="<?= $tour['image'] ?>" alt="<?= $tour['title'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                  <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-image"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="ml-4 flex-grow">
                <h4 class="text-sm font-medium text-gray-800"><?= $tour['title'] ?></h4>
                <div class="flex items-center mt-1">
                  <div class="flex items-center text-amber-500 text-xs">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <?php if ($i <= round($tour['rating'])): ?>
                        <i class="fas fa-star"></i>
                      <?php else: ?>
                        <i class="far fa-star"></i>
                      <?php endif; ?>
                    <?php endfor; ?>
                    <span class="ml-1 text-gray-500">(<?= $tour['reviews'] ?>)</span>
                  </div>
                  <span class="mx-2 text-gray-300">|</span>
                  <span class="text-xs text-gray-500"><?= $tour['bookings'] ?> đặt tour</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm font-semibold text-gray-800"><?= FormatHelper::formatCurrency($tour['price']) ?></div>
                <div class="text-xs text-gray-500"><?= $tour['duration'] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Recent News Articles - Phần mới -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Tin tức gần đây</h3>
        <a href="<?= UrlHelper::route('admin/news') ?>" class="text-sm text-teal-600 hover:text-teal-800">Xem tất cả</a>
      </div>

      <?php if (empty($recentNews)): ?>
        <div class="text-center py-8 text-gray-500">
          <i class="fas fa-newspaper text-3xl mb-2"></i>
          <p>Chưa có bài viết nào</p>
        </div>
      <?php else: ?>
        <div class="space-y-4">
          <?php foreach ($recentNews as $article): ?>
            <div class="flex items-center border-b border-gray-100 pb-4">
              <div class="w-16 h-16 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                <?php if (!empty($article['featured_image'])): ?>
                  <img src="<?= $article['featured_image'] ?>" alt="<?= $article['title'] ?>"
                    class="w-full h-full object-cover">
                <?php else: ?>
                  <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-image"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="ml-4 flex-grow">
                <h4 class="text-sm font-medium text-gray-800"><?= $article['title'] ?></h4>
                <div class="flex items-center mt-1 text-xs text-gray-500">
                  <span><i class="far fa-calendar mr-1"></i><?= date('d/m/Y', strtotime($article['published_at'])) ?></span>
                  <span class="mx-2">•</span>
                  <span><i class="far fa-eye mr-1"></i><?= number_format($article['views']) ?> lượt xem</span>
                </div>
              </div>
              <div
                class="text-xs px-2 py-1 rounded-full <?= $article['status'] == 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                <?= $article['status'] == 'published' ? 'Đã xuất bản' : 'Bản nháp' ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>


  </div>
</div>

<?php
// Helper functions for status labels and classes
function getStatusLabel($status)
{
  $labels = [
    'pending' => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'paid' => 'Đã thanh toán',
    'cancelled' => 'Đã hủy',
    'completed' => 'Hoàn thành'
  ];

  return $labels[$status] ?? $status;
}

function getStatusClass($status)
{
  $classes = [
    'pending' => 'bg-yellow-100 text-yellow-800',
    'confirmed' => 'bg-blue-100 text-blue-800',
    'paid' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
    'completed' => 'bg-purple-100 text-purple-800'
  ];

  return $classes[$status] ?? 'bg-gray-100 text-gray-800';
}
?>

<!-- Truyền dữ liệu từ PHP sang JavaScript -->
<script>
  // Truyền dữ liệu từ PHP sang JavaScript
  const dashboardData = {
    bookingStatusLabels: <?= json_encode(array_keys($bookingStatusData)) ?>,
    bookingStatusValues: <?= json_encode(array_values($bookingStatusData)) ?>,
    monthlyRevenueLabels: <?= json_encode(array_keys($monthlyRevenueData)) ?>,
    monthlyRevenueValues: <?= json_encode(array_values($monthlyRevenueData)) ?>,
    newsViewsLabels: <?= json_encode(array_keys($newsViewsData)) ?>,
    newsViewsValues: <?= json_encode(array_values($newsViewsData)) ?>
  };

  console.log({
    dashboardData
  })
</script>

<!-- Dashboard JS -->
<script src="<?= UrlHelper::js('admin/dashboard.js') ?>"></script>
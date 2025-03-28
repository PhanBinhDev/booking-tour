<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;

$title = 'Quản lý đặt tours';
?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Tiêu đề trang -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Quản lý Đặt Tour</h1>
    </div>
    <!-- FILTER SECTION - ENHANCED UI -->
    <div class="bg-white p-5 rounded-lg shadow-md mb-6 border border-gray-200">
      <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
        <h3 class="text-lg font-medium text-gray-800 flex items-center">
          <i class="fas fa-filter text-teal-600 mr-2"></i> Bộ lọc tìm kiếm
          <?php $filterCount = count(array_filter($filters, function ($value) {
            return $value !== '';
          })); ?>
          <?php if ($filterCount > 0): ?>
            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800">
              <?= $filterCount ?> bộ lọc
            </span>
          <?php endif; ?>
        </h3>
        <button type="button" id="toggle-filter"
          class="text-gray-500 hover:text-teal-600 focus:outline-none transition-colors duration-150">
          <i class="fas fa-chevron-up"></i>
        </button>
      </div>

      <div id="filter-content">
        <form action="<?= UrlHelper::route('admin/bookings') ?>" method="GET"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- DANH MỤC TOUR -->
          <div class="col-span-1">
            <label for="tour_category" class="block text-sm font-medium text-gray-700 mb-1">
              Danh mục tour
            </label>
            <div class="relative" x-data="{ open: false, selected: '<?= $filters['tour_category'] ?? '' ?>' }">
              <!-- Dropdown trigger -->
              <button type="button" @click="open = !open"
                class="w-full flex items-center justify-between rounded-md border border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-30 pl-10 pr-10 py-2.5 text-gray-700 bg-white hover:border-gray-400 transition-all duration-200">
                <span
                  x-text="selected ? document.querySelector(`[data-value='${selected}']`)?.innerText : 'Tất cả danh mục'"></span>
                <i class="fas fa-chevron-down text-gray-400" :class="{ 'transform rotate-180': open }"></i>
              </button>

              <!-- Icon -->
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-tag text-teal-500 opacity-70"></i>
              </div>

              <!-- Selected badge -->
              <input type="hidden" name="tour_category" :value="selected">
              <?php if (!empty($filters['tour_category'])): ?>
                <div class="absolute inset-y-0 right-0 pr-8 flex items-center">
                  <span class="text-xs font-medium px-1.5 py-0.5 rounded-full bg-teal-100 text-teal-800">Đã chọn</span>
                </div>
              <?php endif; ?>

              <!-- Dropdown options -->
              <div x-show="open" @click.away="open = false"
                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 overflow-auto scrollbar scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95">

                <!-- All categories option -->
                <div @click="selected = ''; open = false" class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer">
                  Tất cả danh mục
                </div>

                <!-- Category options -->
                <?php foreach ($parentCategories as $parent): ?>
                  <div @click="selected = '<?= $parent['id'] ?>'; open = false"
                    class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer font-medium text-gray-800 border-t border-gray-100"
                    data-value="<?= $parent['id'] ?>">
                    <?= htmlspecialchars($parent['name']) ?>
                  </div>

                  <?php if (isset($childCategories[$parent['id']])): ?>
                    <?php foreach ($childCategories[$parent['id']] as $child): ?>
                      <div @click="selected = '<?= $child['id'] ?>'; open = false"
                        class="px-4 py-2 pl-8 text-sm hover:bg-gray-100 cursor-pointer" data-value="<?= $child['id'] ?>">
                        <i class="fas fa-long-arrow-alt-right mr-2 text-gray-400"></i><?= htmlspecialchars($child['name']) ?>
                      </div>

                      <?php if (isset($childCategories[$child['id']])): ?>
                        <?php foreach ($childCategories[$child['id']] as $grandchild): ?>
                          <div @click="selected = '<?= $grandchild['id'] ?>'; open = false"
                            class="px-4 py-2 pl-12 text-sm hover:bg-gray-100 cursor-pointer"
                            data-value="<?= $grandchild['id'] ?>">
                            <i class="fas fa-angle-right mr-2 text-gray-400"></i><?= htmlspecialchars($grandchild['name']) ?>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <!-- TRẠNG THÁI -->
          <div class="col-span-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Trạng thái đặt tour
            </label>
            <div class="relative">
              <select id="status" name="status"
                class="w-full rounded-md border border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-30 pl-10 pr-10 py-2.5 text-gray-700 placeholder-gray-400 hover:border-gray-400 transition-all duration-200 bg-white bg-opacity-95">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" <?= ($filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ xác nhận
                </option>
                <option value="confirmed" <?= ($filters['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận
                </option>
                <option value="paid" <?= ($filters['status'] ?? '') == 'paid' ? 'selected' : '' ?>>Đã thanh toán
                </option>
                <option value="cancelled" <?= ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Đã hủy
                </option>
                <option value="completed" <?= ($filters['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Hoàn thành
                </option>
              </select>
              <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                <i class="fas fa-check-circle text-gray-400"></i>
              </div>
              <?php if (!empty($filters['status'])): ?>
                <div class="absolute inset-y-0 right-0 pr-8 flex items-center">
                  <span class="text-xs font-medium px-1.5 py-0.5 rounded bg-teal-100 text-teal-800">Đã chọn</span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-span-2">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Trạng thái thanh toán
            </label>
            <div class="relative">
              <select id="payment_status" name="payment_status"
                class="w-full rounded-md border border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-30 pl-10 pr-10 py-2.5 text-gray-700 placeholder-gray-400 hover:border-gray-400 transition-all duration-200 bg-white bg-opacity-95">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" <?= ($filters['payment_status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ
                  thanh toán
                </option>
                <option value="confirmed" <?= ($filters['payment_status'] ?? '') == 'refunded' ? 'selected' : '' ?>>
                  Hoàn trả
                </option>
                <option value="paid" <?= ($filters['payment_status'] ?? '') == 'paid' ? 'selected' : '' ?>>Đã thanh toán
                </option>
                <option value="cancelled" <?= ($filters['payment_status'] ?? '') == 'failed' ? 'selected' : '' ?>>Thất
                  bại
                </option>
              </select>
              <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                <i class="fas fa-check-circle text-gray-400"></i>
              </div>
              <?php if (!empty($filters['payment_status'])): ?>
                <div class="absolute inset-y-0 right-0 pr-8 flex items-center">
                  <span class="text-xs font-medium px-1.5 py-0.5 rounded bg-teal-100 text-teal-800">Đã chọn</span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- TÌM KIẾM -->
          <div class="col-span-4">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
              Tìm kiếm
            </label>
            <div class="relative">
              <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                placeholder="Nhập tên khách hàng hoặc mã đặt tour..."
                class="w-full rounded-md border border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-30 pl-10 pr-10 py-2.5 text-gray-700 placeholder-gray-400 hover:border-gray-400 transition-all duration-200 bg-white bg-opacity-95">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
              </div>
              <?php if (!empty($filters['search'])): ?>
                <div class="absolute inset-y-0 right-2 flex items-center">
                  <button type="button" onclick="document.getElementById('search').value='';this.form.submit();"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none" aria-label="Clear search">
                    <i class="fas fa-times-circle"></i>
                  </button>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- BUTTONS -->
          <div class="col-span-4 flex justify-end space-x-2 mt-2">
            <?php if ($filterCount > 0): ?>
              <a href="<?= UrlHelper::route('admin/bookings') ?>"
                class="bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium py-2 px-4 rounded transition-colors duration-150 flex items-center">
                <i class="fas fa-times-circle mr-2"></i> Xóa bộ lọc
              </a>
            <?php endif; ?>
            <button type="submit"
              class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded transition-colors duration-150 flex items-center">
              <i class="fas fa-filter mr-2"></i> Áp dụng bộ lọc
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Bảng danh sách đặt tour du lịch với scroll horizontal -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
      <div class="overflow-x-auto">
        <table class="booking-table min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Mã đặt tour
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thông tin tour
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Khách hàng
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Số lượng
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tổng tiền
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Trạng thái
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thanh toán
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ngày tạo
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thao tác
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($bookings['items'] as $item): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= $item["booking_number"] ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?= $item["tour_title"] ?></div>
                  <div class="text-sm text-gray-500"><?= $item["duration"] ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900"><?= $item["customer_name"] ?></div>
                  <div class="text-xs text-gray-500">ID: <?= $item["customer_id"] ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?= $item["adults"] ?> người lớn</div>
                  <div class="text-xs text-gray-500"><?= $item["children"] ?> trẻ em</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?= FormatHelper::formatCurrency($item["tour_price"]) ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?= renderBookingStatus($item["booking_status"]) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?= renderPaymentStatus($item["payment_status"]) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= FormatHelper::formatDate($item["booking_date"]) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <?php if ($item["booking_status"] !== 'cancelled'): ?>
                    <a href="<?= UrlHelper::route('admin/bookings/' . $item['id']) ?>"
                      class="text-teal-600 hover:text-teal-900 mr-2" title="Xem chi tiết">
                      <i class="fas fa-eye"></i>
                    </a>
                    <button class="text-blue-600 hover:text-blue-900 mr-2 change-status-btn" data-id="<?= $item['id'] ?>"
                      data-current-status="<?= $item['booking_status'] ?>" title="Đổi trạng thái">
                      <i class="fas fa-exchange-alt"></i>
                    </button>
                  <?php else: ?>
                    <a href="<?= UrlHelper::route('admin/bookings/' . $item['id']) ?>"
                      class="text-gray-600 hover:text-gray-900" title="Xem chi tiết">
                      <i class="fas fa-eye"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Phân trang -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
      <div class="flex-1 flex justify-between sm:hidden">
        <?php if ($bookings['pagination']['current_page'] > 1): ?>
          <a href="?page=<?= $bookings['pagination']['current_page'] - 1 ?>"
            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Trước
          </a>
        <?php endif; ?>
        <?php if ($bookings['pagination']['current_page'] < $bookings['pagination']['total_pages']): ?>
          <a href="?page=<?= $bookings['pagination']['current_page'] + 1 ?>"
            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Sau
          </a>
        <?php endif; ?>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Hiển thị
            <span class="font-medium"><?= $bookings['pagination']['from'] ?></span>
            đến
            <span class="font-medium"><?= $bookings['pagination']['to'] ?></span>
            trong
            <span class="font-medium"><?= $bookings['pagination']['total'] ?></span>
            kết quả
          </p>
        </div>
        <div>
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <?php for ($i = 1; $i <= $bookings['pagination']['total_pages']; $i++): ?>
              <a href="<?= UrlHelper::route('admin/bookings?page=' . $i) ?>" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium 
              <?= (int)$i === (int)$bookings['pagination']['current_page']
                ? 'z-10 bg-teal-50 border-teal-500 text-teal-600 font-bold'
                : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>
          </nav>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal đổi trạng thái -->
<div id="change-status-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
  role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div
      class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

      <form action="<?= UrlHelper::route('admin/bookings/updateStatus') ?>" method="POST">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
            Đổi trạng thái đặt tour
          </h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              Chọn trạng thái mới cho đặt tour:
            </p>
            <input type="hidden" id="booking-id-input" name="id" value="">

            <div class="relative" x-data="{ statusOpen: false, selectedStatus: '', disableChange: false }"
              x-init="selectedStatus = ''; $watch('selectedStatus', value => { document.getElementById('hidden-status').value = value; })">
              <!-- Hidden input để lưu giá trị -->
              <input type="hidden" id="hidden-status" name="status" x-model="selectedStatus">

              <!-- Dropdown trigger -->
              <button type="button" @click="!disableChange && (statusOpen = !statusOpen)"
                :class="{ 'opacity-50 cursor-not-allowed': disableChange }"
                class="w-full flex items-center justify-between rounded-md border border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-30 pl-10 pr-10 py-2.5 text-gray-700 bg-white hover:border-gray-400 transition-all duration-200">
                <span x-text="selectedStatus === 'pending' ? 'Chờ xử lý' : 
                      selectedStatus === 'confirmed' ? 'Đã xác nhận' : 
                      selectedStatus === 'cancelled' ? 'Đã hủy' : 
                      selectedStatus === 'completed' ? 'Hoàn thành' : 'Chọn trạng thái'"></span>
                <i class="fas fa-chevron-down text-gray-400" :class="{ 'transform rotate-180': statusOpen }"></i>
              </button>

              <!-- Status icon -->
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-exchange-alt" :class="{
                  'text-yellow-500': selectedStatus === 'pending',
                  'text-blue-500': selectedStatus === 'confirmed',
                  'text-green-500': selectedStatus === 'completed',
                  'text-red-500': selectedStatus === 'cancelled',
                  'text-gray-400': !selectedStatus
                }"></i>
              </div>

              <!-- Dropdown options -->
              <div x-show="statusOpen" @click.away="statusOpen = false"
                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 overflow-auto focus:outline-none"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95">

                <!-- Status options -->
                <div @click="selectedStatus = 'pending'; statusOpen = false"
                  class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                  :class="{ 'bg-teal-50': selectedStatus === 'pending' }">
                  <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 mr-2"></span>
                    Chờ xử lý
                  </span>
                </div>
                <div @click="selectedStatus = 'confirmed'; statusOpen = false"
                  class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                  :class="{ 'bg-teal-50': selectedStatus === 'confirmed' }">
                  <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-blue-400 mr-2"></span>
                    Đã xác nhận
                  </span>
                </div>
                <div @click="selectedStatus = 'cancelled'; statusOpen = false"
                  class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                  :class="{ 'bg-teal-50': selectedStatus === 'cancelled' }">
                  <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-red-400 mr-2"></span>
                    Đã hủy
                  </span>
                </div>
                <div @click="selectedStatus = 'completed'; statusOpen = false"
                  class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                  :class="{ 'bg-teal-50': selectedStatus === 'completed' }">
                  <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-green-600 mr-2"></span>
                    Hoàn thành
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
            Xác nhận
          </button>
          <button type="button" id="cancel-status-change"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Hủy
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const changeStatusBtns = document.querySelectorAll('.change-status-btn');
    const modal = document.getElementById('change-status-modal');
    const cancelBtn = document.getElementById('cancel-status-change');

    // Debug - Kiểm tra các phần tử
    console.log("Modal:", modal);
    console.log("Change status buttons:", changeStatusBtns.length);
    console.log("Cancel button:", cancelBtn);

    changeStatusBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const bookingId = this.dataset.id;
        const currentStatus = this.dataset.currentStatus;
        console.log("Button clicked, status:", currentStatus, "ID:", bookingId);

        // Thiết lập giá trị cho các input ẩn
        document.getElementById('hidden-status').value = currentStatus;
        document.getElementById('booking-id-input').value = bookingId;

        // Mở modal
        modal.style.display = 'block';
        modal.classList.remove('hidden');
      });
    });

    cancelBtn.addEventListener('click', function() {
      modal.style.display = 'none';
      modal.classList.add('hidden');
    });
  });
</script>

<?php
// Helper functions for rendering status badges
function renderBookingStatus($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ xử lý</span>';
    case 'confirmed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Đã xác nhận</span>';
    case 'cancelled':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>';
    case 'completed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã hoàn thành</span>';
    case 'refunded':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Đã hoàn tiền</span>';
    case 'in_progress':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Đang diễn ra</span>';
    default:
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
  }
}

function renderPaymentStatus($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ thanh toán</span>';
    case 'paid':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã thanh toán</span>';
    case 'failed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Thanh toán thất bại</span>';
    case 'refunded':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Đã hoàn tiền</span>';
    case 'partial':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Thanh toán một phần</span>';
    case 'processing':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Đang xử lý</span>';
    case 'cancelled':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>';
    default:
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
  }
}

?>


<style>
  #change-status-modal {
    display: flex;
  }

  #change-status-modal.hidden {
    display: none !important;
  }
</style>
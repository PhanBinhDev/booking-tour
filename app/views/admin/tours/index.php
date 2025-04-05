<?php

use App\Helpers\UrlHelper;
?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Tiêu đề trang -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Quản lý Tour Du lịch</h1>
      <a href="<?= UrlHelper::route('admin/tours/createTour') ?>">
        <button id="addTourBtn" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-plus mr-2"></i> Thêm tour mới
        </button>
      </a>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <div
      class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
      <div class="border-b border-gray-100 bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
        <h3 class="text-lg font-medium text-white flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          Tìm kiếm và lọc tour
        </h3>
      </div>

      <form method="GET" action="<?= UrlHelper::route('admin/tours') ?>" class="px-6 py-5">
        <!-- Filter Grid - Responsive Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
          <!-- Category Filter -->
          <div class="filter-group">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1.5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
              Danh mục
            </label>
            <div class="relative">
              <select id="category_id" name="category_id"
                class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $category) { ?>
                  <option value="<?= $category['id'] ?>"
                    <?= ($filters['category_id'] == $category['id']) ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                  </option>
                <?php } ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Status Filter -->
          <div class="filter-group">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1.5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Trạng thái
            </label>
            <div class="relative">
              <select id="status" name="status"
                class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
                <option value="">Tất cả trạng thái</option>
                <option value="active" <?= ($filters['status'] == 'active') ? 'selected' : '' ?>>
                  Đang hoạt động
                </option>
                <option value="inactive" <?= ($filters['status'] == 'inactive') ? 'selected' : '' ?>>
                  Tạm ngưng
                </option>
                <option value="draft" <?= ($filters['status'] == 'draft') ? 'selected' : '' ?>>
                  Bản nháp
                </option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Location Filter -->
          <div class="filter-group">
            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1.5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Địa điểm
            </label>
            <div class="relative">
              <select id="location_id" name="location_id"
                class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none transition-colors">
                <option value="">Tất cả địa điểm</option>
                <?php foreach ($locations as $location) { ?>
                  <option value="<?= $location['id'] ?>"
                    <?= ($filters['location_id'] == $location['id']) ? 'selected' : '' ?>>
                    <?= $location['name'] ?>
                  </option>
                <?php } ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Search Input -->
          <div class="filter-group">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1.5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Tìm kiếm
            </label>
            <div class="relative">
              <input type="text" id="search" name="search" placeholder="Nhập tên tour hoặc mã tour..."
                value="<?= $filters['search'] ?? '' ?>"
                class="w-full rounded-lg p-2.5 pl-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <?php if (!empty($filters['search'])): ?>
                <button type="button" onclick="document.getElementById('search').value = ''; this.form.submit();"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Filter Actions - Always Visible on Mobile -->
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
          <div class="w-full sm:w-auto flex items-center">
            <div class="relative">
              <select name="limit"
                class="rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 text-gray-700 appearance-none shadow-sm">
                <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10 mục</option>
                <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25 mục</option>
                <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50 mục</option>
                <option value="100" <?= ($pagination['per_page'] == 100) ? 'selected' : '' ?>>100 mục</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>

            <!-- Show active filter count -->
            <?php
            $activeFilters = 0;
            if (!empty($filters['category_id'])) $activeFilters++;
            if (!empty($filters['status'])) $activeFilters++;
            if (!empty($filters['location_id'])) $activeFilters++;
            if (!empty($filters['search'])) $activeFilters++;
            ?>

            <?php if ($activeFilters > 0): ?>
              <div class="ml-3 text-sm text-gray-500">
                <span class="bg-teal-100 text-teal-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                  <?= $activeFilters ?> bộ lọc đang áp dụng
                </span>
              </div>
            <?php endif; ?>
          </div>

          <div class="w-full sm:w-auto flex gap-3">
            <a href="<?= UrlHelper::route('admin/tours') ?>"
              class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center justify-center border border-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Đặt lại
            </a>

            <button type="submit"
              class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 shadow-sm flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              Áp dụng
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Compact Filter Section for Mobile -->
    <div class="lg:hidden bg-white rounded-xl shadow-sm mb-6 border border-gray-100 overflow-hidden md:hidden">
      <div class="p-4">
        <button type="button" id="toggleMobileFilter"
          class="w-full flex items-center justify-between text-gray-700 font-medium">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Tìm kiếm và lọc tour
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform" id="mobileFilterIcon"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <?php if ($activeFilters > 0): ?>
          <div class="mt-2 text-sm text-gray-500">
            <span class="bg-teal-100 text-teal-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
              <?= $activeFilters ?> bộ lọc đang áp dụng
            </span>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <script>
      // Toggle mobile filter
      document.getElementById('toggleMobileFilter')?.addEventListener('click', function() {
        const filterSection = document.querySelector('.filter-section');
        const icon = document.getElementById('mobileFilterIcon');

        if (filterSection) {
          filterSection.classList.toggle('hidden');
          icon.classList.toggle('rotate-180');
        }
      });
    </script>



    <!-- Bảng danh sách tour du lịch với scroll horizontal -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
      <div class="overflow-x-auto">
        <table class="tour-table min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'id', 'direction' => ($sort == 'id' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  ID
                  <?php if ($sort == 'id'): ?>
                    <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                    <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Hình ảnh
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'title', 'direction' => ($sort == 'title' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  Tên tour
                  <?php if ($sort == 'title'): ?>
                    <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                    <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Số lượng
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'price', 'direction' => ($sort == 'price' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  Giá
                  <?php if ($sort == 'price'): ?>
                    <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                    <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thời gian
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Trạng thái
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'created_at', 'direction' => ($sort == 'created_at' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  Ngày tạo
                  <?php if ($sort == 'created_at'): ?>
                    <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                    <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thao tác
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($tours)): ?>
              <?php foreach ($tours as $item): ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= $item["id"] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php if (!empty($item['tour_images'][0])): ?>
                      <img src="<?= $item['tour_images'][0] ?>" alt="<?= $item['title'] ?>"
                        class="h-12 w-20 object-cover rounded">
                    <?php else: ?>
                      <img src="<?= UrlHelper::asset('images/no-image.jpg') ?>" alt="No Image"
                        class="h-12 w-20 object-cover rounded">
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?= $item["title"] ?></div>
                    <div class="text-sm text-gray-500"><?= $item["slug"] ?></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900"><?= $item["group_size"] ?></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php if (!empty($item["sale_price"])): ?>
                      <div class="text-sm font-medium text-gray-900"><?= number_format($item["sale_price"], 0, ',', '.') ?>₫
                      </div>
                      <div class="text-xs text-gray-500 line-through"><?= number_format($item["price"], 0, ',', '.') ?>₫</div>
                    <?php else: ?>
                      <div class="text-sm font-medium text-gray-900"><?= number_format($item["price"], 0, ',', '.') ?>₫</div>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= $item["duration"] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php
                    $statusClass = [
                      'active' => 'bg-green-100 text-green-800',
                      'inactive' => 'bg-red-100 text-red-800',
                      'draft' => 'bg-gray-100 text-gray-800'
                    ][$item["status"]] ?? 'bg-gray-100 text-gray-800';

                    $statusLabel = [
                      'active' => 'Hoạt động',
                      'inactive' => 'Tạm ngưng',
                      'draft' => 'Bản nháp'
                    ][$item["status"]] ?? $item["status"];
                    ?>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                      <?= $statusLabel ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= date('d/m/Y', strtotime($item["created_at"])) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                      <a href="<?= UrlHelper::route('admin/tours/editTour/' . $item['id']) ?>">
                        <button class="text-teal-600 hover:text-teal-900" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                      </a>
                      <a href="<?= UrlHelper::route('admin/tours/deleteTour/' . $item['id']) ?>"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tour này?');">
                        <button class="text-red-600 hover:text-red-900" title="Xóa">
                          <i class="fas fa-trash"></i>
                        </button>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tr>
            <?php else: ?>
              <tr>
                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                  Không tìm thấy tour nào phù hợp với điều kiện tìm kiếm.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Phân trang -->
      <?php if ($pagination['total'] > 0): ?>
        <div class="px-6 py-4 bg-white border-t border-gray-200">
          <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="text-sm text-gray-600 mb-4 sm:mb-0">
              Hiển thị <?= $pagination['from'] ?> đến <?= $pagination['to'] ?> trong số <?= $pagination['total'] ?>
              tour
            </div>

            <!-- Các nút phân trang -->
            <div class="flex flex-wrap items-center space-x-1">
              <?php if ($pagination['has_prev_page']): ?>
                <a href="<?= UrlHelper::buildQueryString(['page' => $pagination['current_page'] - 1]) ?>"
                  class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                  &laquo; Trước
                </a>
              <?php endif; ?>
              <!-- Các nút phân trang -->
              <div class="flex flex-wrap items-center space-x-1">

                <?php
                // Hiển thị các số trang
                $start = max(1, $pagination['current_page'] - 2);
                $end = min($pagination['total_pages'], $pagination['current_page'] + 2);

                if ($start > 1) {
                  echo '<a href="' . UrlHelper::buildQueryString(['page' => 1]) . '" 
                       class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">1</a>';
                  if ($start > 2) {
                    echo '<span class="px-2 text-gray-500">...</span>';
                  }
                }

                for ($i = $start; $i <= $end; $i++) {
                  $isActive = $i === $pagination['current_page'];
                  echo '<a href="' . UrlHelper::buildQueryString(['page' => $i]) . '" 
                       class="px-3 py-1 border rounded-md text-sm ' .
                    ($isActive ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50') .
                    '">' . $i . '</a>';
                }

                if ($end < $pagination['total_pages']) {
                  if ($end < $pagination['total_pages'] - 1) {
                    echo '<span class="px-2 text-gray-500">...</span>';
                  }
                  echo '<a href="' . UrlHelper::buildQueryString(['page' => $pagination['total_pages']]) . '" 
                       class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">' . $pagination['total_pages'] . '</a>';
                }
                ?>

                <?php if ($pagination['has_next_page']): ?>
                  <a href="<?= UrlHelper::buildQueryString(['page' => $pagination['current_page'] + 1]) ?>"
                    class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                    Sau &raquo;
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
<?php endif; ?>
</div>
</div>
</div>
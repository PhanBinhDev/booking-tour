<?php

use App\Helpers\UrlHelper;
?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Tiêu đề trang -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Quản lý Danh mục Tour</h1>
      <a href="<?= UrlHelper::route('admin/tours/createCategory') ?>">
        <button id="addTourBtn" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-plus mr-2"></i> Thêm Danh mục mới
        </button>
      </a>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <!-- Bộ lọc và tìm kiếm danh mục -->
    <div
      class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
      <div class="border-b border-gray-100 bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
        <h3 class="text-lg font-medium text-white flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          Tìm kiếm và lọc danh mục
        </h3>
      </div>

      <form method="GET" action="<?= UrlHelper::route('admin/tours/categories') ?>" class="px-6 py-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
          <!-- Status Filter -->
          <div class="md:col-span-3">
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
                <option value="active" <?= ($filters['status'] == 'active') ? 'selected' : '' ?>>Đang hoạt động</option>
                <option value="inactive" <?= ($filters['status'] == 'inactive') ? 'selected' : '' ?>>Tạm ngưng</option>
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
          <div class="md:col-span-5">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1.5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Tìm kiếm
            </label>
            <div class="relative">
              <input type="text" id="search" name="search" placeholder="Nhập tên danh mục..."
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

          <!-- Filter Actions -->
          <div class="md:col-span-4 flex items-end space-x-2">
            <div class="relative">
              <select name="limit"
                class="rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 text-gray-700 appearance-none shadow-sm">
                <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10 mục</option>
                <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25 mục</option>
                <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50 mục</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>

            <div class="flex space-x-2 h-[42px]">
              <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-medium px-4 rounded-lg transition-all duration-200 shadow-sm flex items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Áp dụng
              </button>

              <a href="<?= UrlHelper::route('admin/tours/categories') ?>"
                class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-4 rounded-lg transition-all duration-200 flex items-center justify-center border border-gray-200 h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="ml-2 sr-only md:not-sr-only">Đặt lại</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Show active filter count -->
        <?php
        $activeFilters = 0;
        if (!empty($filters['status'])) $activeFilters++;
        if (!empty($filters['search'])) $activeFilters++;
        ?>

        <?php if ($activeFilters > 0): ?>
        <div class="mt-4 text-sm text-gray-500">
          <span class="bg-teal-100 text-teal-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
            <?= $activeFilters ?> bộ lọc đang áp dụng
          </span>
        </div>
        <?php endif; ?>
      </form>
    </div>

    <!-- Compact Filter Section for Mobile -->
    <div class="md:hidden bg-white rounded-xl shadow-sm mb-6 border border-gray-100 overflow-hidden">
      <div class="p-4">
        <button type="button" id="toggleCategoryFilter"
          class="w-full flex items-center justify-between text-gray-700 font-medium">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Tìm kiếm và lọc danh mục
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform" id="categoryFilterIcon"
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

    <!-- Compact Filter Section for Mobile -->
    <div class="md:hidden bg-white rounded-xl shadow-sm mb-6 border border-gray-100 overflow-hidden">
      <div class="p-4">
        <button type="button" id="toggleCategoryFilter"
          class="w-full flex items-center justify-between text-gray-700 font-medium">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Tìm kiếm và lọc danh mục
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform" id="categoryFilterIcon"
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

    <!-- Bảng danh sách danh mục với scroll horizontal -->
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
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'name', 'direction' => ($sort == 'name' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  Tên danh mục
                  <?php if ($sort == 'name'): ?>
                  <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                  <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Mô tả
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <a href="<?= UrlHelper::buildQueryString(['sort' => 'status', 'direction' => ($sort == 'status' && $direction == 'asc') ? 'desc' : 'asc']) ?>"
                  class="flex items-center">
                  Trạng thái
                  <?php if ($sort == 'status'): ?>
                  <i class="fas fa-sort-<?= ($direction == 'asc') ? 'up' : 'down' ?> ml-1"></i>
                  <?php else: ?>
                  <i class="fas fa-sort ml-1 text-gray-300"></i>
                  <?php endif; ?>
                </a>
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
            <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $item): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?= $item["id"] ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php if (!empty($item["image"])): ?>
                <img src="<?= $item["image"] ?>" alt="<?= $item["name"] ?>" style='width: 50px; height: 50px'
                  class="object-cover rounded">
                <?php else: ?>
                <div class="w-[50px] h-[50px] bg-gray-200 rounded flex items-center justify-center">
                  <i class="fas fa-image text-gray-400"></i>
                </div>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900"><?= $item["name"] ?></div>
                <div class="text-xs text-gray-500"><?= $item["slug"] ?? '' ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?= mb_strimwidth($item["description"] ?? '', 0, 50, "...") ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php
                    $statusClass = $item['status'] === 'active'
                      ? 'bg-green-100 text-green-800'
                      : 'bg-red-100 text-red-800';

                    $statusLabel = $item['status'] === 'active'
                      ? 'Hoạt động'
                      : 'Tạm ngưng';
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
                  <a href="<?= UrlHelper::route('admin/tours/updateCategory/' . $item['id']) ?>">
                    <button class="text-teal-600 hover:text-teal-900">
                      <i class="fas fa-edit"></i>
                    </button>
                  </a>
                  <a href="<?= UrlHelper::route('admin/tours/deleteCategory/' . $item['id']) ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                    <button class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash"></i>
                    </button>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                Không tìm thấy danh mục nào.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Phân trang -->
      <?php if (!empty($pagination) && $pagination['total'] > 0): ?>
      <div class="px-6 py-4 bg-white border-t border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="text-sm text-gray-600 mb-4 sm:mb-0">
            Hiển thị <?= $pagination['from'] ?> đến <?= $pagination['to'] ?> trong số <?= $pagination['total'] ?> danh
            mục
          </div>

          <!-- Các nút phân trang -->
          <div class="flex flex-wrap items-center space-x-1">
            <?php if ($pagination['has_prev_page']): ?>
            <a href="<?= UrlHelper::buildQueryString(['page' => $pagination['current_page'] - 1]) ?>"
              class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
              &laquo; Trước
            </a>
            <?php endif; ?>

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
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
// Toggle category filter
document.getElementById('toggleCategoryFilter')?.addEventListener('click', function() {
  const filterSection = document.querySelector('.category-filter-section');
  const icon = document.getElementById('categoryFilterIcon');

  if (filterSection) {
    filterSection.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
  }
});
</script>
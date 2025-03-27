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
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
      <form method="GET" action="<?= UrlHelper::route('admin/tours/categories') ?>">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="col-span-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select id="status" name="status"
              class="w-full rounded-md focus:outline-none p-2 border-2 border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
              <option value="">Tất cả trạng thái</option>
              <option value="active" <?= ($filters['status'] == 'active') ? 'selected' : '' ?>>Đang hoạt động</option>
              <option value="inactive" <?= ($filters['status'] == 'inactive') ? 'selected' : '' ?>>Tạm ngưng</option>
            </select>
          </div>
          <div class="col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
            <div class="relative">
              <input type="text" id="search" name="search" placeholder="Nhập tên danh mục..."
                value="<?= $filters['search'] ?? '' ?>"
                class="w-full rounded-md focus:outline-none p-2 border-2 border-gray-150 shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20 pl-10">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
              </div>
            </div>
          </div>
          <div class="col-span-1 flex items-end">
            <div class="w-full">
              <select name="limit" class="rounded-md focus:outline-none p-2 border-2 border-gray-150">
                <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10 mục</option>
                <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25 mục</option>
                <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50 mục</option>
              </select>
              <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded ml-2">
                <i class="fas fa-filter mr-2"></i> Lọc
              </button>
              <a href="<?= UrlHelper::route('admin/tours/categories') ?>"
                class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold h-full py-2 px-4 rounded">
                <i class="fas fa-sync-alt mr-2"></i>
              </a>
            </div>
          </div>
        </div>
      </form>
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
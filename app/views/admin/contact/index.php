<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;
?>

<div>
  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold text-gray-800">Quản Lý Liên Hệ</h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
      <form action="<?= UrlHelper::route('admin/contacts') ?>" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <div class="relative">
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
              placeholder="Tìm kiếm theo tên, email, số điện thoại..."
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
          </div>
        </div>
        <div class="flex gap-4">
          <select name="status"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            <option value="">Tất cả trạng thái</option>
            <option value="new" <?= isset($_GET['status']) && $_GET['status'] === 'new' ? 'selected' : '' ?>>Mới
            </option>
            <option value="read" <?= isset($_GET['status']) && $_GET['status'] === 'read' ? 'selected' : '' ?>>Đã đọc
            </option>
            <option value="replied" <?= isset($_GET['status']) && $_GET['status'] === 'replied' ? 'selected' : '' ?>>Đã
              trả lời</option>
            <option value="archived" <?= isset($_GET['status']) && $_GET['status'] === 'archived' ? 'selected' : '' ?>>
              Lưu trữ</option>
          </select>
          <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-filter mr-2"></i>
            <span>Lọc</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Contacts Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tên
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Số điện thoại
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tiêu đề
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Trạng thái
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
            <?php foreach ($contacts as $contact): ?>
              <tr class="hover:bg-gray-50 <?= $contact['status'] === 'new' ? 'font-semibold' : '' ?>">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900"><?= htmlspecialchars($contact['id']) ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($contact['name'] ?? '') ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900"><?= htmlspecialchars($contact['email'] ?? '') ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900"><?= htmlspecialchars($contact['phone'] ?? '') ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 truncate max-w-[150px]"
                    title="<?= htmlspecialchars($contact['subject'] ?? '') ?>">
                    <?= htmlspecialchars($contact['subject'] ?? '') ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $contact['status'] === 'new' ? 'bg-yellow-100 text-yellow-800' : ($contact['status'] === 'read' ? 'bg-blue-100 text-blue-800' : ($contact['status'] === 'replied' ? 'bg-green-100 text-green-800' :
                                      'bg-gray-100 text-gray-800')) ?>">
                    <?= htmlspecialchars($this->getStatusLabel($contact['status'] ?? '')) ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-500"><?= FormatHelper::formatDate($contact['created_at'] ?? '') ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <a href="<?= UrlHelper::route('admin/contacts/view/') ?><?= $contact['id'] ?>"
                      class="text-teal-500 hover:text-teal-700" title="Xem chi tiết">
                      <i class="fas fa-eye"></i>
                    </a>

                    <?php if ($contact['status'] === 'new'): ?>
                      <form action="<?= UrlHelper::route('admin/contacts/mark-read') ?>" method="POST" class="inline">
                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                        <button type="submit" class="text-blue-500 hover:text-blue-700" title="Đánh dấu đã đọc">
                          <i class="fas fa-check"></i>
                        </button>
                      </form>
                    <?php endif; ?>

                    <?php if ($contact['status'] !== 'archived'): ?>
                      <form action="<?= UrlHelper::route('admin/contacts/archive') ?>" method="POST" class="inline">
                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Lưu trữ">
                          <i class="fas fa-archive"></i>
                        </button>
                      </form>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination Component (if needed) -->
    <?php if (isset($pagination)): ?>
      <div class="bg-white rounded-lg shadow-sm p-4 mt-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center gap-4">
            <!-- Results info -->
            <p class="text-sm text-gray-700 mb-4 md:mb-0">
              Hiển thị <span class="font-medium"><?= $pagination['from'] ?></span>
              đến <span class="font-medium"><?= $pagination['to'] ?></span>
              trong <span class="font-medium"><?= $pagination['total'] ?></span> kết quả
            </p>
            <!-- Per page selector -->
            <div class="flex justify-end">
              <form action="<?= UrlHelper::route('admin/contacts') ?>" method="GET" class="flex items-center space-x-2">
                <!-- Preserve existing query parameters -->
                <?php foreach ($_GET as $key => $value): ?>
                  <?php if ($key !== 'limit' && $key !== 'page'): ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>">
                  <?php endif; ?>
                <?php endforeach; ?>

                <label for="limit" class="text-sm text-gray-600">Hiển thị:</label>
                <select id="limit" name="limit" onchange="this.form.submit()"
                  class="form-select rounded-md border-gray-300 text-sm py-1 pl-2 pr-8 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                  <option value="10" <?= ($pagination['per_page'] == 10) ? 'selected' : '' ?>>10</option>
                  <option value="25" <?= ($pagination['per_page'] == 25) ? 'selected' : '' ?>>25</option>
                  <option value="50" <?= ($pagination['per_page'] == 50) ? 'selected' : '' ?>>50</option>
                  <option value="100" <?= ($pagination['per_page'] == 100) ? 'selected' : '' ?>>100</option>
                </select>
              </form>
            </div>
          </div>
          <!-- Pagination links -->
          <div class="flex items-center space-x-1">
            <?php
            // Previous page link
            if ($pagination['has_prev_page']):
              $prevUrl = UrlHelper::route('admin/contacts') . '?' . http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] - 1]));
            ?>
              <a href="<?= $prevUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-chevron-left text-xs"></i>
              </a>
            <?php else: ?>
              <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
                <i class="fas fa-chevron-left text-xs"></i>
              </span>
            <?php endif; ?>

            <!-- Page number links -->
            <?php
            $visiblePages = 5; // Number of page links to show
            $startPage = max(1, min($pagination['current_page'] - floor($visiblePages / 2), $pagination['total_pages'] - $visiblePages + 1));
            $startPage = max(1, $startPage);
            $endPage = min($startPage + $visiblePages - 1, $pagination['total_pages']);

            for ($i = $startPage; $i <= $endPage; $i++):
              $pageUrl = UrlHelper::route('admin/contacts') . '?' . http_build_query(array_merge($_GET, ['page' => $i]));
              $isCurrentPage = $i === $pagination['current_page'];
            ?>
              <?php if ($isCurrentPage): ?>
                <span class="px-3 py-1 rounded-md text-sm bg-teal-500 text-white font-medium">
                  <?= $i ?>
                </span>
              <?php else: ?>
                <a href="<?= $pageUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
                  <?= $i ?>
                </a>
              <?php endif; ?>
            <?php endfor; ?>

            <!-- Next page link -->
            <?php
            if ($pagination['has_next_page']):
              $nextUrl = UrlHelper::route('admin/contacts') . '?' . http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] + 1]));
            ?>
              <a href="<?= $nextUrl ?>" class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-chevron-right text-xs"></i>
              </a>
            <?php else: ?>
              <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
                <i class="fas fa-chevron-right text-xs"></i>
              </span>
            <?php endif; ?>
          </div>
        </div>


      </div>
    <?php endif; ?>
  </main>
</div>
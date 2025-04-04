<?php

use App\Helpers\UrlHelper;

$title = 'Quản lý địa điểm';
?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Breadcrumb + Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
      <div>
        <div class="flex items-center text-sm text-gray-500 mb-2">
          <a href="<?= UrlHelper::route('admin/dashboard') ?>" class="hover:text-teal-600">Dashboard</a>
          <span class="mx-2">/</span>
          <span>Quản lý địa điểm</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Danh sách địa điểm</h1>
      </div>

      <div class="mt-4 md:mt-0">
        <a href="<?= UrlHelper::route('admin/locations/create') ?>"
          class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded shadow-sm flex items-center justify-center">
          <i class="fas fa-plus mr-2"></i> Thêm địa điểm mới
        </a>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6 p-4 border border-gray-200">
      <form action="<?= UrlHelper::route('admin/locations') ?>" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Search -->
          <div class="col-span-1 md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
            <div class="relative">
              <input type="text" name="search" id="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                placeholder="Tìm theo tên, mô tả..."
                class="w-full rounded-md border border-gray-300 pl-10 pr-4 py-2 focus:border-teal-500 focus:ring-teal-500">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
              </div>
              <?php if (!empty($filters['search'])): ?>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <a href="<?= UrlHelper::route('admin/locations', array_diff_key($filters, ['search' => ''])) ?>"
                    class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Region Filter -->
          <div class="col-span-1">
            <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Khu vực</label>
            <div class="relative">
              <select name="region" id="region"
                class="w-full h-full rounded-md border border-gray-300 pl-10 pr-4 py-2 focus:border-teal-500 focus:ring-teal-500"
                onchange="this.form.submit()">
                <option value="">Tất cả khu vực</option>
                <?php foreach ($regions as $region): ?>
                  <option value="<?= htmlspecialchars($region) ?>"
                    <?= ($filters['region'] ?? '') == $region ? 'selected' : '' ?>>
                    <?= htmlspecialchars($region) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-globe-asia text-gray-400"></i>
              </div>
            </div>
          </div>

          <!-- Country Filter -->
          <div class="col-span-1">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Quốc gia</label>
            <div class="relative">
              <select name="country" id="country"
                class="w-full rounded-md border border-gray-300 pl-10 pr-4 py-2 focus:border-teal-500 focus:ring-teal-500"
                onchange="this.form.submit()" <?= empty($filters['region']) ? 'disabled' : '' ?>>
                <option value="">Tất cả quốc gia</option>
                <?php foreach ($countries as $country): ?>
                  <option value="<?= htmlspecialchars($country) ?>"
                    <?= ($filters['country'] ?? '') == $country ? 'selected' : '' ?>>
                    <?= htmlspecialchars($country) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-flag text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Active Filters & Submit -->
        <div class="flex justify-between items-center pt-2">
          <div class="flex flex-wrap gap-2">
            <?php if (!empty($filters['region']) || !empty($filters['country']) || !empty($filters['search'])): ?>
              <?php if (!empty($filters['search'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  Tìm kiếm: <?= htmlspecialchars($filters['search']) ?>
                  <a href="<?= UrlHelper::route('admin/locations', array_diff_key($filters, ['search' => ''])) ?>"
                    class="ml-1 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times-circle"></i>
                  </a>
                </span>
              <?php endif; ?>

              <?php if (!empty($filters['region'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  Khu vực: <?= htmlspecialchars($filters['region']) ?>
                  <a href="<?= UrlHelper::route('admin/locations', array_diff_key($filters, ['region' => '', 'country' => ''])) ?>"
                    class="ml-1 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times-circle"></i>
                  </a>
                </span>
              <?php endif; ?>

              <?php if (!empty($filters['country'])): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  Quốc gia: <?= htmlspecialchars($filters['country']) ?>
                  <a href="<?= UrlHelper::route('admin/locations', array_diff_key($filters, ['country' => '']) + ['region' => $filters['region']]) ?>"
                    class="ml-1 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times-circle"></i>
                  </a>
                </span>
              <?php endif; ?>

              <a href="<?= UrlHelper::route('admin/locations') ?>" class="text-teal-600 hover:text-teal-800 text-sm">
                <i class="fas fa-times mr-1"></i> Xóa bộ lọc
              </a>
            <?php else: ?>
              <span class="text-sm text-gray-500">Không có bộ lọc nào được áp dụng</span>
            <?php endif; ?>
          </div>

          <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded shadow-sm">
            <i class="fas fa-search mr-1"></i> Tìm kiếm
          </button>
        </div>
      </form>
    </div>

    <!-- Locations Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="px-4 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-medium text-gray-800">Danh sách địa điểm</h2>

        <div class="text-sm text-gray-600">
          Hiển thị từ <?= $pagination['from'] ?> đến <?= $pagination['to'] ?> trên tổng số <?= $pagination['total'] ?>
          địa điểm
        </div>
      </div>

      <?php if (empty($locations)): ?>
        <div class="p-8 text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
            <i class="fas fa-map-marker-alt text-gray-500 text-2xl"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-1">Không tìm thấy địa điểm nào</h3>
          <p class="text-gray-500">Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên
                  địa điểm</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Quốc gia</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khu
                  vực</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tọa độ</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Thao tác</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($locations as $location): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= $location['id'] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <?php if (!empty($location['image'])): ?>
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-md object-cover" src="<?= $location['image'] ?>"
                            alt="<?= htmlspecialchars($location['image']) ?>">
                        </div>
                      <?php else: ?>
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                          <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                      <?php endif; ?>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($location['name']) ?></div>
                        <div class="text-sm text-gray-500 truncate max-w-md">
                          <?= htmlspecialchars(substr($location['description'] ?? '', 0, 60)) ?><?= strlen($location['description'] ?? '') > 60 ? '...' : '' ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= htmlspecialchars($location['country']) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= htmlspecialchars($location['region']) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                    <?php if (!empty($location['latitude']) && !empty($location['longitude'])): ?>
                      <span class="text-xs text-gray-500">
                        <?= number_format($location['latitude'], 6) ?>, <?= number_format($location['longitude'], 6) ?>
                      </span>
                    <?php else: ?>
                      <span class="text-xs text-gray-400">Không có</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right space-x-2">
                    <a href="<?= UrlHelper::route('admin/locations/edit/' . $location['id']) ?>"
                      class="text-blue-600 hover:text-blue-900">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= UrlHelper::route('admin/locations/show/' . $location['id']) ?>"
                      class="text-gray-600 hover:text-gray-900">
                      <i class="fas fa-eye"></i>
                    </a>
                    <button onclick="confirmDelete(<?= $location['id'] ?>, '<?= addslashes($location['name']) ?>')"
                      class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <!-- Pagination -->
      <div class="bg-white rounded-lg shadow-sm p-4 mt-6 border border-gray-200">
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
              <form action="<?= UrlHelper::route('admin/locations') ?>" method="GET"
                class="flex items-center space-x-2">
                <!-- Preserve existing query parameters -->
                <?php foreach ($filters as $key => $value): ?>
                  <?php if ($key !== 'limit' && $key !== 'page' && !empty($value)): ?>
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
              $prevUrl = UrlHelper::route('admin/locations') . '?' . http_build_query(array_merge(
                array_filter($filters),
                ['page' => $pagination['current_page'] - 1]
              ));
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
              $pageUrl = UrlHelper::route('admin/locations') . '?' . http_build_query(array_merge(
                array_filter($filters),
                ['page' => $i]
              ));
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
              $nextUrl = UrlHelper::route('admin/locations') . '?' . http_build_query(array_merge(
                array_filter($filters),
                ['page' => $pagination['current_page'] + 1]
              ));
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
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
  aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Xác nhận xóa địa điểm
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Bạn có chắc chắn muốn xóa địa điểm "<span id="deleteLocationName"></span>"? Hành động này không thể hoàn
                tác.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <form id="deleteForm" action="" method="POST">
          <button type="submit"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Xóa
          </button>
        </form>
        <button type="button" onclick="closeDeleteModal()"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Hủy
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Functions to handle delete confirmation modal
  function confirmDelete(id) {
    document.getElementById('deleteLocationName').textContent = name;
    document.getElementById('deleteForm').action = '<?= UrlHelper::route('admin/locations/delete') ?>/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
  }

  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('deleteModal')) {
      closeDeleteModal();
    }
  });

  // Region change to update countries dropdown
  document.getElementById('region').addEventListener('change', function() {
    const countrySelect = document.getElementById('country');
    if (this.value === '') {
      countrySelect.disabled = true;
      countrySelect.value = '';
    } else {
      countrySelect.disabled = false;
    }
    this.form.submit();
  });
</script>

<?php
// Helper functions
function getStatusBadge($status)
{
  if ($status === 'active') {
    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hoạt động</span>';
  } else {
    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Vô hiệu</span>';
  }
}
?>
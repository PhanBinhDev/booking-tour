<?php
// filepath: c:\xampp\htdocs\project\app\views\admin\locations\show.php
use App\Helpers\UrlHelper;
use App\Helpers\CloudinaryHelper;
use App\Helpers\FormatHelper;

$title = 'Chi tiết địa điểm';
?>

<!-- Thêm CSS của Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.js"></script>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Breadcrumb + Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
      <div>
        <div class="flex items-center text-sm text-gray-500 mb-2">
          <a href="<?= UrlHelper::route('admin/dashboard') ?>" class="hover:text-teal-600">Dashboard</a>
          <span class="mx-2">/</span>
          <a href="<?= UrlHelper::route('admin/locations') ?>" class="hover:text-teal-600">Quản lý địa điểm</a>
          <span class="mx-2">/</span>
          <span>Chi tiết</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
          <?= htmlspecialchars($location['name']) ?>
        </h1>
      </div>

      <div class="mt-4 md:mt-0">
        <div class="flex space-x-3">
          <a href="<?= UrlHelper::route('admin/locations') ?>"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow-sm flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
          </a>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Info Column -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden border border-gray-200">
          <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-800">Thông tin địa điểm</h2>
            <span
              class="<?= $location['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?> px-3 py-1 rounded-full text-xs font-medium">
              <?= $location['status'] === 'active' ? 'Hoạt động' : 'Vô hiệu' ?>
            </span>
          </div>

          <div class="p-6">
            <!-- Thumbnail -->
            <?php if (!empty($location['thumbnail'])): ?>
              <div class="mb-6">
                <div class="w-full h-52 rounded-lg overflow-hidden bg-gray-100">
                  <img
                    src="<?= CloudinaryHelper::getImageUrl('locations', $location['slug'], ['width' => 800, 'height' => 400, 'crop' => 'fill']) ?>"
                    alt="<?= htmlspecialchars($location['name']) ?>" class="w-full h-full object-cover"
                    onerror="this.onerror=null; this.src='https://placeholder.co/800x400?text=No+Image';">
                </div>
              </div>
            <?php endif; ?>

            <!-- Location Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Basic Info -->
              <div>
                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Tên địa điểm</h3>
                  <p class="mt-1 text-base text-gray-900"><?= htmlspecialchars($location['name']) ?></p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Slug</h3>
                  <p class="mt-1 text-base text-gray-900 font-mono"><?= htmlspecialchars($location['slug']) ?></p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Khu vực</h3>
                  <p class="mt-1 text-base text-gray-900"><?= htmlspecialchars($location['region']) ?></p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Quốc gia</h3>
                  <p class="mt-1 text-base text-gray-900"><?= htmlspecialchars($location['country']) ?></p>
                </div>
              </div>

              <!-- Additional Info -->
              <div>
                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Vĩ độ (Latitude)</h3>
                  <p class="mt-1 text-base text-gray-900 font-mono">
                    <?= !empty($location['latitude']) ? htmlspecialchars($location['latitude']) : '<span class="text-gray-400">Chưa thiết lập</span>' ?>
                  </p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Kinh độ (Longitude)</h3>
                  <p class="mt-1 text-base text-gray-900 font-mono">
                    <?= !empty($location['longitude']) ? htmlspecialchars($location['longitude']) : '<span class="text-gray-400">Chưa thiết lập</span>' ?>
                  </p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">URL</h3>
                  <p class="mt-1 text-base text-gray-900">
                    <?php if (!empty($location['url'])): ?>
                      <a href="<?= htmlspecialchars($location['url']) ?>" target="_blank"
                        class="text-blue-600 hover:text-blue-800 hover:underline">
                        <?= htmlspecialchars($location['url']) ?> <i class="fas fa-external-link-alt text-xs ml-1"></i>
                      </a>
                    <?php else: ?>
                      <span class="text-gray-400">Chưa thiết lập</span>
                    <?php endif; ?>
                  </p>
                </div>

                <div class="mb-4">
                  <h3 class="text-sm font-medium text-gray-500">Ngày tạo</h3>
                  <p class="mt-1 text-base text-gray-900">
                    <?= !empty($location['created_at']) ? FormatHelper::formatDate($location['created_at']) : 'N/A' ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- Image -->
            <?php if (!empty($location['image'])): ?>
              <div class="mb-6">
                <div class="w-full h-52 rounded-lg overflow-hidden bg-gray-100">
                  <img src="<?= htmlspecialchars($location['image']) ?>" alt="<?= htmlspecialchars($location['name']) ?>"
                    class="w-full h-full object-cover"
                    onerror="this.onerror=null; this.src='https://placeholder.co/800x400?text=No+Image';">
                </div>
              </div>
            <?php endif; ?>

            <!-- Description -->
            <div class="mt-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Mô tả</h3>
              <div class="p-4 bg-gray-50 rounded-md prose prose-sm max-w-none">
                <?php if (!empty($location['description'])): ?>
                  <?= nl2br(htmlspecialchars($location['description'])) ?>
                <?php else: ?>
                  <p class="text-gray-400 italic">Không có mô tả</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Map Section -->
        <?php if (!empty($location['latitude']) && !empty($location['longitude'])): ?>
          <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
              <h2 class="text-lg font-medium text-gray-800">Vị trí bản đồ</h2>
            </div>

            <div style="height: 400px; width: 100%; position: relative;">
              <div id="map" style="position: absolute; top: 0; bottom: 0; width: 100%;"></div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1">
        <!-- Meta Info Card -->
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden border border-gray-200">
          <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Thông tin mở rộng</h2>
          </div>

          <div class="p-6">
            <dl>
              <div class="mb-4">
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900 font-mono"><?= $location['id'] ?></dd>
              </div>

              <div class="mb-4">
                <dt class="text-sm font-medium text-gray-500">Trạng thái</dt>
                <dd class="mt-1">
                  <?php if ($location['status'] === 'active'): ?>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      <div class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></div>
                      Hoạt động
                    </span>
                  <?php else: ?>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      <div class="w-2 h-2 bg-gray-500 rounded-full mr-1.5"></div>
                      Vô hiệu
                    </span>
                  <?php endif; ?>
                </dd>
              </div>

              <div class="mb-4">
                <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  <?= !empty($location['created_at']) ? FormatHelper::formatDate($location['created_at']) : 'N/A' ?>
                </dd>
              </div>

              <div class="mb-4">
                <dt class="text-sm font-medium text-gray-500">Cập nhật lần cuối</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  <?= !empty($location['updated_at']) ? FormatHelper::formatDate($location['updated_at']) : 'N/A' ?>
                </dd>
              </div>

              <?php if (!empty($location['created_by'])): ?>
                <div class="mb-4">
                  <dt class="text-sm font-medium text-gray-500">Tạo bởi</dt>
                  <dd class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($location['created_by']) ?></dd>
                </div>
              <?php endif; ?>

              <?php if (!empty($location['updated_by'])): ?>
                <div class="mb-4">
                  <dt class="text-sm font-medium text-gray-500">Cập nhật bởi</dt>
                  <dd class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($location['updated_by']) ?></dd>
                </div>
              <?php endif; ?>
            </dl>
          </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
          <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Hành động</h2>
          </div>

          <div class="p-6 space-y-4">
            <a href="<?= UrlHelper::route('admin/locations/edit/' . $location['id']) ?>"
              class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              <i class="fas fa-edit mr-2"></i> Chỉnh sửa
            </a>

            <button type="button"
              onclick="confirmDelete(<?= $location['id'] ?>, '<?= addslashes($location['name']) ?>')"
              class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
              <i class="fas fa-trash-alt mr-2"></i> Xóa
            </button>

            <?php if ($location['status'] === 'active'): ?>
              <form action="<?= UrlHelper::route('admin/locations/change-status/' . $location['id']) ?>" method="POST">
                <input type="hidden" name="status" value="inactive">
                <button type="submit"
                  class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                  <i class="fas fa-ban mr-2"></i> Vô hiệu hóa
                </button>
              </form>
            <?php else: ?>
              <form action="<?= UrlHelper::route('admin/locations/change-status/' . $location['id']) ?>" method="POST">
                <input type="hidden" name="status" value="active">
                <button type="submit"
                  class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                  <i class="fas fa-check-circle mr-2"></i> Kích hoạt
                </button>
              </form>
            <?php endif; ?>

            <!-- Additional actions could go here -->
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
  // Khởi tạo map nếu có tọa độ
  <?php if (!empty($location['latitude']) && !empty($location['longitude'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
      // Thiết lập access token
      mapboxgl.accessToken =
        'pk.eyJ1IjoiYmluaGRldiIsImEiOiJjbHduODEzNXMweWxrMmltanU3M3Voc3IxIn0.oZ19gfygIANckV1rAPGXuw';

      // Lấy tọa độ
      const lat = <?= (float)$location['latitude'] ?>;
      const lng = <?= (float)$location['longitude'] ?>;

      // Khởi tạo map
      const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lng, lat],
        zoom: 14
      });

      // Thêm controls
      map.addControl(new mapboxgl.NavigationControl(), 'top-right');

      // Thêm marker
      const popup = new mapboxgl.Popup({
          offset: 25
        })
        .setHTML(`<h3 class="font-medium text-sm"><?= addslashes($location['name']) ?></h3>`);

      new mapboxgl.Marker({
          color: "#e53e3e"
        })
        .setLngLat([lng, lat])
        .setPopup(popup)
        .addTo(map);
    });
  <?php endif; ?>

  // Xử lý modal xóa
  function confirmDelete(id, name) {
    document.getElementById('deleteLocationName').textContent = name;
    document.getElementById('deleteForm').action = '<?= UrlHelper::route('admin/locations/delete') ?>/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
  }
</script>
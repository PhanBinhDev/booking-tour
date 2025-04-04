<?php
// filepath: c:\xampp\htdocs\project\app\views\admin\locations\edit.php
use App\Helpers\UrlHelper;
use App\Helpers\CloudinaryHelper;

$title = 'Chỉnh sửa địa điểm';
?>

<!-- Thêm CSS của Mapbox -->

<head>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= UrlHelper::css('mapbox.css') ?>">
</head>

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
          <span>Chỉnh sửa</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
          Chỉnh sửa địa điểm: <?= htmlspecialchars($location['name']) ?>
        </h1>
      </div>

      <div class="mt-4 md:mt-0">
        <a href="<?= UrlHelper::route('admin/locations') ?>"
          class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow-sm flex items-center">
          <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden border border-gray-200">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">Thông tin địa điểm</h2>
      </div>

      <form action="<?= UrlHelper::route('admin/locations/update/' . $location['id']) ?>" method="POST" class="p-6"
        enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Tên địa điểm -->
          <div class="col-span-1">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1 required">Tên địa điểm</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($location['name']) ?>" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tên hiển thị của địa điểm</p>
          </div>

          <!-- Slug -->
          <div class="col-span-1">
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1 required">Slug</label>
            <input type="text" name="slug" id="slug" value="<?= htmlspecialchars($location['slug']) ?>" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Được sử dụng trong URL, chỉ chứa chữ thường, số và dấu gạch ngang</p>
          </div>

          <!-- Khu vực -->
          <div class="col-span-1">
            <label for="region" class="block text-sm font-medium text-gray-700 mb-1 required">Khu vực</label>
            <input type="text" name="region" id="region" value="<?= htmlspecialchars($location['region']) ?>" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Khu vực địa lý (châu lục, miền)</p>
          </div>

          <!-- Quốc gia -->
          <div class="col-span-1">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1 required">Quốc gia</label>
            <input type="text" name="country" id="country" value="<?= htmlspecialchars($location['country']) ?>"
              required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Quốc gia của địa điểm</p>
          </div>

          <!-- Vĩ độ (latitude) -->
          <div class="col-span-1">
            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Vĩ độ (Latitude)</label>
            <input type="text" name="latitude" id="latitude"
              value="<?= htmlspecialchars($location['latitude'] ?? '') ?>" placeholder="Ví dụ: 21.0278"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tọa độ vĩ độ của địa điểm</p>
          </div>

          <!-- Kinh độ (longitude) -->
          <div class="col-span-1">
            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Kinh độ (Longitude)</label>
            <input type="text" name="longitude" id="longitude"
              value="<?= htmlspecialchars($location['longitude'] ?? '') ?>" placeholder="Ví dụ: 105.8342"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tọa độ kinh độ của địa điểm</p>
          </div>

          <!-- Thumbnail -->
          <div class="col-span-1">
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh đại diện</label>
            <div class="flex items-center space-x-4">
              <?php if (!empty($location['thumbnail'])): ?>
                <div class="w-24 h-24 border rounded-md overflow-hidden bg-gray-100">
                  <img src="<?= CloudinaryHelper::getPlaceholder() ?>" alt="<?= htmlspecialchars($location['name']) ?>"
                    class="w-full h-full object-cover"
                    onerror="this.onerror=null; this.src='https://placeholder.co/200?text=No+Image';">
                </div>
              <?php endif; ?>
              <div class="flex-1">
                <input type="file" name="thumbnail" id="thumbnail"
                  class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-teal-500 focus:border-teal-500">
                <p class="mt-1 text-sm text-gray-500">Chọn hình ảnh đại diện mới (để trống nếu không muốn thay đổi)</p>
              </div>
            </div>
          </div>

          <!-- Trạng thái -->
          <div class="col-span-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1 required">Trạng thái</label>
            <select name="status" id="status"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
              <option value="active" <?= $location['status'] == 'active' ? 'selected' : '' ?>>Hoạt động</option>
              <option value="inactive" <?= $location['status'] == 'inactive' ? 'selected' : '' ?>>Vô hiệu</option>
            </select>
            <p class="mt-1 text-sm text-gray-500">Trạng thái của địa điểm</p>
          </div>

          <!-- URL -->
          <div class="col-span-2">
            <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
            <input type="text" name="url" id="url" value="<?= htmlspecialchars($location['url'] ?? '') ?>"
              placeholder="https://example.com/locations/hanoi"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">URL trang web chính thức của địa điểm (nếu có)</p>
          </div>

          <!-- Mô tả -->
          <div class="col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="6"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500"><?= htmlspecialchars($location['description'] ?? '') ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Mô tả chi tiết về địa điểm</p>
          </div>
        </div>

        <!-- Map Preview -->
        <div class="mt-6 border rounded-md overflow-hidden" id="map-section">
          <div class="px-4 py-2 bg-gray-50 border-b">
            <h3 class="font-medium">Bản đồ</h3>
            <p class="text-xs text-gray-500 mt-1">Bạn có thể click vào bản đồ để cập nhật tọa độ</p>
          </div>
          <div class="h-[500px] relative" id="map-container">
            <div id="map" class="absolute inset-0"></div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex items-center justify-end space-x-3">
          <a href="<?= UrlHelper::route('admin/locations') ?>"
            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Hủy
          </a>
          <button type="submit"
            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Cập nhật
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Thiết lập token Mapbox
    mapboxgl.accessToken =
      'pk.eyJ1IjoiYmluaGRldiIsImEiOiJjbHduODEzNXMweWxrMmltanU3M3Voc3IxIn0.oZ19gfygIANckV1rAPGXuw';

    // Lấy tọa độ từ các trường input
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    // Sử dụng giá trị mặc định nếu không có tọa độ
    const lat = parseFloat(latInput.value) || 21.0278; // Hà Nội mặc định
    const lng = parseFloat(lngInput.value) || 105.8342;

    // Khởi tạo map với cấu hình đơn giản
    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: [lng, lat], // Mapbox dùng [lng, lat] không phải [lat, lng]
      zoom: 12
    });
    // Thêm control điều hướng
    map.addControl(new mapboxgl.NavigationControl());

    map.on('style.load', () => {
      map.setFog({}); // Set the default atmosphere style
    });

    // Tạo marker có thể kéo
    const marker = new mapboxgl.Marker({
        color: "#e53e3e",
        draggable: true
      })
      .setLngLat([lng, lat])
      .addTo(map);

    // Cập nhật tọa độ khi kéo thả marker
    marker.on('dragend', function() {
      console.log(marker.getLngLat());
      const lngLat = marker.getLngLat();
      latInput.value = lngLat.lat.toFixed(6);
      lngInput.value = lngLat.lng.toFixed(6);
    });

    // Cập nhật marker khi click vào map
    map.on('click', function(e) {
      marker.setLngLat(e.lngLat);
      latInput.value = e.lngLat.lat.toFixed(6);
      lngInput.value = e.lngLat.lng.toFixed(6);
    });

    // Cập nhật marker khi thay đổi các trường input
    function updateMarker() {
      const lat = parseFloat(latInput.value);
      const lng = parseFloat(lngInput.value);

      if (!isNaN(lat) && !isNaN(lng)) {
        marker.setLngLat([lng, lat]);
        map.flyTo({
          center: [lng, lat],
          zoom: 12,
          essential: true // Đảm bảo animation diễn ra
        });
      }
    }

    // Thêm event listeners
    latInput.addEventListener('change', updateMarker);
    lngInput.addEventListener('change', updateMarker);

    // Auto-generate slug từ tên
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', function() {
      if (!slugInput.dataset.userModified || slugInput.dataset.userModified === 'false') {
        slugInput.value = this.value
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '')
          .toLowerCase()
          .replace(/[^a-z0-9]+/g, '-')
          .replace(/^-+|-+$/g, '');
      }
    });

    slugInput.addEventListener('input', function() {
      slugInput.dataset.userModified = 'true';
    });
  });
</script>

<style>
  .required:after {
    content: " *";
    color: #f43f5e;
  }

  /* Styling cho Mapbox */
  .mapboxgl-popup {
    max-width: 200px;
  }

  .mapboxgl-popup-content {
    text-align: center;
    padding: 10px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  .mapboxgl-popup-content h3 {
    margin: 0;
    padding: 0;
  }

  /* Marker styling */
  .mapboxgl-marker {
    cursor: pointer;
  }

  /* Map container styling */
  #map-container {
    border-radius: 0.375rem;
    overflow: hidden;
  }
</style>
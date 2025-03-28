<?php
// filepath: c:\xampp\htdocs\project\app\views\admin\locations\create.php
use App\Helpers\UrlHelper;

$title = 'Thêm mới địa điểm';
?>

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
          <span>Thêm mới</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
          Thêm mới địa điểm
        </h1>
      </div>

      <div class="mt-4 md:mt-0">
        <a href="<?= UrlHelper::route('admin/locations') ?>"
          class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow-sm flex items-center">
          <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">Thông tin địa điểm</h2>
      </div>

      <form action="<?= UrlHelper::route('admin/locations/create') ?>" method="POST" class="p-6"
        enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Tên địa điểm -->
          <div class="col-span-1">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1 required">Tên địa điểm</label>
            <input type="text" name="name" id="name" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tên hiển thị của địa điểm</p>
          </div>

          <!-- Slug -->
          <div class="col-span-1">
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1 required">Slug</label>
            <input type="text" name="slug" id="slug" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Được sử dụng trong URL, chỉ chứa chữ thường, số và dấu gạch ngang</p>
          </div>

          <!-- Khu vực (Sử dụng select thay vì input text) -->
          <div class="col-span-1">
            <label for="region" class="block text-sm font-medium text-gray-700 mb-1 required">Khu vực</label>
            <div class="relative">
              <select name="region" id="region" required
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500 appearance-none">
                <option value="">-- Chọn khu vực --</option>
                <option value="Châu Á">Châu Á</option>
                <option value="Châu Âu">Châu Âu</option>
                <option value="Châu Phi">Châu Phi</option>
                <option value="Châu Mỹ">Châu Mỹ</option>
                <option value="Châu Đại Dương">Châu Đại Dương</option>
                <option value="Miền Bắc">Miền Bắc</option>
                <option value="Miền Trung">Miền Trung</option>
                <option value="Miền Nam">Miền Nam</option>
                <option value="Đông Nam Á">Đông Nam Á</option>
                <option value="Tây Âu">Tây Âu</option>
                <option value="Đông Âu">Đông Âu</option>
                <option value="Bắc Mỹ">Bắc Mỹ</option>
                <option value="Nam Mỹ">Nam Mỹ</option>
                <option value="Trung Đông">Trung Đông</option>
                <option value="other">Khác (nhập tùy chỉnh)</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
            <input type="text" id="custom_region" name="custom_region" placeholder="Nhập khu vực tùy chỉnh"
              class="w-full mt-2 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500 hidden">
            <p class="mt-1 text-sm text-gray-500">Khu vực địa lý (châu lục, miền)</p>
          </div>

          <!-- Quốc gia -->
          <div class="col-span-1">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1 required">Quốc gia</label>
            <input type="text" name="country" id="country" required list="country-list"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <datalist id="country-list">
              <!-- Danh sách các quốc gia phổ biến -->
              <option value="Việt Nam">
              <option value="Thái Lan">
              <option value="Singapore">
              <option value="Malaysia">
              <option value="Indonesia">
              <option value="Philippines">
              <option value="Nhật Bản">
              <option value="Hàn Quốc">
              <option value="Trung Quốc">
              <option value="Hoa Kỳ">
              <option value="Anh">
              <option value="Pháp">
              <option value="Đức">
              <option value="Ý">
              <option value="Tây Ban Nha">
              <option value="Úc">
              <option value="New Zealand">
                <!-- Thêm các quốc gia khác nếu cần -->
            </datalist>
            <p class="mt-1 text-sm text-gray-500">Quốc gia của địa điểm</p>
          </div>

          <!-- Vĩ độ (latitude) -->
          <div class="col-span-1">
            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Vĩ độ (Latitude)</label>
            <input type="text" name="latitude" id="latitude" placeholder="Ví dụ: 21.0278"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tọa độ vĩ độ của địa điểm</p>
          </div>

          <!-- Kinh độ (longitude) -->
          <div class="col-span-1">
            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Kinh độ (Longitude)</label>
            <input type="text" name="longitude" id="longitude" placeholder="Ví dụ: 105.8342"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Tọa độ kinh độ của địa điểm</p>
          </div>

          <!-- Thumbnail -->
          <div class="col-span-1">
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1 required">Hình ảnh đại
              diện</label>
            <input type="file" name="thumbnail" id="thumbnail" required
              class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Chọn hình ảnh đại diện cho địa điểm (JPEG, PNG, tối đa 2MB)</p>

            <!-- Thumbnail Preview -->
            <div id="thumbnailPreview" class="hidden mt-2">
              <div class="w-32 h-32 border rounded-md overflow-hidden bg-gray-100">
                <img src="" alt="Thumbnail preview" class="w-full h-full object-cover" id="thumbnailPreviewImg">
              </div>
            </div>
          </div>

          <!-- Trạng thái -->
          <div class="col-span-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1 required">Trạng thái</label>
            <select name="status" id="status"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
              <option value="active" selected>Hoạt động</option>
              <option value="inactive">Vô hiệu</option>
            </select>
            <p class="mt-1 text-sm text-gray-500">Trạng thái của địa điểm</p>
          </div>

          <!-- URL -->
          <div class="col-span-2">
            <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
            <input type="text" name="url" id="url" placeholder="https://example.com/locations/hanoi"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">URL trang web chính thức của địa điểm (nếu có)</p>
          </div>

          <!-- Mô tả -->
          <div class="col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="6"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-teal-500 focus:border-teal-500"></textarea>
            <p class="mt-1 text-sm text-gray-500">Mô tả chi tiết về địa điểm</p>
          </div>
        </div>

        <!-- Gallery Images -->
        <div class="mt-8">
          <h3 class="text-base font-medium text-gray-900 mb-3">Thư viện ảnh</h3>
          <div class="border rounded-md p-4 bg-gray-50">
            <label class="block text-sm font-medium text-gray-700 mb-2">Thêm ảnh vào thư viện</label>
            <input type="file" name="galleries" id="gallery" multiple
              class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-teal-500 focus:border-teal-500">
            <p class="mt-1 text-sm text-gray-500">Chọn nhiều ảnh cùng lúc cho thư viện (JPEG, PNG, tối đa 5MB mỗi ảnh)
            </p>

            <!-- Gallery Preview -->
            <div id="galleryPreview" class="hidden mt-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Xem trước</h4>
              <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3"
                id="galleryPreviewContainer">
                <!-- Preview images will be inserted here -->
              </div>
            </div>
          </div>
        </div>

        <!-- Map Preview -->
        <div class="mt-8">
          <h3 class="text-base font-medium text-gray-900 mb-3">Vị trí bản đồ</h3>
          <div class="border rounded-md overflow-hidden">
            <div class="px-4 py-2 bg-gray-50 border-b">
              <p class="text-sm text-gray-600">Click vào bản đồ để chọn vị trí hoặc nhập tọa độ vào các trường trên</p>
            </div>
            <div style="height: 400px; width: 100%; position: relative;">
              <div id="map" style="position: absolute; top: 0; bottom: 0; width: 100%;"></div>
            </div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex items-center justify-end space-x-3">
          <a href="<?= UrlHelper::route('admin/locations') ?>"
            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Hủy
          </a>
          <button type="submit"
            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Tạo địa điểm
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Auto-generate slug from name
  document.getElementById('name').addEventListener('input', function() {
    const nameValue = this.value;
    const slugInput = document.getElementById('slug');

    if (!slugInput.dataset.userModified || slugInput.dataset.userModified === 'false') {
      slugInput.value = nameValue
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    }
  });

  // Set the flag to false when user manually edits the slug
  document.getElementById('slug').addEventListener('input', function() {
    this.dataset.userModified = 'true';
  });

  // Thumbnail preview
  document.getElementById('thumbnail').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const previewImg = document.getElementById('thumbnailPreviewImg');
        previewImg.src = e.target.result;
        document.getElementById('thumbnailPreview').classList.remove('hidden');
      }
      reader.readAsDataURL(file);
    } else {
      document.getElementById('thumbnailPreview').classList.add('hidden');
    }
  });

  // Gallery preview
  document.getElementById('gallery').addEventListener('change', function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('galleryPreviewContainer');
    previewContainer.innerHTML = ''; // Clear existing previews

    if (files.length > 0) {
      document.getElementById('galleryPreview').classList.remove('hidden');

      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file.type.match('image.*')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'aspect-w-1 aspect-h-1 overflow-hidden rounded-md bg-gray-100';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'object-cover w-full h-full';
            img.alt = 'Gallery image preview';

            imgContainer.appendChild(img);
            previewContainer.appendChild(imgContainer);
          }
          reader.readAsDataURL(file);
        }
      }
    } else {
      document.getElementById('galleryPreview').classList.add('hidden');
    }
  });

  // Mapbox initialization
  document.addEventListener('DOMContentLoaded', function() {
    // Thiết lập access token
    mapboxgl.accessToken =
      'pk.eyJ1IjoiYmluaGRldiIsImEiOiJjbHduODEzNXMweWxrMmltanU3M3Voc3IxIn0.oZ19gfygIANckV1rAPGXuw';

    // Mặc định hiển thị vị trí Hà Nội khi chưa có tọa độ
    const defaultLat = 21.0278;
    const defaultLng = 105.8342;

    // Khởi tạo map
    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: [defaultLng, defaultLat],
      zoom: 12
    });

    // Thêm controls
    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    // Tạo marker có thể kéo
    const marker = new mapboxgl.Marker({
        color: "#e53e3e",
        draggable: true
      })
      .setLngLat([defaultLng, defaultLat])
      .addTo(map);

    // Cập nhật lat, lng khi kéo marker
    marker.on('dragend', function() {
      const lngLat = marker.getLngLat();
      document.getElementById('latitude').value = lngLat.lat.toFixed(6);
      document.getElementById('longitude').value = lngLat.lng.toFixed(6);
    });

    // Click vào map để đặt marker
    map.on('click', function(e) {
      marker.setLngLat(e.lngLat);
      document.getElementById('latitude').value = e.lngLat.lat.toFixed(6);
      document.getElementById('longitude').value = e.lngLat.lng.toFixed(6);
    });

    // Cập nhật marker khi nhập tọa độ
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    function updateMapFromInputs() {
      const lat = parseFloat(latInput.value);
      const lng = parseFloat(lngInput.value);

      if (!isNaN(lat) && !isNaN(lng)) {
        marker.setLngLat([lng, lat]);
        map.flyTo({
          center: [lng, lat],
          zoom: 12,
          essential: true
        });
      }
    }

    latInput.addEventListener('change', updateMapFromInputs);
    lngInput.addEventListener('change', updateMapFromInputs);

    // Thêm tìm kiếm địa điểm (geocoder)
    const geocoder = new MapboxGeocoder({
      accessToken: mapboxgl.accessToken,
      mapboxgl: mapboxgl,
      marker: false,
      placeholder: 'Tìm kiếm địa điểm...'
    });

    map.addControl(geocoder, 'top-left');

    // Cập nhật marker khi tìm kiếm
    geocoder.on('result', function(e) {
      const coordinates = e.result.center;
      marker.setLngLat(coordinates);

      // Cập nhật input fields
      document.getElementById('latitude').value = coordinates[1].toFixed(6);
      document.getElementById('longitude').value = coordinates[0].toFixed(6);

      // Hiển thị tên địa điểm
      if (e.result.place_name && !document.getElementById('name').value) {
        document.getElementById('name').value = e.result.text;
        // Trigger slug generation
        document.getElementById('name').dispatchEvent(new Event('input'));
      }
    });
  });
</script>

<!-- Thêm Mapbox Geocoder -->


<style>
  .required:after {
    content: " *";
    color: #f43f5e;
  }

  /* Fix aspect ratio for gallery previews */
  .aspect-w-1 {
    position: relative;
    padding-bottom: 100%;
  }

  .aspect-w-1>img {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    object-fit: cover;
    object-position: center;
  }

  /* Mapbox style adjustments */
  .mapboxgl-ctrl-geocoder {
    min-width: 100%;
  }

  @media (min-width: 640px) {
    .mapboxgl-ctrl-geocoder {
      min-width: 300px;
    }
  }
</style>
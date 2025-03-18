<?php
  use App\Helpers\UrlHelper;
  var_dump($images);
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Thư viện hình ảnh
      </h2>
      <p class="mt-1 text-gray-600">Quản lý và tổ chức hình ảnh cho website</p>
    </div>

    <div class="flex items-center space-x-3">
      <button id="upload-btn"
        class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
        </svg>
        Tải lên
      </button>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-teal-50 text-teal-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <div class="ml-4">
          <h3 class="text-sm font-medium text-gray-500">Tổng số ảnh</h3>
          <p class="text-xl font-semibold text-gray-800"><?= number_format($stats['total_images'] ?? 0) ?></p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-50 text-purple-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
        </div>
        <div class="ml-4">
          <h3 class="text-sm font-medium text-gray-500">Ảnh tour</h3>
          <p class="text-xl font-semibold text-gray-800"><?= number_format($stats['tour_images'] ?? 0) ?></p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-amber-50 text-amber-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
          </svg>
        </div>
        <div class="ml-4">
          <h3 class="text-sm font-medium text-gray-500">Ảnh banner</h3>
          <p class="text-xl font-semibold text-gray-800"><?= number_format($stats['banner_images'] ?? 0) ?></p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-50 text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
        </div>
        <div class="ml-4">
          <h3 class="text-sm font-medium text-gray-500">Dung lượng</h3>
          <p class="text-xl font-semibold text-gray-800"><?= formatFileSize($stats['total_size'] ?? 0) ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Bar -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
    <form action="<?= UrlHelper::route('admin/images') ?>" method="GET" class="flex flex-col md:flex-row gap-4">
      <div class="flex-grow">
        <div class="relative">
          <input type="text" name="keyword" value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>"
            placeholder="Tìm kiếm hình ảnh..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="flex-shrink-0">
        <select name="category"
          class="w-full px-3 py-2 h-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          <option value="">Tất cả danh mục</option>
          <option value="general" <?= ($filters['category'] ?? '') === 'general' ? 'selected' : '' ?>>Chung</option>
          <option value="tours" <?= ($filters['category'] ?? '') === 'tours' ? 'selected' : '' ?>>Tour</option>
          <option value="locations" <?= ($filters['category'] ?? '') === 'locations' ? 'selected' : '' ?>>Địa điểm
          </option>
          <option value="banner" <?= ($filters['category'] ?? '') === 'banner' ? 'selected' : '' ?>>Banner</option>
        </select>
      </div>

      <div class="flex gap-2">
        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          Tìm kiếm
        </button>

        <a href="<?= UrlHelper::route('admin/images') ?>"
          class="inline-flex items-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          Đặt lại
        </a>
      </div>
    </form>
  </div>

  <!-- Image Gallery -->
  <?php if (empty($images)): ?>
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
    <div class="mx-auto w-16 h-16 mb-4 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-800 mb-2">Không tìm thấy hình ảnh</h3>
    <p class="text-gray-600 mb-4">Không có hình ảnh nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
    <button id="empty-upload-btn"
      class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
      </svg>
      Tải lên hình ảnh mới
    </button>
  </div>
  <?php else: ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
    <?php foreach ($images as $image): ?>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden image-card"
      data-id="<?= $image['id'] ?>" data-description="<?= htmlspecialchars($image['description'] ?? '') ?>">
      <div class="relative aspect-w-16 aspect-h-9 bg-gray-100">
        <img src="<?= htmlspecialchars($image['cloudinary_url']) ?>" alt="<?= htmlspecialchars($image['alt_text']) ?>"
          class="object-cover w-full h-full">

        <?php if (isset($image['is_featured']) && $image['is_featured']): ?>
        <div class="absolute top-2 left-2">
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Nổi bật
          </span>
        </div>
        <?php endif; ?>

        <?php if (!empty($image['category']) && $image['category'] !== 'general'): ?>
        <div class="absolute top-2 <?= isset($image['is_featured']) && $image['is_featured'] ? 'left-20' : 'left-2' ?>">
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
            <?php 
            switch($image['category']) {
              case 'tours': echo 'bg-purple-100 text-purple-800'; break;
              case 'locations': echo 'bg-green-100 text-green-800'; break;
              case 'banner': echo 'bg-amber-100 text-amber-800'; break;
              default: echo 'bg-gray-100 text-gray-800';
            }
            ?>">
            <?php 
            switch($image['category']) {
              case 'tours': echo 'Tour'; break;
              case 'locations': echo 'Địa điểm'; break;
              case 'banner': echo 'Banner'; break;
              default: echo 'Chung';
            }
            ?>
          </span>
        </div>
        <?php endif; ?>

        <div class="absolute top-2 right-2">
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
              class="p-1 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full text-gray-600 hover:text-gray-800 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
              </svg>
            </button>

            <div x-show="open" @click.away="open = false"
              class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-100 border border-gray-200">
              <div class="py-1">
                <!-- Tìm phần nút edit trong dropdown menu và thay đổi từ button thành link -->
                <!-- Thay thế đoạn code này: -->
                <!-- <button class="edit-image-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  data-id="<?= $image['id'] ?>" data-url="<?= UrlHelper::route('admin/images') ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Chỉnh sửa
                </button> -->

                <!-- Thay thế bằng đoạn code này: -->
                <a href="<?= UrlHelper::route('admin/images/edit/' . $image['id']) ?>"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Chỉnh sửa
                </a>

                <a href="<?= htmlspecialchars($image['cloudinary_url']) ?>" target="_blank"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                  Xem đầy đủ
                </a>

                <button class="copy-url-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  data-url="<?= htmlspecialchars($image['cloudinary_url']) ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                  </svg>
                  Sao chép URL
                </button>

                <?php if ($image['category'] === 'tours' && (!isset($image['is_featured']) || !$image['is_featured']) && isset($image['tour_id'])): ?>
                <button
                  class="set-featured-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  data-id="<?= $image['id'] ?>" data-tour-id="<?= $image['tour_id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                  </svg>
                  Đặt làm ảnh nổi bật
                </button>
                <?php endif; ?>

                <hr class="my-1 border-gray-200">

                <button class="delete-image-btn block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                  data-base-url="<?= UrlHelper::route('admin/images/delete/' . $image['id']) ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Xóa
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-3">
        <h3 class="font-medium text-gray-800 truncate" title="<?= htmlspecialchars($image['title']) ?>">
          <?= htmlspecialchars($image['title']) ?></h3>

        <?php if (isset($image['tour_name']) && !empty($image['tour_name'])): ?>
        <div class="mt-1 text-xs text-gray-500 truncate" title="<?= htmlspecialchars($image['tour_name']) ?>">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
          <?= htmlspecialchars($image['tour_name']) ?>
        </div>
        <?php endif; ?>

        <?php if (isset($image['banner_title']) && !empty($image['banner_title'])): ?>
        <div class="mt-1 text-xs text-gray-500 truncate" title="<?= htmlspecialchars($image['banner_title']) ?>">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
          </svg>
          <?= htmlspecialchars($image['banner_title']) ?>
        </div>
        <?php endif; ?>

        <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
          <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            <?= htmlspecialchars($image['file_type']) ?>
          </span>
          <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
            <?= formatFileSize($image['file_size']) ?>
          </span>
        </div>
        <div class="flex items-center justify-between mt-2 text-xs">
          <span class="text-gray-500">
            <?= date('d/m/Y', strtotime($image['created_at'])) ?>
          </span>
          <span class="text-gray-500">
            <?= $image['width'] ?>x<?= $image['height'] ?> px
          </span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
  <div class="flex justify-center mt-8">
    <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
      <?php if ($currentPage > 1): ?>
      <a href="<?= str_replace('(:num)', $currentPage - 1, $pagination['urlPattern']) ?>"
        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
        <span class="sr-only">Previous</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
          aria-hidden="true">
          <path fill-rule="evenodd"
            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
            clip-rule="evenodd" />
        </svg>
      </a>
      <?php else: ?>
      <span
        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
        <span class="sr-only">Previous</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
          aria-hidden="true">
          <path fill-rule="evenodd"
            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
            clip-rule="evenodd" />
        </svg>
      </span>
      <?php endif; ?>

      <?php
      $startPage = max(1, $currentPage - 2);
      $endPage = min($totalPages, $startPage + 4);
      if ($endPage - $startPage < 4) {
          $startPage = max(1, $endPage - 4);
      }
      
      for ($i = $startPage; $i <= $endPage; $i++):
      ?>
      <?php if ($i == $currentPage): ?>
      <span
        class="relative inline-flex items-center px-4 py-2 border border-teal-500 bg-teal-50 text-sm font-medium text-teal-600">
        <?= $i ?>
      </span>
      <?php else: ?>
      <a href="<?= str_replace('(:num)', $i, $pagination['urlPattern']) ?>"
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
        <?= $i ?>
      </a>
      <?php endif; ?>
      <?php endfor; ?>

      <?php if ($currentPage < $totalPages): ?>
      <a href="<?= str_replace('(:num)', $currentPage + 1, $pagination['urlPattern']) ?>"
        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
        <span class="sr-only">Next</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
          aria-hidden="true">
          <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </a>
      <?php else: ?>
      <span
        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
        <span class="sr-only">Next</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
          aria-hidden="true">
          <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </span>
      <?php endif; ?>
    </nav>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</div>

<!-- Upload Modal -->
<div id="upload-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <form id="upload-form" action="<?= UrlHelper::route('admin/images') ?>" method="POST" enctype="multipart/form-data"
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
              Tải lên hình ảnh mới
            </h3>


            <div class="mb-4">
              <div class="flex items-center justify-center">
                <div class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg relative" id="dropzone">
                  <!-- Preview Container -->
                  <div id="preview-container" class="hidden w-full h-full">
                    <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-contain rounded-lg">
                    <button type="button" id="remove-preview"
                      class="absolute top-2 right-2 p-1 bg-white rounded-full shadow-sm hover:bg-gray-100">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>

                  <!-- Dropzone Text -->
                  <div id="dropzone-text" class="absolute inset-0 flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                    </svg>
                    <p class="mt-1 text-sm text-gray-600">Kéo và thả hình ảnh vào đây hoặc <span
                        class="text-teal-500 font-medium">chọn tệp</span></p>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF tối đa 5MB</p>
                  </div>

                  <input type="file" id="file-input" name="image"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span
                  class="text-red-500">*</span></label>
              <input type="text" id="title" name="title" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
              <textarea id="description" name="description" rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
            </div>

            <div class="mb-4">
              <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
              <input type="text" id="alt_text" name="alt_text"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div class="mb-4">
              <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
              <select id="category" name="category"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <option value="general">Chung</option>
                <option value="tours">Tour</option>
                <option value="locations">Địa điểm</option>
                <option value="banner">Banner</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" form="upload-form" id="upload-submit-btn"
          class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-500 text-base font-medium text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
          Tải lên
        </button>
        <button type="button" id="upload-cancel-btn"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Xóa hình ảnh
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Bạn có chắc chắn muốn xóa hình ảnh này? Hành động này không thể hoàn tác.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <form id="delete-form" action="" method="POST" data-base-url="<?= UrlHelper::route('admin/images/delete') ?>">
          <input type="hidden" id="delete-id" name="id">
          <button type="submit" id="delete-confirm-btn"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Xóa
          </button>
        </form>
        <button type="button" id="delete-cancel-btn"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Hủy
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Set Featured Image Modal -->
<div id="featured-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Đặt làm ảnh nổi bật
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Bạn có chắc chắn muốn đặt hình ảnh này làm ảnh nổi bật cho tour? Ảnh nổi bật hiện tại sẽ bị thay thế.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <form id="featured-form" action="<?= UrlHelper::route('admin/tours/set-featured-image') ?>" method="POST">
          <input type="hidden" id="featured-image-id" name="image_id">
          <input type="hidden" id="featured-tour-id" name="tour_id">
          <button type="submit" id="featured-confirm-btn"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
            Đặt làm ảnh nổi bật
          </button>
        </form>
        <button type="button" id="featured-cancel-btn"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Hủy
        </button>
      </div>
    </div>
  </div>
</div>


<?php
// Helper function to format file size
  function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
  }
?>

<!-- Thêm vào phần head của trang hoặc ngay trước thẻ đóng body -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="<?= UrlHelper::js('admin/image-gallery.js') ?>"></script>
<?php
// filepath: c:\xampp\htdocs\project\app\views\home\news.php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;


$title = 'Tin Tức - Di Travel';
$activePage = 'news';

// Xác định danh mục đang được chọn
$currentCategoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
?>

<div class="py-8 md:py-12">
  <!-- Banner Section nếu có -->
  <?php if (!$currentCategoryId) : ?>
    <div class="container mx-auto px-4 mb-10">
      <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tin Tức Du Lịch</h1>
        <p class="text-gray-600 max-w-3xl mx-auto">Khám phá những thông tin mới nhất về du lịch, ẩm thực, văn hóa và các
          điểm đến hấp dẫn trong nước và quốc tế.</p>
      </div>
    </div>
  <?php else: ?>
    <div class="container mx-auto px-4 mb-10">
      <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
          <?= htmlspecialchars($currentCategoryName ?? 'Danh mục tin tức') ?></h1>
      </div>
    </div>
  <?php endif; ?>

  <!-- News Content Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <!-- Filter Bar -->
    <div class=" bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
      <?php foreach ($top1ViewedNews as $item) { ?>
        <div class="flex flex-col">
          <!-- Featured Image -->
          <div class="relative w-full ">
            <img src="<?= $item['featured_image'] ?>"
              alt="<?= htmlspecialchars($item['title']) ?>"
              class="object-cover w-full">
            <div class="absolute top-3 left-3 bg-teal-600 text-white px-3 py-1 text-sm font-medium rounded-md shadow-sm">
              Nổi bật
            </div>
          </div>

          <!-- Content -->
          <div class=" p-6 md:p-8">
            <!-- Category and Date -->
            <div class="flex items-center justify-between mb-4">
              <span class="bg-teal-50 text-teal-700 text-xs font-medium px-3 py-1.5 rounded-full"><?= $item['category_name'] ?></span>
              <div class="flex items-center text-gray-500 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?= FormatHelper::formatDate($item["created_at"]) ?>
              </div>
            </div>

            <!-- Title -->
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 line-clamp-2">
              <?= $item['title'] ?>
            </h3>

            <!-- Excerpt -->
            <p class="text-gray-600 mb-6 line-clamp-3">
              <?= $item['content'] ?>
            </p>


            <!-- Stats and Read More -->
            <div class="flex items-center justify-between mt-auto">
              <div class="flex items-center space-x-4 text-sm text-gray-500">
                <!-- Views -->
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <span><?= $item['views'] ?> lượt xem</span>
                </div>
              </div>

              <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm font-medium rounded-md transition-colors">
                Đọc tiếp
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="flex flex-col lg:flex-row gap-8">

      <!-- Main News Content -->
      <div class="lg:w-2/3">
        <!-- Featured News -->
        <?php if (!$currentCategoryId && isset($featuredNews) && $featuredNews): ?>
          <div class="mb-12">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
              <div class="relative h-[300px] md:h-[400px] bg-gray-100">
                <!-- Placeholder hiển thị trước khi ảnh load -->
                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                  id="featured-placeholder">
                  <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30 mb-2" viewBox="0 0 24 24"
                      fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                      <circle cx="8.5" cy="8.5" r="1.5"></circle>
                      <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <span class="text-gray-500">Đang tải ảnh...</span>
                  </div>
                </div>

                <!-- Ảnh chính -->
                <img src="<?= $featuredNews['featured_image'] ?>" alt="<?= htmlspecialchars($featuredNews['title']) ?>"
                  class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300"
                  onload="this.style.opacity='1'; document.getElementById('featured-placeholder').style.display='none';"
                  onerror="handleFeaturedImageError(this);">

                <div class="absolute top-4 left-4">
                  <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-sm">Nổi Bật</span>
                </div>
              </div>
              <div class="p-6">
                <div class="flex items-center text-gray-500 text-sm mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>

                  <span><?= FormatHelper::formatDate($featuredNews["created_at"]) ?></span>

                  <span class="mx-2">•</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <span><?= number_format($featuredNews['views'] ?? 0) ?> lượt xem</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                  <?= htmlspecialchars($featuredNews['title']) ?></h2>
                <p class="text-gray-600 mb-4 line-clamp-3 text-sm md:text-base">
                  <?= htmlspecialchars($featuredNews['summary'] ?? substr($featuredNews['content'], 0, 200) . '...') ?>
                </p>
                <a href="<?= UrlHelper::route('home/news-detail/' . $featuredNews['id']) ?>"
                  class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium transition-colors">
                  Đọc tiếp
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>



        <!-- News List -->
        <div>
          <div class="mb-8 mt-8">
            <h2 class="text-2xl font-bold text-gray-800">
              <?= $currentCategoryId ? htmlspecialchars($currentCategoryName ?? 'Danh mục tin tức') : 'Tin Tức Mới Nhất' ?>
            </h2>
          </div>

          <?php if (empty($newsList)): ?>
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
              <div class="mb-4 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy bài viết nào</h3>
              <p class="text-gray-500 mb-4">Hiện tại chưa có bài viết nào trong danh mục này.</p>
              <a href="<?= UrlHelper::route('home/news') ?>"
                class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                Xem tất cả tin tức
              </a>
            </div>
          <?php else: ?>
            <div class="space-y-6" id="list-view">
              <?php foreach ($newsList as $item): ?>
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                  <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 md:min-w-[280px]">
                      <div class="relative h-[200px] md:h-full bg-gray-100">
                        <!-- Placeholder hiển thị trước khi ảnh load -->
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                          id="placeholder-<?= $item['id'] ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-30" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                          </svg>
                        </div>

                        <!-- Ảnh chính -->
                        <img src="<?= $item['featured_image'] ?>" alt="<?= htmlspecialchars($item['title']) ?>"
                          class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300"
                          onload="this.style.opacity='1'; document.getElementById('placeholder-<?= $item['id'] ?>').style.display='none';"
                          onerror="handleNewsImageError(this, 'placeholder-<?= $item['id'] ?>', '<?= htmlspecialchars($item['title'], ENT_QUOTES) ?>');">

                        <?php if (!empty($item['categories']) && isset($item['categories'][0])): ?>
                          <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                              <?= htmlspecialchars($item['categories'][0]['category_name'] ?? 'Chưa phân loại') ?>
                            </span>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="md:w-2/3 p-5 md:p-6 flex flex-col justify-between">
                      <div>
                        <div class="flex items-center text-gray-500 text-sm mb-3">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                          <span><?= FormatHelper::formatDate($item["created_at"]) ?></span>
                          <span class="mx-2 text-teal-500">•</span>
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                          <span><?= number_format($item['views'] ?? 0) ?> lượt xem</span>
                        </div>

                        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 line-clamp-2">
                          <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                            class="hover:text-teal-600 transition-colors">
                            <?= htmlspecialchars($item['title']) ?>
                          </a>
                        </h3>

                        <p class="text-gray-600 mb-4 line-clamp-3 text-sm md:text-base">
                          <?= htmlspecialchars($item['summary'] ?? substr($item['content'], 0, 200) . '...') ?>
                        </p>
                      </div>

                      <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                        class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium group">
                        Đọc tiếp
                        <svg xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Grid view -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 hidden" id="grid-view">
              <?php foreach ($newsList as $item): ?>
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                  <div class="relative h-48 bg-gray-100">
                    <!-- Placeholder hiển thị trước khi ảnh load -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                      id="grid-placeholder-<?= $item['id'] ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-30" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                      </svg>
                    </div>

                    <!-- Ảnh chính -->
                    <img src="<?= $item['featured_image'] ?>" alt="<?= htmlspecialchars($item['title']) ?>"
                      class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300"
                      onload="this.style.opacity='1'; document.getElementById('grid-placeholder-<?= $item['id'] ?>').style.display='none';"
                      onerror="handleNewsImageError(this, 'grid-placeholder-<?= $item['id'] ?>', '<?= htmlspecialchars($item['title'], ENT_QUOTES) ?>');">

                    <?php if (!empty($item['categories']) && isset($item['categories'][0])): ?>
                      <div class="absolute top-3 left-3">
                        <span class="bg-teal-600 text-white px-2 py-1 text-xs rounded-full shadow-sm">
                          <?= htmlspecialchars($item['categories'][0]['category_name'] ?? 'Chưa phân loại') ?>
                        </span>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="p-5">
                    <div class="flex items-center text-gray-500 text-xs mb-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-teal-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <span><?= $item['created_at'] ?></span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14">
                      <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                        class="hover:text-teal-600 transition-colors">
                        <?= htmlspecialchars($item['title']) ?>
                      </a>
                    </h3>

                    <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                      class="inline-flex items-center text-teal-600 hover:text-teal-700 text-sm font-medium mt-2 group">
                      Đọc tiếp
                      <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14 5l7 7m0 0l-7 7m7-7H3" />
                      </svg>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

          <?php endif; ?>

          <!-- Pagination -->
          <?php if ($totalPages > 1): ?>
            <div class="mt-10 flex justify-center">
              <nav class="flex items-center space-x-2">
                <?php if ($currentPage > 1): ?>
                  <a href="<?= UrlHelper::route('home/news' . ($currentCategoryId ? '?category=' . $currentCategoryId . '&' : '?') . 'page=' . ($currentPage - 1)) ?>"
                    class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Previous</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                  </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <?php if ($i == 1 || $i == $totalPages || ($i >= $currentPage - 2 && $i <= $currentPage + 2)): ?>
                    <a href="<?= UrlHelper::route('home/news' . ($currentCategoryId ? '?category=' . $currentCategoryId . '&' : '?') . 'page=' . $i) ?>"
                      class="px-4 py-2 rounded-md <?= $i == $currentPage ? 'bg-teal-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' ?> font-medium">
                      <?= $i ?>
                    </a>
                  <?php elseif ($i == 2 || $i == $totalPages - 1): ?>
                    <span class="px-4 py-2 text-gray-700">...</span>
                  <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                  <a href="<?= UrlHelper::route('home/news' . ($currentCategoryId ? '?category=' . $currentCategoryId . '&' : '?') . 'page=' . ($currentPage + 1)) ?>"
                    class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </a>
                <?php endif; ?>
              </nav>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:w-1/3 mt-10">
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
          <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Danh Mục
          </h3>
          <ul class="space-y-2">
            <li>
              <a href="<?= UrlHelper::route('home/news') ?>"
                class="flex items-center justify-between px-3 py-2 rounded-md <?= !$currentCategoryId ? 'bg-teal-50 text-teal-600' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?> transition-colors">
                <span>Tất cả tin tức</span>
                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">
                  <?= $totalNewsCount ?? '0' ?>
                </span>
              </a>
            </li>
            <?php foreach ($getActiveCategories as $category): ?>
              <li>
                <a href="<?= UrlHelper::route('home/news?category=' . $category['id']) ?>"
                  class="flex items-center justify-between px-3 py-2 rounded-md <?= $currentCategoryId == $category['id'] ? 'bg-teal-50 text-teal-600' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?> transition-colors">
                  <span><?= htmlspecialchars($category['name']) ?></span>
                  <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">
                    <?= $category['post_count'] ?? '0' ?>
                  </span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Popular Posts -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
          <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            Bài Viết Phổ Biến
          </h3>
          <div class="space-y-4">
            <?php foreach ($topViewedNews as $news): ?>
              <a href="<?= UrlHelper::route('home/news-detail/' . $news['id']) ?>"
                class="flex space-x-4 group hover:bg-gray-50 p-2 rounded-lg -mx-2 transition-colors">
                <div class="flex-shrink-0 w-20 h-20 relative bg-gray-100 rounded">
                  <!-- Placeholder hiển thị trước khi ảnh load -->
                  <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gay-400"
                    id="popular-placeholder-<?= $news['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-30" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                      <circle cx="8.5" cy="8.5" r="1.5"></circle>
                      <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                  </div>

                  <!-- Ảnh bài viết -->
                  <img src="<?= $news['featured_image'] ?>" alt="<?= htmlspecialchars($news['title']) ?>"
                    class="absolute inset-0 w-full h-full object-cover rounded opacity-0 transition-opacity duration-300"
                    onload="this.style.opacity='1'; document.getElementById('popular-placeholder-<?= $news['id'] ?>').style.display='none';"
                    onerror="handlePopularNewsImageError(this, 'popular-placeholder-<?= $news['id'] ?>', '<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>');">
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="text-gray-800 font-medium group-hover:text-teal-600 transition-colors line-clamp-2 text-sm">
                    <?= htmlspecialchars($news['title']) ?>
                  </h4>
                  <div class="flex items-center mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="text-gray-500 text-xs ml-1"><?= number_format($news['views']) ?> lượt xem</span>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Tags -->
        <?php if (!empty($popularTags)): ?>
          <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
              Thẻ Phổ Biến
            </h3>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($popularTags as $tag): ?>
                <a href="<?= UrlHelper::route('home/news?tag=' . urlencode($tag['name'])) ?>"
                  class="bg-gray-100 hover:bg-teal-50 hover:text-teal-600 transition-colors text-gray-700 rounded-full px-3 py-1 text-sm">
                  #<?= htmlspecialchars($tag['name']) ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Newsletter Subscribe -->
        <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-6 rounded-xl shadow-sm text-white">
          <h3 class="font-bold text-xl mb-2">Nhận thông tin mới nhất</h3>
          <p class="text-teal-100 text-sm mb-4">Đăng ký để nhận thông tin du lịch và ưu đãi mới nhất từ Di Travel</p>

          <form class="space-y-3">
            <div>
              <input type="email" placeholder="Email của bạn"
                class="w-full px-3 py-2 rounded-lg border-0 focus:ring-2 focus:ring-white/50 text-gray-800 text-sm">
            </div>
            <button type="submit"
              class="w-full bg-white text-teal-600 font-medium py-2 rounded-lg hover:bg-teal-50 transition-colors">
              Đăng ký ngay
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Xử lý lỗi ảnh
  function handleFeaturedImageError(img) {
    img.style.display = 'none';
    const placeholder = document.getElementById('featured-placeholder');
    if (placeholder) {
      placeholder.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-teal-500 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="text-gray-600 text-center px-4 font-medium">Tin tức nổi bật</span>
            </div>
        `;
    }
  }

  function handleNewsImageError(img, placeholderId, title) {
    img.style.display = 'none';
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) {
      placeholder.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="text-gray-600 text-center px-4 text-sm">${title}</span>
            </div>
        `;
    }
  }

  function handlePopularNewsImageError(img, placeholderId, title) {
    img.style.display = 'none';
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) {
      placeholder.innerHTML = `
      <div class="flex flex-col items-center justify-center h-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
      </div>
    `;
    }
  }

  // Chuyển đổi kiểu xem (Grid/List)
  document.addEventListener('DOMContentLoaded', function() {
    const listViewBtn = document.getElementById('view-list');
    const gridViewBtn = document.getElementById('view-grid');
    const listView = document.getElementById('list-view');
    const gridView = document.getElementById('grid-view');

    if (listViewBtn && gridViewBtn && listView && gridView) {
      listViewBtn.addEventListener('click', function() {
        listView.classList.remove('hidden');
        gridView.classList.add('hidden');
        listViewBtn.classList.remove('bg-gray-100', 'text-gray-700');
        listViewBtn.classList.add('bg-teal-600', 'text-white');
        gridViewBtn.classList.remove('bg-teal-600', 'text-white');
        gridViewBtn.classList.add('bg-gray-100', 'text-gray-700');
        localStorage.setItem('newsViewMode', 'list');
      });

      gridViewBtn.addEventListener('click', function() {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridViewBtn.classList.remove('bg-gray-100', 'text-gray-700');
        gridViewBtn.classList.add('bg-teal-600', 'text-white');
        listViewBtn.classList.remove('bg-teal-600', 'text-white');
        listViewBtn.classList.add('bg-gray-100', 'text-gray-700');
        localStorage.setItem('newsViewMode', 'grid');
      });

      // Load saved preference
      const savedViewMode = localStorage.getItem('newsViewMode');
      if (savedViewMode === 'grid') {
        gridViewBtn.click();
      }
    }
  });
</script>
<?php

use App\Helpers\UrlHelper;

$title = 'Khám phá Tours - Di Travel';
$activePage = 'tours';

// Get current category from request
$currentCategory = isset($_GET['category']) ? $_GET['category'] : null;
?>

<div class="py-10 md:py-16 bg-gradient-to-b from-teal-50 to-white">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <!-- Page Header -->
    <div class="text-center mb-12">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Khám Phá Tours Du Lịch</h1>
      <p class="text-lg text-gray-600">Những chuyến đi tuyệt vời đang chờ đón bạn</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Categories sidebar - Enhanced -->
      <div class="lg:w-1/4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          Danh Mục Tour
        </h3>

        <form action="<?= UrlHelper::route('home/tours') ?>" method="GET" id="categoryFilterForm">
          <!-- CATEGORY FILTER -->
          <ul class="space-y-1">
            <li>
              <a href="<?= UrlHelper::route('home/tours') ?>"
                class="flex items-center px-4 py-3 rounded-lg <?= $currentCategory === null ? 'bg-teal-500 text-white shadow-md' : 'hover:bg-teal-50 text-gray-600 hover:text-teal-700' ?> transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-3 <?= $currentCategory === null ? 'text-white' : 'text-teal-500' ?>" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="font-medium">Tất cả danh mục</span>
                <!-- Updated count badge styling -->
                <span
                  class="ml-auto <?= $currentCategory === null ? 'bg-teal-400/40 text-white' : 'bg-gray-200 text-gray-600' ?> text-xs rounded-full px-2.5 py-1 font-medium"><?= array_sum($categoryCounts) ?></span>
              </a>
            </li>
            <?php foreach ($categories as $category) { ?>
            <li>
              <a href="<?= UrlHelper::route('home/tours') ?>?category=<?= $category['id'] ?>"
                class="flex items-center px-4 py-3 rounded-lg <?= $currentCategory == $category['id'] ? 'bg-teal-500 text-white shadow-md' : 'hover:bg-teal-50 text-gray-600 hover:text-teal-700' ?> transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-3 <?= $currentCategory == $category['id'] ? 'text-white' : 'text-teal-500' ?>"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="font-medium"><?= $category['name'] ?></span>
                <!-- Updated count badge styling -->
                <span
                  class="ml-auto <?= $currentCategory == $category['id'] ? 'bg-teal-400/40 text-white' : 'bg-gray-200 text-gray-600' ?> text-xs rounded-full px-2.5 py-1 font-medium"><?= $categoryCounts[$category['id']] ?? 0 ?></span>
              </a>
            </li>
            <?php } ?>
          </ul>
          <!-- PRICE FILTER -->
          <div class="mt-8 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Giá</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="price_range" value="all" class="h-4 w-4 text-teal-500 focus:ring-teal-400"
                  <?= empty($_GET['price_range']) || $_GET['price_range'] == 'all' ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700">Tất cả</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="price_range" value="0-500000"
                  class="h-4 w-4 text-teal-500 focus:ring-teal-400"
                  <?= isset($_GET['price_range']) && $_GET['price_range'] == '0-500000' ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700">Dưới 500.000đ</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="price_range" value="500000-2000000"
                  class="h-4 w-4 text-teal-500 focus:ring-teal-400"
                  <?= isset($_GET['price_range']) && $_GET['price_range'] == '500000-2000000' ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700">500.000đ - 2.000.000đ</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="price_range" value="2000000-5000000"
                  class="h-4 w-4 text-teal-500 focus:ring-teal-400"
                  <?= isset($_GET['price_range']) && $_GET['price_range'] == '2000000-5000000' ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700">2.000.000đ - 5.000.000đ</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="price_range" value="5000000-max"
                  class="h-4 w-4 text-teal-500 focus:ring-teal-400"
                  <?= isset($_GET['price_range']) && $_GET['price_range'] == '5000000-max' ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700">Trên 5.000.000đ</span>
              </label>
            </div>
          </div>

          <!-- Nếu đang có category được chọn, giữ lại giá trị đó khi lọc giá -->
          <?php if ($currentCategory): ?>
          <input type="hidden" name="category" value="<?= $currentCategory ?>">
          <?php endif; ?>

          <!-- Nếu đang có sort được chọn, giữ lại khi lọc giá -->
          <?php if (isset($_GET['sort'])): ?>
          <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
          <?php endif; ?>

          <!-- Apply Filters Button - Cập nhật type="submit" -->
          <button type="submit"
            class="w-full bg-teal-500 hover:bg-teal-600 text-white mt-6 py-3 rounded-lg font-medium transition-colors flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                clip-rule="evenodd" />
            </svg>
            Lọc kết quả
          </button>
        </form>
      </div>

      <div class="lg:w-3/4">
        <!-- Current category title - Enhanced -->
        <?php if ($currentCategory !== null) {
          $categoryName = '';
          foreach ($categories as $category) {
            if ($category['id'] == $currentCategory) {
              $categoryName = $category['name'];
              break;
            }
          }
          if ($categoryName) { ?>
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white p-6 rounded-xl mb-8 shadow-md">
          <h2 class="text-2xl font-bold"><?= $categoryName ?></h2>
          <p class="text-teal-100 mt-1">Khám phá những tour du lịch <?= $categoryName ?> tuyệt vời nhất</p>
        </div>
        <?php }
        } ?>

        <!-- Sort options & Results - Enhanced -->
        <div
          class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-center">
          <div class="flex items-center mb-4 sm:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" viewBox="0 0 20 20"
              fill="currentColor">
              <path
                d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
            </svg>
            <span class="font-medium text-gray-700 mr-3">Sắp xếp:</span>
            <select
              class="bg-gray-50 border border-gray-200 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500"
              id="sortOptions" onchange="applySorting()">
              <option value="popular">Phổ biến nhất</option>
              <option value="price_asc">Giá từ thấp đến cao</option>
              <option value="price_desc">Giá từ cao xuống thấp</option>
              <option value="rating">Đánh giá cao nhất</option>
              <option value="newest">Mới nhất</option>
            </select>
          </div>

          <!-- Results count -->
          <div class="flex items-center text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" viewBox="0 0 20 20"
              fill="currentColor">
              <path
                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            <span class="font-medium">
              Hiển thị <span class="text-teal-600"><?= count($allTours) ?></span> tours
            </span>
          </div>
        </div>

        <!-- Tour Grid - Enhanced Cards -->
        <div id="toursGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php
          foreach ($allTours as $tour) {
            $isFavorited = isset($_SESSION['user_id']) && in_array($tour['id'], $userFavorites);
            $heartClass = $isFavorited ? "text-red-500" : "text-teal-500";
          ?>
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1">
            <div class="relative">
              <!-- Tour Image -->
              <div class="h-56 overflow-hidden relative">
                <!-- Placeholder hiển thị trước khi ảnh load -->
                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                  id="placeholder-<?= $tour['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                  </svg>
                </div>

                <!-- Ảnh chính với overlay gradient -->
                <div
                  class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <img src="<?= $tour['cloudinary_url'] ?>" alt="<?= $tour['title'] ?>"
                  class="w-full h-full object-cover transition-all duration-500 ease-in-out group-hover:scale-110"
                  onload="document.getElementById('placeholder-<?= $tour['id'] ?>').style.display='none'; this.style.opacity='1';"
                  onerror="this.onerror=null; this.style.display='none'; showErrorPlaceholder('<?= $tour['id'] ?>', '<?= htmlspecialchars($tour['title'], ENT_QUOTES) ?>');"
                  style="opacity: 0;">
              </div>

              <!-- Category Badge - New! -->
              <?php
                $categoryName = "";
                foreach ($categories as $cat) {
                  if ($cat['id'] == $tour['category_id']) {
                    $categoryName = $cat['name'];
                    break;
                  }
                }
                ?>
              <div class="absolute top-4 left-4 bg-teal-500 text-white px-3 py-1 rounded-md text-xs font-medium">
                <?= $categoryName ?>
              </div>

              <!-- Discount Badge -->
              <?= $tour['sale_price'] ?
                  ' <div class="absolute bottom-4 right-4 bg-red-500 text-white px-3 py-1 rounded-md text-xs font-semibold shadow">' .
                  number_format((($tour['price'] - $tour['sale_price']) / $tour['price']) * 100) . '% GIẢM'
                  . '</div>'
                  : ''
                ?>

              <!-- Favorite Button -->
              <button data-tour-id="<?php echo $tour['id']; ?>"
                class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300 favorite-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $heartClass ?> fill-current"
                  viewBox="0 0 24 24">
                  <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
              </button>

              <!-- Duration Badge -->
              <div
                class="absolute bottom-4 left-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?= $tour['duration'] ?>
              </div>
            </div>

            <div class="p-5">
              <!-- Tour Title -->
              <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>">
                <h3
                  class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14 hover:text-teal-600 transition-colors">
                  <?= $tour['title'] ?>
                </h3>
              </a>

              <!-- Rating - Improved -->
              <div class="flex items-center mb-3">
                <div class="flex text-yellow-400">
                  <?php
                    $avgRating = isset($tour['avg_rating']) ? floatval($tour['avg_rating']) : 0;
                    $reviewCount = isset($tour['review_count']) ? intval($tour['review_count']) : 0;

                    for ($i = 1; $i <= 5; $i++) {
                      if ($avgRating >= $i) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>';
                      } elseif ($avgRating >= $i - 0.5) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>';
                      } else {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>';
                      }
                    }
                    ?>
                </div>
                <span class="text-gray-600 ml-2 text-sm">
                  <?= number_format($avgRating, 1) ?>
                  <span class="text-gray-400">(<?= $reviewCount ?> đánh giá)</span>
                </span>
              </div>

              <!-- Location - New! -->
              <div class="flex items-center mb-3 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <?= $tour['location'] ?? 'Việt Nam' ?>
              </div>

              <!-- Departure Date -->
              <div class="flex items-center mb-4 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <?php if (!empty($tour['next_start_date'])) { ?>
                <?php if ($tour['date_count'] == 1) { ?>
                <span>Khởi hành: <span
                    class="font-medium"><?= date('d/m/Y', strtotime($tour['next_start_date'])) ?></span></span>
                <?php } else { ?>
                <span>Khởi hành: <span
                    class="font-medium"><?= date('d/m/Y', strtotime($tour['next_start_date'])) ?></span></span>
                <?php } ?>
                <?php } ?>
              </div>

              <!-- Price and Action -->
              <div class="flex justify-between items-end">
                <div>
                  <span class="text-gray-400 line-through text-sm block">
                    <?= $tour['sale_price'] ? number_format($tour['price'], 0, ',', '.') . ' đ'  :  '' ?>
                  </span>
                  <span class="text-red-500 font-bold text-xl">
                    <?= $tour['sale_price'] ? number_format($tour['sale_price'], 0, ',', '.') : number_format($tour['price'], 0, ',', '.')  ?>
                    đ
                  </span>
                  <span class="text-gray-500 text-xs">/người</span>
                </div>
                <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>"
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 flex items-center">
                  <span>Chi tiết</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>

        <!-- Empty state - Enhanced -->
        <?php if (count($allTours) == 0) { ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
          <div class="py-12 flex flex-col items-center justify-center text-center">
            <div class="bg-teal-50 p-6 rounded-full mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Không có tour nào trong danh mục này</h3>
            <p class="text-gray-500 mb-6 max-w-md">Rất tiếc, hiện tại chúng tôi không có tour nào trong danh mục này.
              Vui lòng thử lại với danh mục khác.</p>
            <a href="<?= UrlHelper::route('home/tours') ?>"
              class="inline-flex items-center bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-6 rounded-lg transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                  clip-rule="evenodd" />
              </svg>
              Quay lại tất cả tour
            </a>
          </div>
        </div>
        <?php } ?>

        <!-- Pagination - Enhanced -->
        <!-- Add this pagination section after the tour cards grid -->
        <?php if ($pagination['total_pages'] > 1): ?>
        <div class="mt-10">
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center">
              <div class="mb-4 md:mb-0">
                <p class="text-sm text-gray-500">
                  Hiển thị <span class="font-medium"><?= $pagination['from'] ?></span>-<span
                    class="font-medium"><?= $pagination['to'] ?></span> của <span
                    class="font-medium"><?= $pagination['total'] ?></span> kết quả
                </p>
              </div>

              <div class="flex flex-wrap justify-center space-x-1">
                <!-- Previous page button -->
                <?php if ($pagination['has_prev_page']): ?>
                <a href="<?= $this->buildPaginationUrl($pagination['current_page'] - 1) ?>"
                  class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors"
                  aria-label="Previous page">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                </a>
                <?php else: ?>
                <span class="px-3 py-2 rounded text-gray-300 cursor-not-allowed">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                </span>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php
                  // Calculate page range to show
                  $startPage = max(1, $pagination['current_page'] - 2);
                  $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);

                  // Always show first page
                  if ($startPage > 1):
                  ?>
                <a href="<?= $this->buildPaginationUrl(1) ?>"
                  class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                  1
                </a>

                <!-- Show dots if needed -->
                <?php if ($startPage > 2): ?>
                <span class="px-3 py-1.5 rounded-lg text-gray-600">...</span>
                <?php endif; ?>
                <?php endif; ?>

                <!-- Loop through page numbers -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="<?= $this->buildPaginationUrl($i) ?>"
                  class="px-3 py-1.5 rounded-lg <?= $i == $pagination['current_page'] ? 'bg-teal-500 text-white font-medium' : 'text-gray-600 hover:bg-teal-50 hover:text-teal-600' ?>">
                  <?= $i ?>
                </a>
                <?php endfor; ?>

                <!-- Show dots if needed -->
                <?php if ($endPage < $pagination['total_pages'] - 1): ?>
                <span class="px-3 py-1.5 rounded-lg text-gray-600">...</span>
                <?php endif; ?>

                <!-- Always show last page -->
                <?php if ($endPage < $pagination['total_pages']): ?>
                <a href="<?= $this->buildPaginationUrl($pagination['total_pages']) ?>"
                  class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                  <?= $pagination['total_pages'] ?>
                </a>
                <?php endif; ?>

                <!-- Next page button -->
                <?php if ($pagination['has_next_page']): ?>
                <a href="<?= $this->buildPaginationUrl($pagination['current_page'] + 1) ?>"
                  class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors"
                  aria-label="Next page">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                </a>
                <?php else: ?>
                <span class="px-3 py-2 rounded text-gray-300 cursor-not-allowed">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                </span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Error placeholder script improved -->
<script>
function showErrorPlaceholder(tourId, tourTitle) {
  const placeholder = document.getElementById('placeholder-' + tourId);
  if (placeholder) {
    placeholder.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-500">${tourTitle}</p>
                </div>
            `;
    placeholder.style.display = 'flex';
  }
}

// Function to apply sorting with enhanced animations
function applySorting() {
  const sortOption = document.getElementById('sortOptions').value;
  // Animate the grid fade out
  const toursGrid = document.getElementById('toursGrid');
  toursGrid.style.opacity = '0.5';
  toursGrid.style.transition = 'opacity 0.3s';

  // Get current URL
  let url = new URL(window.location.href);
  // Set or update the sort parameter
  url.searchParams.set('sort', sortOption);
  // Navigate to the new URL after animation
  setTimeout(() => {
    window.location.href = url.toString();
  }, 300);
}

// Initialize sorting from URL parameter
document.addEventListener('DOMContentLoaded', function() {
  const url = new URL(window.location.href);
  const sortParam = url.searchParams.get('sort');
  if (sortParam) {
    document.getElementById('sortOptions').value = sortParam;
  }

  // Animate cards entrance
  const cards = document.querySelectorAll('#toursGrid > div');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

    setTimeout(() => {
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, 100 + index * 50);
  });
});
</script>

<script src="<?= UrlHelper::route('assets/js/admin/favorites.js') ?>"></script>
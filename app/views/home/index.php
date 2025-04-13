<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;


$title = 'Trang chủ - Di Travel';

?>

<main class=" min-h-screen bg-gray-50">
  <!-- Hero Section -->
  <section class="relative overflow-hidden" style="height: calc(100vh - 80px);">
    <div class="absolute inset-0">
      <video autoplay muted loop class="w-full h-full object-cover">
        <source
          src="https://storage.googleapis.com/teko-gae.appspot.com/media/video/2023/11/19/22451432-c310-4081-858c-cfb57570e249/6487d1c5c3473ff5e5376abd_camelia-transcode.webm">
      </video>
      <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    </div>
    <div class="relative h-full flex items-center justify-center px-4">
      <div class="text-center max-w-3xl">
        <h1 class="text-xl md:text-5xl lg:text-6xl font-bold text-white mb-3">
          Di Travel
        </h1>
        <p class="text-l text-white mb-5">
          Tại DiTravel, chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch độc đáo, những dịch vụ chất lượng
          và những thông tin hữu ích để bạn có thể lên kế hoạch cho chuyến đi hoàn hảo.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <!-- Button nổi bật chính -->
          <a href="<?= UrlHelper::route('home/tours') ?>">
            <button
              class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-1 hover:shadow-xl">
              <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Khám phá ngay
              </span>
            </button>
          </a>

          <!-- Button đặt lịch -->
          <a href="<?= UrlHelper::route('home/contact') ?>">
            <button
              class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-1 hover:shadow-xl">
              <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Liên hệ
              </span>
            </button>
          </a>
        </div>
      </div>
    </div>
    </div>
  </section>

  <!-- Search Section -->
  <section class="p-8 bg-gradient-to-r from-teal-50 bg-teal-50">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-xl relative z-10 p-8 border border-gray-100">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          Tìm kiếm tour du lịch
        </h2>
      </div>

      <form method="get" action="<?= UrlHelper::route('home/tours') ?>">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-1">
            <label class="block text-gray-700 font-medium mb-2">Danh mục</label>
            <div class="relative">
              <select name="category"
                class="w-full p-3 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white appearance-none">
                <option>Tất cả danh mục</option>
                <?php foreach ($categories as $category) { ?>
                  <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
                <?php } ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="md:col-span-1">
            <label class="block text-gray-700 font-medium mb-2">Địa điểm</label>
            <div class="relative">
              <select name="location"
                class="w-full p-3 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white appearance-none">
                <option>Tất cả địa điểm</option>
                <?php
                foreach ($locations as $location) { ?>
                  <option value="<?= $location["id"] ?>"><?= $location["name"] ?></option>
                <?php } ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
          </div>
          <div class="md:col-span-1 flex items-end">
            <button
              class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Tìm kiếm
            </button>
          </div>
        </div>
      </form>

      <div class="mt-6 flex flex-wrap gap-2">
        <div class="text-sm text-gray-500 hidden md:block">Tìm kiếm nhanh chóng tour phù hợp với bạn</div>
      </div>
    </div>
  </section>


  <!-- Featured Destinations -->
  <section class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Điểm đến nổi bật</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Hãy cùng chúng tôi hòa mình vào văn hóa bản địa, thưởng thức ẩm thực đặc sắc và tạo nên những kỷ niệm khó
          quên.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Destination Card 1 -->
        <?php foreach ($allFeaturedTours as $tour) {
          $isFavorited = isset($_SESSION['user_id']) && in_array($tour['id'], $userFavorites);

          $heartClass = $isFavorited ? "text-red-500" : "text-teal-500";
        ?>
          <div
            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
            <div class="relative">
              <!-- Tour Image -->
              <div class="h-56 overflow-hidden relative rounded-lg bg-gray-100">
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


                <!-- Ảnh chính -->
                <img src="<?= $tour['cloudinary_url'] ?>" alt="<?= $tour['title'] ?>"
                  class="w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                  onload="document.getElementById('placeholder-<?= $tour['id'] ?>').style.display='none'; this.style.opacity='1';"
                  onerror="this.onerror=null; this.style.display='none'; showErrorPlaceholder('<?= $tour['id'] ?>', '<?= htmlspecialchars($tour['title'], ENT_QUOTES) ?>');"
                  style="opacity: 0;">
              </div>

              <!-- Discount Badge -->


              <?= $tour['sale_price'] ?
                ' <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">' .
                number_format((($tour['price'] - $tour['sale_price']) / $tour['price']) * 100) . '%'
                . '</div>'
                : ''
              ?>

              <!-- Favorite Button -->
              <button data-tour-id="<?php echo $tour['id']; ?>"
                class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300 favorite-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $heartClass ?> fill-current" viewBox="0 0 24 24">
                  <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
              </button>

              <!-- Duration Badge -->
              <div
                class="absolute bottom-4 left-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium">
                <?= $tour['duration'] ?>
              </div>
            </div>

            <div class="p-5">
              <!-- Tour Title -->
              <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>">
                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14">
                  <?= $tour['title'] ?>
                </h3>
              </a>

              <!-- Rating -->
              <div class="flex items-center mb-3">
                <div class="flex text-yellow-400">
                  <?php
                  $avgRating = isset($tour['avg_rating']) ? floatval($tour['avg_rating']) : 0;
                  $reviewCount = isset($tour['review_count']) ? intval($tour['review_count']) : 0;

                  for ($i = 1; $i <= 5; $i++) {
                    if ($avgRating >= $i) {
                      echo '<span class="text-yellow-400">★</span>';
                    } elseif ($avgRating >= $i - 0.5) {
                      echo '<span class="text-yellow-400">⯨</span>';
                    } else {
                      echo '<span class="text-gray-300">☆</span>';
                    }
                  }
                  ?>
                </div>
                <span class="text-gray-600 ml-2">
                  <?= number_format($avgRating, 1) ?>
                  (<?= $reviewCount ?> đánh giá)
                </span>
              </div>

              <!-- Description -->
              <p class="text-gray-600 mb-4 text-sm line-clamp-2 h-10">
                <?= $tour['description'] ?>
              </p>

              <!-- Departure Date -->
              <div class="flex items-center mb-4 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <?php if (!empty($tour['next_start_date'])) { ?>
                  <?php if ($tour['date_count'] == 1) { ?>
                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
                  <?php } else { ?>
                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
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
                </div>
                <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>"
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                  Xem chi tiết
                </a>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>

      <div class="text-center mt-12">
        <a href="<?= UrlHelper::route('home/tours/') ?>">
          <button
            class="bg-white border-2 border-teal-500 hover:bg-teal-50 text-teal-500 font-semibold py-3 px-8 rounded-lg transition duration-300">
            Xem tất cả
          </button>
        </a>
      </div>
    </div>
  </section>

  <!-- Special Offers -->
  <section class="py-12 px-4 bg-teal-50">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Giá cả ưu đãi không thể bỏ lỡ</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Những tour với giá ưu đãi nhất, đi thả ga không lo về giá.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($allTours as $tour) {
          $isFavorited = isset($_SESSION['user_id']) && in_array($tour['id'], $userFavorites);

          $heartClass = $isFavorited ? "text-red-500" : "text-teal-500"; ?>
          <div
            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
            <div class="relative">
              <!-- Tour Image -->
              <div class="h-56 overflow-hidden relative rounded-lg bg-gray-100">
                <!-- Placeholder hiển thị trước khi ảnh load -->
                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                  id="placeholder-offer-<?= $tour['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                  </svg>
                </div>


                <!-- Ảnh chính -->
                <img src="<?= $tour['cloudinary_url'] ?>" alt="<?= $tour['title'] ?>"
                  class="w-full h-full object-cover transition-all duration-300 ease-in-out group-hover:scale-105"
                  onload="document.getElementById('placeholder-offer-<?= $tour['id'] ?>').style.display='none'; this.style.opacity='1';"
                  onerror="this.onerror=null; this.style.display='none'; showErrorPlaceholder('placeholder-offer-<?= $tour['id'] ?>', '<?= htmlspecialchars($tour['title'], ENT_QUOTES) ?>');"
                  style="opacity: 0;">
              </div>


              <!-- Discount Badge -->
              <?= $tour['sale_price'] ?
                ' <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">' .
                number_format((($tour['price'] - $tour['sale_price']) / $tour['price']) * 100) . '%'
                . '</div>'
                : ''
              ?>

              <!-- Favorite Button -->
              <button data-tour-id="<?php echo $tour['id']; ?>"
                class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300 favorite-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $heartClass ?> fill-current" viewBox="0 0 24 24">
                  <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
              </button>

              <!-- Duration Badge -->
              <div
                class="absolute bottom-4 left-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium">
                <?= $tour['duration'] ?>
              </div>
            </div>

            <div class="p-5">
              <!-- Tour Title -->
              <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>">
                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14">
                  <?= $tour['title'] ?>
                </h3>
              </a>

              <!-- Rating -->
              <div class="flex items-center mb-3">
                <div class="flex text-yellow-400">
                  <?php
                  $avgRating = isset($tour['avg_rating']) ? floatval($tour['avg_rating']) : 0;
                  $reviewCount = isset($tour['review_count']) ? intval($tour['review_count']) : 0;

                  for ($i = 1; $i <= 5; $i++) {
                    if ($avgRating >= $i) {
                      echo '<span class="text-yellow-400">★</span>';
                    } elseif ($avgRating >= $i - 0.5) {
                      echo '<span class="text-yellow-400">⯨</span>';
                    } else {
                      echo '<span class="text-gray-300">☆</span>';
                    }
                  }
                  ?>
                </div>
                <span class="text-gray-600 ml-2">
                  <?= number_format($avgRating, 1) ?>
                  (<?= $reviewCount ?> đánh giá)
                </span>
              </div>

              <!-- Departure Date -->
              <div class="flex items-center mb-4 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <?php if (!empty($tour['next_start_date'])) { ?>
                  <?php if ($tour['date_count'] == 1) { ?>
                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
                  <?php } else { ?>
                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
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
                </div>
                <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>"
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                  Xem chi tiết
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <section class="explore-section relative">
    <!-- Hero Banner with Maldives Image -->
    <div class="relative h-[600px] overflow-hidden">
      <img src="https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=1600&h=900&fit=crop"
        alt="Maldives Aerial View" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>

      <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-4">
        <div class="container mx-auto max-w-6xl">
          <h2 class="text-5xl md:text-6xl font-bold mb-6 text-center md:text-left">EXPLORE MALDIVES</h2>
          <div class="w-full h-px bg-white/30 my-6"></div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
            <div class="md:col-span-1">
              <p class="text-white/90 mb-8 max-w-md">
                Khám phá thiên đường biển đảo Maldives với những bãi cát trắng mịn, làn nước trong xanh và những khu
                nghỉ dưỡng sang trọng trên mặt nước. Trải nghiệm kỳ nghỉ đáng nhớ tại một trong những điểm đến đẹp
                nhất hành tinh.
              </p>
              <a href="#"
                class="inline-flex items-center bg-white text-gray-800 px-6 py-3 rounded-full font-medium hover:bg-teal-500 hover:text-white transition-colors">
                Xem tất cả
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </a>
            </div>

            <div class="md:col-span-2 grid grid-cols-3 gap-4">
              <!-- Destination Card 1 -->
              <div class="group">
                <div class="rounded-lg overflow-hidden shadow-lg">
                  <img src="https://images.unsplash.com/photo-1540202404-a2f29016b523?w=500&h=350&fit=crop"
                    alt="Azure Haven"
                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h3 class="text-center text-white font-medium mt-3">Azure Haven</h3>
              </div>

              <!-- Destination Card 2 -->
              <div class="group">
                <div class="rounded-lg overflow-hidden shadow-lg">
                  <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=500&h=350&fit=crop"
                    alt="Serene Sanctuary"
                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h3 class="text-center text-white font-medium mt-3">Serene Sanctuary</h3>
              </div>

              <!-- Destination Card 3 -->
              <div class="group">
                <div class="rounded-lg overflow-hidden shadow-lg">
                  <img src="https://images.unsplash.com/photo-1602002418816-5c0aeef426aa?w=500&h=350&fit=crop"
                    alt="Verdant Vista"
                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h3 class="text-center text-white font-medium mt-3">Verdant Vista</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature News Section -->
    <div class="bg-white py-16">
      <div class="container mx-auto max-w-6xl px-4">
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tin tức</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- News Card 1 -->
          <?php foreach ($news as $item) { ?>
            <div
              class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100">
              <div class="h-48 overflow-hidden relative bg-gray-100">
                <!-- Placeholder hiển thị trước khi ảnh load -->
                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                  id="placeholder-news-<?= $item['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-30" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                  </svg>
                </div>

                <!-- Ảnh chính -->
                <img src="<?= $item['featured_image'] ?>" alt="<?= $item['title'] ?>"
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                  onload="document.getElementById('placeholder-news-<?= $item['id'] ?>').style.display='none'; this.style.opacity='1';"
                  onerror="this.onerror=null; this.style.display='none'; showErrorNewsPlaceholder('placeholder-news-<?= $item['id'] ?>', '<?= htmlspecialchars($item['title'], ENT_QUOTES) ?>');"
                  style="opacity: 0;">
              </div>

              <div class="p-5">
                <div class="flex items-center text-gray-500 text-sm mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>

                  <?= FormatHelper::formatDate($item["created_at"]) ?>

                </div>

                <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>">
                  <h3 class="font-bold text-gray-800 text-lg mb-2"><?= $item['title'] ?></h3>
                </a>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                  <?= $item['summary'] ?>
                </p>

                <a href="<?= UrlHelper::route('home/news-detail/' . $item['id']) ?>"
                  class="inline-flex items-center text-teal-500 hover:text-teal-600 font-medium text-sm">
                  <span class="w-6 h-6 rounded-full border border-teal-500 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </span>
                  Xem chi tiết
                </a>
              </div>
            </div>
          <?php } ?>


        </div>

        <div class="text-center mt-12">
          <a href="<?= UrlHelper::route('home/news/') ?>">
            <button
              class="bg-white border-2 border-teal-500 hover:bg-teal-50 text-teal-500 font-semibold py-3 px-8 rounded-lg transition duration-300">
              Xem tất cả
            </button>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-12 px-4 bg-teal-50">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Khách hàng nói gì về chúng tôi</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Cùng đọc những trải nghiệm mà các vị khách đã nhận được trong suốt những chuyến hành trình cùng Di Travel
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div
          class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
          <div class="flex items-center mb-4">
            <div class="flex text-yellow-400 mb-2">
              <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
          </div>
          <p class="text-gray-600 mb-6 italic">
            "The trip to Bali was absolutely amazing! The accommodations were perfect, and our guide was knowledgeable
            and friendly. I can't wait to book my next adventure!"
          </p>
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-100 relative">
              <!-- Placeholder hiển thị trước khi ảnh load -->
              <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                id="testimonial-placeholder-1">
                <span class="font-semibold text-teal-500 text-lg">SJ</span>
              </div>
              <!-- Ảnh avatar -->
              <img src="https://placeholder.co/50x50" alt="Sarah Johnson"
                class="w-full h-full object-cover opacity-0 transition-opacity duration-300"
                onload="this.style.opacity='1'; document.getElementById('testimonial-placeholder-1').style.display='none';"
                onerror="handleTestimonialImageError(this, 'testimonial-placeholder-1', 'Sarah Johnson');" />
            </div>
            <div>
              <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
              <p class="text-gray-500 text-sm">Bali, Indonesia</p>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div
          class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
          <div class="flex items-center mb-4">
            <div class="flex text-yellow-400 mb-2">
              <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
          </div>
          <p class="text-gray-600 mb-6 italic">
            "Our family trip to Japan exceeded all expectations. The itinerary was perfectly balanced with cultural
            experiences and fun activities for the kids. Highly recommended!"
          </p>
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-100 relative">
              <!-- Placeholder hiển thị trước khi ảnh load -->
              <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                id="testimonial-placeholder-2">
                <span class="font-semibold text-teal-500 text-lg">MC</span>
              </div>
              <!-- Ảnh avatar -->
              <img src="https://placeholder.co/50x50" alt="Michael Chen"
                class="w-full h-full object-cover opacity-0 transition-opacity duration-300"
                onload="this.style.opacity='1'; document.getElementById('testimonial-placeholder-2').style.display='none';"
                onerror="handleTestimonialImageError(this, 'testimonial-placeholder-2', 'Michael Chen');" />
            </div>
            <div>
              <h4 class="font-semibold text-gray-800">Michael Chen</h4>
              <p class="text-gray-500 text-sm">Tokyo, Japan</p>
            </div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div
          class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
          <div class="flex items-center mb-4">
            <div class="flex text-yellow-400 mb-2">
              <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
          </div>
          <p class="text-gray-600 mb-6 italic">
            "The European tour was the trip of a lifetime! Every detail was taken care of, and we got to experience
            the best of each city we visited. I'm already planning my next trip!"
          </p>
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-100 relative">
              <!-- Placeholder hiển thị trước khi ảnh load -->
              <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                id="testimonial-placeholder-3">
                <span class="font-semibold text-teal-500 text-lg">ER</span>
              </div>
              <!-- Ảnh avatar -->
              <img src="https://placeholder.co/50x50" alt="Emily Rodriguez"
                class="w-full h-full object-cover opacity-0 transition-opacity duration-300"
                onload="this.style.opacity='1'; document.getElementById('testimonial-placeholder-3').style.display='none';"
                onerror="handleTestimonialImageError(this, 'testimonial-placeholder-3', 'Emily Rodriguez');" />
            </div>
            <div>
              <h4 class="font-semibold text-gray-800">Emily Rodriguez</h4>
              <p class="text-gray-500 text-sm">Paris, France</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-white">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Tại Sao Chọn Di Travel</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Reason 1 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đặt Tour An Toàn 100%</h3>
        <p class="text-gray-600 text-center">
          Thanh toán dễ dàng, thông tin cá nhân của bạn luôn được bảo vệ với hệ thống đặt tour an toàn và bảo mật của
          chúng tôi.
        </p>
      </div>

      <!-- Reason 2 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Hỗ Trợ 24/7</h3>
        <p class="text-gray-600 text-center">
          Đội ngũ dịch vụ khách hàng tận tâm của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc với bất kỳ câu hỏi hoặc
          thắc
          mắc nào.
        </p>
      </div>

      <!-- Reason 3 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đảm Bảo Giá Tốt Nhất</h3>
        <p class="text-gray-600 text-center">
          Chúng tôi cung cấp giá cả cạnh tranh và sẽ đáp ứng bất kỳ ưu đãi tương đương nào cho cùng một tour và điều
          kiện.
        </p>
      </div>

      <!-- Reason 4 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">HDV Chuyên Nghiệp</h3>
        <p class="text-gray-600 text-center">
          Các hướng dẫn viên am hiểu của chúng tôi cung cấp góc nhìn nội địa và đảm bảo bạn trải nghiệm bản chất chân
          thực của mỗi điểm đến.
        </p>
      </div>
    </div>
  </div>

  <!-- Call to Action -->
  <section class="py-12 px-4 bg-gray-900 text-white">
    <div class="max-w-6xl mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Bạn đã sẵn sàng cho chuyến đi sắp tới?</h2>
      <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
        Cùng Di Travel tạo nên những hành trình tuyệt vời chỉ với một cú nhấp chuột.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="<?= UrlHelper::route('home/tours') ?>">
          <button
            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
            Khám phá ngay
          </button>
        </a>
        <a href="<?= UrlHelper::route('home/contact') ?>">
          <button
            class="bg-transparent hover:bg-white hover:text-gray-900 text-white font-semibold py-3 px-8 rounded-lg border-2 border-white transition duration-300">
            Liên hệ với chúng tôi
          </button>
        </a>
      </div>
    </div>
  </section>
</main>


<script>
  // Thêm vào phần script hiện có
  function handleTestimonialImageError(img, placeholderId, name) {
    img.style.display = 'none';
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) {
      // Tạo viết tắt từ tên
      const initials = name.split(' ')
        .map(part => part.charAt(0))
        .join('')
        .substring(0, 2);

      // Hiển thị viết tắt trong một vòng tròn có màu
      placeholder.innerHTML = `
      <div class="w-full h-full flex items-center justify-center bg-teal-100">
        <span class="font-semibold text-teal-600 text-lg">${initials}</span>
      </div>
    `;
      placeholder.style.display = 'flex';
    }
  }

  // Thêm function này vào đoạn script xử lý ảnh
  function showErrorPlaceholder(placeholderId, title) {
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) {
      placeholder.innerHTML = `
      <div class="flex flex-col items-center justify-center h-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        <span class="text-gray-600 text-center px-4 text-sm">${title || 'Tour du lịch'}</span>
      </div>
    `;
      placeholder.style.display = 'flex';
    }
  }

  function showErrorNewsPlaceholder(placeholderId, title) {
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) {
      placeholder.innerHTML = `
      <div class="flex flex-col items-center justify-center h-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-teal-500 mb-2" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        <span class="text-gray-600 text-center px-4 text-sm">${title || 'Tin tức'}</span>
      </div>
    `;
      placeholder.style.display = 'flex';
    }
  }
</script>
<script src="<?= UrlHelper::route('assets/js/admin/favorites.js') ?>"></script>
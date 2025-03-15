<?php
// filepath: c:\xampp\htdocs\project\app\views\errors\404.php
use App\Helpers\UrlHelper;
?>

<div class="flex-1 flex items-center justify-center bg-gradient-to-b from-gray-50 to-gray-100 p-4 sm:p-6">
  <div class="w-full max-w-md">
    <div class="bg-white rounded-md shadow-md overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
      <!-- 404 Header with Animation -->
      <div class="relative h-36 sm:h-46 bg-gradient-to-r from-teal-600 to-teal-400 overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute inset-0">
          <?php for($i = 0; $i < 8; $i++): ?>
          <div class="absolute animate-pulse"
            style="width: <?= rand(40, 180) ?>px; height: <?= rand(40, 180) ?>px; background-color: white; opacity: <?= rand(5, 15) / 100 ?>; top: <?= rand(-40, 140) ?>px; left: <?= rand(-40, 500) ?>px; transform: rotate(<?= rand(0, 45) ?>deg); border-radius: <?= rand(0, 100) ?>%;">
          </div>
          <?php endfor; ?>
        </div>

        <!-- 404 Text -->
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="flex items-center space-x-3">
            <span class="text-7xl sm:text-8xl font-bold text-white drop-shadow-lg">4</span>
            <div class="relative">
              <div
                class="w-20 h-20 sm:w-24 sm:h-24 bg-white bg-opacity-10 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white border-opacity-20">
                <svg class="animate-spin h-12 w-12 sm:h-14 sm:w-14 text-white" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
              </div>
            </div>
            <span class="text-7xl sm:text-8xl font-bold text-white drop-shadow-lg">4</span>
          </div>
        </div>

        <!-- Animated Dots -->
        <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-1.5">
          <?php for($i = 0; $i < 5; $i++): ?>
          <div class="animate-bounce" style="animation-delay: <?= $i * 100 ?>ms;">
            <div class="h-1.5 w-1.5 rounded-full bg-white bg-opacity-70"></div>
          </div>
          <?php endfor; ?>
        </div>
      </div>

      <div class="px-3 py-5 sm:px-5">
        <div class="text-center">
          <h1
            class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-teal-400 mb-3">
            Oops! Trang không tồn tại
          </h1>

          <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển đến địa chỉ khác.
          </p>

          <?php if(isset($view) && defined('DEBUG') && DEBUG): ?>
          <div class="mb-8 bg-teal-50 rounded-lg p-4">
            <div class="flex items-center justify-center gap-2 text-sm">
              <span class="text-gray-500">Trang được yêu cầu:</span>
              <code class="px-2 py-1 bg-white rounded text-teal-600 font-mono border border-teal-100">
                <?= htmlspecialchars($view ?? 'Unknown') ?>
              </code>
            </div>
          </div>
          <?php endif; ?>

          <div class="flex flex-col sm:flex-row gap-3 space-x-2 justify-center">
            <a href="javascript:history.back()"
              class="inline-flex items-center justify-center px-5 py-3 border border-teal-200 text-teal-700 hover:text-teal-600 hover:border-teal-300 font-medium rounded-lg transition-all duration-200 bg-white hover:bg-teal-50">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                  clip-rule="evenodd" />
              </svg>
              Quay lại
            </a>

            <a href="<?= UrlHelper::route('') ?>"
              class="inline-flex items-center justify-center px-5 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path
                  d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
              </svg>
              Về trang chủ
            </a>
          </div>
        </div>
      </div>

      <!-- Decorative footer -->
      <!-- <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-gray-50">
        <div class="flex justify-center items-center gap-3">
          <div class="h-px flex-1 bg-gradient-to-r from-transparent to-teal-200"></div>
          <div class="text-teal-400">404</div>
          <div class="h-px flex-1 bg-gradient-to-r from-teal-200 to-transparent"></div>
        </div>
      </div> -->
    </div>
  </div>
</div>
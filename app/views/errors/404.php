<div class="flex items-center justify-center bg-gray-100 p-6">
  <div class="max-w-md w-full bg-white rounded-lg shadow-xl overflow-hidden">
    <div class="p-6">
      <div class="flex justify-center mb-8">
        <div class="text-6xl font-bold text-red-500">404</div>
      </div>

      <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
        Trang không tồn tại
      </h2>

      <p class="text-gray-600 text-center mb-8">
        Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.
      </p>

      <?php
        use App\Helpers\UrlHelper;
        
        // Lấy thông tin về lỗi cho debug
        $requestedView = isset($view) ? $view : 'Unknown';
      ?>
      <div class="bg-gray-50 p-4 rounded-md mb-6 text-sm flex items-center gap-2">
        <div class="text-gray-500">Trang được yêu cầu:</div>
        <div class="font-mono text-red-600"><?= htmlspecialchars($requestedView) ?></div>
      </div>

      <div class="flex justify-center">
        <a href="<?= UrlHelper::route('')?>"
          class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors">
          Về trang chủ
        </a>
      </div>
    </div>
  </div>
</div>
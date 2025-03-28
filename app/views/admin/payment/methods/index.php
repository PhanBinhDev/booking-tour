<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Phương thức thanh toán
      </h2>
      <p class="mt-1 text-gray-600">Quản lý các phương thức thanh toán trong hệ thống</p>
    </div>

    <a href="<?= UrlHelper::route('admin/payment/methods/create') ?>"
      class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      Thêm phương thức
    </a>
  </div>

  <!-- Alert Messages -->
  <?php if(isset($_SESSION['success'])): ?>
  <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-green-700"><?= $_SESSION['success'] ?></p>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['success']); endif; ?>

  <!-- Payment Methods Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($methods as $method): ?>
    <div
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:border-teal-500 transition-colors">
      <div class="p-6 h-full flex flex-col">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center">
            <div class="h-10 w-10 rounded-lg bg-teal-50 flex items-center justify-center mr-3">
              <?php if($method['code'] === 'card'): ?>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
              <?php elseif($method['code'] === 'bank'): ?>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
              </svg>
              <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <?php endif; ?>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($method['name']) ?></h3>
              <p class="text-sm text-gray-500"><?= htmlspecialchars($method['code']) ?></p>
            </div>
          </div>
          <div class="flex items-center">
            <span
              class="px-2 py-1 text-xs rounded-full <?= $method['is_active'] ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600' ?>">
              <?= $method['is_active'] ? 'Đang hoạt động' : 'Đã tắt' ?>
            </span>
          </div>
        </div>

        <?php if(!empty($method['description'])): ?>
        <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($method['description']) ?></p>
        <?php endif; ?>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
          <a href="<?= UrlHelper::route('admin/payment/methods/edit/' . $method['id']) ?>"
            class="text-teal-600 hover:text-teal-700 font-medium text-sm">
            Chỉnh sửa
          </a>
          <?php if($method['is_active']): ?>
          <form action="<?= UrlHelper::route('admin/payment/methods/toggle/' . $method['id']) ?>" method="POST"
            class="inline">
            <?php $this->createCSRFToken(); ?>
            <input type="hidden" name="status" value="0">
            <button type="submit" class="text-gray-600 hover:text-gray-700 font-medium text-sm">
              Tạm dừng
            </button>
          </form>
          <?php else: ?>
          <form action="<?= UrlHelper::route('admin/payment/methods/toggle/' . $method['id']) ?>" method="POST"
            class="inline">
            <?php $this->createCSRFToken(); ?>
            <input type="hidden" name="status" value="1">
            <button type="submit" class="text-teal-600 hover:text-teal-700 font-medium text-sm">
              Kích hoạt
            </button>
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
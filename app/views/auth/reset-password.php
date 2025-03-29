<?php

use App\Helpers\UrlHelper;
?>


<div class="flex items-center justify-center px-4 py-12">
  <div class="max-w-md w-full">
    <!-- Logo (optional) -->
    <div class="text-center mb-6">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-100 text-teal-500 mb-2">
        <i class="fas fa-key text-2xl"></i>
      </div>
      <h1 class="text-3xl font-bold text-gray-800">Đặt lại mật khẩu</h1>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="p-6 sm:p-8">
        <?php if (isset($errors['reset'])): ?>
          <div class="bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-lg mb-6" role="alert">
            <span class="block sm:inline"><?php echo $errors['reset']; ?></span>
          </div>
        <?php endif; ?>

        <form method="post" action="<?php echo UrlHelper::route('auth/reset-password/' . $token); ?>">
          <input type="hidden" name="token" value="<?php echo $token; ?>">

          <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input
                type="password"
                id="password"
                name="password"
                class="pl-10 w-full px-4 py-3 border <?php echo isset($errors['password']) ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-teal-500 focus:border-teal-500'; ?> rounded-lg shadow-sm"
                required>
            </div>
            <?php if (isset($errors['password'])): ?>
              <p class="mt-2 text-sm text-red-600">
                <?php echo $errors['password']; ?>
              </p>
            <?php else: ?>
              <p class="mt-2 text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i> Tối thiểu 6 ký tự
              </p>
            <?php endif; ?>
          </div>

          <div class="mb-6">
            <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                class="pl-10 w-full px-4 py-3 border <?php echo isset($errors['password_confirm']) ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-teal-500 focus:border-teal-500'; ?> rounded-lg shadow-sm"
                required>
            </div>
            <?php if (isset($errors['password_confirm'])): ?>
              <p class="mt-2 text-sm text-red-600">
                <?php echo $errors['password_confirm']; ?>
              </p>
            <?php endif; ?>
          </div>

          <div class="mb-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
              Đặt lại mật khẩu
            </button>
          </div>

          <div class="text-center">
            <a href="<?php echo UrlHelper::route('auth/login'); ?>" class="text-sm font-medium text-teal-600 hover:text-teal-500 flex items-center justify-center">
              <i class="fas fa-arrow-left mr-2"></i>
              Quay lại đăng nhập
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- Security Note -->
    <div class="mt-6 text-center">
      <div class="flex items-center justify-center text-sm text-gray-500 mb-2">
        <i class="fas fa-shield-alt text-teal-500 mr-2"></i>
        <span>Bảo mật cao</span>
      </div>
      <p class="text-xs text-gray-500">Mật khẩu của bạn được mã hóa và bảo vệ an toàn</p>
    </div>
  </div>
</div>
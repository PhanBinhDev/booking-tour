<?php

use App\Helpers\UrlHelper;
?>


<div class="flex items-center justify-center px-4 py-12">
  <div class="max-w-md w-full">
    <!-- Logo (optional) -->
    <div class="text-center mb-6">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-100 text-teal-500 mb-2">
        <i class="fas fa-lock text-2xl"></i>
      </div>
      <h1 class="text-3xl font-bold text-gray-800">Quên mật khẩu</h1>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="p-6 sm:p-8">
        <p class="text-gray-600 text-center mb-8">
          Nhập email của bạn và chúng tôi sẽ gửi hướng dẫn đặt lại mật khẩu.
        </p>

        <?php if (isset($_SESSION['flash_message'])): ?>
          <div
            class="<?php echo $_SESSION['flash_message']['type'] === 'success' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-red-50 text-red-700 border-red-200'; ?> px-4 py-3 rounded-lg border mb-6 relative"
            role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['flash_message']['message']; ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
              onclick="this.parentElement.style.display='none'">
              <i class="fas fa-times text-sm"></i>
            </button>
          </div>
          <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <form method="post" action="<?php echo UrlHelper::route('auth/forgot-password'); ?>">
          <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
              </div>
              <input type="email" id="email" name="email"
                class="pl-10 w-full px-4 py-3 bg-blue-50 border-0 <?php echo isset($errors['email']) ? 'text-red-900 placeholder-red-300 focus:outline-none focus:ring-1 focus:ring-red-500' : 'text-gray-900 focus:outline-none focus:ring-1 focus:ring-teal-500'; ?> rounded-md shadow-sm"
                placeholder="your.email@example.com" value="<?php echo $email ?? ''; ?>" required>
            </div>
            <?php if (isset($errors['email'])): ?>
              <p class="mt-2 text-sm text-red-600">
                <?php echo $errors['email']; ?>
              </p>
            <?php endif; ?>
          </div>

          <div class="mb-6">
            <button type="submit"
              class="w-full flex justify-center py-3 px-4 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
              Gửi yêu cầu đặt lại mật khẩu
            </button>
          </div>

          <div class="text-center">
            <a href="<?php echo UrlHelper::route('auth/login'); ?>"
              class="text-sm font-medium text-teal-500 hover:text-teal-600 flex items-center justify-center">
              <i class="fas fa-arrow-left mr-2"></i>
              Quay lại đăng nhập
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-sm text-gray-500">
      <p>Cần trợ giúp? <a href="#" class="font-medium text-teal-500 hover:text-teal-600">Liên hệ hỗ trợ</a></p>
    </div>
  </div>
</div>
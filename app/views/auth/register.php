<?php
// filepath: c:\xampp\htdocs\project\app\views\auth\register.php
use App\Helpers\UrlHelper;

$title = 'Đăng Ký Tài Khoản - Di Travel';
$activePage = 'register';
?>

<div class="min-h-screen bg-white py-10 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto">
    <!-- Logo & Header -->
    <div class="text-center mb-6">
      <a href="<?= UrlHelper::route('') ?>" class="inline-block">
        <img src="<?= UrlHelper::asset('images/logo.png') ?>" alt="Di Travel" class="h-10 mx-auto">
      </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
      <?php if (isset($errors['register'])): ?>
        <div class="mb-6 p-3 rounded-md bg-red-50 text-red-600 text-sm border-l-4 border-red-500">
          <?= $errors['register'] ?>
        </div>
      <?php endif; ?>

      <form action="<?= UrlHelper::route('auth/register') ?>" method="POST" class="space-y-5">
        <!-- Basic info -->
        <div>
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Thông tin cơ bản</h3>
            <span class="text-xs text-red-500">* Thông tin bắt buộc</span>
          </div>

          <div class="space-y-4">
            <div>
              <label for="username" class="block text-sm font-medium text-gray-700">
                Tên đăng nhập <span class="text-red-500">*</span>
              </label>
              <div class="mt-1">
                <input type="text" name="username" id="username"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 <?= isset($errors['username']) ? 'border-red-300' : '' ?>"
                  value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                <?php if (isset($errors['username'])): ?>
                  <p class="mt-1 text-sm text-red-600"><?= $errors['username'] ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div>
              <label for="full_name" class="block text-sm font-medium text-gray-700">
                Họ và tên
              </label>
              <div class="mt-1">
                <input type="text" name="full_name" id="full_name"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500"
                  value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>">
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">
                Email <span class="text-red-500">*</span>
              </label>
              <div class="mt-1">
                <input type="email" name="email" id="email"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 <?= isset($errors['email']) ? 'border-red-300' : '' ?>"
                  value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <?php if (isset($errors['email'])): ?>
                  <p class="mt-1 text-sm text-red-600"><?= $errors['email'] ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700">
                Số điện thoại
              </label>
              <div class="mt-1">
                <input type="tel" name="phone" id="phone"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500"
                  value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- Password section -->
        <div class="pt-2">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Mật khẩu</h3>

          <div class="space-y-4">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">
                Mật khẩu <span class="text-red-500">*</span>
              </label>
              <div class="mt-1">
                <input type="password" name="password" id="password"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 <?= isset($errors['password']) ? 'border-red-300' : '' ?>"
                  required>
                <?php if (isset($errors['password'])): ?>
                  <p class="mt-1 text-sm text-red-600"><?= $errors['password'] ?></p>
                <?php else: ?>
                  <p class="mt-1 text-xs text-gray-500">Ít nhất 6 ký tự</p>
                <?php endif; ?>
              </div>
            </div>

            <div>
              <label for="password_confirm" class="block text-sm font-medium text-gray-700">
                Xác nhận mật khẩu <span class="text-red-500">*</span>
              </label>
              <div class="mt-1">
                <input type="password" name="password_confirm" id="password_confirm"
                  class="block w-full px-3 py-2 border-0 bg-blue-50 text-gray-900 rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 <?= isset($errors['password_confirm']) ? 'border-red-300' : '' ?>"
                  required>
                <?php if (isset($errors['password_confirm'])): ?>
                  <p class="mt-1 text-sm text-red-600"><?= $errors['password_confirm'] ?></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start pt-2">
          <div class="flex items-center h-5">
            <input id="agree_terms" name="agree_terms" type="checkbox"
              class="h-4 w-4 text-teal-500 focus:ring-teal-500 border-gray-300 rounded <?= isset($errors['agree_terms']) ? 'border-red-300' : '' ?>">
          </div>
          <div class="ml-3 text-sm">
            <label for="agree_terms" class="text-gray-700">
              Tôi đồng ý với <a href="#" class="text-teal-500 hover:text-teal-600 font-medium">Điều khoản sử
                dụng</a> và <a href="#" class="text-teal-500 hover:text-teal-600 font-medium">Chính sách bảo
                mật</a>
            </label>
            <?php if (isset($errors['agree_terms'])): ?>
              <p class="mt-1 text-sm text-red-600"><?= $errors['agree_terms'] ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div class="pt-2">
          <button type="submit"
            class="w-full flex justify-center py-2 px-4 border-0 rounded-md text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
            Tạo tài khoản
          </button>
        </div>
      </form>

      <div class="mt-5 text-center text-sm">
        Đã có tài khoản? <a href="<?= UrlHelper::route('auth/login') ?>"
          class="font-medium text-teal-500 hover:text-teal-600">Đăng nhập</a>
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center">
      <p class="text-xs text-gray-500">
        &copy; <?= date('Y') ?> Di Travel. Đã đăng ký bản quyền.
      </p>
    </div>
  </div>
</div>
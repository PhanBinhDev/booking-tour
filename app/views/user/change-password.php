<?php
use App\Helpers\UrlHelper;

$title = 'Đổi mật khẩu';
?>

<div class="py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Thông tin cá nhân</h1>

    <?php if (isset($_SESSION['flash'])): ?>
    <div
      class="mb-6 p-4 rounded-md <?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' ?>">
      <?= $_SESSION['flash']['message'] ?>
    </div>
    <?php endif; ?>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <!-- Tabs -->
      <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
          <a href="<?= UrlHelper::route('user/profile') ?>"
            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
            Thông tin cá nhân
          </a>
          <a href="<?= UrlHelper::route('user/changePassword') ?>"
            class="border-teal-500 text-teal-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
            Đổi mật khẩu
          </a>
        </nav>
      </div>

      <form action="<?= UrlHelper::route('user/changePassword') ?>" method="POST" class="p-6">
        <div class="max-w-md mx-auto space-y-6">
          <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
              Mật khẩu hiện tại
            </label>
            <input type="password" name="current_password" id="current_password" required
              class="bg-white border <?= isset($errors['current_password']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
            <?php if (isset($errors['current_password'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['current_password'] ?></p>
            <?php endif; ?>
          </div>

          <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
              Mật khẩu mới
            </label>
            <input type="password" name="new_password" id="new_password" required
              class="bg-white border <?= isset($errors['new_password']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
            <?php if (isset($errors['new_password'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['new_password'] ?></p>
            <?php else: ?>
            <p class="mt-1 text-xs text-gray-500">Mật khẩu phải có ít nhất 6 ký tự</p>
            <?php endif; ?>
          </div>

          <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">
              Xác nhận mật khẩu mới
            </label>
            <input type="password" name="confirm_password" id="confirm_password" required
              class="bg-white border <?= isset($errors['confirm_password']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
            <?php if (isset($errors['confirm_password'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['confirm_password'] ?></p>
            <?php endif; ?>
          </div>

          <div class="pt-5">
            <div class="flex justify-end">
              <a href="<?= UrlHelper::route('user/profile') ?>"
                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Hủy
              </a>
              <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Đổi mật khẩu
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
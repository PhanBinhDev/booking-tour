<?php
use App\Helpers\UrlHelper;

$title = 'Thông tin cá nhân';
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
            class="border-teal-500 text-teal-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
            Thông tin cá nhân
          </a>
          <a href="<?= UrlHelper::route('user/changePassword') ?>"
            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
            Đổi mật khẩu
          </a>
        </nav>
      </div>

      <form action="<?= UrlHelper::route('user/update-profile') ?>" method="POST" enctype="multipart/form-data"
        class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Avatar -->
          <div class="md:col-span-1">
            <div class="flex flex-col items-center space-y-4">
              <div class="relative">
                <?php if (!empty($user['avatar'])): ?>
                <img src="<?= $user['avatar'] ?>" alt="<?= $user['username'] ?>"
                  class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-md">
                <?php else: ?>
                <div
                  class="h-32 w-32 rounded-full bg-teal-600 flex items-center justify-center text-white text-4xl font-medium border-4 border-white shadow-md">
                  <?= strtoupper(substr($user['username'], 0, 1)) ?>
                </div>
                <?php endif; ?>
              </div>

              <div class="w-full">
                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">
                  Thay đổi ảnh đại diện
                </label>
                <input type="file" name="avatar" id="avatar" accept="image/*"
                  class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                <?php if (isset($errors['avatar'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['avatar'] ?></p>
                <?php endif; ?>
              </div>

              <div class="w-full">
                <p class="text-xs text-gray-500">
                  Chấp nhận file ảnh JPG, PNG hoặc GIF. Kích thước tối đa 5MB.
                </p>
              </div>
            </div>
          </div>

          <!-- Thông tin cơ bản -->
          <div class="md:col-span-2 space-y-6">
            <div>
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Thông tin cơ bản</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                  Tên đăng nhập
                </label>
                <input type="text" id="username" value="<?= $user['username'] ?>"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                  disabled>
                <p class="mt-1 text-xs text-gray-500">Tên đăng nhập không thể thay đổi</p>
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                  Email
                </label>
                <input type="email" id="email" value="<?= $user['email'] ?>"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                  disabled>
                <p class="mt-1 text-xs text-gray-500">Email không thể thay đổi</p>
              </div>

              <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Họ và tên
                </label>
                <input type="text" name="full_name" id="full_name" value="<?= $user['full_name'] ?? '' ?>"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
              </div>

              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                  Số điện thoại
                </label>
                <input type="tel" name="phone" id="phone" value="<?= $user['phone'] ?? '' ?>"
                  class="bg-white border <?= isset($errors['phone']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                <?php if (isset($errors['phone'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['phone'] ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div>
              <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                Địa chỉ
              </label>
              <textarea name="address" id="address" rows="2"
                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"><?= $user['address'] ?? '' ?></textarea>
            </div>

            <div>
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mt-8">Thông tin chi tiết</h3>
            </div>

            <div>
              <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">
                Giới thiệu bản thân
              </label>
              <textarea name="bio" id="bio" rows="3"
                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"><?= $profile['bio'] ?? '' ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                  Ngày sinh
                </label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                  value="<?= $profile['date_of_birth'] ?? '' ?>"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
              </div>

              <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                  Giới tính
                </label>
                <select name="gender" id="gender"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                  <option value="">-- Chọn giới tính --</option>
                  <option value="male"
                    <?= (isset($profile['gender']) && $profile['gender'] === 'male') ? 'selected' : '' ?>>Nam</option>
                  <option value="female"
                    <?= (isset($profile['gender']) && $profile['gender'] === 'female') ? 'selected' : '' ?>>Nữ</option>
                  <option value="other"
                    <?= (isset($profile['gender']) && $profile['gender'] === 'other') ? 'selected' : '' ?>>Khác</option>
                </select>
              </div>
            </div>

            <div>
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mt-8">Liên kết mạng xã hội</h3>
            </div>

            <div class="grid grid-cols-1 gap-4">
              <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                  Website
                </label>
                <input type="url" name="website" id="website" value="<?= $profile['website'] ?? '' ?>"
                  placeholder="https://example.com"
                  class="bg-white border <?= isset($errors['website']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                <?php if (isset($errors['website'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['website'] ?></p>
                <?php endif; ?>
              </div>

              <div>
                <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">
                  Facebook
                </label>
                <input type="url" name="facebook" id="facebook" value="<?= $profile['facebook'] ?? '' ?>"
                  placeholder="https://facebook.com/username"
                  class="bg-white border <?= isset($errors['facebook']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                <?php if (isset($errors['facebook'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['facebook'] ?></p>
                <?php endif; ?>
              </div>

              <div>
                <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">
                  Twitter
                </label>
                <input type="url" name="twitter" id="twitter" value="<?= $profile['twitter'] ?? '' ?>"
                  placeholder="https://twitter.com/username"
                  class="bg-white border <?= isset($errors['twitter']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                <?php if (isset($errors['twitter'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['twitter'] ?></p>
                <?php endif; ?>
              </div>

              <div>
                <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">
                  Instagram
                </label>
                <input type="url" name="instagram" id="instagram" value="<?= $profile['instagram'] ?? '' ?>"
                  placeholder="https://instagram.com/username"
                  class="bg-white border <?= isset($errors['instagram']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                <?php if (isset($errors['instagram'])): ?>
                <p class="mt-1 text-sm text-red-600"><?= $errors['instagram'] ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div class="pt-5">
              <div class="flex justify-end">
                <button type="submit"
                  class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                  Cập nhật thông tin
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
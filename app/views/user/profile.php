<?php
use App\Helpers\UrlHelper;

$title = 'Thông tin cá nhân';

// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu biến $profile chưa tồn tại, thì tạo một mảng rỗng để tránh lỗi
if (!isset($profile) || !is_array($profile)) {
    $profile = [];
}

// Kiểm tra nếu có dữ liệu gửi lên, cập nhật lại $user và $profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user['full_name'] = $_POST['full_name'] ?? $user['full_name'] ?? '';
    $user['phone'] = $_POST['phone'] ?? $user['phone'] ?? '';
    $user['address'] = $_POST['address'] ?? $user['address'] ?? '';

    $profile['bio'] = $_POST['bio'] ?? $profile['bio'] ?? '';
    $profile['date_of_birth'] = $_POST['date_of_birth'] ?? $profile['date_of_birth'] ?? '';
    $profile['gender'] = $_POST['gender'] ?? $profile['gender'] ?? '';
    $profile['website'] = $_POST['website'] ?? $profile['website'] ?? '';
    $profile['facebook'] = $_POST['facebook'] ?? $profile['facebook'] ?? '';
    $profile['twitter'] = $_POST['twitter'] ?? $profile['twitter'] ?? '';
    $profile['instagram'] = $_POST['instagram'] ?? $profile['instagram'] ?? '';
}
?>


<div class="py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Thông tin cá nhân</h1>

    <?php if (!empty($_SESSION['flash']) && isset($_SESSION['flash']['message'])): ?>
    <div class="mb-6 p-4 rounded-md <?= ($_SESSION['flash']['type'] ?? '') === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' ?>">
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
          <a href="<?= UrlHelper::route('user/change-password') ?>"
            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
            Đổi mật khẩu
          </a>
        </nav>
      </div>

      <form action="<?= UrlHelper::route('user/profile') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Avatar -->
          <div class="md:col-span-1">
            <div class="flex flex-col items-center space-y-4">
              <div class="relative">
                <?php if (!empty($user['avatar'])): ?>
                <img src="<?= $user['avatar'] ?>" alt="<?= $user['username'] ?>"
                  class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-md">
                <?php else: ?>
                <div class="h-32 w-32 rounded-full bg-teal-600 flex items-center justify-center text-white text-4xl font-medium border-4 border-white shadow-md">
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
            </div>
          </div>

          <!-- Thông tin cơ bản -->
          <div class="md:col-span-2 space-y-6">
            <div>
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Thông tin cơ bản</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                <input type="text" value="<?= htmlspecialchars($user['username']) ?>"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                  disabled>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" value="<?= htmlspecialchars($user['email']) ?>"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                  disabled>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
              </div>
           
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày sinh</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($profile['date_of_birth'] ?? '') ?>"
                  class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                <select name="gender" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                  <option value="">-- Chọn giới tính --</option>
                  <option value="male" <?= ($profile['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
                  <option value="female" <?= ($profile['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
                  <option value="other" <?= ($profile['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Khác</option>
                </select>
              </div>
              <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                <textarea name="address" id="address" rows="2" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?= $user['address'] ?? '' ?></textarea>
              </div>
            </div>

            <div>
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mt-8">Liên kết mạng xã hội</h3>
            </div>

            <div class="grid grid-cols-1 gap-4">
              <?php foreach (['website', 'facebook', 'twitter', 'instagram'] as $social): ?>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"><?= ucfirst($social) ?></label>
                  <input type="url" name="<?= $social ?>" value="<?= htmlspecialchars($profile[$social] ?? '') ?>"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                </div>
              <?php endforeach; ?>
            </div>

            <div class="pt-5 flex justify-end">
              <button type="submit" class="py-2 px-4 bg-teal-600 text-white rounded-md">Cập nhật</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

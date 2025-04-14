<?php

use App\Helpers\UrlHelper;
?>

<div class="container px-6 py-8 mx-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-700">Chỉnh sửa người dùng</h3>
    <a href="<?= UrlHelper::route('admin/users/index') ?>">
      <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Quay lại
      </button>
    </a>
  </div>

  <!-- User Edit Form -->
  <div class="bg-white rounded-xl shadow-md mb-6 border border-gray-100 overflow-hidden">
    <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
      <h3 class="text-lg font-medium text-gray-700 flex items-center">
        <i class="fas fa-user-edit text-teal-500 mr-2"></i> Thông tin người dùng
      </h3>
    </div>

    <form action="<?= UrlHelper::route('admin/users/edit/' . $user['id']) ?>" method="post" class="px-6 py-5"
      enctype="multipart/form-data">
      <!-- Form Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-5">
          <!-- Username -->
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
              Tên đăng nhập <span class="text-red-500">*</span>
            </label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <?php if (isset($errors['username'])): ?>
            <p class="mt-1 text-sm text-red-500"><?= $errors['username'] ?></p>
            <?php endif; ?>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Email <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <?php if (isset($errors['email'])): ?>
            <p class="mt-1 text-sm text-red-500"><?= $errors['email'] ?></p>
            <?php endif; ?>
          </div>

          <!-- Full Name -->
          <div>
            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
              Họ và tên
            </label>
            <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>"
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          </div>

          <!-- Phone -->
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
              Số điện thoại
            </label>
            <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
          </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-5">
          <!-- Role Selection -->
          <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
              Vai trò <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select id="role_id" name="role_id" required
                class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none">
                <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= ($user['role_id'] == $role['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($role['name']) ?>
                </option>
                <?php endforeach; ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
              </div>
            </div>
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Trạng thái <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select id="status" name="status" required
                class="w-full rounded-lg p-2.5 pl-4 pr-10 border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-20 shadow-sm text-gray-700 appearance-none">
                <option value="active" <?= ($user['status'] == 'active') ? 'selected' : '' ?>>Hoạt động</option>
                <option value="inactive" <?= ($user['status'] == 'inactive') ? 'selected' : '' ?>>Không hoạt động
                </option>
                <option value="banned" <?= ($user['status'] == 'banned') ? 'selected' : '' ?>>Bị cấm</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
              </div>
            </div>
          </div>

          <!-- Password (optional) -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
              Mật khẩu mới <span class="text-gray-500 font-normal">(để trống nếu không đổi)</span>
            </label>
            <input type="password" name="password" id="password"
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <?php if (isset($errors['password'])): ?>
            <p class="mt-1 text-sm text-red-500"><?= $errors['password'] ?></p>
            <?php endif; ?>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">
              Xác nhận mật khẩu mới
            </label>
            <input type="password" name="password_confirm" id="password_confirm"
              class="w-full rounded-lg border border-gray-300 p-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            <?php if (isset($errors['password_confirm'])): ?>
            <p class="mt-1 text-sm text-red-500"><?= $errors['password_confirm'] ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Avatar Section -->
      <div class="mb-6">
        <label for="avatar" class="block mb-2 text-sm font-medium text-gray-700">Avatar</label>
        <div class="flex items-center">
          <?php if (!empty($user['avatar'])): ?>
          <div class="mr-4">
            <img src="<?= $user['avatar'] ?>" alt="Avatar" class="w-16 h-16 rounded-full object-cover border">
          </div>
          <?php endif; ?>
          <div>
            <label class="block">
              <span class="sr-only">Choose profile photo</span>
              <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-teal-50 file:text-teal-700
                        hover:file:bg-teal-100
                        ">
            </label>
            <p class="mt-1 text-sm text-gray-500">PNG, JPG hoặc GIF (Tối đa 1MB)</p>
            <?php if (isset($errors['avatar'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['avatar'] ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- CSRF Protection (if used) -->
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">

      <!-- Success Message Display -->
      <?php if (isset($success)): ?>
      <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= $success ?></p>
      </div>
      <?php endif; ?>

      <!-- Error Message Display -->
      <?php if (isset($error)): ?>
      <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p><?= $error ?></p>
      </div>
      <?php endif; ?>

      <!-- Form Actions -->
      <div class="mt-6 flex justify-end space-x-3">
        <a href="<?= UrlHelper::route('admin/users/index') ?>"
          class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg">
          Hủy
        </a>
        <button type="submit"
          class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg focus:ring-2 focus:ring-teal-300">
          <i class="fas fa-save mr-2"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>

  <!-- Last Login Information -->
  <?php if (!empty($user['last_login'])): ?>
  <div class="bg-blue-50 p-4 rounded-lg text-sm text-blue-700 mb-6">
    <p><i class="fas fa-info-circle mr-1"></i> Lần đăng nhập cuối:
      <?= date('d/m/Y H:i:s', strtotime($user['last_login'])) ?></p>
  </div>
  <?php endif; ?>
</div>

<script>
// Simple client-side validation
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form');
  const password = document.getElementById('password');
  const passwordConfirm = document.getElementById('password_confirm');

  form.addEventListener('submit', function(e) {
    // Password match validation
    if (password.value && password.value !== passwordConfirm.value) {
      e.preventDefault();
      alert('Mật khẩu xác nhận không khớp!');
    }
  });
});
</script>
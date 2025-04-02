<?php

use App\Helpers\UrlHelper;

?>

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
  <h2 class="text-2xl font-semibold text-gray-700 mb-4">Chỉnh sửa người dùng</h2>

  <form action="<?= UrlHelper::route('admin/users/edit/' . $user['id']) ?>" method="post">
    <!-- Tên người dùng -->
    <div class="mb-4">
      <label for="username" class="block text-gray-600 font-medium mb-1">Tên người dùng</label>
      <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
    </div>

    <!-- Email -->
    <div class="mb-4">
      <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
    </div>

    <!-- Họ và tên -->
    <div class="mb-4">
      <label for="full_name" class="block text-gray-600 font-medium mb-1">Họ và tên</label>
      <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
    </div>

    <!-- Vai trò -->
    <div class="mb-4">
      <label for="role" class="block text-gray-600 font-medium mb-1">Vai trò</label>
      <select id="role" name="role" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
        <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Quản trị viên</option>
        <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>Người dùng</option>
      </select>
    </div>

    <!-- Trạng thái -->
    <div class="mb-4">
      <label for="status" class="block text-gray-600 font-medium mb-1">Trạng thái</label>
      <select id="status" name="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
        <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Hoạt động</option>
        <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Không hoạt động</option>
      </select>
    </div>

    <!-- Nút lưu -->
    <div class="mt-6">
      <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
        Lưu thay đổi
      </button>
    </div>
  </form>
</div>
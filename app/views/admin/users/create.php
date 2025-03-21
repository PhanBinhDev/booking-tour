<?php

use App\Helpers\UrlHelper;
?>
<div class="container mx-auto px-4 py-10 flex justify-center">
  <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-teal-500 px-6 py-5">
      <h1 class="text-2xl font-semibold text-white text-center">Thêm Người Dùng Mới</h1>
    </div>
    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
        <strong class="font-bold">Thành công!</strong>
        <span class="block sm:inline">Người dùng đã được thêm thành công.</span>
      </div>
    <?php endif; ?>
    <form action="<?= UrlHelper::route('admin/users/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
            Tên đăng nhập <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="username"
            name="username"
            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
            required
            class="w-full px-4 py-2 border <?= !empty($errors['username']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
          <?php if (!empty($errors['username'])): ?>
            <p class="text-red-500 text-sm mt-1"><?= $errors['username']; ?></p>
          <?php endif; ?>
        </div>


        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
          <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
        </div>
      </div>

      <div class="mb-6">
        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên <span class="text-red-500">*</span></label>
        <input type="text" id="full_name" name="full_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu <span class="text-red-500">*</span></label>
        <input type="password" id="password" name="password" value="123456" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
      </div>
      <div class="mb-6">
        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Vai trò <span class="text-red-500">*</span></label>
        <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
          <option value="">-- Chọn vai trò --</option>
          <option value="admin">Quản trị viên</option>
          <option value="manager">Quản lý</option>
          <option value="user">Người dùng</option>
        </select>
      </div>
      <div class="mb-6">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
        <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
          <option value="active">Hoạt Động</option>
          <option value="banned">Bị Cấm</option>
          <option value="inactive">Không hoạt động</option>
        </select>

      </div>
      <div class="mb-6">
        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
        <div class="flex items-center space-x-4">
          <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden shadow-md" id="avatar-preview">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <div>
            <input type="file" id="avatar" name="avatar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
            <p class="text-xs text-gray-500 mt-1">Định dạng: JPG, PNG. Tối đa 2MB</p>
          </div>
        </div>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="px-6 py-3 bg-teal-500 text-white font-medium rounded-lg shadow-lg hover:bg-teal-600 transition-all focus:outline-none focus:ring-2 focus:ring-teal-500">Thêm Người Dùng</button>
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const usernameInput = document.getElementById("username");
    const errorMessage = document.createElement("p"); // Tạo phần tử hiển thị lỗi
    errorMessage.classList.add("text-red-500", "text-sm", "mt-1");
    errorMessage.style.display = "none"; // Ẩn ban đầu
    usernameInput.parentNode.appendChild(errorMessage); // Chèn vào sau input

    usernameInput.addEventListener("input", function() {
      const username = usernameInput.value.trim();

      if (username.length < 6) {
        usernameInput.classList.add("border-red-500"); // Đổi màu viền input
        errorMessage.textContent = "Tên đăng nhập phải có ít nhất 6 ký tự!";
        errorMessage.style.display = "block"; // Hiển thị thông báo lỗi
      } else {
        usernameInput.classList.remove("border-red-500"); // Xóa viền đỏ nếu hợp lệ
        errorMessage.style.display = "none"; // Ẩn lỗi nếu hợp lệ
      }
    });

    form.addEventListener("submit", function(event) {
      if (usernameInput.value.trim().length < 6) {
        event.preventDefault(); // Chặn form submit nếu vẫn lỗi
      }
    });
  });
</script>
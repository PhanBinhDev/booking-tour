<?php 
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-700">Quản lý người dùng</h3>
    <a href="<?= UrlHelper::route('admin/users/create')?>">
      <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-user-plus mr-2"></i> Thêm người dùng
      </button>
    </a>
  </div>

  <!-- Bảng danh sách người dùng -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thông
              tin</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vai
              trò</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng
              thái</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đăng
              nhập cuối</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao
              tác</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php
          $counter = 1;
          foreach ($users as $user): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $counter++;?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <?php if (!empty($user['avatar'])): ?>
                  <img class="h-10 w-10 rounded-full" src="<?= $user['avatar'] ?>" alt="Avatar">
                  <?php else: ?>
                  <div class="h-10 w-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900"><?= $user['full_name'] ?? $user['username'] ?></div>
                  <div class="text-sm text-gray-500"><?= $user['username'] ?></div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $user['email'] ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getRoleBadgeClass($user['role_name']) ?>">
                <?= $user['role_name'] ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getStatusBadgeClass($user['status']) ?>">
                <?= ucfirst($user['status']) ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Chưa đăng nhập' ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="<?= UrlHelper::route('admin/users/edit/' . $user['id'])?>">
                <button class="edit-user-btn text-indigo-600 hover:text-indigo-900 mr-3" data-id="<?= $user['id'] ?>">
                  <i class="fas fa-edit"></i>
                </button>
              </a>
              <?php if ($user['id'] != $_SESSION['user_id']): ?>
              <button class="delete-user-btn text-red-600 hover:text-red-900" data-id="<?= $user['id'] ?>"
                data-name="<?= $user['username'] ?>">
                <i class="fas fa-trash-alt"></i>
              </button>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($users)): ?>
          <tr>
            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Không có người dùng nào</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal thêm người dùng -->
  <div id="addUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Thêm người dùng mới</h3>
        <a href="<? UrlHelper::route('admin/users/create')?>">
          <button id="closeAddModal" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </a>
      </div>
      <form id="addUserForm" action="<?= UrlHelper::route('admin/users') ?>" method="POST">
        <div class="p-4">
          <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập <span
                class="text-red-500">*</span></label>
            <input type="text" name="username" id="username"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
          </div>

          <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email <span
                class="text-red-500">*</span></label>
            <input type="email" name="email" id="email"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
          </div>

          <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu <span
                class="text-red-500">*</span></label>
            <input type="password" name="password" id="password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
          </div>

          <div class="mb-4">
            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">Họ tên</label>
            <input type="text" name="full_name" id="full_name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-4">
            <label for="role_id" class="block text-gray-700 text-sm font-bold mb-2">Vai trò <span
                class="text-red-500">*</span></label>
            <select name="role_id" id="role_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
              <option value="">-- Chọn vai trò --</option>
              <?php foreach ($roles as $role): ?>
              <option value="<?= $role['id'] ?>"><?= strtoupper($role['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Trạng thái <span
                class="text-red-500">*</span></label>
            <select name="status" id="status"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
              <option value="active">Hoạt động</option>
              <option value="inactive">Không hoạt động</option>
              <option value="banned">Bị cấm</option>
            </select>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
          <button type="button" id="cancelAddBtn"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
            Hủy
          </button>
          <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
            Thêm người dùng
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal chỉnh sửa người dùng -->
  <div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Chỉnh sửa người dùng</h3>
        <button id="closeEditModal" class="text-gray-400 hover:text-gray-500">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="editUserForm" action="<?= ADMIN_URL ?>/users/update" method="POST">
        <input type="hidden" name="user_id" id="edit_user_id">
        <div class="p-4">
          <div class="mb-4">
            <label for="edit_username" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập <span
                class="text-red-500">*</span></label>
            <input type="text" name="username" id="edit_username"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
          </div>

          <div class="mb-4">
            <label for="edit_email" class="block text-gray-700 text-sm font-bold mb-2">Email <span
                class="text-red-500">*</span></label>
            <input type="email" name="email" id="edit_email"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
          </div>

          <div class="mb-4">
            <label for="edit_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới (để trống nếu
              không thay đổi)</label>
            <input type="password" name="password" id="edit_password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-4">
            <label for="edit_full_name" class="block text-gray-700 text-sm font-bold mb-2">Họ tên</label>
            <input type="text" name="full_name" id="edit_full_name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-4">
            <label for="edit_role_id" class="block text-gray-700 text-sm font-bold mb-2">Vai trò <span
                class="text-red-500">*</span></label>
            <select name="role_id" id="edit_role_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
              <option value="">-- Chọn vai trò --</option>
              <?php foreach ($roles as $role): ?>
              <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="edit_status" class="block text-gray-700 text-sm font-bold mb-2">Trạng thái <span
                class="text-red-500">*</span></label>
            <select name="status" id="edit_status"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required>
              <option value="active">Hoạt động</option>
              <option value="inactive">Không hoạt động</option>
              <option value="banned">Bị cấm</option>
            </select>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
          <button type="button" id="cancelEditBtn"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
            Hủy
          </button>
          <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
            Cập nhật
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal xác nhận xóa người dùng -->
  <div id="deleteUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa</h3>
        <button id="closeDeleteModal" class="text-gray-400 hover:text-gray-500">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-4">
        <p class="text-gray-700">Bạn có chắc chắn muốn xóa người dùng <span id="deleteUserName"
            class="font-bold"></span>?</p>
        <p class="text-gray-500 text-sm mt-2">Hành động này không thể hoàn tác.</p>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
        <button type="button" id="cancelDeleteBtn"
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
          Hủy
        </button>
        <a id="confirmDeleteBtn" href="#"
          class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
          Xóa
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Helper functions -->
<?php
function getRoleBadgeClass($roleName) {
    $classes = [
        'admin' => 'bg-red-100 text-red-800',
        'moderator' => 'bg-yellow-100 text-yellow-800',
        'editor' => 'bg-blue-100 text-blue-800',
        'user' => 'bg-green-100 text-green-800'
    ];
    
    return $classes[strtolower($roleName)] ?? 'bg-gray-100 text-gray-800';
}

function getStatusBadgeClass($status) {
    $classes = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-gray-100 text-gray-800',
        'banned' => 'bg-red-100 text-red-800'
    ];
    
    return $classes[$status] ?? 'bg-gray-100 text-gray-800';
}
?>

<!-- JavaScript cho các modal và chức năng -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Modal thêm người dùng
  const addUserBtn = document.getElementById('addUserBtn');
  const addUserModal = document.getElementById('addUserModal');
  const closeAddModal = document.getElementById('closeAddModal');
  const cancelAddBtn = document.getElementById('cancelAddBtn');

  addUserBtn.addEventListener('click', function() {
    addUserModal.classList.remove('hidden');
  });

  closeAddModal.addEventListener('click', function() {
    addUserModal.classList.add('hidden');
  });

  cancelAddBtn.addEventListener('click', function() {
    addUserModal.classList.add('hidden');
  });

  // Modal xóa người dùng
  const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
  const deleteUserModal = document.getElementById('deleteUserModal');
  const closeDeleteModal = document.getElementById('closeDeleteModal');
  const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const deleteUserName = document.getElementById('deleteUserName');

  deleteUserBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const userId = this.getAttribute('data-id');
      const username = this.getAttribute('data-name');

      deleteUserName.textContent = username;
      confirmDeleteBtn.href = `<?= ADMIN_URL ?>/users/${userId}/delete`;

      deleteUserModal.classList.remove('hidden');
    });
  });

  closeDeleteModal.addEventListener('click', function() {
    deleteUserModal.classList.add('hidden');
  });

  cancelDeleteBtn.addEventListener('click', function() {
    deleteUserModal.classList.add('hidden');
  });
});
</script>
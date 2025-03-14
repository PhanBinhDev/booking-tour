<div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold text-gray-800">Quản lý vai trò</h1>
  <a href="<?= PUBLIC_URL ?>/admin/roles/create"
    class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
    <i class="fas fa-plus mr-2"></i> Thêm vai trò mới
  </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <table class="w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên vai
          trò</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô tả
        </th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số người
          dùng</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác
        </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <?php foreach ($roles as $role): ?>
      <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $role['id'] ?></td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm font-medium text-gray-900"><?= $role['name'] ?></div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm text-gray-500"><?= $role['description'] ?? 'Không có mô tả' ?></div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <?= $role['user_count'] ?> người dùng
          </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <a href="<?= PUBLIC_URL ?>/admin/roles/<?= $role['id'] ?>/permissions"
            class="text-indigo-600 hover:text-indigo-900 mr-3">
            <i class="fas fa-key mr-1"></i> Phân quyền
          </a>
          <a href="<?= PUBLIC_URL ?>/admin/roles/<?= $role['id'] ?>/edit"
            class="text-yellow-600 hover:text-yellow-900 mr-3">
            <i class="fas fa-edit mr-1"></i> Sửa
          </a>
          <?php if ($role['user_count'] == 0): ?>
          <a href="<?= PUBLIC_URL ?>/admin/roles/<?= $role['id'] ?>/delete" class="text-red-600 hover:text-red-900"
            onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">
            <i class="fas fa-trash-alt mr-1"></i> Xóa
          </a>
          <?php else: ?>
          <span class="text-gray-400 cursor-not-allowed">
            <i class="fas fa-trash-alt mr-1"></i> Xóa
          </span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>

      <?php if (empty($roles)): ?>
      <tr>
        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Không có vai trò nào</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
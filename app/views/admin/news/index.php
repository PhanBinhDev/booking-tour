<?php

use App\Helpers\UrlHelper;

?>

<div>
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Quản Lý Tin Tức</h1>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <form action="<?= UrlHelper::route('admin/news/index') ?>" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                            placeholder="Tìm kiếm theo tiêu đề..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex gap-4">
                    <select name="status"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">Tất cả trạng thái</option>
                        <option value="published"
                            <?= isset($filters['status']) && $filters['status'] === 'published' ? 'selected' : '' ?>>Đã xuất bản
                        </option>
                        <option value="draft" <?= isset($filters['status']) && $filters['status'] === 'draft' ? 'selected' : '' ?>>
                            Nháp</option>
                    </select>
                    <select name="category"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"
                                <?= isset($filters['category']) && $filters['category'] == $category['id'] ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        <span>Lọc</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- News Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hình ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiêu đề</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày xuất bản</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($news as $new): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($new['id']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><img src="<?= $new['featured_image'] ?>" alt="Tin tức"
                                        class="w-12 h-12 object-cover rounded"></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($new['title']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $new['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                        <?= $new['status'] === 'published' ? 'Đã xuất bản' : 'Nháp' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($new['published_at']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?= UrlHelper::route('admin/news/preview/' . $new['id']) ?>"
                                            class="text-teal-500 hover:text-teal-700" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= UrlHelper::route('admin/news/updateNews/' . $new['id']) ?>"
                                            class="text-blue-500 hover:text-blue-700" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" id="delete-form-<?= $new['id'] ?>"
                                            action="<?= UrlHelper::route('admin/news/deleteNews/' . $new['id']) ?>">
                                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');"
                                                class="text-red-500 hover:text-red-700" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Component -->
        <?php if (isset($pagination)): ?>
            <div class="bg-white rounded-lg shadow-sm p-4 mt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center gap-4">
                        <p class="text-sm text-gray-700 mb-4 md:mb-0">
                            Hiển thị <span class="font-medium"><?= $pagination['from'] ?></span>
                            đến <span class="font-medium"><?= $pagination['to'] ?></span>
                            trong <span class="font-medium"><?= $pagination['total'] ?></span> kết quả
                        </p>
                    </div>
                    <div class="flex items-center space-x-1">
                        <?php if ($pagination['has_prev_page']): ?>
                            <a href="<?= UrlHelper::route('admin/news/index') . '?' . http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] - 1])) ?>"
                                class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        <?php endif; ?>

                        <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                            <?php if ($i === $pagination['current_page']): ?>
                                <span class="px-3 py-1 rounded-md text-sm bg-teal-500 text-white font-medium"><?= $i ?></span>
                            <?php else: ?>
                                <a href="<?= UrlHelper::route('admin/news/index') . '?' . http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                                    class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagination['has_next_page']): ?>
                            <a href="<?= UrlHelper::route('admin/news/index') . '?' . http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] + 1])) ?>"
                                class="px-3 py-1 rounded-md text-sm border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-md text-sm border border-gray-200 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
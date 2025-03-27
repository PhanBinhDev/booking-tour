<?php

use App\Helpers\UrlHelper;

?>

<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý Danh mục Tin Tức</h1>
            <a href="<?= UrlHelper::route('admin/news/createCategory') ?>">
                <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i> Thêm Danh mục mới
                </button>
            </a>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select class="w-full rounded-md p-2 border-2 border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option>Tất cả trạng thái</option>
                        <option>Đang hoạt động</option>
                        <option>Tạm ngưng</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" placeholder="Nhập tên danh mục..." class="w-full rounded-md p-2 border-2 border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div class="flex items-end">
                    <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-filter mr-2"></i> Lọc
                    </button>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hình ảnh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mô tả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($news as $new) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $new['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><img src="<?= $new['image'] ?>" alt="Danh mục" class="w-12 h-12 object-cover rounded"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $new['name'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $new['description'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?= $new['status'] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $new['created_at'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?= UrlHelper::route('admin/news/updateCategory/' . $new['id']) ?>">
                                    <button class="text-teal-600 hover:text-teal-900"><i class="fas fa-edit"></i></button>
                                </a>

                                <a href="<?= UrlHelper::route('admin/news/deleteCategory/' . $new['id']) ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    <button class="text-red-600 hover:text-red-900 ml-2"><i class="fas fa-trash"></i></button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
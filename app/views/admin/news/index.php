<?php

use App\Helpers\UrlHelper;

?>

<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý Tin tức</h1>
            <a href="<?= UrlHelper::route('admin/news/createNews') ?>">
                <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i> Thêm Tin tức mới
                </button>
            </a>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select class="w-full rounded-md p-2 border-2 border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option>Tất cả trạng thái</option>
                        <option>Đã xuất bản</option>
                        <option>Nháp</option>
                        <option>Lưu trữ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" placeholder="Nhập tiêu đề tin tức..." class="w-full rounded-md p-2 border-2 border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div class="flex items-end w-full">
                    <button class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiêu đề</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày xuất bản</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($news as $new) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $new['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><img src="<?= $new['featured_image'] ?>" alt="Tin tức" class="w-12 h-12 object-cover rounded"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $new['title'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?= $new['status'] ?></span></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $new['created_at'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-teal-600 hover:text-teal-900"><i class="fas fa-eye"></i></button>
                                <a href="<?= UrlHelper::route('admin/news/updateNews/' . $new['id']) ?>">
                                    <button class="text-teal-600 hover:text-teal-900 ml-2"><i class="fas fa-edit"></i></button>
                                </a>
                                <a href="<?= UrlHelper::route('admin/news/deleteNews/' . $new['id']) ?>"
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
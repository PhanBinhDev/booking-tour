<?php

use App\Helpers\UrlHelper;
?>

<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Tiêu đề trang -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý Danh mục Tour</h1>
            <a href="<?= UrlHelper::route('admin/tours/createCategory') ?>">
                <button id="addTourBtn" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i> Thêm Danh mục mới
                </button>
            </a>
        </div>


        <!-- Bảng danh sách danh mục với scroll horizontal -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="tour-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hình ảnh
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tên danh mục
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mô tả
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày tạo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Danh mục 1 -->
                        <?php foreach ($categories as $item) { ?>
                            <tr>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $item["id"] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="<?= UrlHelper::image('') ?>" alt="Du lịch trong nước" class="w-full h-full object-cover rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $item["name"] ?></div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $item["description"] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <?= $item["status"] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $item["created_at"] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-teal-600 hover:text-teal-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
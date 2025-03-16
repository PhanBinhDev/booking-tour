<?php

use App\Helpers\UrlHelper;
?>

<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Tiêu đề trang -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý Đặt Tour</h1>

        </div>

        <!-- Bộ lọc và tìm kiếm -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-1">
                    <label for="tour_category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục tour</label>
                    <select id="tour_category" name="tour_category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        <option value="">Tất cả danh mục</option>
                        <option value="1">Du lịch trong nước</option>
                        <option value="2">Du lịch nước ngoài</option>
                        <option value="3">Miền Bắc</option>
                        <option value="4">Miền Trung</option>
                        <option value="5">Miền Nam</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending">Chờ xác nhận</option>
                        <option value="confirmed">Đã xác nhận</option>
                        <option value="paid">Đã thanh toán</option>
                        <option value="cancelled">Đã hủy</option>
                        <option value="completed">Hoàn thành</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" placeholder="Nhập tên khách hàng hoặc mã đặt tour..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-filter mr-2"></i> Lọc
                </button>
            </div>
        </div>

        <!-- Bảng danh sách đặt tour du lịch với scroll horizontal -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="booking-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mã đặt tour
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thông tin tour
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Khách hàng
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Số lượng
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tổng tiền
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thanh toán
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
                        <!-- Đặt tour 1 - Đây là mẫu, bạn sẽ thay thế bằng dữ liệu từ MySQL -->

                        <?php foreach ($bookings as $item) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $item["booking_number"] ?>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $item["tour_title"] ?></div>
                                    <div class="text-sm text-gray-500"><?= $item["duration"] ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $item["customer_name"] ?></div>
                                    <div class="text-xs text-gray-500">ID: <?= $item["customer_id"] ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $item["adults"] ?> người lớn</div>
                                    <div class="text-xs text-gray-500"><?= $item["children"] ?> trẻ em</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $item["tour_price"] ?>₫</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?= $item["booking_status"] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <?= $item["payment_status"] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $item["booking_date"] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?= UrlHelper::route('admin/bookings/deleteBooking/' . $item['id']) ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                        <button class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
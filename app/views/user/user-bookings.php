<?php

use App\Helpers\UrlHelper;

$title = 'Danh sách đặt tour';

?>
<main class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Đơn đặt tour của bạn</h1>
            <p class="text-gray-600">Danh sách các tour du lịch bạn đã đặt</p>
        </div>

        <!-- Filters and Sorting -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-gray-700 font-medium">Lọc theo:</span>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Tất cả</option>
                    <option>Trong nước</option>
                    <option>Quốc tế</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Mọi thời gian</option>
                    <option>Tháng này</option>
                    <option>Tháng sau</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-gray-700 font-medium">Sắp xếp:</span>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Mới nhất</option>
                    <option>Giá: Thấp đến cao</option>
                    <option>Giá: Cao đến thấp</option>
                    <option>Đánh giá cao nhất</option>
                </select>
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
                                Thời gian
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Số lượng
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tổng tiền
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thanh toán
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày đặt
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($bookings) {
                            foreach ($bookings as $booking) { ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $booking['id'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= $booking['title'] ?></div>
                                        <div class="text-sm text-gray-500"><?= $booking['duration'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= $booking['start_date'] ?> <br> <?= $booking['end_date'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"> <?= $booking['adults'] ?> người lớn</div>
                                        <div class="text-xs text-gray-500"><?= $booking['children'] ?> trẻ em</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= number_format($booking['total_price'], 0, ',', '.') . ' đ' ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $statusClass = [
                                            'paid' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'pending' => 'bg-gray-100 text-gray-800'
                                        ][$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';

                                        $statusLabel = [
                                            'paid' => 'Đã thanh toán',
                                            'failed' => 'Thanh toán thất bại',
                                            'pending' => 'Chưa thanh toán'
                                        ][$booking['payment_status']] ?? $booking['payment_status'];
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                            <?= $statusLabel ?>
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $booking['created_at'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="">
                                                <button class="text-teal-600 hover:text-teal-900" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </a>
                                            <a href="">
                                                <button class="text-red-600 hover:text-red-900" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-l font-medium text-gray-700 mb-2">
                                    Bạn chưa đặt tour nào
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div class="hidden bg-white rounded-xl shadow-md p-8 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Danh sách trống</h3>
            <p class="text-gray-600 mb-6">Bạn chưa đặt tour nào</p>
            <a href="#" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 inline-block">
                Khám phá tour
            </a>
        </div>

    </div>
</main>
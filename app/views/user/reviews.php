<?php

use App\Helpers\UrlHelper;

$title = 'Danh sách đặt tour';

?>
<main class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Đánh giá tour của bạn</h1>
            <p class="text-gray-600">Danh sách các đánh giá của bạn về các tour du lịch của chúng tôi</p>
        </div>

        <!-- Filters and Sorting -->
        <!-- <div class="bg-white rounded-xl shadow-md p-4 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
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
                    <option>Sao: Thấp đến cao</option>
                    <option>Sao: Cao đến thấp</option>
                    <option>Đánh giá cao nhất</option>
                </select>
            </div>
        </div> -->

        <!-- Bảng danh sách đặt tour du lịch với scroll horizontal -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="booking-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                STT
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thông tin tour
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Đánh giá
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
                        <?php $i = 1;
                        foreach ($reviews as $review) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $i++ ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?= UrlHelper::route('home/tour-details/' . $review["tour_id"]) ?>">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= $review['title'] ?>
                                        </div>
                                    </a>
                                    <div class="text-sm text-gray-500"></div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <div class="flex text-yellow-400">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($review['rating'] >= $i) {
                                                    echo '<span class="text-yellow-400">★</span>';
                                                } elseif ($review['rating'] >= $i - 0.5) {
                                                    echo '<span class="text-yellow-400">⯨</span>';
                                                } else {
                                                    echo '<span class="text-gray-300">☆</span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="text-sm font-regular text-gray-600" style="white-space: pre-line;">
                                        <?= $review['review'] ?>
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $status = [
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800'
                                    ][$review['status']] ?? 'bg-gray-100 text-gray-800';

                                    $label = [
                                        'approved' => 'Đã xác nhận',
                                        'rejected' => 'Đã từ chối',
                                        'pending' => 'Chờ xác nhận'
                                    ][$review['status']] ?? $review['status'];
                                    ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full <?= $status ?>">
                                        <?= $label ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= $review['created_at'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- <button class="text-teal-600 hover:text-teal-900" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button> -->

                                        <a href="<?= UrlHelper::route('user/deleteReview/' . $review['id']) ?>"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                            <button class="text-red-600 hover:text-red-900" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>
                                    </div>
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
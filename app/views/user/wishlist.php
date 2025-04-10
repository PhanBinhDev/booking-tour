<?php

use App\Helpers\UrlHelper;
?>
<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tour yêu thích của bạn</h1>
            <p class="text-gray-600">Danh sách các tour du lịch bạn đã đánh dấu yêu thích</p>
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
                    <option>Giá: Thấp đến cao</option>
                    <option>Giá: Cao đến thấp</option>
                    <option>Đánh giá cao nhất</option>
                </select>
            </div>
        </div> -->

        <!-- Tour List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($favoriteTours as $tour) {
                $isFavorited = isset($_SESSION['user_id']) && in_array($tour['id'], $userFavorites);

                $heartClass = $isFavorited ? "text-red-500" : "text-teal-500"; ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                    <div class="relative">
                        <!-- Tour Image -->
                        <div class="h-56 overflow-hidden relative rounded-lg bg-gray-100">
                            <!-- Placeholder hiển thị trước khi ảnh load -->
                            <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                                id="placeholder-<?= $tour['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>

                            <!-- Ảnh chính -->
                            <img src="<?= $tour['cloudinary_url'] ?>" alt="<?= $tour['title'] ?>"
                                class="w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                                onload="document.getElementById('placeholder-<?= $tour['id'] ?>').style.display='none'; this.style.opacity='1';"
                                onerror="this.onerror=null; this.style.display='none'; showErrorPlaceholder('<?= $tour['id'] ?>', '<?= htmlspecialchars($tour['title'], ENT_QUOTES) ?>');"
                                style="opacity: 0;">
                        </div>

                        <!-- Discount Badge -->
                        <?= $tour['sale_price'] ?
                            ' <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">' .
                            number_format((($tour['price'] - $tour['sale_price']) / $tour['price']) * 100) . '%'
                            . '</div>'
                            : ''
                        ?>

                        <!-- Favorite Button -->
                        <button data-tour-id="<?php echo $tour['id']; ?>"
                            class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300 favorite-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $heartClass ?> fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </button>

                        <!-- Duration Badge -->
                        <div class="absolute bottom-4 left-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium">
                            <?= $tour['duration'] ?>
                        </div>
                    </div>

                    <div class="p-5">
                        <!-- Tour Title -->
                        <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14">
                                <?= $tour['title'] ?>
                            </h3>
                        </a>

                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <?php
                                $avgRating = isset($tour['avg_rating']) ? floatval($tour['avg_rating']) : 0;
                                $reviewCount = isset($tour['review_count']) ? intval($tour['review_count']) : 0;

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($avgRating >= $i) {
                                        echo '<span class="text-yellow-400">★</span>';
                                    } elseif ($avgRating >= $i - 0.5) {
                                        echo '<span class="text-yellow-400">⯨</span>';
                                    } else {
                                        echo '<span class="text-gray-300">☆</span>';
                                    }
                                }
                                ?>
                            </div>
                            <span class="text-gray-600 ml-2">
                                <?= number_format($avgRating, 1) ?>
                                (<?= $reviewCount ?> đánh giá)
                            </span>
                        </div>

                        <!-- Departure Date -->
                        <div class="flex items-center mb-4 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>

                            <?php if (!empty($tour['next_start_date'])) { ?>
                                <?php if ($tour['date_count'] == 1) { ?>
                                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
                                <?php } else { ?>
                                    Khởi hành: <?= date('d/m/Y', strtotime($tour['next_start_date'])) ?>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <!-- Price and Action -->
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-gray-400 line-through text-sm block">
                                    <?= $tour['sale_price'] ? number_format($tour['price'], 0, ',', '.') . ' đ'  :  '0 đ' ?>
                                </span>
                                <span class="text-red-500 font-bold text-xl">
                                    <?= $tour['sale_price'] ? number_format($tour['sale_price'], 0, ',', '.') : number_format($tour['price'], 0, ',', '.')  ?> đ
                                </span>
                            </div>
                            <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div class="hidden bg-white rounded-xl shadow-md p-8 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Chưa có tour yêu thích</h3>
            <p class="text-gray-600 mb-6">Bạn chưa thêm tour nào vào danh sách yêu thích</p>
            <a href="#" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 inline-block">
                Khám phá tour
            </a>
        </div>

        <!-- Pagination -->
        <?php if (count($favoriteTours) > 10) { ?>
            <div class="mt-10 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-teal-50 hover:text-teal-500 hover:border-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="px-4 py-2 rounded-lg bg-teal-500 text-white font-medium">1</a>
                    <a href="#" class="px-4 py-2 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-teal-500 font-medium">2</a>
                    <a href="#" class="px-4 py-2 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-teal-500 font-medium">3</a>
                    <span class="px-4 py-2 text-gray-600">...</span>
                    <a href="#" class="px-4 py-2 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-teal-500 font-medium">8</a>
                    <a href="#" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-teal-50 hover:text-teal-500 hover:border-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?= UrlHelper::route('assets/js/admin/favorites.js') ?>"></script>
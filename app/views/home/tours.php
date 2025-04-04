<?php

use App\Helpers\FormatHelper;
use App\Helpers\UrlHelper;

$title = 'Tours - Di Travel';
$activePage = 'tours';

// Get current category from request
$currentCategory = isset($_GET['category']) ? $_GET['category'] : null;

?>

<div class="py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex flex-col lg:flex-row gap-12">

            <div class="lg:w-1/4">
                <!-- Categories sidebar -->
                <h3 class="text-xl font-bold mb-6 text-teal-500">Danh mục</h3>

                <form action="<?= UrlHelper::route('home/tours') ?>" method="GET" id="categoryFilterForm">
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= UrlHelper::route('home/tours') ?>"
                                class="block border-l-4 <?= $currentCategory === null ? 'border-teal-500 bg-teal-50 text-teal-700 font-medium' : 'border-transparent hover:border-teal-500 hover:bg-teal-50' ?> pl-3 py-2 transition-colors">
                                Tất cả danh mục
                            </a>
                        </li>
                        <?php foreach ($categories as $category) { ?>
                            <li>
                                <a href="<?= UrlHelper::route('home/tours') ?>?category=<?= $category['id'] ?>"
                                    class="block border-l-4 <?= $currentCategory == $category['id'] ? 'border-teal-500 bg-teal-50 text-teal-700 font-medium' : 'border-transparent hover:border-teal-500 hover:bg-teal-50' ?> pl-3 py-2 transition-colors">
                                    <?= $category['name'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </form>

            </div>

            <div class="lg:w-3/4">
                <!-- Current category title -->
                <?php if ($currentCategory !== null) {
                    $categoryName = '';
                    foreach ($categories as $category) {
                        if ($category['id'] == $currentCategory) {
                            $categoryName = $category['name'];
                            break;
                        }
                    }
                    if ($categoryName) { ?>
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800"><?= $categoryName ?></h2>
                            <p class="text-gray-600">Exploring the best of <?= $categoryName ?></p>
                        </div>
                <?php }
                } ?>

                <!-- Sort options -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-2">Lọc theo:</span>
                        <select class="text-sm border border-gray-300 rounded py-1 px-2 focus:ring-teal-500 focus:border-teal-500" id="sortOptions" onchange="applySorting()">
                            <option value="popular">Phổ biến nhất</option>
                            <option value="price_asc">Giá từ thấp đến cao</option>
                            <option value="price_desc">Giá từ cao xuống thấp</option>
                            <option value="rating">Đánh giá</option>
                        </select>
                    </div>

                    <!-- Results count -->
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-medium"><?= count($allTours) ?></span> tours
                    </div>
                </div>

                <!-- Tour Grid -->
                <div id="toursGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    foreach ($allTours as $tour) { ?>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                            <div class="relative">
                                <!-- Tour Image -->
                                <div class="h-56 overflow-hidden">
                                    <img src="<?= $tour['cloudinary_url'] ?>" alt="<?= $tour['title'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>

                                <!-- Discount Badge -->
                                <?= $tour['sale_price'] ?
                                    ' <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">' .
                                    number_format((($tour['price'] - $tour['sale_price']) / $tour['price']) * 100) . '%'
                                    . '</div>'
                                    : ''
                                ?>

                                <!-- Favorite Button -->
                                <button class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
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

                <!-- Empty state -->
                <?php if (count($allTours) == 0) { ?>
                    <div class="py-16 flex flex-col items-center justify-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Không có tour nào trong danh mục này</h3>
                        <p class="text-gray-500 mb-4">Chọn danh mục khác</p>
                        <a href="<?= UrlHelper::route('home/tours') ?>" class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                            Tất cả tour
                        </a>
                    </div>
                <?php } ?>

                <!-- Pagination -->
                <?php if (count($allTours) > 9) { ?>
                    <div class="mt-10 flex justify-center">
                        <div class="flex space-x-1">
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="px-3 py-2 rounded bg-teal-500 text-white">1</button>
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">2</button>
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">3</button>
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">...</button>
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">8</button>
                            <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for filtering and sorting -->
<script>
    // Function to apply sorting
    function applySorting() {
        const sortOption = document.getElementById('sortOptions').value;
        // Get current URL
        let url = new URL(window.location.href);
        // Set or update the sort parameter
        url.searchParams.set('sort', sortOption);
        // Navigate to the new URL
        window.location.href = url.toString();
    }

    // Initialize sorting from URL parameter
    document.addEventListener('DOMContentLoaded', function() {
        const url = new URL(window.location.href);
        const sortParam = url.searchParams.get('sort');
        if (sortParam) {
            document.getElementById('sortOptions').value = sortParam;
        }
    });
</script>
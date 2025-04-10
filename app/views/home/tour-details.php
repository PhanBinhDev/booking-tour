<?php

use App\Helpers\UrlHelper;

// Parse itinerary data from JSON string if needed
$itinerary = json_decode($tourDetails['itinerary'], true) ?? [];

// Calculate price display
$hasDiscount = !empty($tourDetails['sale_price']);
$displayPrice = $hasDiscount ? $tourDetails['sale_price'] : $tourDetails['price'];
$childPrice = $displayPrice * 0.7;

?>


<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-8 text-sm text-gray-500 flex items-center">
            <a href="<?= UrlHelper::route('home/') ?>" class="hover:text-teal-500 transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="<?= UrlHelper::route('home/tours') ?>" class="hover:text-teal-500 transition-colors">Tours</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-700 font-medium"><?= htmlspecialchars($tourDetails['title']) ?></span>
        </div>

        <!-- Tour Title Section -->
        <div class="mb-10">
            <h1 class="text-3xl  font-bold text-gray-800 mb-4">
                <?= htmlspecialchars($tourDetails['title']) ?>
            </h1>
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center">
                    <div class="bg-teal-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-medium"><?= htmlspecialchars($tourDetails["location_name"]) ?></span>
                </div>
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <span class="font-medium"><?= intval($tourDetails['rating']) ?></span>
                    <?= $tourDetails['views'] ? '<span class="text-gray-500 ml-1">(' . intval($tourDetails['views']) . ' lượt xem)</span>' : '' ?>

                </div>
                <div class="flex items-center">
                    <div class="bg-teal-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium"><?= htmlspecialchars($tourDetails["duration"]) ?></span>
                </div>
            </div>
        </div>

        <!-- Swiper.js Image Gallery with Side Thumbnails -->
        <div class="mb-12 flex flex-col md:flex-row gap-4">
            <!-- Main Gallery -->
            <div class="md:w-5/6 relative">
                <div class="swiper galleryMain rounded-2xl overflow-hidden shadow-lg">
                    <div class="swiper-wrapper">
                        <!-- Slides từ các ảnh thực tế từ tour -->
                        <?php foreach ($tourDetails['images'] as $img) { ?>
                            <div class="swiper-slide">
                                <img
                                    src="<?= $img ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e' ?>"
                                    alt="<?= htmlspecialchars($tourDetails['title']) ?>" class="w-full h-[500px] object-cover">
                            </div>
                        <?php } ?>

                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <!-- Thumbnail Swiper - Vertical on right side -->
            <div class="md:w-1/6">
                <div class="swiper galleryThumbs h-[500px] rounded-xl overflow-hidden">
                    <div class="swiper-wrapper">
                        <?php foreach ($tourDetails['images'] as $img) { ?>
                            <div
                                class="swiper-slide cursor-pointer border-2 border-transparent hover:border-teal-500 transition-all rounded-lg overflow-hidden">
                                <img
                                    src="<?= $img ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e' ?>"
                                    alt="Thumbnail 1" class="w-full h-full object-cover">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Tour Details -->
            <div class="lg:col-span-2">
                <!-- Overview Section -->
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8 transition-all hover:shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="bg-teal-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Tổng quan Tour
                    </h2>

                    <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                        <?= htmlspecialchars($tourDetails["description"]) ?>
                    </p>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <?= nl2br(htmlspecialchars($tourDetails["content"])) ?>
                    </p>

                    <!-- Dịch vụ bao gồm / không bao gồm -->
                    <h3 class="text-xl font-semibold text-gray-800 mt-10 mb-6 flex items-center">
                        <div class="bg-teal-100 p-1.5 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        Dịch vụ
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Dịch vụ bao gồm -->
                        <div
                            class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl border border-green-100 hover:shadow-md transition-all">
                            <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3 text-lg">Dịch vụ Bao Gồm</h4>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($tourDetails["included"])) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Dịch vụ không bao gồm -->
                        <div
                            class="flex items-start space-x-4 p-6 bg-red-50 rounded-xl border border-red-100 hover:shadow-md transition-all">
                            <div class="bg-red-100 p-2 rounded-full flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3 text-lg">Không Bao Gồm</h4>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($tourDetails["excluded"])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lịch trình Tour - Compact & Responsive -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
                    <!-- Header - More Compact -->
                    <div class="bg-teal-500 p-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Lịch trình chi tiết
                        </h2>
                    </div>

                    <div class="p-4">
                        <!-- Itinerary Timeline - More Compact -->
                        <div class="space-y-4">
                            <?php foreach ($itinerary as $index => $details): ?>
                                <div class="relative <?= $index >= 3 ? 'itinerary-day hidden' : '' ?>">
                                    <!-- Timeline connector - Simplified -->
                                    <?php if ($index < count($itinerary) - 1): ?>
                                        <div class="absolute top-10 bottom-0 left-4 w-0.5 bg-teal-200"></div>
                                    <?php endif; ?>

                                    <div class="relative flex items-start">
                                        <!-- Day number - Smaller, No Animation -->
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold text-sm">
                                            <?= $details["day"] ?>
                                        </div>

                                        <!-- Day content - More Compact, No Hover Effects -->
                                        <div class="ml-4 bg-white p-3 rounded-lg border border-gray-100 flex-grow">
                                            <h3 class="text-base font-semibold text-gray-800 mb-2">
                                                <?= htmlspecialchars($details["title"] ?? "Ngày {$details["day"]}") ?>
                                            </h3>

                                            <?php if (!empty($details["description"])): ?>
                                                <p class="text-gray-600 text-sm mb-3"><?= htmlspecialchars($details["description"]) ?></p>
                                            <?php else: ?>
                                                <p class="text-gray-500 italic text-sm mb-3">Chưa có thông tin chi tiết cho ngày này.</p>
                                            <?php endif; ?>

                                            <!-- Activity Details - More Compact -->
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <!-- Meals info - Smaller -->
                                                <?php if (!empty($details["meals"]) && is_array($details["meals"])): ?>
                                                    <div class="inline-flex items-center bg-orange-50 px-2 py-1 rounded text-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-orange-500 mr-1" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z" />
                                                        </svg>
                                                        <span class="font-medium">Bữa ăn:</span>
                                                        <span class="ml-1"><?= implode(", ", array_map('htmlspecialchars', $details["meals"])) ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Accommodation info - Smaller -->
                                                <?php if (!empty($details["accommodation"])): ?>
                                                    <div class="inline-flex items-center bg-blue-50 px-2 py-1 rounded text-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-500 mr-1" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                        </svg>
                                                        <span class="font-medium">Nơi ở:</span>
                                                        <span class="ml-1"><?= htmlspecialchars($details["accommodation"]) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- "Show more" button - Simplified -->
                        <?php if (count($itinerary) > 3): ?>
                            <div class="mt-4 text-center">
                                <button id="showAllItinerary"
                                    class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium inline-flex items-center">
                                    <span>Xem toàn bộ lịch trình</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Phần Chỗ Ở -->
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8 transition-all hover:shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
                        <div class="bg-teal-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        Chỗ Ở
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Loại Phòng 1 -->
                        <div
                            class="border border-gray-200 rounded-xl overflow-hidden transition-all hover:-translate-y-2 hover:shadow-lg duration-300">
                            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500&h=300&fit=crop"
                                alt="Phòng Deluxe View Biển" class="w-full h-56 object-cover" />
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Phòng Deluxe View Biển</h3>
                                <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Giường King-size
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Ban công riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        View biển
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="bg-teal-100 text-teal-600 px-4 py-1.5 rounded-full font-medium">Bao gồm trong gói</span>
                                </div>
                            </div>
                        </div>

                        <!-- Loại Phòng 2 -->
                        <div
                            class="border border-gray-200 rounded-xl overflow-hidden transition-all hover:-translate-y-2 hover:shadow-lg duration-300">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=300&fit=crop"
                                alt="Biệt Thự Bãi Biển" class="w-full h-56 object-cover" />
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Biệt Thự Bãi Biển</h3>
                                <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Khu vực sinh hoạt riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Hồ bơi riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Truy cập trực tiếp ra biển
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="bg-gray-100 text-gray-700 px-4 py-1.5 rounded-full font-medium">+ 899.000đ nâng
                                        cấp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <!-- Reviews Section -->
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8 transition-all hover:shadow-lg border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <div class="bg-teal-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            Đánh giá (<?= count($reviews) ?>)
                        </h2>
                        <div class="flex items-center">
                            <div class="flex">
                                <?php
                                $fullStars = floor($avgRating);
                                $hasHalfStar = $avgRating - $fullStars >= 0.5;

                                for ($i = 1; $i <= 5; $i++):
                                    if ($i <= $fullStars): ?>
                                        <!-- Full star -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    <?php elseif ($i == $fullStars + 1 && $hasHalfStar): ?>
                                        <!-- Half star -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <defs>
                                                <linearGradient id="halfStarGradient">
                                                    <stop offset="50%" stop-color="#FBBF24" />
                                                    <stop offset="50%" stop-color="#D1D5DB" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#halfStarGradient)"
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    <?php else: ?>
                                        <!-- Empty star -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="ml-2 font-semibold"><?= $avgRating ?>/5</span>
                        </div>
                    </div>

                    <?php if ($canReview): ?>
                        <!-- Review Form for eligible users -->
                        <form id="reviewForm" action="<?= UrlHelper::route('tours/review') ?>" method="post"
                            class="bg-teal-50 p-6 rounded-xl mb-8 border border-teal-100">
                            <h3 class="text-lg font-semibold mb-4">Viết đánh giá của bạn</h3>
                            <input type="hidden" name="tour_id" value="<?= $tourDetails['id'] ?>">

                            <!-- Star Rating -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                                <div class="flex star-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="star h-8 w-8 text-gray-300 cursor-pointer hover:text-yellow-400" data-rating="<?= $i ?>"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    <?php endfor; ?>
                                    <input type="hidden" name="rating" id="ratingInput" value="0" required>
                                </div>
                            </div>

                            <!-- Review Title -->
                            <div class="mb-4">
                                <label for="reviewTitle" class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề</label>
                                <input type="text" id="reviewTitle" name="title"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    placeholder="Tóm tắt trải nghiệm của bạn" required>
                            </div>

                            <!-- Review Content -->
                            <div class="mb-4">
                                <label for="reviewContent" class="block text-sm font-medium text-gray-700 mb-2">Nội dung đánh giá</label>
                                <textarea id="reviewContent" name="review" rows="4"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    placeholder="Chia sẻ chi tiết trải nghiệm tour của bạn" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-right">
                                <button type="submit"
                                    class="bg-teal-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-teal-600 transition-colors">
                                    Gửi đánh giá
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <!-- Review Filters -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <button data-filter="all"
                            class="filter-btn bg-teal-500 text-white px-5 py-2.5 rounded-full text-sm font-medium shadow-sm">
                            Tất cả đánh giá
                        </button>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <?php
                            $count = count(array_filter($reviews, function ($review) use ($i) {
                                return $review['rating'] == $i;
                            }));
                            if ($count > 0):
                            ?>
                                <button data-filter="<?= $i ?>"
                                    class="filter-btn bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-sm font-medium transition-colors">
                                    <?= $i ?> Sao (<?= $count ?>)
                                </button>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <!-- Individual Reviews -->
                    <div class="space-y-8" id="reviewsList">
                        <?php if (empty($reviews)): ?>
                            <div class="text-center py-8 text-gray-500">
                                Chưa có đánh giá nào cho tour này.
                            </div>
                        <?php else: ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="border-b border-gray-200 pb-8 review-item" data-rating="<?= $review['rating'] ?>">
                                    <div class="flex justify-between mb-4">
                                        <div class="flex items-start">
                                            <div
                                                class="w-14 h-14 rounded-full bg-gray-200 overflow-hidden mr-4 border-2 border-teal-100 flex-shrink-0">
                                                <?php if (!empty($review['avatar'])): ?>
                                                    <!-- User has uploaded an avatar -->
                                                    <img src="<?= $review['avatar'] ?>" alt="<?= htmlspecialchars($review['full_name']) ?>"
                                                        class="w-full h-full object-cover"
                                                        onerror="this.onerror=null;this.src='https://avatar.iran.liara.run/public';" />
                                                    />
                                                <?php else: ?>
                                                    <!-- Generate avatar from external service using user's name -->
                                                    <?php
                                                    $userName = htmlspecialchars($review['full_name']);
                                                    ?>
                                                    <img src="https://avatar.iran.liara.run/public" alt="<?= $userName ?>"
                                                        class="w-full h-full object-cover" />
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($review['full_name']) ?></h4>
                                                <p class="text-sm text-gray-500">
                                                    <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                                                </p>
                                                <?php if (!empty($review['title'])): ?>
                                                    <p class="font-medium text-gray-700 mt-2"><?= htmlspecialchars($review['title']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 <?= ($i < $review['rating']) ? 'text-yellow-400' : 'text-gray-300' ?>"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4 leading-relaxed">
                                        <?= nl2br(htmlspecialchars($review['review'])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>

                            <?php if (count($reviews) > 5): ?>
                                <div class="text-center">
                                    <button id="loadMoreReviews"
                                        class="px-8 py-3 bg-teal-50 text-teal-600 rounded-full font-medium border border-teal-200 hover:bg-teal-100 transition-colors">
                                        Xem thêm đánh giá
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Phần Bản Đồ & Vị Trí -->
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8 transition-all hover:shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="bg-teal-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        Vị Trí
                    </h2>
                    <!-- Replace Static Map with Interactive Mapbox Map -->
                    <div class="aspect-video bg-gray-200 rounded-xl mb-6 overflow-hidden shadow-md">
                        <!-- Mapbox container with specific ID -->
                        <div id="tourLocationMap" class="w-full h-full"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-3 text-lg">Địa Chỉ</h3>
                            <p class="text-gray-600 mb-6">
                                <?= htmlspecialchars($tourDetails["location_name"]) ?><br />
                                <?= htmlspecialchars($tourDetails["location_des"]) ?>
                            </p>
                            <h3 class="font-semibold text-gray-800 mb-3 text-lg">Các Điểm Tham Quan Gần Kề</h3>
                            <ul class="text-gray-600 space-y-3">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Bãi biển địa phương (0.5 km)</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Trung tâm mua sắm (1.5 km)</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Thắng cảnh địa phương (2.3 km)</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-3 text-lg">Cách Di Chuyển Đến</h3>
                            <ul class="text-gray-600 space-y-3 mb-6">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Sân bay gần nhất (13 km)</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Đưa đón sân bay (đã bao gồm)</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-3 mt-0.5 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Dịch vụ taxi 24/7</span>
                                </li>
                            </ul>
                            <button id="getRouteBtn"
                                class="text-teal-500 font-medium hover:text-teal-600 transition-colors flex items-center bg-teal-50 px-5 py-2.5 rounded-lg">
                                <span>Nhận Lộ Trình</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking & Info: Compact Redesign -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-xl shadow overflow-hidden sticky top-24 border border-gray-100 hover:border-teal-100 transition-all">
                    <!-- Card Header with Gradient - Smaller -->
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 relative">
                        <?php if (!empty($tourDetails['sale_price'])): ?>
                            <div
                                class="absolute top-0 right-0 bg-white text-red-600 px-3 py-0.5 rounded-bl-lg font-semibold shadow-sm transform translate-y-0 -skew-y-3 text-sm">
                                <?= round((1 - $tourDetails['sale_price'] / $tourDetails['price']) * 100) ?>% GIẢM
                            </div>
                        <?php endif; ?>
                        <h3 class="text-white text-lg font-bold mb-1">Đặt tour</h3>
                        <p class="text-teal-100 text-xs">Đảm bảo chỗ của bạn ngay hôm nay</p>
                    </div>

                    <!-- Card Body - More Compact -->
                    <div class="p-4">
                        <!-- Date Selection Section -->
                        <div class="mb-4">
                            <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-teal-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Chọn ngày
                            </label>
                            <div class="relative">
                                <?php if (empty($tourDates)): ?>
                                    <div class="w-full border border-gray-300 rounded-lg py-2.5 px-3 text-sm bg-gray-100 text-gray-500">
                                        Không có lịch trình nào sắp tới
                                    </div>
                                <?php else: ?>
                                    <select id="tourDate"
                                        class="w-full border border-gray-300 rounded-lg py-2.5 px-3 text-sm appearance-none focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white shadow-sm">
                                        <?php foreach ($tourDates as $date):
                                            $startDate = date('d/m/Y', strtotime($date['start_date']));
                                            $endDate = date('d/m/Y', strtotime($date['end_date']));
                                            $datePrice = !empty($date['sale_price']) ? $date['sale_price'] : $date['price'];
                                            $defaultPrice = !empty($tourDetails['sale_price']) ? $tourDetails['sale_price'] : $tourDetails['price'];
                                            $displayPrice = !empty($datePrice) ? $datePrice : $defaultPrice;
                                        ?>
                                            <option value="<?= $date['id'] ?>" data-price="<?= $displayPrice ?>"
                                                data-seats="<?= $date['available_seats'] ?>">
                                                <?= $startDate ?> - <?= $endDate ?> (<?= $date['available_seats'] ?> chỗ)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-gray-400 absolute right-3 top-3 pointer-events-none" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Add hidden input for selected date ID -->
                        <input type="hidden" name="tour_date_id" id="selectedTourDateId"
                            value="<?= !empty($tourDates) ? $tourDates[0]['id'] : '' ?>">

                        <!-- Guests Selection Section - More Compact -->
                        <div class="mb-4">
                            <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-teal-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Số lượng khách
                            </label>

                            <!-- Adults Counter - More Compact -->
                            <div
                                class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg mb-2 bg-white shadow-sm">
                                <div>
                                    <p class="font-medium text-sm text-gray-700">Người lớn</p>
                                    <p class="text-xs text-gray-500">Trên 12 tuổi</p>
                                </div>
                                <div class="flex items-center">
                                    <button type="button"
                                        class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors"
                                        onclick="decrementGuests('adults')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-600" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-medium text-gray-700 text-sm" id="adults-count">2</span>
                                    <button type="button"
                                        class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors"
                                        onclick="incrementGuests('adults')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-600" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Children Counter - More Compact -->
                            <div class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg bg-white shadow-sm">
                                <div>
                                    <p class="font-medium text-sm text-gray-700">Trẻ em</p>
                                    <p class="text-xs text-gray-500">5-12 tuổi (Giảm 30%)</p>
                                </div>
                                <div class="flex items-center">
                                    <button type="button"
                                        class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors"
                                        onclick="decrementGuests('children')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-600" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-medium text-gray-700 text-sm" id="children-count">0</span>
                                    <button type="button"
                                        class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors"
                                        onclick="incrementGuests('children')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-600" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Price Calculation Summary - More Compact -->
                        <div class="bg-gray-50 p-3 rounded-lg mb-4 border border-gray-100 text-sm">
                            <h4 class="font-semibold text-gray-700 border-b border-gray-200 pb-1.5 mb-2">Chi tiết thanh toán</h4>
                            <?php
                            // Calculate initial values for display
                            $initialAdultTotal = $displayPrice * 1; // 2 is the default number of adults
                            $childPrice = $displayPrice * 0.7;      // Child price is 70% of adult price
                            $initialChildTotal = $childPrice * 0;   // 0 is the default number of children
                            $initialSubtotal = $initialAdultTotal + $initialChildTotal;
                            $initialTax = $initialSubtotal * 0.1;    // 10% tax
                            ?>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-gray-600">Người lớn (2 × <span
                                        class="adults-price"><?= number_format($displayPrice, 0, ',', '.') ?></span>)</span>
                                <span class="font-medium adults-total"><?= number_format($displayPrice * 2, 0, ',', '.') ?> VND</span>
                            </div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-gray-600">Trẻ em (0 × <span
                                        class="children-price"><?= number_format($childPrice, 0, ',', '.') ?></span>)</span>
                                <span class="font-medium children-total">0 VND</span>
                            </div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-gray-600">Thuế & phí (10%)</span>
                                <span class="font-medium tax-amount"><?= number_format($initialTax, 0, ',', '.') ?> VND</span>
                            </div>
                            <div class="flex justify-between font-bold mt-2 pt-2 border-t border-gray-200">
                                <span>Tổng cộng</span>
                                <span class="text-teal-600 total-price"><?= number_format(($displayPrice * 2) + 300000, 0, ',', '.') ?>
                                    VND</span>
                            </div>
                        </div>

                        <!-- Action Buttons - More Compact -->
                        <div class="space-y-3">
                            <button id="bookTourButton"
                                class="w-full bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold py-2 px-3 rounded-lg transition duration-300 flex justify-center items-center shadow-sm hover:shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Đặt Tour Ngay
                            </button>
                            <div class="flex gap-2">
                                <a href="<?= UrlHelper::route('home/contact') ?>" class="flex-1">
                                    <button
                                        class="w-full border border-teal-500 text-teal-500 hover:bg-teal-50 font-medium py-2 px-3 rounded-lg transition duration-300 flex items-center justify-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Đặt tư vấn
                                    </button>
                                </a>
                                <button id="wishlistButton"
                                    class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-medium py-2 px-2.5 rounded-lg transition duration-300 relative overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span
                                        class="absolute inset-0 rounded-lg flex items-center justify-center bg-teal-500 text-white text-xs transform -translate-y-full wishlist-tooltip">Đã
                                        thêm!</span>
                                </button>
                            </div>
                        </div>

                        <!-- Security badges - More Compact -->
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <div class="flex items-center justify-center space-x-3">
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-500 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Thanh toán an toàn
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-500 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Hỗ trợ 24/7
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Required Modal -->
        <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4 transform transition-all">
                <!-- Close button -->
                <div class="flex justify-end">
                    <button id="closeLoginModal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal content -->
                <div class="text-center mb-6">
                    <div class="bg-teal-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Đăng nhập để tiếp tục</h3>
                    <p class="text-gray-600 mb-6">Bạn cần đăng nhập để đặt tour này. Đăng nhập ngay để tiếp tục đặt tour!</p>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?= UrlHelper::route('auth/login') ?>"
                            class="flex-1 bg-teal-500 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-teal-600 transition-colors shadow-sm flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Đăng nhập
                        </a>
                        <a href="<?= UrlHelper::route('auth/register') ?>"
                            class="flex-1 border border-teal-500 text-teal-500 py-2.5 px-4 rounded-lg font-medium hover:bg-teal-50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                            Đăng ký
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thêm script của Swiper -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Khởi tạo Swiper thumbnail vertical
                const galleryThumbs = new Swiper('.galleryThumbs', {
                    direction: 'vertical',
                    spaceBetween: 10,
                    slidesPerView: 4,
                    watchSlidesProgress: true,
                    freeMode: true,
                    grabCursor: true,
                    breakpoints: {
                        // when window width is >= 320px
                        320: {
                            direction: 'horizontal',
                            slidesPerView: 3,
                        },
                        // when window width is >= 768px
                        768: {
                            direction: 'vertical',
                            slidesPerView: 4,
                        }
                    }
                });

                // Khởi tạo Swiper chính
                const galleryMain = new Swiper('.galleryMain', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    thumbs: {
                        swiper: galleryThumbs
                    }
                });

                // Xử lý các FAQ toggle
                const faqToggles = document.querySelectorAll('.faq-toggle');
                faqToggles.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const content = document.getElementById(targetId);
                        const icon = this.querySelector('.faq-icon');

                        // Toggle hiển thị nội dung
                        content.classList.toggle('hidden');

                        // Xoay icon khi mở/đóng
                        if (!content.classList.contains('hidden')) {
                            icon.classList.add('rotate-180');
                        } else {
                            icon.classList.remove('rotate-180');
                        }
                    });
                });

                // Hiển thị thêm nội dung lịch trình khi click vào button
                const showAllItineraryBtn = document.getElementById('showAllItinerary');
                if (showAllItineraryBtn) {
                    showAllItineraryBtn.addEventListener('click', function() {
                        const btnText = this.querySelector('span');
                        const btnIcon = this.querySelector('svg');
                        const hiddenDays = document.querySelectorAll('.itinerary-day');

                        hiddenDays.forEach(day => {
                            day.classList.toggle('hidden');
                        });

                        if (btnText.textContent === 'Xem toàn bộ lịch trình') {
                            btnText.textContent = 'Thu gọn lịch trình';
                            btnIcon.classList.add('rotate-180');
                        } else {
                            btnText.textContent = 'Xem toàn bộ lịch trình';
                            btnIcon.classList.remove('rotate-180');
                        }
                    });
                }
            });

            function incrementGuests(type) {
                const countElement = document.getElementById(type + '-count');
                let count = parseInt(countElement.textContent);

                if (type === 'adults' && count < 10) {
                    count++;
                } else if (type === 'children' && count < 5) {
                    count++;
                }

                countElement.textContent = count;
                updatePriceSummary();
            }

            function decrementGuests(type) {
                const countElement = document.getElementById(type + '-count');
                let count = parseInt(countElement.textContent);

                if (type === 'adults' && count > 1) {
                    count--;
                } else if (type === 'children' && count > 0) {
                    count--;
                }

                countElement.textContent = count;
                updatePriceSummary();
            }

            const tourDateSelect = document.getElementById('tourDate');
            if (tourDateSelect) {
                tourDateSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const datePrice = parseFloat(selectedOption.dataset.price);
                    const childPrice = datePrice * 0.7;
                    const selectedDateId = this.value;

                    // Update hidden input with selected date ID
                    document.getElementById('selectedTourDateId').value = selectedDateId;

                    // Update price display
                    updatePricesForDate(datePrice, childPrice);
                });
            }

            // New function to update price display when date changes
            function updatePricesForDate(adultPrice, childPrice) {
                // Update the displayed prices in the summary
                document.querySelectorAll('.adults-price').forEach(el => {
                    el.textContent = formatCurrency(adultPrice);
                });
                document.querySelectorAll('.children-price').forEach(el => {
                    el.textContent = formatCurrency(childPrice);
                });
                updatePriceSummary();
            }

            function updatePriceSummary() {
                const adultCount = parseInt(document.getElementById('adults-count').textContent);
                const childrenCount = parseInt(document.getElementById('children-count').textContent);

                let adultPrice = <?= $displayPrice ?>;

                // Check if a date is selected and use its price
                if (tourDateSelect) {
                    const selectedOption = tourDateSelect.options[tourDateSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.price) {
                        adultPrice = parseFloat(selectedOption.dataset.price);
                    }
                }

                // Ensure child price is ALWAYS 70% of adult price
                const childPrice = adultPrice * 0.7;

                const adultTotal = adultCount * adultPrice;
                const childrenTotal = childrenCount * childPrice;
                const subtotal = adultTotal + childrenTotal;
                const taxFee = subtotal * 0.1; // 10% tax
                const total = subtotal + taxFee;

                document.querySelector('.adults-total').textContent = formatCurrency(adultTotal) + ' VND';
                document.querySelector('.children-total').textContent = formatCurrency(childrenTotal) + ' VND';
                document.querySelector('.tax-amount').textContent = formatCurrency(taxFee) + ' VND';
                document.querySelector('.total-price').textContent = formatCurrency(total) + ' VND';
            }

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN').format(amount);
            }

            // Add wishlist button animation
            document.getElementById('wishlistButton').addEventListener('click', function() {
                const tooltip = this.querySelector('.wishlist-tooltip');
                tooltip.classList.remove('-translate-y-full');
                tooltip.classList.add('translate-y-0');

                setTimeout(() => {
                    tooltip.classList.remove('translate-y-0');
                    tooltip.classList.add('-translate-y-full');
                }, 1500);
            });


            const bookTourButton = document.getElementById('bookTourButton');
            const loginModal = document.getElementById('loginModal');
            const closeLoginModal = document.getElementById('closeLoginModal');

            // Replace the existing bookTourButton click handler with this one
            if (bookTourButton) {
                bookTourButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Check if user is logged in
                    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

                    if (isLoggedIn) {
                        // User is logged in, redirect to summary page
                        const tourId = <?= $tourDetails['id'] ?>;
                        const tourDateId = document.getElementById('selectedTourDateId').value;
                        const adultCount = parseInt(document.getElementById('adults-count').textContent);
                        const childrenCount = parseInt(document.getElementById('children-count').textContent);

                        // Build the URL with query parameters
                        let summaryUrl = `<?= UrlHelper::route('home/bookings/summary/') ?>${tourId}?` +
                            `tour_date_id=${tourDateId}&` +
                            `adults=${adultCount}&` +
                            `children=${childrenCount}`;

                        console.log(summaryUrl)
                        // return;
                        // Redirect to the summary page
                        window.location.href = summaryUrl;
                    } else {
                        // User is not logged in, show the modal
                        loginModal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                });
            }

            // Close modal when clicking the close button
            if (closeLoginModal) {
                closeLoginModal.addEventListener('click', function() {
                    loginModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            // Close modal when clicking outside the modal content
            if (loginModal) {
                loginModal.addEventListener('click', function(e) {
                    if (e.target === loginModal) {
                        loginModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }

            // MAPBOX

            mapboxgl.accessToken =
                'pk.eyJ1IjoiYmluaGRldiIsImEiOiJjbHduODEzNXMweWxrMmltanU3M3Voc3IxIn0.oZ19gfygIANckV1rAPGXuw';
            // Get location coordinates from tour details
            const lat = <?= !empty($tourDetails['location_la']) ? $tourDetails['location_la'] : 21.0285 ?>;
            const lng = <?= !empty($tourDetails['location_long']) ? $tourDetails['location_long'] : 105.8542 ?>;
            const locationName = "<?= htmlspecialchars($tourDetails['location_name']) ?>";

            // Initialize the map
            const map = new mapboxgl.Map({
                container: 'tourLocationMap',
                style: 'mapbox://styles/mapbox/streets-v11', // Default style
                center: [lng, lat], // [longitude, latitude]
                zoom: 12,
                interactive: true
            });

            // Add navigation controls
            map.addControl(new mapboxgl.NavigationControl(), 'top-right');

            // Create a custom marker element
            const markerElement = document.createElement('div');
            markerElement.className = 'custom-marker';
            markerElement.innerHTML = `
            <div class="relative">
                <div class="w-5 h-5 bg-teal-500 rounded-full border-2 border-white shadow-md"></div>
                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 translate-y-full">
                    <div class="bg-white px-2 py-1 rounded text-xs font-medium shadow-sm whitespace-nowrap">
                        ${locationName}
                    </div>
                </div>
            </div>
        `;

            // Add marker to the map
            new mapboxgl.Marker(markerElement)
                .setLngLat([lng, lat])
                .addTo(map);

            // Add a popup with location info
            new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false,
                    offset: 25,
                    className: 'custom-popup'
                })
                .setLngLat([lng, lat])
                .setHTML(`
            <div>
                <h3 class="text-sm font-bold">${locationName}</h3>
                <p class="text-xs text-gray-600"><?= htmlspecialchars($tourDetails['location_des']) ?></p>
            </div>
        `)
                .addTo(map);

            // Add event to "Nhận Lộ Trình" button to open directions
            document.querySelector('#getRouteBtn').addEventListener('click', function() {
                window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`, '_blank');
            });
        </script>

        <style>
            .custom-marker {
                cursor: pointer;
                z-index: 1;
            }

            .custom-popup .mapboxgl-popup-content {
                padding: 12px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                max-width: 250px;
            }

            .mapboxgl-popup-close-button {
                font-size: 16px;
                color: #666;
            }

            /* Animation for marker bounce */
            @keyframes markerBounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .custom-marker:hover>div {
                animation: markerBounce 0.6s ease infinite;
            }
        </style>
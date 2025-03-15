<?php

use App\Helpers\UrlHelper;

$title = 'Tin Tức - Di Travel';
$activePage = 'news';

?>

<div class="py-8 md:py-12">

    <!-- News Content Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main News Content -->
            <div class="lg:w-2/3">
                <!-- Featured News -->
                <div class="mb-12">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative h-[300px] md:h-[400px]">
                            <img src="<?= UrlHelper::image('featured-news.jpg') ?>" alt="Tin tức nổi bật" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Điểm Đến Hot</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>15 Tháng 7, 2023</span>
                                <span class="mx-2">•</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>1.2K lượt xem</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Top 10 Bãi Biển Đẹp Nhất Việt Nam Phải Đến Hè Này</h3>
                            <p class="text-gray-600 mb-4">Khám phá những bãi biển tuyệt đẹp với làn nước trong xanh, bờ cát trắng mịn và dịch vụ đẳng cấp. Hãy cùng Di Travel điểm qua những thiên đường biển đảo hàng đầu Việt Nam mà bạn không nên bỏ lỡ trong mùa hè này.</p>
                            <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                                Đọc tiếp
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News List -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-800">Tin Tức Mới Nhất</h2>
                        <div class="flex space-x-2">
                            <button class="p-2 rounded-md bg-teal-600 text-white hover:bg-teal-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                            </button>

                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- News Item 1 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3">
                                    <div class="relative h-[200px] md:h-full">
                                        <img src="<?= UrlHelper::image('news-1.jpg') ?>" alt="Tin tức 1" class="w-full h-full object-cover">
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Ẩm Thực</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>10 Tháng 7, 2023</span>
                                        <span class="mx-2">•</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>850 lượt xem</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">Khám Phá 5 Món Ăn Đặc Sản Không Thể Bỏ Qua Khi Đến Đà Nẵng</h3>
                                    <p class="text-gray-600 mb-4">Đà Nẵng không chỉ nổi tiếng với cảnh đẹp mà còn có nền ẩm thực phong phú. Hãy cùng khám phá những món ăn đặc sản mà bạn không nên bỏ lỡ khi đến thành phố biển xinh đẹp này.</p>
                                    <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 2 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3">
                                    <div class="relative h-[200px] md:h-full">
                                        <img src="<?= UrlHelper::image('news-2.jpg') ?>" alt="Tin tức 2" class="w-full h-full object-cover">
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Mẹo Du Lịch</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>5 Tháng 7, 2023</span>
                                        <span class="mx-2">•</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>720 lượt xem</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">7 Cách Tiết Kiệm Chi Phí Khi Du Lịch Vào Mùa Cao Điểm</h3>
                                    <p class="text-gray-600 mb-4">Du lịch vào mùa cao điểm thường đồng nghĩa với giá cả tăng cao. Tuy nhiên, với những mẹo nhỏ này, bạn vẫn có thể tận hưởng kỳ nghỉ tuyệt vời mà không cần lo lắng về ngân sách.</p>
                                    <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 3 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3">
                                    <div class="relative h-[200px] md:h-full">
                                        <img src="<?= UrlHelper::image('news-3.jpg') ?>" alt="Tin tức 3" class="w-full h-full object-cover">
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Văn Hóa</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>1 Tháng 7, 2023</span>
                                        <span class="mx-2">•</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>635 lượt xem</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">Lễ Hội Truyền Thống Đặc Sắc Tại Các Vùng Miền Việt Nam</h3>
                                    <p class="text-gray-600 mb-4">Việt Nam có nền văn hóa phong phú với nhiều lễ hội truyền thống độc đáo. Hãy cùng Di Travel khám phá những lễ hội đặc sắc nhất tại các vùng miền khác nhau trên đất nước hình chữ S.</p>
                                    <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 4 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3">
                                    <div class="relative h-[200px] md:h-full">
                                        <img src="<?= UrlHelper::image('news-4.jpg') ?>" alt="Tin tức 4" class="w-full h-full object-cover">
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Khuyến Mãi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>28 Tháng 6, 2023</span>
                                        <span class="mx-2">•</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>580 lượt xem</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ưu Đãi Đặc Biệt: Giảm 30% Cho Tour Phú Quốc Mùa Hè Này</h3>
                                    <p class="text-gray-600 mb-4">Hè này, Di Travel mang đến cho bạn cơ hội khám phá đảo ngọc Phú Quốc với ưu đãi giảm giá lên đến 30%. Hãy nhanh tay đặt tour để tận hưởng kỳ nghỉ tuyệt vời với giá cực kỳ hấp dẫn.</p>
                                    <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex justify-center mt-8">
                        <nav class="flex items-center space-x-2">
                            <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <a href="#" class="px-4 py-2 rounded-md bg-teal-600 text-white font-medium">1</a>
                            <a href="#" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">2</a>
                            <a href="#" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">3</a>
                            <span class="px-4 py-2 text-gray-700">...</span>
                            <a href="#" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">8</a>
                            <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>


            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">

                <!-- Categories -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Danh Mục</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Điểm Đến Hot</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">24</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Ẩm Thực</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">18</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Mẹo Du Lịch</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">15</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Văn Hóa</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Khuyến Mãi</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">9</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                <span>Trải Nghiệm</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">7</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Popular Posts -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Bài Viết Phổ Biến</h3>
                    <div class="space-y-4">
                        <!-- Popular Post 1 -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-20 h-20">
                                <img src="<?= UrlHelper::image('popular-1.jpg') ?>" alt="Bài viết phổ biến 1" class="w-full h-full object-cover rounded">
                            </div>
                            <div>
                                <h4 class="text-gray-800 font-medium hover:text-teal-600 transition-colors line-clamp-2">
                                    <a href="#">10 Điểm Du Lịch Miền Bắc Lý Tưởng Cho Mùa Thu</a>
                                </h4>
                                <p class="text-gray-500 text-sm mt-1">20 Tháng 6, 2023</p>
                            </div>
                        </div>

                        <!-- Popular Post 2 -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-20 h-20">
                                <img src="<?= UrlHelper::image('popular-2.jpg') ?>" alt="Bài viết phổ biến 2" class="w-full h-full object-cover rounded">
                            </div>
                            <div>
                                <h4 class="text-gray-800 font-medium hover:text-teal-600 transition-colors line-clamp-2">
                                    <a href="#">Kinh Nghiệm Du Lịch Tự Túc Đà Lạt Tiết Kiệm</a>
                                </h4>
                                <p class="text-gray-500 text-sm mt-1">15 Tháng 6, 2023</p>
                            </div>
                        </div>

                        <!-- Popular Post 3 -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-20 h-20">
                                <img src="<?= UrlHelper::image('popular-3.jpg') ?>" alt="Bài viết phổ biến 3" class="w-full h-full object-cover rounded">
                            </div>
                            <div>
                                <h4 class="text-gray-800 font-medium hover:text-teal-600 transition-colors line-clamp-2">
                                    <a href="#">5 Resort Sang Chảnh Nhất Việt Nam Đáng Để Trải Nghiệm</a>
                                </h4>
                                <p class="text-gray-500 text-sm mt-1">10 Tháng 6, 2023</p>
                            </div>
                        </div>

                        <!-- Popular Post 4 -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-20 h-20">
                                <img src="<?= UrlHelper::image('popular-4.jpg') ?>" alt="Bài viết phổ biến 4" class="w-full h-full object-cover rounded">
                            </div>
                            <div>
                                <h4 class="text-gray-800 font-medium hover:text-teal-600 transition-colors line-clamp-2">
                                    <a href="#">Những Món Quà Lưu Niệm Ý Nghĩa Khi Du Lịch Miền Trung</a>
                                </h4>
                                <p class="text-gray-500 text-sm mt-1">5 Tháng 6, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


</div>
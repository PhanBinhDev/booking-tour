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
                            <img src="<?php echo $featuredNews['featured_image']; ?>" alt="Tin tức nổi bật" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">Điểm Đến Hot</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span><?php echo $featuredNews['created_at']; ?></span>
                                <span class="mx-2">•</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>1<?php echo $featuredNews['views']; ?> lượt xem</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3"><?php echo $featuredNews['title']; ?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-3 text-sm md:text-base"><?php echo $featuredNews['content']; ?></p>
                            <a href="<?= UrlHelper::route('/home/news-detail/') ?><?= $featuredNews['id'] ?>" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
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
                        <?php foreach ($newsList as $item) { ?>
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden mb-6">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-1/3 md:min-w-[280px]">
                                        <div class="relative h-[200px] md:h-[220px]">
                                            <img
                                                src="<?= $item['featured_image'] ?>"
                                                alt="Tin tức"
                                                class="w-full h-full object-cover">
                                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                                <?php if (!empty($item['categories'])): ?>
                                                    <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                                        <?= $item['categories']['0']['category_name'] ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="md:w-2/3 p-5 md:p-6 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span><?= $item['published_at'] ?></span>
                                                <span class="mx-2 text-teal-500">•</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span><?= number_format($item['views']) ?> lượt xem</span>
                                            </div>

                                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 line-clamp-2">
                                                <a href="<?= UrlHelper::route('/home/news-detail/') ?><?= $item['id'] ?>" class="hover:text-teal-600 transition-colors">
                                                    <?= $item['title'] ?>
                                                </a>
                                            </h3>

                                            <p class="text-gray-600 mb-4 line-clamp-3 text-sm md:text-base">
                                                <?= $item['content'] ?>
                                            </p>
                                        </div>

                                        <a href="<?= UrlHelper::route('/home/news-detail/') ?><?= $item['id'] ?>" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium group">
                                            Đọc tiếp
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                    <?php foreach ($getActiveCategories as $item) { ?>
                        <ul class="space-y-3">
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-teal-600 transition-colors">
                                    <span><?= $item['name'] ?></span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs"><?= $item['post_count'] ?></span>
                                </a>
                        </ul>
                    <?php } ?>
                </div>

                <!-- Popular Posts -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Bài Viết Phổ Biến</h3>
                    <div class="space-y-4">
                        <!-- Popular Post 1 -->
                        <?php foreach ($topViewedNews as $news) { ?>
                            <div class="flex space-x-4">

                                <div class="flex-shrink-0 w-20 h-20">
                                    <img src="<?= $news['featured_image'] ?>" alt="Bài viết phổ biến" class="w-full h-full object-cover rounded">
                                </div>
                                <div>
                                    <h4 class="text-gray-800 font-medium hover:text-teal-600 transition-colors line-clamp-2">
                                        <a href="#"><?= $news['title'] ?></a>
                                    </h4>
                                    <p class="text-gray-500 text-sm mt-1"><?= $news['views'] ?> lượt xem</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
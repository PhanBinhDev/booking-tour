<?php

use App\Helpers\UrlHelper;

?>
<div class="min-h-screen flex flex-col ">
    <!-- Nội dung chính -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Nội dung bài viết -->
            <article class="lg:w-2/3">
                <div class="mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4"><?= $news['title'] ?></h1>

                    <div class="flex flex-wrap items-center text-gray-500 text-sm mb-6">
                        <div class="flex items-center mr-4 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span><?= $news['created_at'] ?></span>
                        </div>
                        <div class="flex items-center mr-4 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Bởi John Smith</span>
                        </div>
                    </div>
                </div>

                <div class="relative w-full h-[400px] mb-6 rounded-lg overflow-hidden">
                    <img src="<?= $news['featured_image'] ?>" alt="Tin tức"
                        class="absolute inset-0 w-full h-full object-cover" />
                </div>



                <!-- Thẻ -->
                <!-- <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold mb-3">Thẻ:</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="/tag/ai" class="px-3 py-1 bg-gray-100 hover:bg-teal-100 rounded-full text-sm">AI</a>
                        <a href="/tag/healthcare"
                            class="px-3 py-1 bg-gray-100 hover:bg-teal-100 rounded-full text-sm">Y tế</a>
                        <a href="/tag/technology"
                            class="px-3 py-1 bg-gray-100 hover:bg-teal-100 rounded-full text-sm">Công nghệ</a>
                        <a href="/tag/machine-learning" class="px-3 py-1 bg-gray-100 hover:bg-teal-100 rounded-full text-sm">Học máy</a>
                    </div>
                </div> -->

                <!-- Chia sẻ -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">Chia sẻ:</h3>
                    <div class="flex space-x-4">
                        <button class="p-2 bg-blue-600 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </button>
                        <button class="p-2 bg-sky-500 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </button>
                        <button class="p-2 bg-red-600 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7 11v2.4h3.97c-.16 1.029-1.2 3.02-3.97 3.02-2.39 0-4.34-1.979-4.34-4.42 0-2.44 1.95-4.42 4.34-4.42 1.36 0 2.27.58 2.79 1.08l1.9-1.83c-1.22-1.14-2.8-1.83-4.69-1.83-3.87 0-7 3.13-7 7s3.13 7 7 7c4.04 0 6.721-2.84 6.721-6.84 0-.46-.051-.81-.111-1.16h-6.61zm0 0 17 2h-3v3h-2v-3h-3v-2h3v-3h2v3h3v2z"
                                    fill-rule="evenodd" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button class="p-2 bg-blue-800 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </article>

            <!-- Thanh bên -->
            <aside class="lg:w-1/3">
                <!-- Tác giả -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <div class="flex items-center mb-4">
                        <div class="relative w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="https://placeholder.co/200" alt="Tác giả" class="absolute inset-0 w-full h-full object-cover" />
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">John Smith</h3>
                            <p class="text-gray-600">Phóng viên Y tế cấp cao</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        John đã đưa tin về y tế và công nghệ trong hơn một thập kỷ, với sự tập trung đặc biệt vào các công nghệ y tế mới nổi.
                    </p>
                </div>

                <!-- Bài viết liên quan -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h3 class="font-bold text-xl mb-4 pb-2 border-b border-gray-200">Bài viết liên quan</h3>
                    <div class="space-y-4">
                        <?php foreach ($topViewedNews as $news) { ?>
                            <div class="flex items-start">
                                <div class="relative w-20 h-20 rounded overflow-hidden flex-shrink-0">
                                    <img src="<?= $news['featured_image'] ?>" alt="Bài viết liên quan"
                                        class="absolute inset-0 w-full h-full object-cover" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium hover:text-teal-500">
                                        <a href="<?= UrlHelper::route('/home/news-detail/') ?><?= $news['id'] ?>"><?= $news['title'] ?></a>
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1"><?= $news['views'] ?> lượt xem</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>


            </aside>
        </div>
    </div>

</div>
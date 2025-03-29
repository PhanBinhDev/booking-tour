<main class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tour yêu thích của bạn</h1>
            <p class="text-gray-600">Danh sách các tour du lịch bạn đã đánh dấu yêu thích</p>
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

        <!-- Tour List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tour Card 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                <div class="relative">
                    <!-- Tour Image -->
                    <div class="h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1540329957110-b87cd2e1c6d7?w=800&auto=format&fit=crop" alt="Đà Nẵng - Hội An" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- Discount Badge -->
                    <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        -13%
                    </div>

                    <!-- Favorite Button -->
                    <button class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </button>

                    <!-- Duration Badge -->
                    <div class="absolute bottom-4 left-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium">
                        4 ngày 3 đêm
                    </div>
                </div>

                <div class="p-5">
                    <!-- Tour Title -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 h-14">
                        Khám phá Đà Nẵng - Hội An - Bà Nà Hills
                    </h3>

                    <!-- Rating -->
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-600 ml-2">4.8 (124 đánh giá)</span>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 mb-4 text-sm line-clamp-2 h-10">
                        Khám phá vẻ đẹp của Đà Nẵng, thành phố đáng sống nhất Việt Nam cùng phố cổ Hội An và khu du lịch Bà Nà Hills.
                    </p>

                    <!-- Departure Date -->
                    <div class="flex items-center mb-4 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Khởi hành: 15/06/2025
                    </div>

                    <!-- Price and Action -->
                    <div class="flex justify-between items-end">
                        <div>
                            <span class="text-gray-400 line-through text-sm block">4.590.000đ</span>
                            <span class="text-teal-500 font-bold text-xl">3.990.000đ</span>
                        </div>
                        <a href="#" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                            Đặt ngay
                        </a>
                    </div>
                </div>
            </div>

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
    </div>
</main>
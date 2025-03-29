<?php

use App\Helpers\UrlHelper;

$title = 'Trang chủ - Di Travel';

?>

<body class="bg-gray-50">
  <!-- Your header goes here -->

  <main class=" min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="relative overflow-hidden" style="height: calc(100vh - 80px);">
      <div class="absolute inset-0">
        <video autoplay muted loop class="w-full h-full object-cover">
          <source
            src="https://storage.googleapis.com/teko-gae.appspot.com/media/video/2023/11/19/22451432-c310-4081-858c-cfb57570e249/6487d1c5c3473ff5e5376abd_camelia-transcode.webm">
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
      </div>
      <div class="relative h-full flex items-center justify-center px-4">
        <div class="text-center max-w-3xl">
          <h1 class="text-xl md:text-5xl lg:text-6xl font-bold text-white mb-3">
            Di Travel
          </h1>
          <p class="text-l text-white mb-5">
            Tại DiTravel, chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch độc đáo, những dịch vụ chất lượng
            và những thông tin hữu ích để bạn có thể lên kế hoạch cho chuyến đi hoàn hảo.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Button nổi bật chính -->
            <button
              class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-1 hover:shadow-xl">
              <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Khám phá ngay
              </span>
            </button>

            <!-- Button đặt lịch -->
            <button
              class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-1 hover:shadow-xl">
              <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Liên hệ
              </span>
            </button>
          </div>

          <!-- Thêm section nhỏ với các link nhanh -->
          <!-- <div class="mt-6 flex justify-center space-x-4">
            <a href="#" class="text-white hover:text-yellow-300 transition duration-300 text-sm underline">Điểm đến hot</a>
            <span class="text-gray-400">|</span>
            <a href="#" class="text-white hover:text-yellow-300 transition duration-300 text-sm underline">Ưu đãi</a>
            <span class="text-gray-400">|</span>
            <a href="#" class="text-white hover:text-yellow-300 transition duration-300 text-sm underline">Đánh giá</a>
          </div> -->
        </div>
      </div>
      </div>
    </section>

    <!-- Search Section -->
    <section class="py-8 px-4 bg-teal-50">
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg -mt-16 relative z-10 p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Tìm kiếm </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


          <div>
            <label class="block text-gray-700 mb-2">Danh mục</label>
            <select
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option>1 Person</option>
              <option>2 People</option>
              <option>3 People</option>
              <option>4+ People</option>
            </select>
          </div>

          <div>
            <label class="block text-gray-700 mb-2">Địa điểm</label>
            <select
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option>Any Destination</option>
              <option>Europe</option>
              <option>Asia</option>
              <option>North America</option>
              <option>South America</option>
              <option>Africa</option>
              <option>Australia</option>
            </select>
          </div>

          <div class="flex items-end">
            <button
              class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
              Search
            </button>
          </div>
        </div>
      </div>
    </section>
    </section>


    <!-- Featured Destinations -->
    <section class="py-12 px-4 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-2">Điểm đến nổi bật</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Hãy cùng chúng tôi hòa mình vào văn hóa bản địa, thưởng thức ẩm thực đặc sắc và tạo nên những kỷ niệm khó quên.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Destination Card 1 -->
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

          <!-- Destination Card 2 -->
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

          <!-- Destination Card 3 -->
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

        <div class="text-center mt-12">
          <button
            class="bg-white border-2 border-teal-500 hover:bg-teal-50 text-teal-500 font-semibold py-3 px-8 rounded-lg transition duration-300">
            Xem tất cả
          </button>
        </div>
      </div>
    </section>

    <!-- Special Offers -->
    <section class="py-12 px-4 bg-teal-50">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-2">Giá cả ưu đãi không thể bỏ lỡ</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Những tour với giá ưu đãi nhất, đi thả ga không lo về giá.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Offer 1 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
            <div class="relative"> mb-2
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

          <!-- Offer 2 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 3 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 4 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 5 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 6 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 7 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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

          <!-- Offer 8 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 group mb-2">
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
      </div>
    </section>

    <section class="explore-section relative">
      <!-- Hero Banner with Maldives Image -->
      <div class="relative h-[600px] overflow-hidden">
        <img src="https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=1600&h=900&fit=crop" alt="Maldives Aerial View" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-4">
          <div class="container mx-auto max-w-6xl">
            <h2 class="text-5xl md:text-6xl font-bold mb-6 text-center md:text-left">EXPLORE MALDIVES</h2>
            <div class="w-full h-px bg-white/30 my-6"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
              <div class="md:col-span-1">
                <p class="text-white/90 mb-8 max-w-md">
                  Khám phá thiên đường biển đảo Maldives với những bãi cát trắng mịn, làn nước trong xanh và những khu nghỉ dưỡng sang trọng trên mặt nước. Trải nghiệm kỳ nghỉ đáng nhớ tại một trong những điểm đến đẹp nhất hành tinh.
                </p>
                <a href="#" class="inline-flex items-center bg-white text-gray-800 px-6 py-3 rounded-full font-medium hover:bg-teal-500 hover:text-white transition-colors">
                  Xem tất cả
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </a>
              </div>

              <div class="md:col-span-2 grid grid-cols-3 gap-4">
                <!-- Destination Card 1 -->
                <div class="group">
                  <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1540202404-a2f29016b523?w=500&h=350&fit=crop" alt="Azure Haven" class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                  </div>
                  <h3 class="text-center text-white font-medium mt-3">Azure Haven</h3>
                </div>

                <!-- Destination Card 2 -->
                <div class="group">
                  <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=500&h=350&fit=crop" alt="Serene Sanctuary" class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                  </div>
                  <h3 class="text-center text-white font-medium mt-3">Serene Sanctuary</h3>
                </div>

                <!-- Destination Card 3 -->
                <div class="group">
                  <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1602002418816-5c0aeef426aa?w=500&h=350&fit=crop" alt="Verdant Vista" class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                  </div>
                  <h3 class="text-center text-white font-medium mt-3">Verdant Vista</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Feature News Section -->
      <div class="bg-white py-16">
        <div class="container mx-auto max-w-6xl px-4">
          <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tin tức</h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- News Card 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100">
              <div class="h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="Restaurant" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
              </div>
              <div class="p-5">
                <div class="flex items-center text-gray-500 text-sm mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  February 20, 2024
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Delicious restaurant at Hanalei Bay</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                  Lorem ipsum is simply dummy text of the printing and typeset industry. Lorem ipsum has been lorem ipsum is simply dummy text of the printing.
                </p>
                <a href="#" class="inline-flex items-center text-teal-500 hover:text-teal-600 font-medium text-sm">
                  <span class="w-6 h-6 rounded-full border border-teal-500 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </span>
                  Xem chi tiết
                </a>
              </div>
            </div>

            <!-- News Card 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100">
              <div class="h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=600&h=400&fit=crop" alt="Beach" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
              </div>
              <div class="p-5">
                <div class="flex items-center text-gray-500 text-sm mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  February 20, 2024
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Top 10 most beautiful check-in spots in Ph...</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                  Lorem ipsum is simply dummy text of the printing and typeset industry. Lorem ipsum has been lorem ipsum is simply dummy text of the printing.
                </p>
                <a href="#" class="inline-flex items-center text-teal-500 hover:text-teal-600 font-medium text-sm">
                  <span class="w-6 h-6 rounded-full border border-teal-500 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </span>
                  Xem chi tiết
                </a>
              </div>
            </div>

            <!-- News Card 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100">
              <div class="h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1540202404-a2f29016b523?w=600&h=400&fit=crop" alt="Resort" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
              </div>
              <div class="p-5">
                <div class="flex items-center text-gray-500 text-sm mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  February 20, 2024
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Top 5 newest services at Navagio Beach</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                  Lorem ipsum is simply dummy text of the printing and typeset industry. Lorem ipsum has been lorem ipsum is simply dummy text of the printing.
                </p>
                <a href="#" class="inline-flex items-center text-teal-500 hover:text-teal-600 font-medium text-sm">
                  <span class="w-6 h-6 rounded-full border border-teal-500 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </span>
                  Xem chi tiết
                </a>
              </div>
            </div>
          </div>

          <div class="text-center mt-12">
            <button
              class="bg-white border-2 border-teal-500 hover:bg-teal-50 text-teal-500 font-semibold py-3 px-8 rounded-lg transition duration-300">
              Xem tất cả
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 px-4 bg-teal-50">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Khách hàng nói gì về chúng tôi</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Cùng đọc những trải nghiệm mà các vị khách đã nhận được trong suốt những chuyến hành trình cùng Di Travel
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Testimonial 1 -->
          <div
            class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center mb-4">
              <div class="flex text-yellow-400 mb-2">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
              </div>
            </div>
            <p class="text-gray-600 mb-6 italic">
              "The trip to Bali was absolutely amazing! The accommodations were perfect, and our guide was knowledgeable
              and friendly. I can't wait to book my next adventure!"
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                <img src="https://via.placeholder.com/50x50" alt="Sarah Johnson" class="w-full h-full object-cover" />
              </div>
              <div>
                <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
                <p class="text-gray-500 text-sm">Bali, Indonesia</p>
              </div>
            </div>
          </div>

          <!-- Testimonial 2 -->
          <div
            class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center mb-4">
              <div class="flex text-yellow-400 mb-2">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
              </div>
            </div>
            <p class="text-gray-600 mb-6 italic">
              "Our family trip to Japan exceeded all expectations. The itinerary was perfectly balanced with cultural
              experiences and fun activities for the kids. Highly recommended!"
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                <img src="https://via.placeholder.com/50x50" alt="Michael Chen" class="w-full h-full object-cover" />
              </div>
              <div>
                <h4 class="font-semibold text-gray-800">Michael Chen</h4>
                <p class="text-gray-500 text-sm">Tokyo, Japan</p>
              </div>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div
            class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center mb-4">
              <div class="flex text-yellow-400 mb-2">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
              </div>
            </div>
            <p class="text-gray-600 mb-6 italic">
              "The European tour was the trip of a lifetime! Every detail was taken care of, and we got to experience
              the best of each city we visited. I'm already planning my next trip!"
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                <img src="https://via.placeholder.com/50x50" alt="Emily Rodriguez" class="w-full h-full object-cover" />
              </div>
              <div>
                <h4 class="font-semibold text-gray-800">Emily Rodriguez</h4>
                <p class="text-gray-500 text-sm">Paris, France</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-white">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Tại Sao Chọn Di Travel</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Reason 1 -->
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đặt Tour An Toàn 100%</h3>
          <p class="text-gray-600 text-center">
            Thanh toán dễ dàng, thông tin cá nhân của bạn luôn được bảo vệ với hệ thống đặt tour an toàn và bảo mật của chúng tôi.
          </p>
        </div>

        <!-- Reason 2 -->
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Hỗ Trợ 24/7</h3>
          <p class="text-gray-600 text-center">
            Đội ngũ dịch vụ khách hàng tận tâm của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc với bất kỳ câu hỏi hoặc
            thắc
            mắc nào.
          </p>
        </div>

        <!-- Reason 3 -->
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đảm Bảo Giá Tốt Nhất</h3>
          <p class="text-gray-600 text-center">
            Chúng tôi cung cấp giá cả cạnh tranh và sẽ đáp ứng bất kỳ ưu đãi tương đương nào cho cùng một tour và điều
            kiện.
          </p>
        </div>

        <!-- Reason 4 -->
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">HDV Chuyên Nghiệp</h3>
          <p class="text-gray-600 text-center">
            Các hướng dẫn viên am hiểu của chúng tôi cung cấp góc nhìn nội địa và đảm bảo bạn trải nghiệm bản chất chân
            thực của mỗi điểm đến.
          </p>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <section class="py-12 px-4 bg-gray-900 text-white">
      <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Bạn đã sẵn sàng cho chuyến đi sắp tới?</h2>
        <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
          Cùng Di Travel tạo nên những hành trình tuyệt vời chỉ với một cú nhấp chuột.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <button
            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
            Lên lịch ngay
          </button>
          <button
            class="bg-transparent hover:bg-white hover:text-gray-900 text-white font-semibold py-3 px-8 rounded-lg border-2 border-white transition duration-300">
            Liên hệ với chúng tôi
          </button>
        </div>
      </div>
    </section>
  </main>

  <!-- Your footer goes here -->
</body>
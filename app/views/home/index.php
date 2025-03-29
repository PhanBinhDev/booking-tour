<?php

use App\Helpers\UrlHelper;

$title = 'Trang chủ - Di Travel';

?>

<body class="bg-gray-50">
  <!-- Your header goes here -->

  <main class="min-h-screen bg-gray-50">
    <!-- Hero Section -->

    <!-- Hero Section -->
    <section class="relative h-screen overflow-hidden">
      <!-- Background Image/Video with Overlay -->
      <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?q=80&w=2068&auto=format&fit=crop"
          alt="Beach Paradise" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-teal-900/30"></div>
      </div>

      <!-- Content Container -->
      <div class="relative h-full container mx-auto px-4 flex flex-col justify-center items-start">
        <div class="max-w-2xl">
          <!-- Main Heading -->
          <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 tracking-tight">
            EXPLORE <span class="text-teal-400">PARADISE</span>
          </h1>

          <!-- Description -->
          <p class="text-lg text-white/90 mb-8 max-w-xl">
            Tại DiTravel, chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch độc đáo, những dịch vụ chất lượng
            và những thông tin hữu ích để bạn có thể lên kế hoạch cho chuyến đi hoàn hảo.
          </p>

          <!-- CTA Button -->
          <button
            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-md transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            Xem ngay
          </button>
        </div>

        <!-- Featured Destinations Cards -->
        <div class="absolute bottom-16 right-4 md:right-16 flex gap-4 overflow-x-auto pb-4 max-w-xl">
          <!-- Destination Card 1 -->
          <div
            class="bg-white/10 backdrop-blur-md rounded-lg overflow-hidden w-32 md:w-40 flex-shrink-0 group hover:bg-white/20 transition duration-300">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&h=300&fit=crop"
              alt="Luxury Resort" class="w-full h-24 object-cover" />
            <div class="p-2">
              <p class="text-white text-xs md:text-sm font-medium">Luxury Resort</p>
            </div>
          </div>

          <!-- Destination Card 2 -->
          <div
            class="bg-white/10 backdrop-blur-md rounded-lg overflow-hidden w-32 md:w-40 flex-shrink-0 group hover:bg-white/20 transition duration-300">
            <img src="https://images.unsplash.com/photo-1602002418082-dd0e2857e0a0?w=500&h=300&fit=crop"
              alt="Seaside Sanctuary" class="w-full h-24 object-cover" />
            <div class="p-2">
              <p class="text-white text-xs md:text-sm font-medium">Seaside Sanctuary</p>
            </div>
          </div>

          <!-- Destination Card 3 -->
          <div
            class="bg-white/10 backdrop-blur-md rounded-lg overflow-hidden w-32 md:w-40 flex-shrink-0 group hover:bg-white/20 transition duration-300">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=500&h=300&fit=crop"
              alt="Vacation Villa" class="w-full h-24 object-cover" />
            <div class="p-2">
              <p class="text-white text-xs md:text-sm font-medium">Vacation Villa</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Search Section -->
    <section class="py-8 px-4 bg-teal-50">
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-xl -mt-16 relative z-10 p-6 border border-teal-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Tìm kiếm chuyến đi mơ ước</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-gray-700 mb-2 font-medium">Danh mục</label>
            <select
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option>1 Person</option>
              <option>2 People</option>
              <option>3 People</option>
              <option>4+ People</option>
            </select>
          </div>

          <div>
            <label class="block text-gray-700 mb-2 font-medium">Địa điểm</label>
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
              class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 shadow-md">
              Search
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Destinations -->
    <section class="py-12 px-4 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-2">Điểm đến nổi bật</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Hãy cùng chúng tôi hòa mình vào văn hóa bản địa, thưởng thức ẩm thực đặc sắc và tạo nên những kỷ niệm khó
            quên.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Destination Card 1 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="relative h-64">
              <img src="https://via.placeholder.com/400x300" alt="Bali, Indonesia" class="w-full h-full object-cover" />
              <div class="absolute top-4 right-4 bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                Popular
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Bali, Indonesia</h3>
              <div class="flex items-center mb-4">
                <div class="flex text-yellow-400">
                  <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <span class="text-gray-600 ml-2">5.0 (120 reviews)</span>
              </div>
              <p class="text-gray-600 mb-4">
                Experience the perfect blend of beautiful beaches, vibrant culture, and spiritual retreats.
              </p>
              <div class="flex justify-between items-center">
                <span class="text-teal-500 font-bold text-xl">$1,299</span>
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                  View Details
                </button>
              </div>
            </div>
          </div>

          <!-- Destination Card 2 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="relative h-64">
              <img src="https://via.placeholder.com/400x300" alt="Santorini, Greece"
                class="w-full h-full object-cover" />
              <div class="absolute top-4 right-4 bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                Trending
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Santorini, Greece</h3>
              <div class="flex items-center mb-4">
                <div class="flex text-yellow-400">
                  <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <span class="text-gray-600 ml-2">4.9 (98 reviews)</span>
              </div>
              <p class="text-gray-600 mb-4">
                Discover the iconic white buildings, blue domes, and breathtaking sunsets over the Aegean Sea.
              </p>
              <div class="flex justify-between items-center">
                <span class="text-teal-500 font-bold text-xl">$1,599</span>
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                  View Details
                </button>
              </div>
            </div>
          </div>

          <!-- Destination Card 3 -->
          <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="relative h-64">
              <img src="https://via.placeholder.com/400x300" alt="Kyoto, Japan" class="w-full h-full object-cover" />
              <div class="absolute top-4 right-4 bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                New
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Kyoto, Japan</h3>
              <div class="flex items-center mb-4">
                <div class="flex text-yellow-400">
                  <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <span class="text-gray-600 ml-2">4.8 (85 reviews)</span>
              </div>
              <p class="text-gray-600 mb-4">
                Immerse yourself in Japanese culture with ancient temples, traditional gardens, and tea ceremonies.
              </p>
              <div class="flex justify-between items-center">
                <span class="text-teal-500 font-bold text-xl">$1,899</span>
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                  View Details
                </button>
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
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop"
                alt="Summer Beach Getaway" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                25% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Summer Beach Getaway</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Enjoy a relaxing beach vacation with our all-inclusive package.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$1,999</span>
                <span class="text-teal-500 font-bold text-xl">$1,499</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 2 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=500&h=300&fit=crop"
                alt="Mountain Retreat" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                30% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Mountain Retreat</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Explore breathtaking mountain views with guided hiking tours.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$2,899</span>
                <span class="text-teal-500 font-bold text-xl">$1,999</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 3 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500&h=300&fit=crop"
                alt="Paris Explorer" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                20% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Paris Explorer</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Experience the romance and culture of Paris with guided tours.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$2,199</span>
                <span class="text-teal-500 font-bold text-xl">$1,759</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 4 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=500&h=300&fit=crop"
                alt="Safari Adventure" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                15% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Safari Adventure</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Witness incredible wildlife on this African safari adventure.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$3,499</span>
                <span class="text-teal-500 font-bold text-xl">$2,974</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 5 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?w=500&h=300&fit=crop"
                alt="Island Hopping" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                35% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Island Hopping</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Explore multiple tropical islands in this 8-day adventure.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$2,499</span>
                <span class="text-teal-500 font-bold text-xl">$1,624</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 6 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?w=500&h=300&fit=crop"
                alt="Cultural Immersion" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                25% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Cultural Immersion</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Immerse yourself in local traditions with this cultural tour.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$1,899</span>
                <span class="text-teal-500 font-bold text-xl">$1,424</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 7 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&h=300&fit=crop"
                alt="Luxury Retreat" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                40% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Luxury Retreat</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Indulge in a luxury retreat with premium accommodations.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$4,999</span>
                <span class="text-teal-500 font-bold text-xl">$2,999</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Offer 8 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="h-48">
              <img src="https://images.unsplash.com/photo-1452626038306-9aae5e071dd3?w=500&h=300&fit=crop"
                alt="Family Fun" class="w-full h-full object-cover" />
            </div>
            <div class="p-5">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                30% OFF
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Family Fun Package</h3>
              <p class="text-gray-600 mb-4 text-sm">
                Create lasting memories with this family-friendly vacation.
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$3,299</span>
                <span class="text-teal-500 font-bold text-xl">$2,309</span>
              </div>
              <div class="flex gap-2">
                <button
                  class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex-1">
                  Đặt ngay
                </button>
                <button
                  class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-2 px-3 rounded-lg transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 px-4 bg-white">
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
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-teal-50">
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
            Thanh toán dễ dàng, thông tin cá nhân của bạn luôn được bảo vệ với hệ thống đặt tour an toàn và bảo mật của
            chúng tôi.
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
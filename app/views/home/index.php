<body class="bg-gray-50">
  <!-- Your header goes here -->

  <main class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="relative h-[500px] overflow-hidden">
      <div class="absolute inset-0">
        <video autoplay muted loop class="w-full h-full object-cover">
          <source
            src="https://storage.googleapis.com/teko-gae.appspot.com/media/video/2023/11/19/22451432-c310-4081-858c-cfb57570e249/6487d1c5c3473ff5e5376abd_camelia-transcode.webm">
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
      </div>
      <div class="relative h-full flex items-center justify-center px-4">
        <div class="text-center max-w-3xl">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
            Di Travel
          </h1>
          <p class="text-xl text-white mb-8">
            Tại DiTravel, chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch độc đáo, những dịch vụ chất lượng
            và những thông tin hữu ích để bạn có thể lên kế hoạch cho chuyến đi hoàn hảo.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button
              class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
              Explore Destinations
            </button>
            <button
              class="bg-white hover:bg-gray-100 text-teal-500 font-semibold py-3 px-8 rounded-lg transition duration-300">
              View Packages
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Search Section -->
    <section class="py-8 px-4">
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg -mt-16 relative z-10 p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Find Your Perfect Trip</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-gray-700 mb-2">Destination</label>
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
          <div>
            <label class="block text-gray-700 mb-2">Date</label>
            <input type="date"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" />
          </div>
          <div>
            <label class="block text-gray-700 mb-2">Travelers</label>
            <select
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option>1 Person</option>
              <option>2 People</option>
              <option>3 People</option>
              <option>4+ People</option>
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

    <!-- Featured Destinations -->
    <section class="py-16 px-4 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Featured Destinations</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Explore our handpicked selection of the most beautiful and exciting destinations around the world
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
            View All Destinations
          </button>
        </div>
      </div>
    </section>

    <!-- Special Offers -->
    <section class="py-16 px-4 bg-teal-50">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Special Offers</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Take advantage of our limited-time deals and save on your next adventure
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Offer 1 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col md:flex-row">
            <div class="md:w-2/5 h-64 md:h-auto">
              <img src="https://via.placeholder.com/300x300" alt="Summer Beach Getaway"
                class="w-full h-full object-cover" />
            </div>
            <div class="md:w-3/5 p-6">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                25% OFF
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Summer Beach Getaway</h3>
              <p class="text-gray-600 mb-4">
                Enjoy a relaxing beach vacation with our all-inclusive package. Limited time offer!
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$1,999</span>
                <span class="text-teal-500 font-bold text-xl">$1,499</span>
              </div>
              <button
                class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                Book Now
              </button>
            </div>
          </div>

          <!-- Offer 2 -->
          <div
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col md:flex-row">
            <div class="md:w-2/5 h-64 md:h-auto">
              <img src="https://via.placeholder.com/300x300" alt="European Adventure"
                class="w-full h-full object-cover" />
            </div>
            <div class="md:w-3/5 p-6">
              <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold inline-block mb-3">
                30% OFF
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">European Adventure</h3>
              <p class="text-gray-600 mb-4">
                Explore the best of Europe with our guided tour package. Book before it's gone!
              </p>
              <div class="flex items-center mb-4">
                <span class="text-gray-400 line-through mr-2">$2,899</span>
                <span class="text-teal-500 font-bold text-xl">$1,999</span>
              </div>
              <button
                class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                Book Now
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 px-4 bg-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">What Our Travelers Say</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Read about the experiences of travelers who have explored the world with us
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

    <!-- Newsletter -->
    <section class="py-16 px-4 bg-teal-500 text-white">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold mb-4">Get Travel Inspiration & Special Offers</h2>
          <p class="max-w-2xl mx-auto">
            Subscribe to our newsletter and be the first to know about new destinations, exclusive deals, and travel
            tips
          </p>
        </div>

        <div class="max-w-xl mx-auto">
          <form class="flex flex-col sm:flex-row gap-4">
            <input type="email" placeholder="Enter your email address"
              class="flex-grow py-3 px-4 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white" />
            <button
              class="bg-white text-teal-500 hover:bg-gray-100 font-semibold py-3 px-6 rounded-lg transition duration-300">
              Subscribe
            </button>
          </form>
          <p class="text-sm mt-4 text-center text-teal-100">
            By subscribing, you agree to our Privacy Policy and consent to receive travel-related emails.
          </p>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
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
            Thanh toán và thông tin cá nhân của bạn luôn được bảo vệ với hệ thống đặt tour an toàn của chúng tôi.
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
          <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Hướng Dẫn Viên Chuyên Nghiệp</h3>
          <p class="text-gray-600 text-center">
            Các hướng dẫn viên am hiểu của chúng tôi cung cấp góc nhìn nội địa và đảm bảo bạn trải nghiệm bản chất chân
            thực của mỗi điểm đến.
          </p>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <section class="py-16 px-4 bg-gray-900 text-white">
      <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your Adventure?</h2>
        <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
          Let us help you create memories that will last a lifetime. Your dream vacation is just a click away.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <button
            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
            Plan Your Trip
          </button>
          <button
            class="bg-transparent hover:bg-white hover:text-gray-900 text-white font-semibold py-3 px-8 rounded-lg border-2 border-white transition duration-300">
            Contact Us
          </button>
        </div>
      </div>
    </section>
  </main>

  <!-- Your footer goes here -->
</body>
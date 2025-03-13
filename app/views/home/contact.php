<?php
use App\Helpers\UrlHelper;

$title = 'Liên Hệ - Di Travel';
$activePage = 'contact';
?>

<div class="py-8 md:py-12">
  <!-- Hero Section -->
  <div class="relative mb-16">
    <div class="w-full h-[300px] md:h-[400px] bg-cover bg-center"
      style="background-image: url('<?= UrlHelper::image('contact-hero.jpg') ?>')">
      <div class="absolute inset-0 bg-black opacity-50"></div>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white px-4">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Liên Hệ Di Travel</h1>
          <p class="text-xl md:text-2xl max-w-3xl mx-auto">Chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Info & Form Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="flex flex-col lg:flex-row gap-12">
      <!-- Contact Information -->
      <div class="lg:w-1/3">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Thông Tin Liên Hệ</h2>

        <div class="space-y-6">
          <!-- Address -->
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-800">Địa Chỉ</h3>
              <p class="text-gray-600 mt-1">123 Đường Lê Lợi, Quận 1<br />TP. Hồ Chí Minh, Việt Nam</p>
            </div>
          </div>

          <!-- Phone -->
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-800">Điện Thoại</h3>
              <p class="text-gray-600 mt-1">+84 (28) 3822 9999</p>
              <p class="text-gray-600">Hotline: 1900 1234</p>
            </div>
          </div>

          <!-- Email -->
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-800">Email</h3>
              <p class="text-gray-600 mt-1">info@ditravel.com</p>
              <p class="text-gray-600">support@ditravel.com</p>
            </div>
          </div>

          <!-- Working Hours -->
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-800">Giờ Làm Việc</h3>
              <p class="text-gray-600 mt-1">Thứ Hai - Thứ Sáu: 8:00 - 17:30</p>
              <p class="text-gray-600">Thứ Bảy: 8:00 - 12:00</p>
              <p class="text-gray-600">Chủ Nhật: Đóng cửa</p>
            </div>
          </div>
        </div>

        <!-- Social Media -->
        <div class="mt-8">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Kết Nối Với Chúng Tôi</h3>
          <div class="flex space-x-4">
            <a href="#"
              class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center hover:bg-teal-700 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
              </svg>
            </a>
            <a href="#"
              class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center hover:bg-teal-700 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
              </svg>
            </a>
            <a href="#"
              class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center hover:bg-teal-700 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>
            <a href="#"
              class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center hover:bg-teal-700 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
              </svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="lg:w-2/3">
        <div class="bg-white p-8 rounded-lg shadow-md">
          <h2 class="text-3xl font-bold text-gray-800 mb-6">Gửi Tin Nhắn Cho Chúng Tôi</h2>
          <p class="text-gray-600 mb-8">Bạn có câu hỏi hoặc yêu cầu đặc biệt? Hãy điền vào mẫu dưới đây và chúng tôi sẽ
            liên hệ lại với bạn trong thời gian sớm nhất.</p>

          <form action="#" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                <input type="text" id="name" name="name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                  placeholder="Nhập họ và tên của bạn" required>
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                  placeholder="Nhập địa chỉ email của bạn" required>
              </div>
            </div>

            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
              <input type="tel" id="phone" name="phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                placeholder="Nhập số điện thoại của bạn">
            </div>

            <div>
              <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Chủ đề</label>
              <select id="subject" name="subject"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                required>
                <option value="">Chọn chủ đề</option>
                <option value="booking">Đặt tour</option>
                <option value="inquiry">Thông tin tour</option>
                <option value="feedback">Phản hồi</option>
                <option value="partnership">Hợp tác</option>
                <option value="other">Khác</option>
              </select>
            </div>

            <div>
              <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Tin nhắn</label>
              <textarea id="message" name="message" rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                placeholder="Nhập nội dung tin nhắn của bạn" required></textarea>
            </div>

            <div class="flex items-start">
              <input id="privacy" name="privacy" type="checkbox"
                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded mt-1" required>
              <label for="privacy" class="ml-2 block text-sm text-gray-600">
                Tôi đồng ý với <a href="#" class="text-teal-600 hover:underline">chính sách bảo mật</a> của Di Travel
              </label>
            </div>

            <div>
              <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                Gửi tin nhắn
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Map Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Vị Trí Của Chúng Tôi</h2>
    <div class="bg-gray-200 rounded-lg overflow-hidden shadow-md h-[400px] w-full">
      <div class="w-full h-full flex items-center justify-center bg-gray-100">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2992.948457658924!2d2.154056776440141!3d41.396925695402885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4a36ce2441329%3A0xfcc3e90be628bbb2!2sDitravel!5e0!3m2!1sen!2s!4v1741883875549!5m2!1sen!2s"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>

  <!-- FAQ Section -->
  <div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Câu Hỏi Thường Gặp</h2>

      <div class="max-w-3xl mx-auto space-y-6">
        <!-- FAQ Item 1 -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Làm thế nào để đặt tour du lịch?</h3>
          <p class="text-gray-600">
            Bạn có thể đặt tour du lịch trực tuyến thông qua trang web của chúng tôi, gọi điện thoại đến số hotline 1900
            1234, hoặc đến trực tiếp văn phòng của Di Travel. Chúng tôi sẽ hỗ trợ bạn trong suốt quá trình đặt tour.
          </p>
        </div>

        <!-- FAQ Item 2 -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Chính sách hủy tour như thế nào?</h3>
          <p class="text-gray-600">
            Chính sách hủy tour của chúng tôi phụ thuộc vào thời gian hủy và loại tour. Thông thường, nếu hủy trước 30
            ngày, bạn sẽ được hoàn lại 90% số tiền. Hủy trước 15-29 ngày, hoàn lại 70%. Hủy trước 7-14 ngày, hoàn lại
            50%. Hủy trong vòng 7 ngày, không hoàn tiền.
          </p>
        </div>

        <!-- FAQ Item 3 -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Tôi có thể thay đổi ngày khởi hành không?</h3>
          <p class="text-gray-600">
            Có, bạn có thể thay đổi ngày khởi hành tùy thuộc vào tình trạng chỗ trống. Vui lòng liên hệ với chúng tôi ít
            nhất 14 ngày trước ngày khởi hành ban đầu để chúng tôi có thể sắp xếp lại cho bạn mà không mất phí thay đổi.
          </p>
        </div>

        <!-- FAQ Item 4 -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Di Travel có cung cấp dịch vụ visa không?</h3>
          <p class="text-gray-600">
            Có, chúng tôi cung cấp dịch vụ hỗ trợ visa cho khách hàng đặt tour quốc tế. Đội ngũ chuyên viên visa của
            chúng tôi sẽ hướng dẫn bạn chuẩn bị hồ sơ và thủ tục cần thiết để tăng tỷ lệ thành công khi xin visa.
          </p>
        </div>

        <!-- FAQ Item 5 -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Tôi có thể yêu cầu tour thiết kế riêng không?</h3>
          <p class="text-gray-600">
            Tất nhiên! Di Travel chuyên cung cấp các tour du lịch cá nhân hóa theo yêu cầu của bạn. Hãy liên hệ với
            chúng tôi để chia sẻ ý tưởng và chúng tôi sẽ thiết kế một hành trình phù hợp với sở thích, ngân sách và thời
            gian của bạn.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-teal-600 rounded-lg shadow-xl overflow-hidden">
      <div class="px-6 py-12 md:p-12 text-center md:text-left md:flex md:items-center md:justify-between">
        <div class="mb-6 md:mb-0 md:w-2/3">
          <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Sẵn sàng cho chuyến phiêu lưu tiếp theo?</h2>
          <p class="text-teal-100 text-lg">Liên hệ với chúng tôi ngay hôm nay để bắt đầu lên kế hoạch cho kỳ nghỉ trong
            mơ của bạn!</p>
        </div>
        <div class="md:w-1/3 text-center md:text-right">
          <a href="#"
            class="inline-block px-6 py-3 border-2 border-white text-white font-medium text-base leading-tight rounded-md hover:bg-white hover:text-teal-600 transition-colors">
            Đặt Tour Ngay
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
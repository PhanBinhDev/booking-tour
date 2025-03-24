<?php

use App\Helpers\UrlHelper;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'PHP MVC Project' ?></title>
  <link href="<?= UrlHelper::css('style.css') ?>" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= UrlHelper::image('favicon/favicon-96x96.png') ?>" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= UrlHelper::image('favicon/favicon.svg') ?>" />
  <link rel="shortcut icon" href="<?= UrlHelper::image('favicon/favicon.ico') ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= UrlHelper::image('favicon/apple-touch-icon.png') ?>" />
  <link rel="manifest" href="<?= UrlHelper::image('favicon/site.webmanifest') ?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js">
  </script>
  <link rel="stylesheet"
    href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
  <link rel="stylesheet" href="<?= UrlHelper::css('mapbox.css') ?>">
</head>

<body class="bg-gray-50 min-h-screen font-sans flex flex-col">
  <header class="bg-white shadow sticky top-0 z-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <a href="<?= UrlHelper::route('') ?>" class="text-2xl font-bold text-teal-600 flex items-center">
            <img alt="logo" src="<?= UrlHelper::image('logo.png') ?>" class="h-[60px]" />
          </a>
        </div>

        <!-- Main Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
          <a href="<?= UrlHelper::route('') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Trang chủ
          </a>
          <a href="<?= UrlHelper::route('home/tours') ?>" <a href="<?= UrlHelper::route('home/tours') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Tours
          </a>
          <a href="<?= UrlHelper::route('home/news') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Tin tức
          </a>
          <a href="<?= UrlHelper::route('home/about') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Về chúng tôi
          </a>
          <a href="<?= UrlHelper::route('home/contact') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Liên hệ
          </a>
        </nav>

        <!-- Auth Buttons -->
        <div class="flex items-center space-x-4">
          <!-- User is not logged in -->
          <div class="hidden md:flex gap-x-2">
            <a href="<?= UrlHelper::route('auth/register') ?>"
              class="text-teal-600 hover:text-white hover:bg-teal-600 px-3 py-2 text-sm font-medium transition-colors rounded-lg">
              Đăng ký
            </a>
            <a href="<?= UrlHelper::route('auth/login') ?>"
              class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm hover:shadow">
              Đăng nhập
            </a>
          </div>
          <!-- Mobile menu button -->
          <button type="button"
            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500"
            aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation (hidden by default) -->
      <div class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <a href="<?= UrlHelper::route('') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Trang chủ
          </a>
          <a href="<?= UrlHelper::route('home/tours') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Tours
          </a>
          <a href="<?= UrlHelper::route('home/news') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Tin tức
          </a>
          <a href="<?= UrlHelper::route('home/about') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Về chúng tôi
          </a>
          <a href="<?= UrlHelper::route('home/contact') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Liên hệ
          </a>
        </div>
      </div>
    </div>
  </header>
  <main class="container mx-auto flex-grow flex flex-col">
    <!-- Flash messages -->
    <?php if (isset($_SESSION['flash_message'])): ?>
      <div
        class="mb-4 p-4 rounded <?= $_SESSION['flash_message']['type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
        <?= $_SESSION['flash_message']['message'] ?>
      </div>
      <?php unset($_SESSION['flash_message']['message'], $_SESSION['flash_message']['type']); ?>
    <?php endif; ?>

    <!-- Content will be inserted here -->
    <?php if (isset($content)) echo $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 pt-10 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
        <!-- Company Info -->
        <div class="lg:col-span-2">
          <div class="flex items-center mb-4">
            <img src="<?= UrlHelper::image('logo.png') ?>" alt="Ditravel Logo" class="h-10 w-auto mr-2">
          </div>
          <p class="text-gray-600 mb-4 max-w-md">
            Khám phá thế giới cùng Ditravel - Đối tác du lịch đáng tin cậy của bạn với hàng nghìn tour hấp dẫn và dịch
            vụ chất lượng cao.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-teal-500 transition-colors">
              <span class="sr-only">Facebook</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                  clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-teal-500 transition-colors">
              <span class="sr-only">Instagram</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                  clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-teal-500 transition-colors">
              <span class="sr-only">Twitter</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path
                  d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-teal-500 transition-colors">
              <span class="sr-only">YouTube</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                  clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
            Khám phá
          </h3>
          <ul class="space-y-3">
            <li>
              <a href="<?= UrlHelper::route('home/tours') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Tour du lịch
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/news') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Tin tức
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('hotels') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Khách sạn
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/activities') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Hoạt động
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('promotions') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Khuyến mãi
              </a>
            </li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
            Hỗ trợ
          </h3>
          <ul class="space-y-3">
            <li>
              <a href="<?= UrlHelper::route('home/about') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Về chúng tôi
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/faq') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Câu hỏi thường gặp
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/privacy-policy') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Chính sách bảo mật
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/terms') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Điều khoản sử dụng
              </a>
            </li>
            <li>
              <a href="<?= UrlHelper::route('home/contact') ?>"
                class="text-base text-gray-600 hover:text-teal-500 transition-colors">
                Liên hệ
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
            Liên hệ
          </h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="text-gray-600">123 Đường Du Lịch, Quận 1, TP. Hồ Chí Minh</span>
            </li>
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <span class="text-gray-600">1900 1234</span>
            </li>
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <span class="text-gray-600">info@ditravel.com</span>
            </li>
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="text-gray-600">8:00 - 22:00 (Tất cả các ngày)</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Newsletter -->
      <div class="border-t border-gray-200 pt-8 pb-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-2">
              Đăng ký nhận thông tin
            </h3>
            <p class="text-gray-600 text-sm">
              Nhận thông tin về ưu đãi và tour mới nhất từ Ditravel
            </p>
          </div>
          <div class="w-full md:w-auto">
            <form class="flex flex-col sm:flex-row gap-2">
              <input type="email" placeholder="Nhập email của bạn"
                class="px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 min-w-0 flex-1"
                required />
              <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md transition-colors">
                Đăng ký
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Payment Methods -->
      <div class="border-t border-gray-200 pt-6 pb-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-2">
              Phương thức thanh toán
            </h3>
          </div>
          <div class="flex flex-wrap gap-3 justify-center">
            <img src="<?= UrlHelper::image('payment/visa.png') ?>" alt="Visa" class="h-8" />
            <img src="<?= UrlHelper::image('payment/mastercard.png') ?>" alt="Mastercard" class="h-8" />
            <img src="<?= UrlHelper::image('payment/jcb.png') ?>" alt="JCB" class="h-8" />
            <img src="<?= UrlHelper::image('payment/momo.png') ?>" alt="MoMo" class="h-8" />
            <img src="<?= UrlHelper::image('payment/zalopay.png') ?>" alt="ZaloPay" class="h-8" />
            <img src="<?= UrlHelper::image('payment/paypal.png') ?>" alt="PayPal" class="h-8" />
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="border-t border-gray-200 pt-6">
        <p class="text-center text-gray-500 text-sm">
          &copy; <?= date('Y') ?> Ditravel. Tất cả các quyền được bảo lưu.
        </p>
        <p class="text-center text-gray-400 text-xs mt-2">
          Giấy phép kinh doanh số: 0123456789 do Sở Kế hoạch và Đầu tư TP.HCM cấp ngày 01/01/2023
        </p>
      </div>
    </div>
  </footer>
  <!-- Add JavaScript for mobile menu toggle -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileMenuButton = document.querySelector('button[aria-expanded]');
      const mobileMenu = document.querySelector('.md\\:hidden.hidden');

      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
          const expanded = this.getAttribute('aria-expanded') === 'true';
          this.setAttribute('aria-expanded', !expanded);
          mobileMenu.classList.toggle('hidden');
        });
      }
    });
  </script>
</body>

</html>
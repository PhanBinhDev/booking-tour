<?php
use App\Helpers\UrlHelper;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Di Travel' ?></title>
  <link href="<?= UrlHelper::css('style.css') ?>" rel="stylesheet">
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
          <a href="<?= UrlHelper::route('tours') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Tours
          </a>
          <a href="<?= UrlHelper::route('destinations') ?>"
            class="text-gray-600 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
            Điểm đến
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

        <!-- User Menu (Logged in) -->
        <div class="flex items-center space-x-4">
          <!-- Notifications -->
          <div class="relative">
            <button type="button" class="p-1 text-gray-600 hover:text-teal-600 focus:outline-none">
              <span class="sr-only">View notifications</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <?php if (isset($_SESSION['notification_count']) && $_SESSION['notification_count'] > 0): ?>
              <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
              <?php endif; ?>
            </button>
          </div>

          <!-- User Dropdown -->
          <div class="relative ml-3" x-data="{ open: false }">
            <div>
              <button type="button" @click="open = !open"
                class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <?php if (isset($_SESSION['user_avatar']) && $_SESSION['user_avatar']): ?>
                <img class="h-8 w-8 rounded-full object-cover" src="<?= $_SESSION['user_avatar'] ?>"
                  alt="<?= $_SESSION['username'] ?>">
                <?php else: ?>
                <div class="h-8 w-8 rounded-full bg-teal-600 flex items-center justify-center text-white font-medium">
                  <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                </div>
                <?php endif; ?>
                <span class="ml-2 text-gray-700 hidden md:block"><?= $_SESSION['username'] ?? 'User' ?></span>
                <svg class="ml-1 h-5 w-5 text-gray-400 hidden md:block" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!-- Dropdown menu -->
            <div x-show="open" @click.away="open = false"
              class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
              role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <div class="px-4 py-2 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-900"><?= $_SESSION['full_name'] ?? $_SESSION['username'] ?></p>
                <p class="text-xs text-gray-500 truncate"><?= $_SESSION['email'] ?? '' ?></p>
              </div>
              <a href="<?= UrlHelper::route('user/profile') ?>"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Tài khoản của tôi</a>
              <a href="<?= UrlHelper::route('user/bookings') ?>"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đơn đặt tour</a>
              <a href="<?= UrlHelper::route('user/wishlist') ?>"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Danh sách yêu thích</a>
              <a href="<?= UrlHelper::route('user/reviews') ?>"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đánh giá của tôi</a>
              <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] <= 3): ?>
              <div class="border-t border-gray-100 my-1"></div>
              <a href="<?= UrlHelper::route('admin') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                role="menuitem">Quản trị hệ thống</a>
              <?php endif; ?>
              <div class="border-t border-gray-100 my-1"></div>
              <a href="<?= UrlHelper::route('auth/logout') ?>"
                class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">Đăng xuất</a>
            </div>
          </div>

          <!-- Mobile menu button -->
          <button type="button"
            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500"
            aria-expanded="false" id="mobile-menu-button">
            <span class="sr-only">Open main menu</span>
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation (hidden by default) -->
      <div class="hidden md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <a href="<?= UrlHelper::route('') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Trang chủ
          </a>
          <a href="<?= UrlHelper::route('tours') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Tours
          </a>
          <a href="<?= UrlHelper::route('destinations') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Điểm đến
          </a>
          <a href="<?= UrlHelper::route('home/about') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Về chúng tôi
          </a>
          <a href="<?= UrlHelper::route('home/contact') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Liên hệ
          </a>
          <div class="border-t border-gray-200 my-2"></div>
          <a href="<?= UrlHelper::route('user/profile') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Tài khoản của tôi
          </a>
          <a href="<?= UrlHelper::route('user/bookings') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Đơn đặt tour
          </a>
          <a href="<?= UrlHelper::route('user/wishlist') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Danh sách yêu thích
          </a>
          <a href="<?= UrlHelper::route('user/reviews') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Đánh giá của tôi
          </a>
          <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] <= 3): ?>
          <div class="border-t border-gray-200 my-2"></div>
          <a href="<?= UrlHelper::route('admin') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Quản trị hệ thống
          </a>
          <?php endif; ?>
          <div class="border-t border-gray-200 my-2"></div>
          <a href="<?= UrlHelper::route('auth/logout') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
            Đăng xuất
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="container mx-auto flex-grow flex flex-col">
    <!-- Flash messages -->
    <?php if(isset($_SESSION['flash'])): ?>
    <div
      class="mb-4 p-4 rounded <?= $_SESSION['flash']['type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
      <?= $_SESSION['flash']['message'] ?>
    </div>
    <?php unset($_SESSION['flash']['message'], $_SESSION['flash']['type']); ?>
    <?php endif; ?>

    <!-- Content will be inserted here -->
    <?php if (isset($content)) echo $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <p class="text-center text-gray-500 text-sm">
        &copy; <?= date('Y') ?> Di Travel. All rights reserved.
      </p>
    </div>
  </footer>

  <!-- Alpine.js for dropdown functionality -->
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

  <!-- JavaScript for mobile menu toggle -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

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
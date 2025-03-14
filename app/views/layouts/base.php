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
          <a href="<?= UrlHelper::route('tours') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Tours
          </a>
          <a href="<?= UrlHelper::route('destinations') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Điểm đến
          </a>
          <a href="<?= UrlHelper::route('about') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Về chúng tôi
          </a>
          <a href="<?= UrlHelper::route('contact') ?>"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
            Liên hệ
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
        &copy; <?= date('Y') ?> Booking Tour. All rights reserved.
      </p>
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
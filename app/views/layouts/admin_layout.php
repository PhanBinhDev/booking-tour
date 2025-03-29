<?php


use App\Helpers\UrlHelper;
// Prepare sidebar content for admins
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Admin Dashboard - Di Travel' ?></title>
  <link href="<?= UrlHelper::css('style.css') ?>" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= UrlHelper::image('favicon/favicon-96x96.png') ?>" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?= UrlHelper::image('favicon/favicon.svg') ?>" />
  <link rel="shortcut icon" href="<?= UrlHelper::image('favicon/favicon.ico') ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= UrlHelper::image('favicon/apple-touch-icon.png') ?>" />
  <link rel="manifest" href="<?= UrlHelper::image('favicon/site.webmanifest') ?>" />
  <!-- Add Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.10.0/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js">
  </script>
  <link rel="stylesheet"
    href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
  <link rel="stylesheet" href="<?= UrlHelper::css('mapbox.css') ?>">
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.26.5"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.7.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@2.9.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.8.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@1.5.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.5.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@2.8.1/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.3.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@2.5.3/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@2.8.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@1.3.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@1.4.0/dist/bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@1.3.0/dist/bundle.min.js"></script>

</head>

<body class="bg-gray-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div id="sidebar"
      class="bg-gray-800 text-white w-64 min-h-screen flex flex-col transition-all duration-300 ease-in-out">
      <!-- Logo -->
      <div class="p-4 border-b border-gray-700">
        <a href="<?= UrlHelper::route('admin/dashboard') ?>" class="flex items-center">
          <span class="text-xl font-bold text-teal-500">Di Travel</span>
          <span class="ml-2 text-sm text-gray-300">Quản Trị Viên</span>
        </a>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">
          <!-- Dashboard -->
          <li>
            <a href="<?= UrlHelper::route('admin/dashboard') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'dashboard' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <!-- Bookings Management -->
          <li>
            <a href="<?= UrlHelper::route('admin/bookings') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'bookings' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-calendar-check w-5 h-5 mr-3"></i>

              <span>Quản lý Bookings</span>
            </a>
          </li>

          <!-- Tours Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['tours', 'tour-categories', 'tour-create']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-route w-5 h-5 mr-3"></i>
                <span>Quản lý Tour</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('admin/tours') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'tours' ? 'text-white' : '' ?>">
                  Tất cả Tour
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/tours/createTour') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'createTour' ? 'text-white' : '' ?>">
                  Thêm Tour mới
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/tours/categories') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'categories' ? 'text-white' : '' ?>">
                  Danh mục Tour
                </a>
              </li>

              <li>
                <a href="<?= UrlHelper::route('admin/tours/createCategory') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'createCategory' ? 'text-white' : '' ?>">
                  Thêm Danh mục mới
                </a>
              </li>


            </ul>
          </li>

          <!-- User Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['users', 'user-create', 'roles']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-users w-5 h-5 mr-3"></i>
                <span>Quản lý Người dùng</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('admin/users/index') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'users' ? 'text-white' : '' ?>">
                  Tất cả Người dùng
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/users/create') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'user-create' ? 'text-white' : '' ?>">
                  Thêm Người dùng
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/roles') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'roles' ? 'text-white' : '' ?>">
                  Vai trò & Quyền hạn
                </a>
              </li>
            </ul>
          </li>

          <!-- Contact Management -->
          <li>
            <a href="<?= UrlHelper::route('admin/contacts') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'contacts' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-envelope w-5 h-5 mr-3"></i>
              <span>Quản lý Liên hệ</span>
            </a>
          </li>

          <!-- Media Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['images', 'banners']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-images w-5 h-5 mr-3"></i>
                <span>Quản lý Media</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('admin/images') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'images' ? 'text-white' : '' ?>">
                  Thư viện Hình ảnh
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/banners') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'banners' ? 'text-white' : '' ?>">
                  Quản lý Banner
                </a>
              </li>
            </ul>
          </li>

          <!-- News Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['news', 'news-create', 'news-categories']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                <span>Quản lý Tin tức</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('admin/news/index') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news' ? 'text-white' : '' ?>">
                  Tất cả Bài viết
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/news/createNews') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news-create' ? 'text-white' : '' ?>">
                  Thêm Bài viết
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/news/categories') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news-categories' ? 'text-white' : '' ?>">
                  Danh mục Tin tức
                </a>
                <a href="<?= UrlHelper::route('admin/news/createCategory') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news-categories' ? 'text-white' : '' ?>">
                  Thêm danh mục
                </a>
              </li>
            </ul>
          </li>

          <!-- Payment Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['news', 'news-create', 'news-categories']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <!-- <i class="fas fa-newspaper w-5 h-5 mr-3"></i> -->
                <i class="fas fa-coins w-5 h-5 mr-3"></i>
                <span>Quản lý Thanh toán</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <!-- Thanh Toán -->
              <li>
                <a href="<?= UrlHelper::route('admin/payment/methods') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news' ? 'text-white' : '' ?>">
                  Phương thức thanh toán
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/payment/transactions') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'transactions' ? 'text-white' : '' ?>">
                  Lịch sử giao dịch
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/payment/invoices') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'invoices' ? 'text-white' : '' ?>">
                  Hóa đơn & Biên lai
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/payment/refunds') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'refunds' ? 'text-white' : '' ?>">
                  Hoàn tiền & Hủy tour
                </a>
              </li>
            </ul>
          </li>

          <!-- Location Management -->
          <li>
            <a href="<?= UrlHelper::route('admin/locations') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'comments' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-map-marker-alt w-5 h-5 mr-3"></i>
              <span>Quản lý Địa điểm</span>
            </a>
          </li>

          <!-- Comments Management -->
          <li>
            <a href="<?= UrlHelper::route('admin/comments') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'comments' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-comments w-5 h-5 mr-3"></i>
              <span>Quản lý Bình luận</span>
            </a>
          </li>

          <!-- System Settings -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['settings', 'logs', 'backup']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                <span>Cài đặt Hệ thống</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('admin/system/activity-logs') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'logs' ? 'text-white' : '' ?>">
                  Nhật ký Hệ thống
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/backup') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'backup' ? 'text-white' : '' ?>">
                  Sao lưu & Phục hồi
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>

      <!-- User Profile Section -->
      <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
          <div class="h-8 w-8 rounded-full bg-teal-600 flex items-center justify-center text-white">
            <?= substr($_SESSION['username'] ?? 'A', 0, 1) ?>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-white"><?= $_SESSION['username'] ?? 'Admin' ?></p>
            <div class="flex space-x-3 mt-1 text-xs text-gray-300">
              <a href="<?= UrlHelper::route('admin/profile') ?>" class="hover:text-white">Hồ sơ</a>
              <a href="<?= UrlHelper::route('auth/logout') ?>" class="hover:text-white">Đăng xuất</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <?php
      // Check if flash message exists AND has the required keys
      if (
        isset($_SESSION['flash_message']) &&
        isset($_SESSION['flash_message']['message']) &&
        isset($_SESSION['flash_message']['type'])
      ):
        $type = $_SESSION['flash_message']['type'];
        $message = $_SESSION['flash_message']['message'];
        $bgColor = ($type === 'error') ? 'bg-red-100' : 'bg-green-100';
        $borderColor = ($type === 'error') ? 'border-red-400' : 'border-green-400';
        $textColor = ($type === 'error') ? 'text-red-700' : 'text-green-700';
        $iconColor = ($type === 'error') ? 'text-red-500' : 'text-green-500';
        $icon = ($type === 'error') ? 'fa-circle-exclamation' : 'fa-circle-check';
      ?>
      <div id="flash-message"
        class="fixed z-[100] top-4 right-4 w-80 rounded-lg border <?= $borderColor ?> <?= $bgColor ?> p-4 shadow-lg animate-fade-in flex items-start">
        <div class="flex-shrink-0 mr-3">
          <i class="fas <?= $icon ?> <?= $iconColor ?>"></i>
        </div>
        <div class="flex-grow <?= $textColor ?>">
          <?= $message ?>
        </div>
        <button type="button" onclick="closeFlashMessage()"
          class="ml-2 -mt-1 flex-shrink-0 <?= $textColor ?> hover:<?= $textColor ?> focus:outline-none">
          <i class="fas fa-times"></i>
        </button>

        <!-- Progress bar -->
        <div class="absolute bottom-0 left-0 h-1 bg-gray-300 w-full rounded-b-lg">
          <div id="flash-progress" class="h-1 <?= ($type === 'error') ? 'bg-red-500' : 'bg-green-500' ?> rounded-b-lg">
          </div>
        </div>
      </div>

      <script>
      document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash-message');
        const progressBar = document.getElementById('flash-progress');

        if (flashMessage) {
          // Animate progress bar
          let width = 100;
          const duration = 5000; // 5 seconds before auto-dismiss
          const interval = 50; // Update every 50ms
          const step = 100 / (duration / interval);

          const timer = setInterval(() => {
            width -= step;
            progressBar.style.width = width + '%';

            if (width <= 0) {
              clearInterval(timer);
              closeFlashMessage();
            }
          }, interval);

          // Allow hovering to pause the timer
          flashMessage.addEventListener('mouseenter', () => {
            clearInterval(timer);
          });

          flashMessage.addEventListener('mouseleave', () => {
            // Restart timer with remaining time
            const remainingPercentage = parseFloat(progressBar.style.width) || 100;
            const remainingTime = (remainingPercentage / 100) * duration;

            width = remainingPercentage;
            const newTimer = setInterval(() => {
              width -= step;
              progressBar.style.width = width + '%';

              if (width <= 0) {
                clearInterval(newTimer);
                closeFlashMessage();
              }
            }, interval);
          });
        }
      });

      function closeFlashMessage() {
        const flashMessage = document.getElementById('flash-message');

        if (flashMessage) {
          // Add slide-out animation
          flashMessage.classList.add('animate-slide-out-right');

          // Remove element after animation completes
          setTimeout(() => {
            flashMessage.remove();
          }, 500); // 500ms matches animation duration
        }
      }
      </script>
      <?php
        // Unset the entire flash message array
        unset($_SESSION['flash_message']);
      endif;
      ?>
      <!-- Top Header -->
      <header class="bg-white shadow-sm z-10">
        <div class="flex items-center justify-between h-16 px-6">
          <!-- Toggle Sidebar Button -->
          <button id="sidebar-toggle" class="text-gray-500 focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>

          <!-- Right Side Header Items -->
          <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative">
              <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bell"></i>
                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
              </button>
            </div>

            <!-- Visit Website -->
            <!-- <a href="<?= UrlHelper::route('') ?>" class="text-sm text-gray-500 hover:text-gray-700" target="_blank">
              <i class="fas fa-external-link-alt mr-1"></i> Xem Website
            </a> -->
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
        <!-- Page Title -->
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-gray-800"><?= $pageTitle ?? 'Dashboard' ?></h1>
          <?php if (isset($breadcrumbs)): ?>
          <nav class="text-sm text-gray-500 mt-1">
            <?= $breadcrumbs ?>
          </nav>
          <?php endif; ?>
        </div>

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <?= $content ?? '' ?>
        </div>
      </main>
    </div>
  </div>

  <!-- JavaScript for sidebar functionality -->
  <script>
  // Toggle sidebar
  const sidebarToggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');

  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('-ml-64');
  });

  // Dropdown functionality
  const dropdownButtons = document.querySelectorAll('.sidebar-dropdown-btn');

  dropdownButtons.forEach(button => {
    button.addEventListener('click', function() {
      const dropdownContent = this.nextElementSibling;
      const icon = this.querySelector('.fas.fa-chevron-down');

      // Toggle dropdown visibility
      dropdownContent.classList.toggle('hidden');

      // Rotate icon when dropdown is open
      if (dropdownContent.classList.contains('hidden')) {
        icon.style.transform = 'rotate(0deg)';
      } else {
        icon.style.transform = 'rotate(180deg)';
      }

      // Close other dropdowns
      dropdownButtons.forEach(otherButton => {
        if (otherButton !== button) {
          const otherDropdown = otherButton.nextElementSibling;
          const otherIcon = otherButton.querySelector('.fas.fa-chevron-down');

          if (!otherDropdown.classList.contains('hidden')) {
            otherDropdown.classList.add('hidden');
            otherIcon.style.transform = 'rotate(0deg)';
          }
        }
      });
    });
  });

  // Auto-expand active dropdown
  document.addEventListener('DOMContentLoaded', function() {
    const activeLinks = document.querySelectorAll('.sidebar-dropdown-content a.text-white');

    activeLinks.forEach(link => {
      const dropdownContent = link.closest('.sidebar-dropdown-content');
      const button = dropdownContent.previousElementSibling;
      const icon = button.querySelector('.fas.fa-chevron-down');

      dropdownContent.classList.remove('hidden');
      icon.style.transform = 'rotate(180deg)';
    });
  });
  </script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>

</html>

<?php
$layoutContent = ob_get_clean();
echo $layoutContent;
?>
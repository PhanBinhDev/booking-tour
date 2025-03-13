<?php
use App\Helpers\UrlHelper;

// Prepare sidebar content for moderators
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Moderator Dashboard - Di Travel' ?></title>
  <link rel="stylesheet" href="<?= UrlHelper::css('style.css') ?>">
  <!-- Add Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div id="sidebar"
      class="bg-gray-800 text-white w-64 min-h-screen flex flex-col transition-all duration-300 ease-in-out">
      <!-- Logo -->
      <div class="p-4 border-b border-gray-700">
        <a href="<?= UrlHelper::route('dashboard') ?>" class="flex items-center">
          <span class="text-xl font-bold text-purple-500">Di Travel</span>
          <span class="ml-2 text-sm text-gray-300">
            Quản lý
          </span>
        </a>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">
          <!-- Dashboard -->
          <li>
            <a href="<?= UrlHelper::route('dashboard') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'dashboard' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <!-- Profile -->
          <li>
            <a href="<?= UrlHelper::route('profile') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'profile' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-user w-5 h-5 mr-3"></i>
              <span>Hồ sơ cá nhân</span>
            </a>
          </li>

          <!-- Content Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['content-manage', 'content-review', 'content-create']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                <span>Quản lý Nội dung</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('content/manage') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'content-manage' ? 'text-white' : '' ?>">
                  Tất cả Nội dung
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('content/create') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'content-create' ? 'text-white' : '' ?>">
                  Thêm Nội dung mới
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('content/review') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'content-review' ? 'text-white' : '' ?>">
                  Duyệt Nội dung
                </a>
              </li>
            </ul>
          </li>

          <!-- User Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['users-manage', 'users-reports']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-users w-5 h-5 mr-3"></i>
                <span>Quản lý Người dùng</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('users/manage') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'users-manage' ? 'text-white' : '' ?>">
                  Danh sách Người dùng
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('users/reports') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'users-reports' ? 'text-white' : '' ?>">
                  Báo cáo Người dùng
                </a>
              </li>
            </ul>
          </li>

          <!-- Comments Management -->
          <li>
            <button type="button"
              class="sidebar-dropdown-btn flex items-center justify-between w-full px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= in_array($activePage, ['comments-review', 'comments-reported']) ? 'bg-gray-700 text-white' : '' ?>">
              <div class="flex items-center">
                <i class="fas fa-comments w-5 h-5 mr-3"></i>
                <span>Quản lý Bình luận</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul class="sidebar-dropdown-content hidden pl-10 py-1 bg-gray-900">
              <li>
                <a href="<?= UrlHelper::route('comments/review') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'comments-review' ? 'text-white' : '' ?>">
                  Duyệt Bình luận
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('comments/reported') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'comments-reported' ? 'text-white' : '' ?>">
                  Bình luận bị báo cáo
                </a>
              </li>
            </ul>
          </li>

          <!-- Tour Reviews -->
          <li>
            <a href="<?= UrlHelper::route('tours/reviews') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'tour-reviews' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-star w-5 h-5 mr-3"></i>
              <span>Đánh giá Tour</span>
            </a>
          </li>

          <!-- Reports -->
          <li>
            <a href="<?= UrlHelper::route('reports') ?>"
              class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?= $activePage === 'reports' ? 'bg-gray-700 text-white' : '' ?>">
              <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
              <span>Báo cáo</span>
            </a>
          </li>
        </ul>
      </nav>

      <!-- User Profile Section -->
      <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
          <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center text-white">
            <?= substr($_SESSION['username'] ?? 'M', 0, 1) ?>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-white"><?= $_SESSION['username'] ?? 'Moderator' ?></p>
            <div class="flex space-x-3 mt-1 text-xs text-gray-300">
              <a href="<?= UrlHelper::route('profile') ?>" class="hover:text-white">Hồ sơ</a>
              <a href="<?= UrlHelper::route('settings') ?>" class="hover:text-white">Cài đặt</a>
              <a href="<?= UrlHelper::route('auth/logout') ?>" class="hover:text-white">Đăng xuất</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
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
                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-purple-500"></span>
              </button>
            </div>

            <!-- Visit Website -->
            <!-- <a href="<?= UrlHelper::route('home') ?>" class="text-sm text-gray-500 hover:text-gray-700" target="_blank">
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
</body>

</html>

<?php
$layoutContent = ob_get_clean();
echo $layoutContent;
?>
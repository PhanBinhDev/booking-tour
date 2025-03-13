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
                <a href="<?= UrlHelper::route('admin/tours/create') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'tour-create' ? 'text-white' : '' ?>">
                  Thêm Tour mới
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/tour-categories') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'tour-categories' ? 'text-white' : '' ?>">
                  Danh mục Tour
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
                <a href="<?= UrlHelper::route('admin/users') ?>"
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
                <a href="<?= UrlHelper::route('admin/news') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news' ? 'text-white' : '' ?>">
                  Tất cả Bài viết
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/news/create') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news-create' ? 'text-white' : '' ?>">
                  Thêm Bài viết
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/news/categories') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'news-categories' ? 'text-white' : '' ?>">
                  Danh mục Tin tức
                </a>
              </li>
            </ul>
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
                <a href="<?= UrlHelper::route('admin/settings') ?>"
                  class="block py-2 px-4 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded <?= $activePage === 'settings' ? 'text-white' : '' ?>">
                  Cài đặt Chung
                </a>
              </li>
              <li>
                <a href="<?= UrlHelper::route('admin/logs') ?>"
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
</body>

</html>

<?php
$layoutContent = ob_get_clean();
echo $layoutContent;
?>
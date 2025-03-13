<?php
use App\Helpers;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'PHP MVC Project' ?></title>
  <link href="<?= Helpers\UrlHelper::css('style.css') ?>" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <a href="/" class="text-xl font-bold text-indigo-600">PHP MVC</a>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="/"
              class="<?= !isset($activePage) || $activePage === 'home' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
              Home
            </a>

            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/dashboard"
              class="<?= isset($activePage) && $activePage === 'dashboard' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
              Dashboard
            </a>
            <a href="/images"
              class="<?= isset($activePage) && $activePage === 'images' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
              Images
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <?php if(isset($_SESSION['user_id'])): ?>
          <div class="ml-3 relative">
            <div class="flex items-center">
              <span class="hidden md:block text-sm font-medium text-gray-700 mr-2">
                Hello, <?= htmlspecialchars($_SESSION['username']) ?>
              </span>
              <div class="flex">
                <a href="/profile"
                  class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Profile</a>
                <a href="/logout"
                  class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
              </div>
            </div>
          </div>
          <?php else: ?>
          <div class="flex items-center">
            <a href="/login"
              class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
            <a href="/register"
              class="ml-2 bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Register</a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php
        // Display flash messages if they exist
        if(isset($_SESSION['flash_message'])): ?>
    <div
      class="mb-4 p-4 rounded-md <?= $_SESSION['flash_type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
      <?= $_SESSION['flash_message'] ?>
    </div>
    <?php
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        endif;
        ?>

    <?= $content ?? '' ?>
  </div>

  <footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <p class="text-center text-gray-500 text-sm">
        &copy; <?= date('Y') ?> PHP MVC Project. All rights reserved.
      </p>
    </div>
  </footer>
</body>

</html>
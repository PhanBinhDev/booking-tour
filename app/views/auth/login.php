<?php

use App\Helpers\UrlHelper;

$title = 'Login';
$activePage = 'login';
?>

<div class="flex flex-1 items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <!-- Left side - Form -->
  <div class="w-full md:w-1/2 flex items-center justify-center p-4 md:p-8 bg-gray-50">
    <div class="w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-teal-600">Booking Tour</h1>
        <p class="text-gray-500 mt-2">Sign in to access your account</p>
      </div>

      <!-- Form Card -->
      <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
        <?php if (isset($errors['login'])): ?>
          <div class="mb-6 p-4 rounded-md bg-red-50 text-red-600 text-sm border-l-4 border-red-500">
            <?= $errors['login'] ?>
          </div>
        <?php endif; ?>

        <form action="<?= UrlHelper::route('auth/login') ?>" method="POST" class="space-y-6">
          <div>
            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
              </div>
              <input type="email" name="email" id="email"
                class="bg-blue-50 border-0 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 block w-full pl-10 p-3 transition-all"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between mb-2">
              <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
              <a href="<?= UrlHelper::route('auth/forgot-password') ?>"
                class="text-xs text-teal-500 hover:text-teal-600 transition-colors">
                Forgot password?
              </a>
            </div>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <input type="password" name="password" id="password"
                class="bg-blue-50 border-0 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-teal-500 block w-full pl-10 p-3 transition-all"
                required>
            </div>
          </div>

          <!-- <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember"
              class="w-4 h-4 text-teal-500 bg-blue-50 border-0 rounded focus:ring-teal-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
          </div> -->

          <button type="submit"
            class="w-full bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:ring-teal-300 text-white font-medium rounded-md text-sm px-5 py-3 text-center transition-all shadow-md hover:shadow-lg">
            Sign In
          </button>

          <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
              Don't have an account? <a href="<?= UrlHelper::route('auth/register') ?>"
                class="text-teal-500 hover:underline font-medium">Create an account</a>
            </p>
          </div>
        </form>
      </div>

      <!-- Footer -->
      <div class="mt-8 text-center">
        <div class="flex justify-center space-x-6">
          <a href="#" class="text-gray-500 hover:text-teal-500">
            <span class="sr-only">Help</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-teal-500">
            <span class="sr-only">Privacy</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-teal-500">
            <span class="sr-only">Terms</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                clip-rule="evenodd" />
            </svg>
          </a>
        </div>
        <p class="mt-4 text-xs text-gray-500">© 2025 Booking Tour. All rights reserved.</p>
      </div>
    </div>
  </div>
  <!-- <div class="hidden md:block md:w-1/2 bg-teal-600 p-8 flex-1"></div> -->
</div>
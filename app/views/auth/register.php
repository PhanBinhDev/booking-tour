<?php

use App\Helpers\UrlHelper;

$title = 'Đăng Ký - Di Travel';
$activePage = 'register';
?>

<div class="min-h-screen flex bg-teal-50">
  <div class="w-full mx-auto flex flex-col md:flex-row">
    <!-- Left side - Form -->
    <div class="flex-1 flex items-center justify-center p-6 md:p-8 lg:p-12">
      <div class="w-full max-w-md space-y-8">

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 relative overflow-hidden">
          <!-- Decorative elements -->
          <div class="absolute -top-10 -right-10 w-40 h-40 bg-teal-50 rounded-full"></div>
          <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-cyan-50 rounded-full"></div>

          <div class="relative z-10">
            <?php if (isset($errors['register'])): ?>
              <div class="mb-6 p-4 rounded-md bg-red-50 text-red-600 text-sm border-l-4 border-red-500">
                <?= $errors['register'] ?>
              </div>
            <?php endif; ?>

            <form action="<?= UrlHelper::route('auth/register') ?>" method="POST" class="space-y-6">
              <!-- Name Fields - 2 columns -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Username -->
                <div>
                  <label for="username" class="block text-gray-700 font-medium mb-2">Tên đăng nhập</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                    <input type="text" name="username" id="username"
                      class="bg-gray-50 border <?= isset($errors['username']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                      value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                  </div>
                  <?php if (isset($errors['username'])): ?>
                    <p class="mt-1 text-xs text-red-600"><?= $errors['username'] ?></p>
                  <?php endif; ?>
                </div>

                <!-- Full Name -->
                <div>
                  <label for="full_name" class="block text-gray-700 font-medium mb-2">Họ và tên</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                          d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                      </svg>
                    </div>
                    <input type="text" name="full_name" id="full_name"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                      value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>">
                  </div>
                </div>
              </div>

              <!-- Contact Fields -->
              <div class="space-y-4">
                <!-- Email Address -->
                <div>
                  <label for="email" class="block text-gray-700 font-medium mb-2">Địa chỉ email</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                      </svg>
                    </div>
                    <input type="email" name="email" id="email"
                      class="bg-gray-50 border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                      value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                  </div>
                  <?php if (isset($errors['email'])): ?>
                    <p class="mt-1 text-xs text-red-600"><?= $errors['email'] ?></p>
                  <?php endif; ?>
                </div>

                <!-- Phone Number -->
                <div>
                  <label for="phone" class="block text-gray-700 font-medium mb-2">Số điện thoại</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                          d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                      </svg>
                    </div>
                    <input type="tel" name="phone" id="phone"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                      value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                  </div>
                </div>
              </div>

              <!-- Password Section -->
              <div class="pt-2">
                <div class="flex items-center mb-4">
                  <div class="h-0.5 bg-gray-200 flex-grow"></div>
                  <h3 class="mx-3 text-sm uppercase text-gray-500 font-semibold tracking-wider">Bảo mật tài khoản</h3>
                  <div class="h-0.5 bg-gray-200 flex-grow"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Password -->
                  <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mật khẩu</label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <input type="password" name="password" id="password"
                        class="bg-gray-50 border <?= isset($errors['password']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                        required>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                      <p class="mt-1 text-xs text-red-600"><?= $errors['password'] ?></p>
                    <?php else: ?>
                      <p class="mt-1 text-xs text-gray-500">Ít nhất 6 ký tự</p>
                    <?php endif; ?>
                  </div>

                  <!-- Confirm Password -->
                  <div>
                    <label for="password_confirm" class="block text-gray-700 font-medium mb-2">Xác nhận mật khẩu</label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <input type="password" name="password_confirm" id="password_confirm"
                        class="bg-gray-50 border <?= isset($errors['password_confirm']) ? 'border-red-500' : 'border-gray-300' ?> text-gray-900 text-base rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-3 transition-all"
                        required>
                    </div>
                    <?php if (isset($errors['password_confirm'])): ?>
                      <p class="mt-1 text-xs text-red-600"><?= $errors['password_confirm'] ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Terms and Conditions -->
              <div class="flex items-start pt-4">
                <div class="flex items-center h-5">
                  <input id="agree_terms" name="agree_terms" type="checkbox"
                    class="w-5 h-5 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2 <?= isset($errors['agree_terms']) ? 'border-red-500' : '' ?>">
                </div>
                <div class="ml-3 text-sm">
                  <label for="agree_terms" class="text-gray-600">Tôi đồng ý với <a href="#"
                      class="text-teal-600 hover:underline font-medium">Điều khoản sử dụng</a> và <a href="#"
                      class="text-teal-600 hover:underline font-medium">Chính sách bảo mật</a></label>
                  <?php if (isset($errors['agree_terms'])): ?>
                    <p class="mt-1 text-xs text-red-600"><?= $errors['agree_terms'] ?></p>
                  <?php endif; ?>
                </div>
              </div>

              <button type="submit"
                class="w-full flex justify-center items-center bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 text-white font-medium rounded-lg text-base px-5 py-4 text-center transition-all shadow-md hover:shadow-lg">
                <span>Tạo tài khoản</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>

              <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                  Đã có tài khoản? <a href="<?= UrlHelper::route('auth/login') ?>"
                    class="text-teal-600 hover:underline font-medium">Đăng nhập</a>
                </p>
              </div>
            </form>
          </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
          <div class="flex justify-center space-x-6 mb-4">
            <a href="#" class="text-gray-500 hover:text-teal-600 transition-colors">
              <span class="sr-only">Trợ giúp</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                  clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-teal-600 transition-colors">
              <span class="sr-only">Bảo mật</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                  clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-teal-600 transition-colors">
              <span class="sr-only">Điều khoản</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                  clip-rule="evenodd" />
              </svg>
            </a>
          </div>
          <p class="text-xs text-gray-500">© 2025 Di Travel. Đã đăng ký bản quyền.</p>
        </div>
      </div>
    </div>

    <!-- Right side - Info Cards instead of image -->
    <div class="hidden md:flex md:w-1/2 flex-col justify-center p-12 bg-teal-600 rounded-l-3xl">
      <div class="text-white mb-12 text-center">
        <h2 class="text-4xl font-bold mb-6">Tham gia cùng chúng tôi</h2>
        <p class="text-xl max-w-md mx-auto">Khám phá những điểm đến tuyệt vời và tạo nên kỷ niệm đáng nhớ với Di Travel
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Feature cards -->
        <div
          class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 hover:bg-white/20 transition-all">
          <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Điểm đến toàn cầu</h3>
          <p class="text-white/80">Khám phá hơn 500 tour du lịch tại hơn 100 quốc gia trên thế giới</p>
        </div>

        <div
          class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 hover:bg-white/20 transition-all">
          <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Đảm bảo giá tốt nhất</h3>
          <p class="text-white/80">Chúng tôi luôn so sánh giá với đối thủ để mang đến cho bạn mức giá tốt nhất</p>
        </div>

        <div
          class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 hover:bg-white/20 transition-all">
          <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Đặt chỗ an toàn</h3>
          <p class="text-white/80">Dữ liệu cá nhân của bạn được bảo vệ với các tiêu chuẩn bảo mật cao nhất</p>
        </div>

        <div
          class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 hover:bg-white/20 transition-all">
          <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Hỗ trợ 24/7</h3>
          <p class="text-white/80">Đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng trợ giúp bạn 24/7</p>
        </div>
      </div>

      <!-- Stats section -->
      <div class="mt-12 flex justify-between">
        <div class="text-center">
          <div class="text-4xl font-bold text-white">500+</div>
          <div class="text-white/80 text-sm">Tours</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-white">100+</div>
          <div class="text-white/80 text-sm">Điểm đến</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-white">10k+</div>
          <div class="text-white/80 text-sm">Khách hàng hài lòng</div>
        </div>
      </div>
    </div>
  </div>
</div>
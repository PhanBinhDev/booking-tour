<?php

use App\Helpers\UrlHelper;

// Calculate prices
$adultPrice =  $tour['sale_price'] ?? $tour['price'];
$childPrice = $adultPrice * 0.7;
$adultTotal = $adults * $adultPrice;
$childrenTotal = $children * $childPrice;
$subtotal = $adultTotal + $childrenTotal;
$taxFee = $subtotal * 0.1; // 10% tax
$total = $subtotal + $taxFee;
?>

<div class="bg-gray-50 py-12">
  <div class="container mx-auto px-4">
    <!-- Breadcrumbs -->
    <div class="mb-8 text-sm text-gray-500 flex items-center">
      <a href="<?= UrlHelper::route('') ?>" class="hover:text-teal-500 transition-colors">Trang chủ</a>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <a href="<?= UrlHelper::route('tours') ?>" class="hover:text-teal-500 transition-colors">Tours</a>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <a href="<?= UrlHelper::route('tours/tour-details/' . $tour['id']) ?>"
        class="hover:text-teal-500 transition-colors">
        <?= htmlspecialchars($tour['title']) ?>
      </a>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-700 font-medium">Xác nhận đặt tour</span>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Column - Form -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md p-8 mb-8 border border-gray-100">
          <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <div class="bg-teal-100 p-2 rounded-full mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            Thông tin người đặt
          </h2>

          <form action="<?= UrlHelper::route('home/bookings/process') ?>" method="post">
            <!-- Hidden fields for tour info -->
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
            <input type="hidden" name="tour_date_id" value="<?= $tourDate['id'] ?>">
            <input type="hidden" name="adults" value="<?= $adults ?>">
            <input type="hidden" name="children" value="<?= $children ?>">
            <input type="hidden" name="total_amount" value="<?= $total ?>">

            <!-- Contact Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Full Name -->
              <div>
                <label for="fullname" class="block text-gray-700 text-sm font-medium mb-2">Họ và tên <span
                    class="text-red-500">*</span></label>
                <input type="text" id="fullname" name="fullname"
                  value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required
                  class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500">
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email <span
                    class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                  required
                  class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500">
              </div>

              <!-- Phone -->
              <div>
                <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Số điện thoại <span
                    class="text-red-500">*</span></label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required
                  class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500">
              </div>

              <!-- Address -->
              <div>
                <label for="address" class="block text-gray-700 text-sm font-medium mb-2">Địa chỉ</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>"
                  class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500">
              </div>
            </div>

            <!-- Special Requests -->
            <div class="mt-6">
              <label for="special_requests" class="block text-gray-700 text-sm font-medium mb-2">Yêu cầu đặc
                biệt</label>
              <textarea id="special_requests" name="special_requests" rows="4"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500"
                placeholder="Vui lòng cho chúng tôi biết nếu bạn có yêu cầu đặc biệt (ăn kiêng, dị ứng, hỗ trợ đặc biệt, v.v.)"></textarea>
            </div>

            <!-- Passengers -->
            <div class="mt-8">
              <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin hành khách</h3>

              <!-- Adults -->
              <div class="mb-6">
                <h4 class="font-medium text-gray-700 mb-3">Người lớn (<?= $adults ?>)</h4>
                <?php for ($i = 1; $i <= $adults; $i++): ?>
                  <div class="p-4 border border-gray-200 rounded-lg mb-4">
                    <div class="flex items-center justify-between mb-4">
                      <h5 class="font-medium">Người lớn <?= $i ?></h5>
                      <span class="text-sm text-gray-500">Trên 12 tuổi</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label class="block text-gray-700 text-xs font-medium mb-1">Họ và tên <span
                            class="text-red-500">*</span></label>
                        <input type="text" name="adult_name[]" required
                          class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                      </div>
                      <div>
                        <label class="block text-gray-700 text-xs font-medium mb-1">CMND/CCCD</label>
                        <input type="text" name="adult_id[]"
                          class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                      </div>

                      <?php if ($tour['is_international'] ?? false): ?>
                        <div>
                          <label class="block text-gray-700 text-xs font-medium mb-1">Số hộ chiếu <span
                              class="text-red-500">*</span></label>
                          <input type="text" name="adult_passport[]" required
                            class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                        </div>
                        <div>
                          <label class="block text-gray-700 text-xs font-medium mb-1">Quốc tịch <span
                              class="text-red-500">*</span></label>
                          <input type="text" name="adult_nationality[]" required value="Việt Nam"
                            class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                        </div>
                      <?php endif; ?>

                      <div>
                        <label class="block text-gray-700 text-xs font-medium mb-1">Ngày sinh</label>
                        <input type="date" name="adult_dob[]"
                          class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                      </div>
                    </div>
                  </div>
                <?php endfor; ?>
              </div>

              <!-- Children if any -->
              <?php if ($children > 0): ?>
                <div>
                  <h4 class="font-medium text-gray-700 mb-3">Trẻ em (<?= $children ?>)</h4>
                  <?php for ($i = 1; $i <= $children; $i++): ?>
                    <div class="p-4 border border-gray-200 rounded-lg mb-4">
                      <div class="flex items-center justify-between mb-4">
                        <h5 class="font-medium">Trẻ em <?= $i ?></h5>
                        <span class="text-sm text-gray-500">5-12 tuổi</span>
                      </div>
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                          <label class="block text-gray-700 text-xs font-medium mb-1">Họ và tên <span
                              class="text-red-500">*</span></label>
                          <input type="text" name="child_name[]" required
                            class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                        </div>
                        <div>
                          <label class="block text-gray-700 text-xs font-medium mb-1">Ngày sinh <span
                              class="text-red-500">*</span></label>
                          <input type="date" name="child_dob[]" required
                            class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                        </div>

                        <?php if ($tour['is_international'] ?? false): ?>
                          <div>
                            <label class="block text-gray-700 text-xs font-medium mb-1">Số hộ chiếu</label>
                            <input type="text" name="child_passport[]"
                              class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                          </div>
                          <div>
                            <label class="block text-gray-700 text-xs font-medium mb-1">Quốc tịch</label>
                            <input type="text" name="child_nationality[]" value="Việt Nam"
                              class="w-full border border-gray-300 rounded-md p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endfor; ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="mt-8">
              <h3 class="text-lg font-semibold text-gray-700 mb-4">Phương thức thanh toán</h3>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($paymentMethods as $index => $method): ?>
                  <div>
                    <label
                      class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-teal-500 transition-colors">
                      <input type="radio" name="payment_method" value="<?= $method['code'] ?>"
                        <?= $index === 0 ? 'checked' : '' ?> class="mt-0.5">
                      <div class="ml-3">
                        <span class="block font-medium text-sm"><?= htmlspecialchars($method['name']) ?></span>
                        <?php if (!empty($method['description'])): ?>
                          <span
                            class="block text-xs text-gray-500 mt-1"><?= htmlspecialchars($method['description']) ?></span>
                        <?php endif; ?>
                      </div>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Terms -->
            <div class="mt-8">
              <label class="flex items-start cursor-pointer">
                <input type="checkbox" required class="mt-1" name="terms">
                <span class="ml-3 text-gray-700 text-sm">
                  Tôi đã đọc và đồng ý với <a href="#" class="text-teal-600 hover:underline">điều khoản và điều kiện</a>
                  của công ty
                </span>
              </label>
            </div>

            <!-- Submit -->
            <div class="mt-8 flex justify-end">
              <button type="submit"
                class="bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-teal-700 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Hoàn tất đặt tour
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column - Booking Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden sticky top-24">
          <!-- Card Header -->
          <div class="bg-teal-500 p-4">
            <h3 class="text-lg font-semibold text-white">Thông tin đặt tour</h3>
          </div>

          <!-- Tour Info -->
          <div class="p-5">
            <!-- Fix for the image display on line 245 -->
            <div class="mb-4">
              <?php if (!empty($tour['featured_image'])): ?>
                <img src="<?= htmlspecialchars($tour['featured_image']) ?>" alt="<?= htmlspecialchars($tour['title']) ?>"
                  class="w-full h-48 object-cover rounded-lg">
              <?php else: ?>
                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                  <span class="text-gray-400">No image available</span>
                </div>
              <?php endif; ?>
            </div>
            <h4 class="font-semibold text-lg mb-2"><?= htmlspecialchars($tour['title']) ?></h4>

            <div class="space-y-3 border-b border-gray-100 pb-4 mb-4">
              <!-- Tour Date -->
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                  <span class="block text-sm font-medium">Ngày khởi hành</span>
                  <span class="block text-sm text-gray-600">
                    <?= date('d/m/Y', strtotime($tourDate['start_date'])) ?>
                  </span>
                </div>
              </div>

              <!-- Duration -->
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <span class="block text-sm font-medium">Thời gian</span>
                  <span class="block text-sm text-gray-600"><?= htmlspecialchars($tour['duration']) ?></span>
                </div>
              </div>

              <!-- Location -->
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div>
                  <span class="block text-sm font-medium">Địa điểm</span>
                  <span class="block text-sm text-gray-600"><?= htmlspecialchars($tour['location_name']) ?></span>
                </div>
              </div>

              <!-- Guests -->
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <div>
                  <span class="block text-sm font-medium">Số lượng khách</span>
                  <span class="block text-sm text-gray-600">
                    <?= $adults ?> người lớn<?= $children ? ', ' . $children . ' trẻ em' : '' ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- Price Summary -->
            <div>
              <h4 class="font-medium text-gray-700 mb-3">Chi tiết giá</h4>

              <div class="space-y-2">
                <div class="flex justify-between text-sm">
                  <span>Người lớn (<?= $adults ?> x <?= number_format($adultPrice, 0, ',', '.') ?>)</span>
                  <span><?= number_format($adultTotal, 0, ',', '.') ?> VND</span>
                </div>

                <?php if ($children > 0): ?>
                  <div class="flex justify-between text-sm">
                    <span>Trẻ em (<?= $children ?> x <?= number_format($childPrice, 0, ',', '.') ?>)</span>
                    <span><?= number_format($childrenTotal, 0, ',', '.') ?> VND</span>
                  </div>
                <?php endif; ?>

                <div class="flex justify-between text-sm">
                  <span>Thuế và phí (10%)</span>
                  <span><?= number_format($taxFee, 0, ',', '.') ?> VND</span>
                </div>

                <div class="border-t border-gray-200 pt-2 mt-2">
                  <div class="flex justify-between font-semibold">
                    <span>Tổng cộng</span>
                    <span class="text-teal-600"><?= number_format($total, 0, ',', '.') ?> VND</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Help Box -->
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
              <h5 class="font-medium text-gray-700 mb-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-teal-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Cần hỗ trợ?
              </h5>
              <p class="text-sm text-gray-600 mb-2">Liên hệ với chúng tôi nếu bạn có thắc mắc.</p>
              <a href="tel:+84912345678" class="text-teal-600 font-medium text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                0912 345 678
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
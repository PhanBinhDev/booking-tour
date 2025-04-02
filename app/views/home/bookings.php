<!-- Main Content - Tour Booking Page -->
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6 text-sm">
            <ol class="flex items-center space-x-2">
                <li><a href="index.php" class="text-gray-600 hover:text-teal-500">Trang chủ</a></li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li><a href="tours.php" class="text-gray-600 hover:text-teal-500">Tours</a></li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li class="text-teal-500">Đặt tour</li>
            </ol>
        </nav>

        <!-- Tour Information and Booking Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Tour Information (1/3 width on large screens) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6" alt="Du lịch Đà Nẵng - Hội An" class="w-full h-48 object-cover">
                        <div class="absolute top-0 right-0 bg-teal-500 text-white px-3 py-1 m-2 rounded-full text-sm font-semibold">
                            <?= $tourDetails['duration'] ?>
                        </div>
                    </div>

                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-800 mb-2"><?= $tourDetails['title'] ?></h2>

                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <span class="text-gray-500 ml-2">(48 đánh giá)</span>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span><?= $tourDetails['location_name'] ?></span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span><?= $tourDetails['duration'] ?></span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span><?= $tourDetails['group_size'] ?></span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="font-semibold text-gray-800 mb-2">Mô tả ngắn:</h3>
                            <p class="text-gray-600 text-sm"><?= $tourDetails["description"] ?></p>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <?= $tourDetails['sale_price'] ?
                                    '<span class="text-gray-500 text-sm line-through">' .
                                    number_format($tourDetails['price'], 0, ',', '.') . 'đ' . '</span>'
                                    : ''
                                ?>
                                <div class="text-2xl font-bold text-teal-600">
                                    <?= $tourDetails['sale_price'] ? number_format($tourDetails['sale_price'], 0, ',', '.') : number_format($tourDetails['price'], 0, ',', '.')  ?> đ
                                </div>
                                <span class="text-gray-500 text-xs">/ người</span>
                            </div>

                            <?= $tourDetails['sale_price'] ?
                                '<div class="bg-teal-100 text-teal-800 text-sm font-semibold px-3 py-1 rounded-full">' .
                                'Giảm ' . number_format($tourDetails['price'] - $tourDetails['sale_price'], 0, ',', '.') . 'đ'
                                . '</div>'
                                : ''
                            ?>

                        </div>
                    </div>
                </div>

                <!-- Tour Highlights -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-6 p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Điểm nổi bật</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Khám phá phố cổ Hội An - Di sản văn hóa thế giới</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Tham quan Bà Nà Hills và Cầu Vàng nổi tiếng</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Thưởng thức ẩm thực đặc sản miền Trung</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Nghỉ dưỡng tại khách sạn 4 sao tiêu chuẩn quốc tế</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Tắm biển Mỹ Khê - một trong những bãi biển đẹp nhất thế giới</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Booking Form (2/3 width on large screens) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-teal-500 text-white py-4 px-6">
                        <h2 class="text-xl font-bold">Đặt tour</h2>
                        <p class="text-teal-100">Điền thông tin để đặt chỗ của bạn</p>
                    </div>

                    <form action="process_booking.php" method="POST" class="p-6">
                        <!-- Hidden fields for tour_id -->
                        <input type="hidden" name="tour_id" value="12">

                        <!-- Tour Date Selection -->
                        <div class="mb-6">
                            <label for="tour_date_id" class="block text-gray-700 font-medium mb-2">Chọn ngày khởi hành</label>
                            <select id="tour_date_id" name="tour_date_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">-- Chọn ngày --</option>
                                <option value="101">15/06/2025 - 18/06/2025 (15 chỗ trống)</option>
                                <option value="102">22/06/2025 - 25/06/2025 (8 chỗ trống)</option>
                                <option value="103">29/06/2025 - 02/07/2025 (20 chỗ trống)</option>
                                <option value="104">06/07/2025 - 09/07/2025 (12 chỗ trống)</option>
                                <option value="105">13/07/2025 - 16/07/2025 (18 chỗ trống)</option>
                            </select>

                        </div>

                        <!-- Number of People -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="adults" class="block text-gray-700 font-medium mb-2">Người lớn (>12 tuổi)</label>
                                <div class="flex items-center">
                                    <button type="button" onclick="decrementValue('adults')" class="bg-gray-200 px-3 py-2 rounded-l-lg hover:bg-gray-300">-</button>
                                    <input type="number" id="adults" name="adults" min="1" value="1" required class="w-full text-center border-y border-gray-300 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <button type="button" onclick="incrementValue('adults')" class="bg-gray-200 px-3 py-2 rounded-r-lg hover:bg-gray-300">+</button>
                                </div>
                            </div>

                            <div>
                                <label for="children" class="block text-gray-700 font-medium mb-2">Trẻ em (5-12 tuổi)</label>
                                <div class="flex items-center">
                                    <button type="button" onclick="decrementValue('children')" class="bg-gray-200 px-3 py-2 rounded-l-lg hover:bg-gray-300">-</button>
                                    <input type="number" id="children" name="children" min="0" value="0" class="w-full text-center border-y border-gray-300 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <button type="button" onclick="incrementValue('children')" class="bg-gray-200 px-3 py-2 rounded-r-lg hover:bg-gray-300">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Thông tin liên hệ</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="fullname" class="block text-gray-700 font-medium mb-2">Họ và tên</label>
                                    <input type="text" id="fullname" name="fullname" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-gray-700 font-medium mb-2">Số điện thoại</label>
                                    <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>

                                <div>
                                    <label for="address" class="block text-gray-700 font-medium mb-2">Địa chỉ</label>
                                    <input type="text" id="address" name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements -->
                        <div class="mb-6">
                            <label for="special_requirements" class="block text-gray-700 font-medium mb-2">Yêu cầu đặc biệt</label>
                            <textarea id="special_requirements" name="special_requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Yêu cầu về ăn uống, phòng ở hoặc các nhu cầu đặc biệt khác..."></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Phương thức thanh toán</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="border border-gray-300 rounded-lg p-4 hover:border-teal-500 cursor-pointer payment-option">
                                    <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="hidden payment-radio" checked>
                                    <label for="bank_transfer" class="flex items-center cursor-pointer">
                                        <div class="w-5 h-5 rounded-full border border-gray-400 mr-2 flex items-center justify-center payment-radio-circle">
                                            <div class="w-3 h-3 rounded-full bg-teal-500 payment-radio-dot"></div>
                                        </div>
                                        <span>Chuyển khoản</span>
                                    </label>
                                </div>

                                <div class="border border-gray-300 rounded-lg p-4 hover:border-teal-500 cursor-pointer payment-option">
                                    <input type="radio" id="momo" name="payment_method" value="momo" class="hidden payment-radio">
                                    <label for="momo" class="flex items-center cursor-pointer">
                                        <div class="w-5 h-5 rounded-full border border-gray-400 mr-2 flex items-center justify-center payment-radio-circle">
                                            <div class="w-3 h-3 rounded-full bg-teal-500 hidden payment-radio-dot"></div>
                                        </div>
                                        <span>Ví MoMo</span>
                                    </label>
                                </div>

                                <div class="border border-gray-300 rounded-lg p-4 hover:border-teal-500 cursor-pointer payment-option">
                                    <input type="radio" id="vnpay" name="payment_method" value="vnpay" class="hidden payment-radio">
                                    <label for="vnpay" class="flex items-center cursor-pointer">
                                        <div class="w-5 h-5 rounded-full border border-gray-400 mr-2 flex items-center justify-center payment-radio-circle">
                                            <div class="w-3 h-3 rounded-full bg-teal-500 hidden payment-radio-dot"></div>
                                        </div>
                                        <span>VNPay</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tổng chi phí</h3>
                            <div class="flex justify-between mb-2">
                                <span class="adults-price">Người lớn (1 × 3,790,000đ)</span>
                                <span class="adults-total">3,790,000đ</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="children-price">Trẻ em (0 × 2,653,000đ)</span>
                                <span class="children-total">0đ</span>
                            </div>
                            <div class="border-t border-gray-300 my-2"></div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Tổng cộng</span>
                                <span class="text-teal-600 total-price">3,790,000đ</span>
                            </div>
                            <input type="hidden" id="total_price" name="total_price" value="3790000">
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">Tôi đồng ý với <a href="#" class="text-teal-600 hover:underline">điều khoản và điều kiện</a></label>
                                    <p class="text-gray-500">Tôi đã đọc và hiểu các chính sách về đặt tour, hủy tour và hoàn tiền.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="bg-teal-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors">
                                Xác nhận đặt tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to increment value
    function incrementValue(id) {
        const input = document.getElementById(id);
        input.value = parseInt(input.value) + 1;
        updatePriceSummary();
    }

    // Function to decrement value
    function decrementValue(id) {
        const input = document.getElementById(id);
        const currentValue = parseInt(input.value);
        if (id === 'adults' && currentValue > 1) {
            input.value = currentValue - 1;
        } else if (id === 'children' && currentValue > 0) {
            input.value = currentValue - 1;
        }
        updatePriceSummary();
    }

    // Function to update price summary
    function updatePriceSummary() {
        const adults = parseInt(document.getElementById('adults').value);
        const children = parseInt(document.getElementById('children').value);
        const adultPrice = 3790000;
        const childPrice = 2653000;

        const adultTotal = adults * adultPrice;
        const childrenTotal = children * childPrice;
        const total = adultTotal + childrenTotal;

        document.querySelector('.adults-price').textContent = `Người lớn (${adults} × ${formatCurrency(adultPrice)})`;
        document.querySelector('.adults-total').textContent = formatCurrency(adultTotal);
        document.querySelector('.children-price').textContent = `Trẻ em (${children} × ${formatCurrency(childPrice)})`;
        document.querySelector('.children-total').textContent = formatCurrency(childrenTotal);
        document.querySelector('.total-price').textContent = formatCurrency(total);
        document.getElementById('total_price').value = total;
    }

    // Format currency function
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
    }

    // Handle payment method selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            // Reset all options
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('border-teal-500');
                opt.querySelector('.payment-radio-dot').classList.add('hidden');
            });

            // Select clicked option
            this.classList.add('border-teal-500');
            this.querySelector('.payment-radio').checked = true;
            this.querySelector('.payment-radio-dot').classList.remove('hidden');
        });
    });
</script>
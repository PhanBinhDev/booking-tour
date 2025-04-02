<div class="bg-gray-50 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Breadcrumbs -->
        <div class="mb-6 text-sm text-gray-500">
            <a href="#" class="hover:text-teal-500">Home</a> &gt;
            <a href="#" class="hover:text-teal-500">Tours</a> &gt;
            <span class="text-gray-700"><?= $tourDetails['title'] ?></span>
        </div>

        <!-- Tour Title Section -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= $tourDetails['title'] ?></h1>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= $tourDetails["location_name"] ?></span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="font-medium">4.8</span>
                    <span class="text-gray-500 ml-1">(124 reviews)</span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?= $tourDetails["duration"] ?></span>
                </div>
            </div>
        </div>



        <!--slideshows ảnh-->
        <div class="flex space-x-4 items-center">
            <!-- Danh sách ảnh nhỏ (BÊN TRÁI) -->
            <div class="flex flex-col space-y-2">
                <img onclick="changeImage(0)" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=150&h=100&fit=crop"
                    class="w-32 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500">
                <img onclick="changeImage(1)" src="https://dynamic-media.tacdn.com/media/photo-o/2e/f5/9c/57/caption.jpg?w=150&h=100&s=1"
                    class="w-32 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500">
                <img onclick="changeImage(2)" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=150&h=100&fit=crop"

                    class="w-32 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500">
                <!-- Ảnh ẩn -->
                <div id="hidden-images" class="hidden flex flex-col space-y-2">
                    <img onclick="changeImage(3)" src="https://images.unsplash.com/photo-1544550581-5f7ceaf7f992?w=150&h=100&fit=crop&fit=crop"
                        class="w-32 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500">
                    <img onclick="changeImage(4)" src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=150&h=100&fit=crop&fit=crop"
                        class="w-32 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500">
                </div>

                <!-- Nút "Xem thêm" -->
                <button id="showMoreBtn" onclick="showMoreImages()"
                    class="w-32 h-20 flex items-center justify-center bg-gray-300 rounded-lg cursor-pointer text-sm text-center font-bold hover:bg-gray-400">
                    Xem thêm
                </button>
            </div>
            <!-- Ảnh chính + Nút Chuyển -->
            <div class="flex items-center space-x-4">
                <!-- Nút Prev -->
                <button onclick="prevImage()" class="text-3xl bg-white px-6 py-4 rounded-full shadow-lg 
               hover:bg-gray-200 transition duration-300">
                    ⬅
                </button>

                <!-- Ảnh chính -->
                <div class="relative w-[800px] h-[600px]">
                    <img id="mainImage" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=600&fit=crop"
                        class="w-full h-full object-cover rounded-lg shadow-md">
                </div>

                <!-- Nút Next -->
                <button onclick="nextImage()" class="text-3xl bg-white px-6 py-4 rounded-full shadow-lg 
               hover:bg-gray-200 transition duration-300">
                    ➡
                </button>
            </div>
        </div>

        <script>
            let images = [
                "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=600&fit=crop",
                "https://dynamic-media.tacdn.com/media/photo-o/2e/f5/9c/57/caption.jpg?w=800&h=600&s=1",
                "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=600&fit=crop",
                "https://images.unsplash.com/photo-1544550581-5f7ceaf7f992?w=800&h=600&fit=crop",
                "https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&h=600&fit=crop"
            ];
            let currentIndex = 0;

            function changeImage(index) {
                currentIndex = index;
                document.getElementById("mainImage").src = images[currentIndex];
            }

            function prevImage() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                document.getElementById("mainImage").src = images[currentIndex];
            }

            function nextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                document.getElementById("mainImage").src = images[currentIndex];
            }

            function showMoreImages() {
                document.getElementById("hidden-images").classList.remove("hidden");
                document.getElementById("showMoreBtn").classList.add("hidden");

                // Cập nhật danh sách ảnh để có thể next/prev qua ảnh ẩn
                images.push(
                    "https://images.unsplash.com/photo-1544550581-5f7ceaf7f992?w=800&h=600&fit=crop",
                    "https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&h=600&fit=crop"
                );
            }
        </script>
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Tour Details -->
            <div class="lg:col-span-2">
                <!-- Overview Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tổng quan Tour</h2>

                    <p class="text-gray-600 mb-4">
                        <?= htmlspecialchars($tourDetails["description"]) ?>
                    </p>

                    <p class="text-gray-600 mb-4">
                        <?= nl2br(htmlspecialchars($tourDetails["content"])) ?>
                    </p>

                    <!-- Dịch vụ bao gồm / không bao gồm -->
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Dịch vụ</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Dịch vụ bao gồm -->
                        <div class="flex items-start space-x-3 p-4 bg-white rounded-lg shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800">Bao Gồm</h4>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($tourDetails["included"])) ?></p>
                            </div>
                        </div>

                        <!-- Dịch vụ không bao gồm -->
                        <div class="flex items-start space-x-3 p-4 bg-white rounded-lg shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM12.707 7.293a1 1 0 00-1.414 0L10 8.586 8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800">Không Bao Gồm</h4>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($tourDetails["excluded"])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lịch trình Tour -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Lịch trình chi tiết</h2>

                    <?php

                    use App\Helpers\UrlHelper;

                    foreach ($itinerary as $details): ?>
                        <div class="mb-6 border-l-4 border-teal-500 pl-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                <?= $details["day"] ?>: <?= htmlspecialchars($details["title"] ?? "Chưa có tiêu đề") ?>
                            </h3>

                            <?php if (!empty($details["description"])): ?>
                                <p class="text-gray-600"><?= htmlspecialchars($details["description"]) ?></p>
                            <?php else: ?>
                                <p class="text-gray-500 italic">Chưa có thông tin chi tiết cho ngày này.</p>
                            <?php endif; ?>

                            <!-- Hiển thị bữa ăn -->
                            <?php if (!empty($details["meals"]) && is_array($details["meals"])): ?>
                                <p class="text-gray-700 font-semibold mt-2"> Bữa ăn: <?= implode(", ", array_map('htmlspecialchars', $details["meals"])) ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị nơi ở -->
                            <?php if (!empty($details["accommodation"])): ?>
                                <p class="text-gray-700 font-semibold mt-2"> Nơi ở: <?= htmlspecialchars($details["accommodation"]) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <!-- Nút xem thêm -->
                    <button class="flex items-center text-teal-500 font-medium hover:text-teal-600 transition-colors">
                        <span>Xem toàn bộ lịch trình</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>



                <!-- Phần Chỗ Ở -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Chỗ Ở</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Loại Phòng 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500&h=300&fit=crop" alt="Phòng Deluxe View Biển" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Phòng Deluxe View Biển</h3>
                                <ul class="text-sm text-gray-600 space-y-1 mb-3">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Giường King-size
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Ban công riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        View biển
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="text-teal-500 font-semibold">Bao gồm trong gói</span>
                                </div>
                            </div>
                        </div>

                        <!-- Loại Phòng 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=300&fit=crop" alt="Biệt Thự Bãi Biển" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Biệt Thự Bãi Biển</h3>
                                <ul class="text-sm text-gray-600 space-y-1 mb-3">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Khu vực sinh hoạt riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Hồ bơi riêng
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Truy cập trực tiếp ra biển
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="text-gray-600 font-semibold">+ $899 nâng cấp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Đánh giá </h2>
                        <div class="flex items-center">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <span class="ml-2 font-semibold">4.8 out of 5</span>
                        </div>
                    </div>

                    <!-- Review Filters -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <button class="bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-medium">Tất cả đánh giá </button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">5 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">4 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">3 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">2 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">1 Star</button>
                    </div>

                    <!-- Individual Reviews -->
                    <div class="space-y-6">
                        <!-- Review 1 -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden mr-3">
                                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Sarah J." class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Sarah J.</h4>
                                        <p class="text-sm text-gray-500">Visited April 2023</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3">
                                Absolutely amazing experience! The resort exceeded all our expectations. The staff was incredibly attentive, the beach was pristine, and the food was outstanding. We particularly enjoyed the cultural excursions which gave us a deeper appreciation of Balinese culture.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Great Service</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Beautiful Location</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Excellent Food</span>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden mr-3">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T." class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Michael T.</h4>
                                        <p class="text-sm text-gray-500">Visited March 2023</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3">
                                My wife and I had a wonderful time at the resort. The beach villa upgrade was definitely worth it! The private pool and direct beach access made our honeymoon truly special. The only minor issue was occasional slow service at the main restaurant during peak hours.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Romantic</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Luxury</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Great Views</span>
                            </div>
                        </div>

                        <!-- Show More Reviews Button -->
                        <a href=""><button class="w-full py-2 border border-teal-500 text-teal-500 rounded-lg font-medium hover:bg-teal-50 transition-colors">
                                Xem thêm
                            </button></a>
                    </div>
                </div>

                <!-- Phần Bản Đồ & Vị Trí -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Vị Trí</h2>
                    <div class="aspect-video bg-gray-200 rounded-lg mb-4 overflow-hidden">
                        <!-- Placeholder bản đồ - trong thực tế, đây sẽ là một bản đồ thực tế -->
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=Nusa+Dua,Bali,Indonesia&zoom=13&size=600x300&maptype=roadmap&markers=color:red%7CNusa+Dua,Bali,Indonesia&key=YOUR_API_KEY" alt="Bản đồ vị trí khu nghỉ dưỡng" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Địa Chỉ</h3>
                            <p class="text-gray-600 mb-4">
                                Jl. Pantai Mengiat, Nusa Dua<br />
                                Bali 80363, Indonesia
                            </p>
                            <h3 class="font-semibold text-gray-800 mb-2">Các Điểm Tham Quan Gần Kề</h3>
                            <ul class="text-gray-600 space-y-1">
                                <li>• Bãi Biển Nusa Dua (0.1 km)</li>
                                <li>• Trung Tâm Mua Sắm Bali Collection (1.5 km)</li>
                                <li>• Water Blow (2.3 km)</li>
                                <li>• Puja Mandala (3.1 km)</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Cách Di Chuyển Đến</h3>
                            <ul class="text-gray-600 space-y-1 mb-4">
                                <li>• Sân Bay Quốc Tế Ngurah Rai (13 km)</li>
                                <li>• Dịch vụ đưa đón sân bay bao gồm trong gói</li>
                                <li>• Dịch vụ taxi có sẵn 24/7</li>
                            </ul>
                            <button class="text-teal-500 font-medium hover:text-teal-600 transition-colors flex items-center">
                                <span>Nhận Lộ Trình</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column - Booking & Info -->
            <div class="lg:w-[350px] w-full">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <?php if (!empty($tourDetails['sale_price'])): ?>
                        <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold w-20">
                            <?= round((1 - $tourDetails['sale_price'] / $tourDetails['price']) * 100) ?>% GIẢM
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-baseline">
                            <span class="text-xl font-bold text-red-500">
                                <?= number_format($tourDetails['sale_price'] ?? $tourDetails['price'], 0, ',', '.') ?> VND
                            </span>
                            <span class="text-gray-500 ml-2">/ người</span>
                        </div>
                    </div>

                    <?php if (!empty($tourDetails['sale_price'])): ?>
                        <div class="text-gray-500 line-through mb-4">
                            <?= number_format($tourDetails['price'], 0, ',', '.') ?> VND (Giá gốc)
                        </div>
                    <?php endif; ?>

                    <div class="mb-6">
                        <label for="tour_date_id" class="block text-gray-700 font-medium mb-2">Chọn ngày khởi hành</label>
                        <select id="tour_date_id" name="tour_date_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Chọn ngày --</option>
                        </select>
                    </div>

                    <script>
                        async function fetchTourDates(tourId) {
                            try {
                                const response = await fetch(`/api/getTourDates?tourId=${tourId}`);
                                const dates = await response.json();
                                console.log('Dữ liệu nhận được:', dates); // Kiểm tra dữ liệu trong console

                                if (!Array.isArray(dates) || dates.length === 0) {
                                    console.warn('Không có ngày tour nào khả dụng');
                                    return;
                                }

                                const dateSelect = document.getElementById('tour_date_id');
                                dateSelect.innerHTML = '<option value="">-- Chọn ngày --</option>';
                                dates.forEach(date => {
                                    if (date.start_date && date.end_date && date.id && date.available_seats !== undefined) {
                                        const option = document.createElement('option');
                                        option.value = date.id;
                                        option.textContent = `${date.start_date} - ${date.end_date} (${date.available_seats} chỗ trống)`;
                                        dateSelect.appendChild(option);
                                    } else {
                                        console.warn('Dữ liệu ngày không hợp lệ:', date);
                                    }
                                });
                            } catch (error) {
                                console.error('Lỗi lấy dữ liệu ngày tour:', error);
                            }
                        }

                        // Gọi API với ID tour cụ thể (thay đổi theo nhu cầu)
                        fetchTourDates(1);
                    </script>



                    <div class="flex space-x-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Người lớn (>12 tuổi)</label>
                            <div class="flex items-center border rounded-lg">
                                <button class="px-3 py-1 bg-gray-200" onclick="changeValue('adult', -1)">-</button>
                                <input id="adult" type="text" value="1" class="w-12 text-center border-none" readonly>
                                <button class="px-3 py-1 bg-gray-200" onclick="changeValue('adult', 1)">+</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Trẻ em (5-12 tuổi)</label>
                            <div class="flex items-center border rounded-lg">
                                <button class="px-3 py-1 bg-gray-200" onclick="changeValue('child', -1)">-</button>
                                <input id="child" type="text" value="0" class="w-12 text-center border-none" readonly>
                                <button class="px-3 py-1 bg-gray-200" onclick="changeValue('child', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        function changeValue(id, delta) {
                            let input = document.getElementById(id);
                            let value = parseInt(input.value) + delta;
                            if (value >= 0) {
                                input.value = value;
                            }
                        }
                    </script>


                    <div class="border-t border-b border-gray-200 py-4 mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Giá cơ bản</span>
                            <span>
                                <?= number_format($tourDetails['price'] ?? 0, 0, ',', '.') ?> VND
                            </span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Thuế & phí</span>
                            <span>
                                <?= number_format($tourDetails['taxes'] ?? 300000, 0, ',', '.') ?> VND
                            </span>
                        </div>
                        <?php
                        $price = $tourDetails['price'] ?? 0;
                        $sale_price = $tourDetails['sale_price'] ?? $price;
                        $taxes = $tourDetails['taxes'] ?? 300000;
                        $total = $sale_price + $taxes;
                        ?>
                        <div class="flex justify-between font-bold mt-3 pt-3 border-t border-gray-200">
                            <span>Tổng cộng</span>
                            <span>
                                <?= number_format($total, 0, ',', '.') ?> VND
                            </span>
                        </div>
                    </div>


                    <div class="space-y-3">
                        <a href="<?= UrlHelper::route('home/bookings/' . $tourDetails['id']) ?>"> <button class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 flex justify-center items-center">
                                Đặt ngay
                            </button></a>
                        <div class="flex gap-2">
                            <button class="flex-1 border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-3 px-4 rounded-lg transition duration-300">
                                Reserve
                            </button>
                            <button class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-3 px-3 rounded-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Thẻ Bao Gồm Những Gì -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Những gì bao gồm</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">7 ngày, 6 đêm lưu trú</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Đưa đón sân bay</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Bữa sáng và bữa tối hàng ngày</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">3 chuyến tham quan có hướng dẫn viên</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">1 liệu pháp spa mỗi người</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Truy cập tất cả các tiện ích của khu nghỉ dưỡng</span>
                        </li>
                    </ul>
                </div>


                <!-- Need Help Card -->
                <div class="bg-teal-50 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Cần Hỗ Trợ?</h3>
                    <p class="text-gray-600 mb-4">
                        Các chuyên gia du lịch của chúng tôi sẵn sàng hỗ trợ bạn với bất kỳ câu hỏi nào về gói tour này. </p>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gọi cho chúng tôi</p>
                            <p class="font-medium text-gray-800">+1 (800) 123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5   stroke-linejoin=" round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gửi email cho chúng tôi</p>
                            <p class="font-medium text-gray-800">support@travelagency.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Tours Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Có thể bạn quan tâm</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Similar Tour 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&h=300&fit=crop" alt="Luxury Retreat" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $2,999
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Maldives</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Maldives Overwater Villa</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.9</span>
                                <span class="text-xs text-gray-500 ml-1">(86)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?w=500&h=300&fit=crop" alt="Cultural Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,799
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Japan</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Japan Cultural Experience</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.8</span>
                                <span class="text-xs text-gray-500 ml-1">(112)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=500&h=300&fit=crop" alt="Mountain Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,599
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Switzerland</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Swiss Alps Adventure</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.7</span>
                                <span class="text-xs text-gray-500 ml-1">(94)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=500&h=300&fit=crop" alt="Rome Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,299
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Italy</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Italian Heritage Tour</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.6</span>
                                <span class="text-xs text-gray-500 ml-1">(78)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
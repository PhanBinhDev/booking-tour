<?php

use App\Helpers\UrlHelper;
?>

<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Tiêu đề trang -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Thêm Tour Du Lịch Mới</h1>
            <p class="text-gray-600">Điền đầy đủ thông tin để tạo tour mới</p>
        </div>

        <!-- Form thêm tour -->
        <form action="" method="POST" class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Tabs điều hướng -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button type="button" class="tab-btn active py-4 px-6 border-b-2 border-teal-500 font-medium text-sm text-teal-600" data-target="basic-info">
                        Thông tin cơ bản
                    </button>
                    <button type="button" class="tab-btn py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="details">
                        Chi tiết tour
                    </button>
                    <button type="button" class="tab-btn py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="itinerary">
                        Lịch trình
                    </button>
                    <button type="button" class="tab-btn py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="seo">
                        SEO & Cài đặt
                    </button>
                </nav>
            </div>

            <!-- Tab content -->
            <div class="p-6">
                <!-- Thông tin cơ bản -->
                <div id="basic-info" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tên tour <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>

                        <div class="col-span-2">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <div class="flex">
                                <input type="text" id="slug" name="slug" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                <button type="button" id="generate-slug" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Tạo slug
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Để trống để tự động tạo từ tên tour</p>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá tour (VNĐ) <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" required min="0" step="1000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" id="sale_price" name="sale_price" min="0" step="1000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Thời gian tour</label>
                            <input type="text" id="duration" name="duration" placeholder="Ví dụ: 3 ngày 2 đêm" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="group_size" class="block text-sm font-medium text-gray-700 mb-1">Số người tối đa</label>
                            <input type="text" id="group_size" name="group_size" placeholder="Ví dụ: 20 người" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục tour</label>
                            <select id="category_id" name="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                <option value="">-- Chọn danh mục --</option>
                                <option value="1">Du lịch trong nước</option>
                                <option value="2">Du lịch nước ngoài</option>
                                <option value="3">Tour miền Bắc</option>
                                <option value="4">Tour miền Trung</option>
                                <option value="5">Tour miền Nam</option>
                            </select>
                        </div>

                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">Điểm đến</label>
                            <select id="location_id" name="location_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                <option value="">-- Chọn điểm đến --</option>
                                <option value="1">Hà Nội</option>
                                <option value="2">Hạ Long</option>
                                <option value="3">Sapa</option>
                                <option value="4">Đà Nẵng</option>
                                <option value="5">Hội An</option>
                                <option value="6">Huế</option>
                                <option value="7">Nha Trang</option>
                                <option value="8">Đà Lạt</option>
                                <option value="9">TP. Hồ Chí Minh</option>
                                <option value="10">Phú Quốc</option>
                            </select>
                        </div>

                        <div>
                            <label for="departure_location_id" class="block text-sm font-medium text-gray-700 mb-1">Điểm khởi hành</label>
                            <select id="departure_location_id" name="departure_location_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                <option value="">-- Chọn điểm khởi hành --</option>
                                <option value="1">Hà Nội</option>
                                <option value="9">TP. Hồ Chí Minh</option>
                                <option value="4">Đà Nẵng</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả ngắn</label>
                            <textarea id="description" name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung chi tiết</label>
                            <textarea id="content" name="content" rows="6" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Mô tả chi tiết về tour du lịch</p>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết tour -->
                <div id="details" class="tab-content hidden">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="included" class="block text-sm font-medium text-gray-700 mb-1">Dịch vụ bao gồm</label>
                            <textarea id="included" name="included" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Mỗi dịch vụ một dòng"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Liệt kê các dịch vụ bao gồm trong tour</p>
                        </div>

                        <div>
                            <label for="excluded" class="block text-sm font-medium text-gray-700 mb-1">Dịch vụ không bao gồm</label>
                            <textarea id="excluded" name="excluded" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Mỗi dịch vụ một dòng"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Liệt kê các dịch vụ không bao gồm trong tour</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh tour</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                            <span>Tải lên hình ảnh</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                        </label>
                                        <p class="pl-1">hoặc kéo thả vào đây</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lịch trình -->
                <div id="itinerary" class="tab-content hidden">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Lịch trình tour</h3>
                        <button type="button" id="add-day" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <i class="fas fa-plus mr-2"></i> Thêm ngày
                        </button>
                    </div>

                    <div id="itinerary-container">
                        <div class="itinerary-day bg-gray-50 p-4 rounded-md mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium">Ngày 1</h4>
                                <button type="button" class="remove-day text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề ngày</label>
                                    <input type="text" name="itinerary[0][title]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Ví dụ: Hà Nội - Hạ Long">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả hoạt động</label>
                                    <textarea name="itinerary[0][description]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Mô tả chi tiết các hoạt động trong ngày"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bữa ăn</label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="itinerary[0][meals][]" value="breakfast" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Sáng</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="itinerary[0][meals][]" value="lunch" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Trưa</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="itinerary[0][meals][]" value="dinner" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Tối</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Chỗ ở</label>
                                    <input type="text" name="itinerary[0][accommodation]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Ví dụ: Khách sạn 4 sao tại Hạ Long">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO & Cài đặt -->
                <div id="seo" class="tab-content hidden">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                            <p class="mt-1 text-xs text-gray-500">Để trống để sử dụng tên tour</p>
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Để trống để sử dụng mô tả ngắn</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                                <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Không hoạt động</option>
                                    <option value="draft">Bản nháp</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tùy chọn</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="featured" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">Tour nổi bật</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form actions -->
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 mr-2">
                    Hủy
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <i class="fas fa-save mr-2"></i> Lưu tour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Tab navigation
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const target = button.dataset.target;

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'border-teal-500', 'text-teal-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                // Show the selected tab content
                document.getElementById(target).classList.remove('hidden');

                // Add active class to the clicked button
                button.classList.add('active', 'border-teal-500', 'text-teal-600');
                button.classList.remove('border-transparent', 'text-gray-500');
            });
        });

        // Generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const generateSlugBtn = document.getElementById('generate-slug');

        generateSlugBtn.addEventListener('click', () => {
            const title = titleInput.value;
            if (title) {
                const slug = title
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[đĐ]/g, 'd')
                    .replace(/[^a-z0-9\s]/g, '')
                    .replace(/\s+/g, '-');

                slugInput.value = slug;
            }
        });

        // Add/remove itinerary days
        const addDayBtn = document.getElementById('add-day');
        const itineraryContainer = document.getElementById('itinerary-container');
        let dayCount = 1;

        addDayBtn.addEventListener('click', () => {
            dayCount++;
            const newDay = document.createElement('div');
            newDay.className = 'itinerary-day bg-gray-50 p-4 rounded-md mb-4';
            newDay.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-medium">Ngày ${dayCount}</h4>
                    <button type="button" class="remove-day text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề ngày</label>
                        <input type="text" name="itinerary[${dayCount-1}][title]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Ví dụ: Hạ Long - Sapa">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả hoạt động</label>
                        <textarea name="itinerary[${dayCount-1}][description]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Mô tả chi tiết các hoạt động trong ngày"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bữa ăn</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="itinerary[${dayCount-1}][meals][]" value="breakfast" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Sáng</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="itinerary[${dayCount-1}][meals][]" value="lunch" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Trưa</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="itinerary[${dayCount-1}][meals][]" value="dinner" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Tối</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Chỗ ở</label>
                        <input type="text" name="itinerary[${dayCount-1}][accommodation]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Ví dụ: Khách sạn 4 sao tại Sapa">
                    </div>
                </div>
            `;
            itineraryContainer.appendChild(newDay);

            // Add event listener to the new remove button
            const removeBtn = newDay.querySelector('.remove-day');
            removeBtn.addEventListener('click', function() {
                newDay.remove();
                updateDayNumbers();
            });
        });

        // Initial setup for remove buttons
        document.querySelectorAll('.remove-day').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.itinerary-day').remove();
                updateDayNumbers();
            });
        });

        // Update day numbers after removal
        function updateDayNumbers() {
            const days = document.querySelectorAll('.itinerary-day');
            days.forEach((day, index) => {
                day.querySelector('h4').textContent = `Ngày ${index + 1}`;

                // Update input names
                const inputs = day.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/itinerary\[\d+\]/, `itinerary[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });

            dayCount = days.length;
        }
    });
</script>
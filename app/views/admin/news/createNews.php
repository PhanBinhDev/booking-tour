<?php

use App\Helpers\UrlHelper;
?>
<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Tiêu đề trang -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Thêm Tin Tức</h1>
            <p class="text-gray-600">Điền thông tin để tạo tin tức mới </p>
        </div>
        <form id="newsForm" class="space-y-6" method="post" action="<?= UrlHelper::route('admin/news/createNews') ?>" enctype="multipart/form-data">
            <!-- Basic Information -->
            <div class="space-y-4">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required
                        class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"
                        placeholder="Nhập tiêu đề ở đây">
                </div>

                <div class="col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <div class="flex">
                        <input type="text" id="slug" name="slug"
                            value=""
                            class="w-full rounded-md border-2 border-gray-150 shadow-sm
                                 focus:border-teal-500 focus:outline-none px-2.5
                                 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                        <button type="button" id="generate-slug" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Tạo slug
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Để trống để tự động tạo từ tên danh mục</p>
                </div>

                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">Mô tả ngắn</label>
                    <textarea id="summary" name="summary" rows="3"
                        class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"
                        placeholder="Mô tả ngắn..."></textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="8" required
                        class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"
                        placeholder="Nội dung..."></textarea>
                </div>
            </div>

            <!-- Media & Categorization -->
            <div class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                            class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20" required>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select id="category_id" name="category_id"
                            class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>


            </div>

            <!-- Publishing Options -->
            <div class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select id="status" name="status"
                            class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                            <option value="published">Phát hành</option>
                            <option value="draft">Bản nháp</option>
                            <option value="archived">Chưa phát hành</option>
                        </select>
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Ngày phát hành</label>
                        <input type="datetime-local" id="published_at" name="published_at"
                            class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2">Thông tin SEO</h2>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title"
                        class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"
                        placeholder="SEO title">
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                        class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20"
                        placeholder="SEO description"></textarea>
                </div>
            </div>

            <!-- Hidden fields that would be handled server-side -->
            <input type="hidden" id="created_by" name="created_by" value="1">

            <!-- Form actions -->
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" onclick="window.history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 mr-2">
                    Hủy
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tạo tin tức
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy các phần tử DOM
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const generateSlugBtn = document.getElementById('generate-slug');

        // Hàm tạo slug từ text
        function createSlug(text) {
            return text
                .toLowerCase()
                .normalize('NFD') // Tách dấu thành ký tự riêng biệt
                .replace(/[\u0300-\u036f]/g, '') // Loại bỏ các dấu
                .replace(/[đĐ]/g, 'd') // Thay thế đ/Đ thành d
                .replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
                .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-') // Loại bỏ nhiều dấu gạch ngang liên tiếp
                .trim(); // Loại bỏ khoảng trắng đầu/cuối
        }

        // Tự động tạo slug khi người dùng nhập tiêu đề
        titleInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.auto === 'true') {
                slugInput.value = createSlug(this.value);
                slugInput.dataset.auto = 'true';
            }
        });

        // Khi người dùng thay đổi slug thủ công, tắt chế độ tự động
        slugInput.addEventListener('input', function() {
            this.dataset.auto = 'false';
        });

        // Nút tạo slug thủ công
        generateSlugBtn.addEventListener('click', function() {
            const title = titleInput.value;
            if (title) {
                slugInput.value = createSlug(title);
                slugInput.dataset.auto = 'true';
                // Focus vào slug để người dùng có thể chỉnh sửa nếu muốn
                slugInput.focus();
            }
        });
    });
</script>
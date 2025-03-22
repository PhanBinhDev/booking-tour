<?php

use App\Helpers\UrlHelper;
// Xác định nếu đang ở chế độ cập nhật hay tạo mới
$isUpdate = isset($isUpdate) && $isUpdate === true;

// Lấy dữ liệu để hiển thị trong form
$formData = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
} elseif ($isUpdate) {
    $formData = $category;
}
?>

<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Tiêu đề trang -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <?php echo isset($formData['id']) ? 'Sửa Danh Mục Tour' : 'Thêm Danh Mục Tour'; ?></h1>
            <p class="text-gray-600">Điền thông tin để
                <?php echo isset($formData['id']) ? 'sửa danh mục tour' : 'tạo danh mục tour mới'; ?> </p>
        </div>

        <!-- Form thêm danh mục -->
        <form action="<?= $isUpdate ? UrlHelper::route('admin/tours/categories/updateCategory/' . $formData['id']) : UrlHelper::route('admin/tours/createCategory') ?>"
            method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2" style="display: flex; width: 100%;">
                        <?php
                        $hasCreatedAt = !empty($formData['created_at']);
                        $nameWidth = $hasCreatedAt ? '75%' : '100%';
                        ?>

                        <div style="flex-basis: <?php echo $nameWidth; ?>; margin-right: 10px;">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Tên danh mục <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                value="<?php echo isset($formData['name']) ? $formData['name'] : ''; ?>"
                                class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                        </div>

                        <?php if ($hasCreatedAt) { ?>
                            <div style="flex-basis: 25%;">
                                <label for="created_at" class="block text-sm font-medium text-gray-700 mb-1">
                                    Ngày tạo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="created_at" name="created_at" disabled
                                    value="<?php echo $formData['created_at']; ?>"
                                    class="w-full p-2.5 rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-1 focus:border-teal-500 focus:outline-none 
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                            </div>
                        <?php } ?>
                    </div>



                    <div class="col-span-2">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <div class="flex">
                            <input type="text" id="slug" name="slug"
                                value="<?php echo isset($formData['slug']) ? $formData['slug'] : ''; ?>"
                                class="w-full rounded-md border-2 border-gray-150 shadow-sm
                                 focus:border-teal-500 focus:outline-none px-2.5
                                 focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20">
                            <button type="button" id="generate-slug" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Tạo slug
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Để trống để tự động tạo từ tên danh mục</p>
                    </div>

                    <div class="col-span-2 md:col-span-2">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select id="status" name="status"
                            class="w-full rounded-md border-2 border-gray-150 shadow-sm
                                    focus:border-teal-500 focus:outline-none px-2.5
                                    focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20 p-2.5">
                            <option value="active" <?php echo (isset($formData['status']) && $formData['status'] == 'active') ? 'selected' : ''; ?>>Hoạt động</option>
                            <option value="inactive" <?php echo (isset($formData['status']) && $formData['status'] == 'inactive') ? 'selected' : ''; ?>>Không hoạt động</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-teal-500 focus:outline-none
                        focus:ring-1 focus:ring-teal-500 focus:ring-opacity-20 px-2.5"><?php echo isset($formData['description']) ? $formData['description'] : ''; ?></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh danh mục</label>
                        <div class="mt-1 flex items-center">
                            <div class="w-32 h-32 border-2 border-gray-300 border-dashed rounded-md flex items-center justify-center mr-4">
                                <img id="preview-image" src="<?php echo isset($formData['image']) && !empty($formData['image']) ? $formData['image'] : '/placeholder.svg?height=128&width=128'; ?>" alt="Preview" class="w-full h-full object-cover rounded-md <?php echo isset($formData['image']) && !empty($formData['image']) ? '' : 'hidden'; ?>">
                                <svg id="placeholder-icon" class="h-12 w-12 text-gray-400 <?php echo isset($formData['image']) && !empty($formData['image']) ? 'hidden' : ''; ?>" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                    <span>Tải lên hình ảnh</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                </label>
                                <?php if (isset($formData['image']) && !empty($formData['image'])) { ?>
                                    <input type="hidden" name="current_image" value="<?php echo $formData['image']; ?>">
                                <?php } ?>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF tối đa 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form actions -->
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" onclick="window.history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 mr-2">
                    Hủy
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <?php echo $isUpdate ? 'Cập nhật danh mục' : 'Tạo danh mục'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const generateSlugBtn = document.getElementById('generate-slug');

        generateSlugBtn.addEventListener('click', () => {
            const name = nameInput.value;
            if (name) {
                const slug = name
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[đĐ]/g, 'd')
                    .replace(/[^a-z0-9\s]/g, '')
                    .replace(/\s+/g, '-');

                slugInput.value = slug;
            }
        });
    });

    // Preview image before upload

    function previewImage(input) {
        const preview = document.getElementById('preview-image');
        const placeholder = document.getElementById('placeholder-icon');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);

            input.value = "";
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
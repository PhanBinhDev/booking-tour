<?php
// filepath: c:\xampp\htdocs\project\app\views\admin\news\updateNews.php

use App\Helpers\UrlHelper;

// Remove var_dump to avoid unwanted output
?>

<div>
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="<?= UrlHelper::route('admin/news/index') ?>" class="mr-4 text-gray-500 hover:text-teal-500">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-semibold text-gray-800">Chỉnh sửa bài viết</h1>
            </div>

            <div>
                <button type="button" id="save-draft-btn"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors mr-2">
                    <i class="far fa-save mr-2"></i>Lưu nháp
                </button>
                <button type="button" id="publish-btn"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Xuất bản
                </button>
            </div>
        </div>

        <form id="news-form" action="<?= UrlHelper::route('admin/news/updateNews/' . $news['id']) ?>" method="POST"
            enctype="multipart/form-data">
            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2">
                    <!-- Title Input -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề bài viết</label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($news['title']) ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Nhập tiêu đề bài viết..." required>
                        </div>

                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <div class="flex">
                                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($news['slug']) ?>"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                    placeholder="tieu-de-bai-viet">
                                <button type="button" id="generate-slug"
                                    class="bg-gray-100 px-4 py-2 border border-gray-300 rounded-r-lg hover:bg-gray-200">
                                    Tạo tự động
                                </button>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">URL thân thiện sẽ tự động tạo từ tiêu đề, bạn có thể chỉnh sửa nếu
                                cần.</p>
                        </div>

                        <div>
                            <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">Tóm tắt</label>
                            <textarea id="summary" name="summary" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Tóm tắt ngắn gọn về bài viết..."><?= htmlspecialchars($news['summary']) ?></textarea>
                        </div>
                    </div>

                    <!-- Editor.js Container -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Nội dung</label>
                        <div id="editorjs" class="border border-gray-200 rounded-lg p-4 min-h-[500px]"></div>
                        <!-- Store content in a hidden field without direct HTML attribute to avoid escaping issues -->
                        <input type="hidden" name="content" id="content-data">
                    </div>
                </div>

                <!-- Right Column - Settings -->
                <div class="lg:col-span-1">
                    <!-- Publish Settings -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="font-medium text-gray-800 mb-4">Xuất bản</h3>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                            <select id="status" name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="draft" <?= $news['status'] === 'draft' ? 'selected' : '' ?>>Bản nháp</option>
                                <option value="published" <?= $news['status'] === 'published' ? 'selected' : '' ?>>Xuất bản</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Ngày xuất bản</label>
                            <input type="datetime-local" id="published_at" name="published_at"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                value="<?= date('Y-m-d\TH:i', strtotime($news['published_at'] ?? $news['created_at'])) ?>">
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="featured" name="featured" value="1" <?= $news['featured'] ? 'checked' : '' ?>
                                    class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500">
                                <label for="featured" class="ml-2 text-sm text-gray-700">Đặt làm bài nổi bật</label>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="font-medium text-gray-800 mb-4">Danh mục</h3>

                        <div class="max-h-48 overflow-y-auto">
                            <?php
                            // Convert existing categories to a simple ID array for easier checking
                            $newsCategories = array_column($categories ?? [], 'id');
                            foreach ($allCategories ?? [] as $category):
                            ?>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="category-<?= $category['id'] ?>" name="categories[]"
                                        value="<?= $category['id'] ?>" class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500"
                                        <?= in_array($category['id'], $newsCategories) ? 'checked' : '' ?>>
                                    <label for="category-<?= $category['id'] ?>" class="ml-2 text-sm text-gray-700">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (empty($allCategories)): ?>
                            <p class="text-sm text-gray-500">Chưa có danh mục nào.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="font-medium text-gray-800 mb-4">Ảnh đại diện</h3>

                        <div class="mb-4">
                            <div id="featured-image-preview"
                                class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center <?= empty($news['featured_image']) ? 'hidden' : '' ?>">
                                <img id="featured-image-preview-img" src="<?= htmlspecialchars($news['featured_image'] ?? '') ?>"
                                    alt="Preview" class="mx-auto max-h-48">
                                <button type="button" id="remove-featured-image" class="mt-2 text-sm text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt mr-1"></i>Xóa ảnh
                                </button>
                            </div>

                            <div id="featured-image-upload"
                                class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer <?= !empty($news['featured_image']) ? 'hidden' : '' ?>">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-500">Nhấn để chọn ảnh hoặc kéo thả ảnh vào đây</p>
                            </div>
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" class="hidden">
                            <!-- Keep existing image if no new one is uploaded -->
                            <input type="hidden" name="existing_featured_image"
                                value="<?= htmlspecialchars($news['featured_image'] ?? '') ?>">
                        </div>

                        <div>
                            <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Alt text cho ảnh</label>
                            <input type="text" id="image_alt" name="image_alt"
                                value="<?= htmlspecialchars($news['image_alt'] ?? '') ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Mô tả ngắn gọn về ảnh...">
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="font-medium text-gray-800 mb-4">SEO</h3>

                        <div class="mb-4">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title"
                                value="<?= htmlspecialchars($news['meta_title'] ?? $news['title'] ?? '') ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Meta tiêu đề...">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta
                                Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Meta mô tả..."><?= htmlspecialchars($news['meta_description'] ?? $news['summary'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="action" id="form-action" value="update">
            <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
            <!-- CSRF token or any other security fields can go here -->
        </form>
    </main>
</div>

<!-- Include necessary scripts for EditorJS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set content directly to avoid HTML escaping issues
        const contentField = document.getElementById('content-data');
        const rawContent = <?= json_encode($news['content']) ?>;
        contentField.value = rawContent;

        // Initialize Editor.js
        try {
            // Parse the content safely
            let existingContent = null;
            try {
                existingContent = JSON.parse(rawContent);
                console.log("Content parsed successfully");
            } catch (e) {
                console.error("Error parsing content:", e);
                existingContent = {
                    time: Date.now(),
                    blocks: [],
                    version: "2.26.5"
                };
            }

            // Initialize Editor
            const editor = new EditorJS({
                holder: 'editorjs',
                autofocus: false,
                placeholder: 'Bắt đầu viết nội dung của bạn...',
                data: existingContent,
                tools: {
                    header: {
                        class: Header,
                        inlineToolbar: true,
                        config: {
                            placeholder: 'Nhập tiêu đề',
                            levels: [2, 3, 4],
                            defaultLevel: 2
                        }
                    },
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        config: {
                            defaultStyle: 'unordered'
                        }
                    },
                    checklist: {
                        class: Checklist,
                        inlineToolbar: true
                    },
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Nhập trích dẫn',
                            captionPlaceholder: 'Người trích dẫn',
                        },
                    },
                    delimiter: Delimiter,
                    image: {
                        class: ImageTool,
                        config: {
                            endpoints: {
                                byFile: '<?= UrlHelper::route('/upload-image') ?>',
                                byUrl: '<?= UrlHelper::route('/fetch-image') ?>'
                            },
                            field: 'image',
                            types: 'image/*'
                        }
                    },
                    embed: {
                        class: Embed,
                        inlineToolbar: true,
                        config: {
                            services: {
                                youtube: true,
                                coub: true,
                                facebook: true,
                                instagram: true,
                                twitter: true
                            }
                        }
                    },
                    warning: {
                        class: Warning,
                        inlineToolbar: true,
                        config: {
                            titlePlaceholder: 'Tiêu đề',
                            messagePlaceholder: 'Nội dung'
                        }
                    },
                },
                onReady: () => {
                    console.log('Editor.js is ready to work!');
                    // Display block count for debugging
                    console.log('Blocks count:', editor.blocks.getBlocksCount());
                },
                onChange: function() {
                    editor.save().then((outputData) => {
                        document.getElementById('content-data').value = JSON.stringify(outputData);
                    }).catch((error) => {
                        console.error('Saving failed: ', error);
                    });
                }
            });
        } catch (error) {
            console.error('Editor initialization failed:', error);
            document.getElementById('editorjs').innerHTML =
                `<div class="p-4 bg-red-50 border border-red-300 rounded text-red-700">
          <p class="font-bold">Lỗi khởi tạo trình soạn thảo</p>
          <p>${error.message}</p>
        </div>`;
        }

        // Form handling
        const form = document.getElementById('news-form');
        const saveDraftBtn = document.getElementById('save-draft-btn');
        const publishBtn = document.getElementById('publish-btn');
        const formAction = document.getElementById('form-action');
        const statusSelect = document.getElementById('status');

        saveDraftBtn.addEventListener('click', () => {
            formAction.value = 'draft';
            statusSelect.value = 'draft';
            form.submit();
        });

        publishBtn.addEventListener('click', () => {
            formAction.value = 'publish';
            statusSelect.value = 'published';
            form.submit();
        });

        // Featured image handling
        const featuredImageUpload = document.getElementById('featured-image-upload');
        const featuredImageInput = document.getElementById('featured_image');
        const featuredImagePreview = document.getElementById('featured-image-preview');
        const featuredImagePreviewImg = document.getElementById('featured-image-preview-img');
        const removeFeaturedImage = document.getElementById('remove-featured-image');
        const existingFeaturedImageInput = document.querySelector('input[name="existing_featured_image"]');

        featuredImageUpload.addEventListener('click', () => {
            featuredImageInput.click();
        });

        featuredImageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(event) {
                    featuredImagePreviewImg.src = event.target.result;
                    featuredImagePreview.classList.remove('hidden');
                    featuredImageUpload.classList.add('hidden');
                };

                reader.readAsDataURL(file);
            }
        });

        removeFeaturedImage.addEventListener('click', () => {
            featuredImageInput.value = '';
            featuredImagePreviewImg.src = '';
            featuredImagePreview.classList.add('hidden');
            featuredImageUpload.classList.remove('hidden');
            existingFeaturedImageInput.value = '';
        });

        // Slug generation
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const generateSlugBtn = document.getElementById('generate-slug');

        function createSlug(text) {
            return text
                .toString()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        generateSlugBtn.addEventListener('click', () => {
            if (titleInput.value) {
                slugInput.value = createSlug(titleInput.value);
            }
        });

        // Drag and drop for featured image
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            featuredImageUpload.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            featuredImageUpload.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            featuredImageUpload.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            featuredImageUpload.classList.add('border-teal-300', 'bg-teal-50');
        }

        function unhighlight() {
            featuredImageUpload.classList.remove('border-teal-300', 'bg-teal-50');
        }

        featuredImageUpload.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0 && files[0].type.match('image.*')) {
                featuredImageInput.files = files;
                const event = new Event('change');
                featuredImageInput.dispatchEvent(event);
            }
        }
    });
</script>
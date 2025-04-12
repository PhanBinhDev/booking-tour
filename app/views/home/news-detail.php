<?php
// filepath: c:\xampp\htdocs\project\app\views\home\news-detail.php
use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;

?>

<div class="min-h-screen flex flex-col bg-white">
    <!-- Hero section với ảnh nền blur -->
    <div class="relative bg-gradient-to-r from-teal-600 to-blue-600 text-white py-12">
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <img id="bg-blur-image" src="<?= $news['featured_image'] ?>" alt=""
                class="w-full h-full object-cover filter blur-md scale-105" onerror="this.style.display='none';">
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold mb-4 drop-shadow-sm"><?= $news['title'] ?></h1>

                <div class="flex flex-wrap items-center text-gray-100 text-sm mb-4">
                    <div class="flex items-center mr-4 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span><?= FormatHelper::formatDate($news["created_at"]) ?></span>
                    </div>
                    <div class="flex items-center mr-4 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Bởi Admin</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span><?= isset($news['views']) ? number_format($news['views']) : '0' ?> lượt xem</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nội dung chính -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Nội dung bài viết -->
            <article class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <div class="relative w-full h-[400px] mb-6 rounded-xl overflow-hidden bg-gray-100">
                        <!-- Placeholder hiển thị trước khi ảnh load -->
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400"
                            id="featured-image-placeholder">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30 mb-2" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <span class="text-gray-500">Đang tải ảnh...</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center text-gray-500 text-sm mb-6">
                            <div class="flex items-center mr-4 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span><?= FormatHelper::formatDate($news["created_at"]) ?></span>
                                <!-- Ảnh chính -->
                                <img src="<?= $news['featured_image'] ?>" alt="<?= $news['title'] ?>"
                                    class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300"
                                    onload="this.style.opacity='1'; document.getElementById('featured-image-placeholder').style.display='none';"
                                    onerror="handleImageError(this, 'featured-image-placeholder', '<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>');" />
                            </div>

                            <div class="prose max-w-none">
                                <?php if (is_string($news['content']) && json_decode($news['content'])): ?>
                                    <!-- EditorJS content container -->
                                    <div id="editorjs-container" class="mt-5"></div>
                                <?php else: ?>
                                    <p class="text-lg leading-relaxed mb-4">
                                        <?= $news['content'] ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Tags section if available -->
                            <?php if (isset($news['tags']) && !empty($news['tags'])): ?>
                                <div class="mt-8 pt-4 border-t border-gray-100">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $news['tags']) as $tag): ?>
                                            <a href="<?= UrlHelper::route('home/news?tag=' . urlencode(trim($tag))) ?>"
                                                class="bg-gray-100 hover:bg-teal-50 hover:text-teal-600 transition-colors text-gray-700 rounded-full px-3 py-1 text-sm">
                                                #<?= trim($tag) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Chia sẻ -->
                            <div class="mt-8 border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Chia sẻ bài viết này:
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    <!-- Facebook -->
                                    <a href="#" onclick="shareArticle('facebook')"
                                        class="share-btn flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                        </svg>
                                        Facebook
                                    </a>

                                    <!-- Twitter/X -->
                                    <a href="#" onclick="shareArticle('twitter')"
                                        class="share-btn flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                        </svg>
                                        Twitter
                                    </a>


                                    <!-- LinkedIn -->
                                    <a href="#" onclick="shareArticle('linkedin')"
                                        class="share-btn flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                                        </svg>
                                        LinkedIn
                                    </a>

                                    <!-- WhatsApp -->
                                    <a href="#" onclick="shareArticle('whatsapp')"
                                        class="share-btn flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                        </svg>
                                        WhatsApp
                                    </a>

                                    <!-- Email -->
                                    <a href="#" onclick="shareArticle('email')"
                                        class="share-btn flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Email
                                    </a>
                                    <!-- Copy link -->
                                    <button id="copy-link-btn"
                                        class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition-colors border border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Sao chép liên kết
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Phần bình luận nếu cần -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Bình luận (0)
                            </h3>

                            <!-- Form bình luận -->
                            <form class="mb-6">
                                <div class="mb-4">
                                    <textarea
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                        rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-5 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                        Gửi bình luận
                                    </button>
                                </div>
                            </form>

                            <!-- Thông báo chưa có bình luận -->
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <p class="text-gray-600">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                            </div>
                        </div>
            </article>

            <!-- Thanh bên -->
            <aside class="lg:w-1/3">
                <!-- Tác giả -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="relative w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="<?= UrlHelper::asset('images/admin-avatar.jpg') ?>"
                                onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=0D9488&color=fff'" alt="Admin"
                                class="absolute inset-0 w-full h-full object-cover" />
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Admin</h3>
                            <p class="text-gray-600">Quản trị viên Di Travel</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Chuyên chia sẻ thông tin du lịch, kinh nghiệm và cập nhật những điểm đến hấp dẫn nhất Việt Nam và thế giới.
                    </p>
                </div>

                <!-- Bài viết liên quan -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                    <h3 class="font-bold text-xl mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Bài viết liên quan
                    </h3>

                    <?php if (isset($relatedNews) && count($relatedNews) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($relatedNews as $related): ?>
                                <a href="<?= UrlHelper::route('home/news-detail/' . $related['id']) ?>"
                                    class="flex items-center hover:bg-gray-50 p-2 rounded-lg -mx-2 transition-colors">
                                    <div class="w-20 h-20 rounded-md overflow-hidden flex-shrink-0 bg-gray-100">
                                        <img src="<?= $related['featured_image'] ?>" alt="<?= $related['title'] ?>"
                                            class="w-full h-full object-cover"
                                            onerror="this.src='<?= UrlHelper::asset('images/placeholder-news.jpg') ?>'">
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h4 class="text-sm font-medium line-clamp-2"><?= $related['title'] ?></h4>
                                        <p class="text-xs text-gray-500 mt-1"><?= $related['created_at'] ?></p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm">Không có bài viết liên quan</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Danh mục -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                    <h3 class="font-bold text-xl mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Danh mục tin tức
                    </h3>

                    <?php if (isset($categories) && count($categories) > 0): ?>
                        <ul class="space-y-2">
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?= UrlHelper::route('home/news?category=' . $cat['id']) ?>"
                                        class="flex items-center justify-between px-3 py-2 hover:bg-teal-50 rounded-md transition-colors">
                                        <span><?= $cat['name'] ?></span>
                                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">
                                            <?= $cat['post_count'] ?? '0' ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-500 text-center">Không có danh mục nào</p>
                    <?php endif; ?>
                </div>


                <!-- Newsletter Subscribe -->
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-6 rounded-xl shadow-sm text-white">
                    <h3 class="font-bold text-xl mb-2">Nhận thông tin mới nhất</h3>
                    <p class="text-teal-100 text-sm mb-4">Đăng ký để nhận thông tin du lịch và ưu đãi mới nhất từ Di Travel</p>

                    <form class="space-y-3">
                        <div>
                            <input type="email" placeholder="Email của bạn"
                                class="w-full px-3 py-2 rounded-lg border-0 focus:ring-2 focus:ring-white/50 text-gray-800 text-sm">
                        </div>
                        <button type="submit"
                            class="w-full bg-white text-teal-600 font-medium py-2 rounded-lg hover:bg-teal-50 transition-colors">
                            Đăng ký ngay
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
    // Xử lý lỗi ảnh
    function handleImageError(img, placeholderId, title) {
        img.style.display = 'none';
        const placeholder = document.getElementById(placeholderId);
        if (placeholder) {
            placeholder.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-teal-500 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="text-gray-600 text-center px-4 font-medium">${title}</span>
            </div>
        `;
        }
    }

    // Xử lý chia sẻ bài viết
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý sao chép liên kết
        const copyLinkBtn = document.getElementById('copy-link-btn');

        copyLinkBtn.addEventListener('click', function() {
            const currentUrl = window.location.href;
            navigator.clipboard.writeText(currentUrl).then(function() {
                // Thay đổi nút khi sao chép thành công
                const originalText = copyLinkBtn.innerHTML;
                copyLinkBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Đã sao chép!
            `;
                copyLinkBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                copyLinkBtn.classList.add('bg-green-50', 'text-green-700', 'border-green-200');

                // Khôi phục nút sau 2 giây
                setTimeout(() => {
                    copyLinkBtn.innerHTML = originalText;
                    copyLinkBtn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                    copyLinkBtn.classList.remove('bg-green-50', 'text-green-700', 'border-green-200');
                }, 2000);
            }).catch(function(err) {
                console.error('Không thể sao chép liên kết: ', err);
                alert('Không thể sao chép liên kết. Vui lòng thử lại sau.');
            });
        });
    });

    function shareArticle(platform) {
        // Lấy thông tin hiện tại của bài viết
        const currentUrl = window.location.href;
        const articleTitle = document.querySelector('h1').innerText;
        const articleSummary = "Đọc bài viết này trên Di Travel: " + articleTitle;

        // Xác định URL chia sẻ dựa trên nền tảng
        let shareUrl;
        let windowFeatures = 'width=600,height=400,resizable=yes,scrollbars=yes,status=yes';

        switch (platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
                break;
            case 'twitter':
                shareUrl =
                    `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentUrl)}&text=${encodeURIComponent(articleTitle)}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(currentUrl)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(articleTitle + ' ' + currentUrl)}`;
                break;
            case 'email':
                shareUrl =
                    `mailto:?subject=${encodeURIComponent(articleTitle)}&body=${encodeURIComponent(articleSummary + '\n\n' + currentUrl)}`;
                window.location.href = shareUrl; // Email không cần popup
                return false;
            default:
                return false;
        }

        // Mở cửa sổ popup chia sẻ
        window.open(shareUrl, `share-${platform}`, windowFeatures);

        return false; // Ngăn chặn hành động mặc định của thẻ <a>
    }

    // Xử lý nội dung EditorJS nếu có
    if (document.getElementById('editorjs-container')) {
        try {
            const editorData = <?= is_string($news['content']) && json_decode($news['content']) ? $news['content'] : '{}' ?>;

            // Chỉ hiển thị nội dung, không cho phép chỉnh sửa
            const editorContainer = document.getElementById('editorjs-container');

            if (editorData && editorData.blocks) {
                editorData.blocks.forEach(block => {
                    let blockElement;

                    switch (block.type) {
                        case 'header':
                            blockElement = document.createElement(`h${block.data.level}`);
                            blockElement.textContent = block.data.text;
                            blockElement.className = 'mt-6 mb-4 font-bold text-gray-900';
                            break;

                        case 'paragraph':
                            blockElement = document.createElement('p');
                            blockElement.innerHTML = block.data.text;
                            blockElement.className = 'mb-4 text-gray-700 leading-relaxed';
                            break;

                        case 'image':
                            const figure = document.createElement('figure');
                            figure.className = 'my-5';

                            const img = document.createElement('img');
                            img.src = block.data.file.url;
                            img.alt = block.data.caption || '';
                            img.className = 'rounded-lg w-full';

                            figure.appendChild(img);

                            if (block.data.caption) {
                                const caption = document.createElement('figcaption');
                                caption.textContent = block.data.caption;
                                caption.className = 'text-sm text-center text-gray-500 mt-2';
                                figure.appendChild(caption);
                            }

                            blockElement = figure;
                            break;

                        case 'list':
                            blockElement = document.createElement(block.data.style === 'ordered' ? 'ol' : 'ul');
                            blockElement.className = 'mb-4 pl-5 ' + (block.data.style === 'ordered' ? 'list-decimal' : 'list-disc');

                            block.data.items.forEach(item => {
                                const li = document.createElement('li');
                                li.innerHTML = item;
                                li.className = 'mb-2 text-gray-700';
                                blockElement.appendChild(li);
                            });
                            break;

                        case 'quote':
                            const blockquote = document.createElement('blockquote');
                            blockquote.className = 'border-l-4 border-teal-500 pl-4 italic my-4';

                            const quoteText = document.createElement('p');
                            quoteText.innerHTML = block.data.text;
                            quoteText.className = 'text-gray-700';
                            blockquote.appendChild(quoteText);

                            if (block.data.caption) {
                                const cite = document.createElement('cite');
                                cite.textContent = '— ' + block.data.caption;
                                cite.className = 'block text-sm text-gray-500 mt-2 not-italic';
                                blockquote.appendChild(cite);
                            }

                            blockElement = blockquote;
                            break;

                        case 'delimiter':
                            blockElement = document.createElement('div');
                            blockElement.className = 'my-6 text-center';
                            blockElement.innerHTML = '<hr class="my-2 border-gray-200">';
                            break;

                        default:
                            blockElement = document.createElement('div');
                            blockElement.textContent = JSON.stringify(block.data);
                    }

                    if (blockElement) {
                        editorContainer.appendChild(blockElement);
                    }
                });
            }
        } catch (error) {
            console.error('Error rendering Editor.js content:', error);
        }
    }
</script>
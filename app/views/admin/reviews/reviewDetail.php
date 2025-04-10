<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;

?>

<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <!-- Assume sidebar is here -->
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <a href="<?= UrlHelper::route('admin/reviews') ?>" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-2xl font-semibold text-gray-800">Chi tiết Đánh Giá</h1>
            </div>
        </div>

        <!-- Review Edit Form -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-800">Thông tin đánh giá</h2>
                    <p class="text-sm text-gray-500">
                        <?php echo htmlspecialchars($getTourReviewById['id']); ?>
                    </p>
                </div>
            </div>

            <div class="py-6">
                <!-- Review Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ngày tạo</label>
                        <div class="text-base text-gray-900 bg-gray-100 px-3 py-2 rounded-md">
                            <?= FormatHelper::formatDate($getTourReviewById["created_at"]) ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cập nhật lần cuối</label>
                        <div class="text-base text-gray-900 bg-gray-100 px-3 py-2 rounded-md"><?= FormatHelper::formatDate($getTourReviewById["updated_at"]) ?></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <?php
                        $statusLabel = [
                            'approved' => 'Đã duyệt',
                            'rejected' => 'Từ chối',
                            'pending' => 'Chờ duyệt'
                        ][$getTourReviewById['status']] ?? '';
                        ?>
                        <div class="text-base text-gray-900 bg-gray-100 px-3 py-2 rounded-md"><?= $statusLabel ?></div>
                    </div>

                </div>

                <!-- Product Information -->
                <div class="mb-8">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Thông tin tour</h3>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-800"><?php echo htmlspecialchars($getTourReviewById['tour_title']); ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="mb-8">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Thông tin khách hàng</h3>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-800"><?php echo htmlspecialchars($getTourReviewById['full_name']); ?></h4>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($getTourReviewById['email']); ?></p>

                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            <?php
                            $rating = (int)$getTourReviewById['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>'; // viền trắng nếu không có sao
                                }
                            }
                            ?>
                        </div>
                        <span class="ml-2 text-sm text-gray-500">(<?php echo htmlspecialchars($getTourReviewById['rating']); ?>/5)</span>

                    </div>
                </div>

                <!-- Review Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                    <input disabled type="text" id="title" name="title" value="<?php echo htmlspecialchars($getTourReviewById['title']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>

                <!-- Review Content -->
                <div class="mb-8">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung đánh giá <span class="text-red-500">*</span></label>
                    <textarea disabled id="content" name="content" rows="5"
                        class="w-full rounded-md border-2 px-2 focus:outline-none border-gray-150 
                            shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 
                            focus:ring-opacity-20">
                    <?php echo htmlspecialchars($getTourReviewById['review']); ?>
                    </textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="<?= UrlHelper::route('admin/reviews') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                        Hủy
                    </a>
                    <form action="<?= UrlHelper::route('admin/reviews/updateStatus/' . $getTourReviewById['id']) ?>" method="POST">
                        <input type="hidden" name="review_id" value="<?= $getTourReviewById['id'] ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit"
                            class=" bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Từ chối
                        </button>
                    </form>
                    <form action="<?= UrlHelper::route('admin/reviews/updateStatus/' . $getTourReviewById['id']) ?>" method="POST">
                        <input type="hidden" name="review_id" value="<?= $getTourReviewById['id'] ?>">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit"
                            class=" bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Chấp nhận
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal (Hidden by default) -->
        <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Xác nhận thay đổi</h3>
                    <p class="text-gray-700 mb-6">Bạn có chắc chắn muốn lưu thay đổi cho đánh giá này?</p>

                    <div class="flex justify-end gap-3">
                        <button id="cancelConfirmation" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                            Hủy
                        </button>
                        <button id="confirmChange" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Xác nhận
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal (Hidden by default) -->
        <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Xác nhận xóa</h3>
                    <p class="text-gray-700 mb-6">Bạn có chắc chắn muốn xóa đánh giá này? Hành động này không thể hoàn tác.</p>

                    <div class="flex justify-end gap-3">
                        <button id="cancelDelete" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                            Hủy
                        </button>
                        <button id="confirmDelete" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </main>

    </div>
</div>

<!-- Assume footer is here -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editReviewForm = document.getElementById('editReviewForm');
        const ratingButtons = document.querySelectorAll('[data-rating]');
        const ratingInput = document.getElementById('rating');
        const confirmationModal = document.getElementById('confirmationModal');
        const cancelConfirmation = document.getElementById('cancelConfirmation');
        const confirmChange = document.getElementById('confirmChange');
        const deleteButton = document.getElementById('deleteButton');
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');

        // Handle star rating
        ratingButtons.forEach(button => {
            button.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;

                // Update stars UI
                ratingButtons.forEach((btn, index) => {
                    const star = btn.querySelector('i');
                    if (index < rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });

                // Update rating text
                const ratingText = document.querySelector('.ml-2.text-sm.text-gray-500');
                ratingText.textContent = `(${rating}/5)`;
            });
        });

        // Form submission
        editReviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            confirmationModal.classList.remove('hidden');
        });

        // Cancel confirmation
        cancelConfirmation.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
        });

        // Confirm changes
        confirmChange.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
            // Here you would normally submit the form or make an API call
            alert('Đánh giá đã được cập nhật thành công!');
            // Redirect back to reviews list
            // window.location.href = './reviews.html';
        });

        // Delete button
        deleteButton.addEventListener('click', function() {
            deleteConfirmationModal.classList.remove('hidden');
        });

        // Cancel delete
        cancelDelete.addEventListener('click', function() {
            deleteConfirmationModal.classList.add('hidden');
        });

        // Confirm delete
        confirmDelete.addEventListener('click', function() {
            deleteConfirmationModal.classList.add('hidden');
            // Here you would normally make an API call to delete the review
            alert('Đánh giá đã được xóa thành công!');
            // Redirect back to reviews list
            // window.location.href = './reviews.html';
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === confirmationModal) {
                confirmationModal.classList.add('hidden');
            }
            if (e.target === deleteConfirmationModal) {
                deleteConfirmationModal.classList.add('hidden');
            }
        });
    });
</script>
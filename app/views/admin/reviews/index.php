<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;
?>
<div class="content-wrapper">
    <div class="mx-auto py-6 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Quản Lý Đánh Giá Tour</h1>
        </div>
        <!-- Reviews Table -->

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tour
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Khách hàng
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Đánh giá
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tiêu đề
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày tạo
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hành động
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Review Item 1 -->
                    <?php foreach ($getTourReviews as $review) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo htmlspecialchars($review['id']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">

                                    <div class="ml">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($review['tour_title']); ?></div>

                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($review['full_name']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($review['email']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex text-yellow-400">
                                    <?php
                                    $rating = (int)$review['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>'; // viền trắng nếu không có sao
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate"><?php echo htmlspecialchars($review['review']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = [
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'pending' => 'bg-gray-100 text-gray-800'
                                ][$review["status"]] ?? 'bg-gray-100 text-gray-800';

                                $statusLabel = [
                                    'approved' => 'Đã duyệt',
                                    'rejected' => 'Từ chối',
                                    'pending' => 'Chờ duyệt'
                                ][$review["status"]] ?? $review["status"];
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($statusLabel); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= FormatHelper::formatDate($review["created_at"]) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-center gap-2">

                                    <a href="<?= UrlHelper::route('admin/reviews/reviewDetail/' . $review['id']) ?>" class="text-red-500 hover:text-red-700">
                                        <button class="text-gray-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="<?= UrlHelper::route('admin/reviews/deleteReview/' . $review['id']) ?>" class="text-red-500 hover:text-red-700"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                        <button class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Bulk Actions (Hidden by default) -->
    <div id="bulkActionsBar" class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200 py-3 px-6 hidden">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-4">Đã chọn <span id="selectedCount">0</span> đánh giá</span>
                <button id="bulkApprove" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg mr-2 transition-colors">
                    Duyệt
                </button>
                <button id="bulkReject" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mr-2 transition-colors">
                    Từ chối
                </button>
                <button id="bulkDelete" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Xóa
                </button>
            </div>
            <button id="cancelBulkAction" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i> Hủy
            </button>
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

<!-- Assume footer is here -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View Review Modal
        const viewLinks = document.querySelectorAll('.text-gray-500.hover\\:text-gray-700');
        const viewReviewModal = document.getElementById('viewReviewModal');
        const closeViewModal = document.getElementById('closeViewModal');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');

        viewLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                viewReviewModal.classList.remove('hidden');
            });
        });

        closeViewModal.addEventListener('click', function() {
            viewReviewModal.classList.add('hidden');
        });

        closeViewModalBtn.addEventListener('click', function() {
            viewReviewModal.classList.add('hidden');
        });

        // Delete Confirmation Modal
        const deleteLinks = document.querySelectorAll('.text-red-500.hover\\:text-red-700');
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                deleteConfirmationModal.classList.remove('hidden');
            });
        });

        cancelDelete.addEventListener('click', function() {
            deleteConfirmationModal.classList.add('hidden');
        });

        confirmDelete.addEventListener('click', function() {
            deleteConfirmationModal.classList.add('hidden');
            // Here you would normally make an API call to delete the review
            alert('Đánh giá đã được xóa thành công!');
            // Reload the page or update the UI
        });

        // Bulk Actions
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        const cancelBulkAction = document.getElementById('cancelBulkAction');

        // Example of how to show bulk actions bar (would be triggered by checkboxes)
        // Uncomment to test
        /*
        setTimeout(() => {
            bulkActionsBar.classList.remove('hidden');
            selectedCount.textContent = '3';
        }, 2000);
        */

        cancelBulkAction.addEventListener('click', function() {
            bulkActionsBar.classList.add('hidden');
            selectedCount.textContent = '0';
            // Here you would also uncheck all checkboxes
        });

        // Apply Filters
        const applyFilters = document.getElementById('applyFilters');

        applyFilters.addEventListener('click', function() {
            // Here you would collect all filter values and reload the page with those filters
            alert('Bộ lọc đã được áp dụng!');
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === viewReviewModal) {
                viewReviewModal.classList.add('hidden');
            }
            if (e.target === deleteConfirmationModal) {
                deleteConfirmationModal.classList.add('hidden');
            }
        });
    });
</script>
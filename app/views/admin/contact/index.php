<?php

use App\Helpers\UrlHelper;
?>
 
 <div> 
        <!-- Main Content -->
        <main class="flex-1 p-6 ml-64"> <!-- ml-64 assumes sidebar width is 16rem (64) -->
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Quản Lý Liên Hệ</h1>
                
            </div>
            
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" placeholder="Tìm kiếm theo số điện thoại..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Tất cả trạng thái</option>
                            <option value="new">New</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                            <option value="archived">Archived</option>
                        </select>
                        <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Lọc</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Contacts Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded text-teal-500 focus:ring-teal-500">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tên
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Số điện thoại
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tiêu đề
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nội dung
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Trạng thái
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ngày tạo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Contact Row 1 -->
                            <?php foreach($contacts as $item){?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="rounded text-teal-500 focus:ring-teal-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($item['id']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $item['name'] ?? '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $item['email'] ?? '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $item['phone'] ?? '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $item['subject'] ?? '' ?></div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900 truncate max-w-xs"><?= $item['message'] ?? '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?= $item['status'] ?? '' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500"><?= $item['created_at'] ?? '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-teal-500 hover:text-teal-700" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-blue-500 hover:text-blue-700" title="Đánh dấu đã đọc">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="text-red-500 hover:text-red-700" title="Lưu trữ">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>        

            <!-- Contact Detail Modal (Hidden by default) -->
            <div id="contactDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Chi tiết liên hệ</h2>
                            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">ID</p>
                                <p class="text-base text-gray-900"><?= $item['id'] ?? '' ?></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Trạng thái</p>
                                <p class="text-base">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Mới
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Tên</p>
                                <p class="text-base text-gray-900">Nguyễn Văn A</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                                <p class="text-base text-gray-900">nguyenvana@example.com</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Số điện thoại</p>
                                <p class="text-base text-gray-900">0912 345 678</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Ngày tạo</p>
                                <p class="text-base text-gray-900">15/05/2023 14:30</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Địa chỉ IP</p>
                                <p class="text-base text-gray-900">192.168.1.1</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Trình duyệt</p>
                                <p class="text-base text-gray-900 truncate">Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36</p>
                            </div>
                        </div>
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-500 mb-1">Tiêu đề</p>
                            <p class="text-base text-gray-900">Yêu cầu báo giá dịch vụ</p>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-500 mb-1">Nội dung</p>
                            <div class="p-4 bg-gray-50 rounded-lg text-base text-gray-900">
                                <p>Tôi muốn biết thêm thông tin về dịch vụ của quý công ty và yêu cầu báo giá chi tiết. Tôi đang quan tâm đến các gói dịch vụ sau:</p>
                                
                                <ul class="list-disc pl-5 mt-2">
                                    <li>Thiết kế website</li>
                                    <li>Dịch vụ SEO</li>
                                    <li>Quản lý mạng xã hội</li>
                                </ul>
                                
                                <p class="mt-2">Mong quý công ty phản hồi sớm để chúng tôi có thể thảo luận chi tiết hơn về nhu cầu và ngân sách. Xin cảm ơn!</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                                Đóng
                            </button>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Đánh dấu đã đọc
                            </button>
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Trả lời
                            </button>
                            <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Lưu trữ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>
    
    <!-- Assume footer is here -->
    
    <script>
        // Simple JavaScript for toggling checkboxes and modal
        document.addEventListener('DOMContentLoaded', function() {
            const mainCheckbox = document.querySelector('thead input[type="checkbox"]');
            const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            
            if (mainCheckbox) {
                mainCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = mainCheckbox.checked;
                    });
                });
            }
            
            // Modal functionality
            const viewButtons = document.querySelectorAll('button[title="Xem chi tiết"]');
            const contactDetailModal = document.getElementById('contactDetailModal');
            const closeModalButton = document.getElementById('closeModal');
            
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    contactDetailModal.classList.remove('hidden');
                });
            });
            
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function() {
                    contactDetailModal.classList.add('hidden');
                });
            }
            
            // Close modal when clicking outside
            contactDetailModal.addEventListener('click', function(e) {
                if (e.target === contactDetailModal) {
                    contactDetailModal.classList.add('hidden');
                }
            });
        });
    </script>

<?php

use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;
?>

<div>
  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
      <div class="flex items-center">
        <a href="<?= UrlHelper::route('admin/contacts') ?>" class="mr-4 text-gray-500 hover:text-teal-500">
          <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Chi tiết liên hệ</h1>
      </div>

      <!-- Action Buttons -->
      <div class="flex space-x-2">
        <?php if ($contact['status'] === 'new'): ?>
          <form action="<?= UrlHelper::route('admin/contacts/mark-read') ?>" method="POST" class="inline">
            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
            <button type="submit"
              class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-sm transition-colors">
              <i class="fas fa-check mr-1"></i> Đánh dấu đã đọc
            </button>
          </form>
        <?php endif; ?>

        <?php if ($contact['status'] !== 'archived'): ?>
          <a href="<?= UrlHelper::route('admin/contacts/reply/') ?><?= $contact['id'] ?>"
            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-md text-sm transition-colors inline-flex items-center">
            <i class="fas fa-reply mr-1"></i> Trả lời
          </a>

          <form action="<?= UrlHelper::route('admin/contacts/archive') ?>" method="POST" class="inline">
            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
            <button type="submit"
              class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1.5 rounded-md text-sm transition-colors">
              <i class="fas fa-archive mr-1"></i> Lưu trữ
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>

    <!-- Contact Information Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
      <div class="p-6">
        <!-- Status Badge -->
        <div class="mb-6 flex justify-end">
          <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    <?= $contact['status'] === 'new' ? 'bg-yellow-100 text-yellow-800' : ($contact['status'] === 'read' ? 'bg-blue-100 text-blue-800' : ($contact['status'] === 'replied' ? 'bg-green-100 text-green-800' :
                      'bg-gray-100 text-gray-800')) ?>">
            <?= htmlspecialchars($this->getStatusLabel($contact['status'])) ?>
          </span>
        </div>

        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div>
            <h3 class="text-lg font-medium text-gray-700 mb-4">Thông tin người gửi</h3>
            <div class="space-y-3">
              <div>
                <p class="text-sm font-medium text-gray-500">Tên</p>
                <p class="text-base text-gray-900"><?= htmlspecialchars($contact['name'] ?? 'N/A') ?></p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Email</p>
                <p class="text-base text-gray-900"><?= htmlspecialchars($contact['email'] ?? 'N/A') ?></p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Số điện thoại</p>
                <p class="text-base text-gray-900"><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></p>
              </div>
            </div>
          </div>

          <div>
            <h3 class="text-lg font-medium text-gray-700 mb-4">Thông tin hệ thống</h3>
            <div class="space-y-3">
              <div>
                <p class="text-sm font-medium text-gray-500">ID</p>
                <p class="text-base text-gray-900"><?= htmlspecialchars($contact['id'] ?? '') ?></p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Ngày tạo</p>
                <p class="text-base text-gray-900"><?= FormatHelper::formatDate($contact['created_at'] ?? '') ?></p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Địa chỉ IP</p>
                <p class="text-base text-gray-900"><?= htmlspecialchars($contact['ip_address'] ?? 'N/A') ?></p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Trình duyệt</p>
                <p class="text-base text-gray-900 break-words"><?= htmlspecialchars($contact['user_agent'] ?? 'N/A') ?>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Message Content -->
        <div>
          <h3 class="text-lg font-medium text-gray-700 mb-4">Nội dung liên hệ</h3>
          <div class="mb-5">
            <p class="text-sm font-medium text-gray-500 mb-2">Tiêu đề</p>
            <p class="text-base text-gray-900 font-medium"><?= htmlspecialchars($contact['subject'] ?? '') ?></p>
          </div>

          <div>
            <p class="text-sm font-medium text-gray-500 mb-2">Nội dung</p>
            <div class="p-4 bg-gray-50 rounded-lg text-base text-gray-900">
              <?= nl2br(htmlspecialchars($contact['message'] ?? '')) ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Response History (if needed for future feature) -->
    <?php if (!empty($responses)): ?>
      <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="p-6">
          <h3 class="text-lg font-medium text-gray-700 mb-4">Lịch sử phản hồi</h3>

          <div class="space-y-4">
            <?php foreach ($responses as $response): ?>
              <div class="border-l-4 border-teal-500 pl-4 py-2">
                <div class="flex justify-between items-start mb-2">
                  <div>
                    <p class="font-medium"><?= htmlspecialchars($response['admin_name']) ?></p>
                    <p class="text-sm text-gray-500"><?= FormatHelper::formatDate($response['created_at']) ?></p>
                  </div>
                </div>
                <div class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?= nl2br(htmlspecialchars($response['message'])) ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
</div>
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
        <a href="<?= UrlHelper::route('admin/contacts/view/') ?><?= $contact['id'] ?>"
          class="mr-4 text-gray-500 hover:text-teal-500">
          <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Trả lời liên hệ</h1>
      </div>
    </div>

    <!-- Contact Info Summary -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <p class="text-sm font-medium text-gray-500">Người gửi</p>
          <p class="text-base font-medium"><?= htmlspecialchars($contact['name'] ?? '') ?></p>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-500">Email</p>
          <p class="text-base"><?= htmlspecialchars($contact['email'] ?? '') ?></p>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-500">Ngày gửi</p>
          <p class="text-base text-gray-700"><?= FormatHelper::formatDate($contact['created_at'] ?? '') ?></p>
        </div>
      </div>
    </div>

    <!-- Original Message -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
      <h3 class="font-medium text-gray-700 mb-2">Nội dung ban đầu</h3>
      <div class="mb-2">
        <p class="text-sm font-medium text-gray-500">Tiêu đề</p>
        <p class="text-base font-medium"><?= htmlspecialchars($contact['subject'] ?? '') ?></p>
      </div>
      <div>
        <p class="text-sm font-medium text-gray-500 mb-1">Nội dung</p>
        <div class="p-3 bg-gray-50 rounded-lg text-sm text-gray-700 max-h-[200px] overflow-y-auto">
          <?= nl2br(htmlspecialchars($contact['message'] ?? '')) ?>
        </div>
      </div>
    </div>

    <!-- Reply Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
      <h2 class="text-lg font-medium text-gray-800 mb-4">Soạn trả lời</h2>

      <form action="<?= UrlHelper::route('admin/contacts/send-reply') ?>" method="POST">
        <input type="hidden" name="contact_id" value="<?= $contact['id'] ?>">
        <input type="hidden" name="recipient_email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
        <input type="hidden" name="recipient_name" value="<?= htmlspecialchars($contact['name'] ?? '') ?>">

        <div class="mb-4">
          <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
          <input type="text" id="subject" name="subject"
            value="Trả lời: <?= htmlspecialchars($contact['subject'] ?? '') ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            required>
        </div>

        <div class="mb-4">
          <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
          <textarea id="message" name="message" rows="10"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            required></textarea>
        </div>

        <div class="flex justify-end space-x-3">
          <a href="<?= UrlHelper::route('admin/contacts/view/') ?><?= $contact['id'] ?>"
            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            Hủy bỏ
          </a>
          <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-paper-plane mr-2"></i> Gửi phản hồi
          </button>
        </div>
      </form>
    </div>
  </main>
</div>
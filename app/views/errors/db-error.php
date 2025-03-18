<div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
  <div class="p-6">
    <div class="flex justify-center mb-6">
      <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Lỗi Kết Nối Cơ Sở Dữ Liệu</h1>
    <p class="text-gray-600 text-center mb-6">
      Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau hoặc liên hệ với quản trị viên.
    </p>
    <div class="flex justify-center">
      <a href="<?= isset($_ENV['APP_URL']) ? $_ENV['APP_URL'] : '/' ?>"
        class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7-7v14" />
        </svg>
        Quay lại trang chủ
      </a>
    </div>
  </div>
  <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
    <p class="text-sm text-gray-500 text-center">
      Nếu vấn đề vẫn tiếp tục, vui lòng liên hệ <a href="mailto:support@example.com"
        class="text-teal-600 hover:text-teal-800">support@example.com</a>
    </p>
  </div>
</div>
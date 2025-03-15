<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Lịch sử giao dịch
      </h2>
      <p class="mt-1 text-gray-600">Xem và quản lý các giao dịch thanh toán</p>
    </div>

    <div class="flex items-center gap-4">
      <div class="relative">
        <input type="text" id="search" placeholder="Tìm kiếm giao dịch..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute right-3 top-2.5" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>

      <button type="button" id="filterButton"
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
        Lọc
      </button>
    </div>
  </div>

  <!-- Transactions Table -->
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mã giao dịch
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Khách hàng
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Số tiền
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Phương thức
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Trạng thái
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thời gian
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thao tác
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($transactions['data'] as $transaction): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                <?= htmlspecialchars($transaction['transaction_code']) ?>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <div class="text-sm font-medium text-gray-900">
                    <?= htmlspecialchars($transaction['customer_name']) ?>
                  </div>
                  <div class="text-sm text-gray-500">
                    <?= htmlspecialchars($transaction['customer_email']) ?>
                  </div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                <?= number_format($transaction['amount'], 0, ',', '.') ?> đ
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                <?= htmlspecialchars($transaction['payment_method']) ?>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                <?php
                switch($transaction['status']) {
                  case 'completed':
                    echo 'bg-green-100 text-green-800';
                    break;
                  case 'pending':
                    echo 'bg-yellow-100 text-yellow-800';
                    break;
                  case 'failed':
                    echo 'bg-red-100 text-red-800';
                    break;
                  default:
                    echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?= htmlspecialchars(ucfirst($transaction['status'])) ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="<?= UrlHelper::route('admin/payment/transactions/' . $transaction['id']) ?>"
                class="text-teal-600 hover:text-teal-900">
                Chi tiết
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if($transactions['pagination']['total_pages'] > 1): ?>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
      <div class="flex-1 flex justify-between sm:hidden">
        <?php if($transactions['pagination']['current_page'] > 1): ?>
        <a href="?page=<?= $transactions['pagination']['current_page'] - 1 ?>"
          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Trước
        </a>
        <?php endif; ?>
        <?php if($transactions['pagination']['current_page'] < $transactions['pagination']['total_pages']): ?>
        <a href="?page=<?= $transactions['pagination']['current_page'] + 1 ?>"
          class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Sau
        </a>
        <?php endif; ?>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Hiển thị
            <span class="font-medium"><?= $transactions['pagination']['from'] ?></span>
            đến
            <span class="font-medium"><?= $transactions['pagination']['to'] ?></span>
            trong
            <span class="font-medium"><?= $transactions['pagination']['total'] ?></span>
            kết quả
          </p>
        </div>
        <div>
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <?php for($i = 1; $i <= $transactions['pagination']['total_pages']; $i++): ?>
            <a href="?page=<?= $i ?>"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 <?= $i === $transactions['pagination']['current_page'] ? 'z-10 bg-teal-50 border-teal-500 text-teal-600' : '' ?>">
              <?= $i ?>
            </a>
            <?php endfor; ?>
          </nav>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('search');
  let timeout = null;

  searchInput.addEventListener('input', function() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      const searchTerm = this.value;
      window.location.href = `<?= ADMIN_URL ?>/payment/transactions?search=${searchTerm}`;
    }, 500);
  });
});
</script>
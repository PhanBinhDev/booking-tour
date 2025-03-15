<?php
use App\Helpers\UrlHelper;
?>
<div class="container px-6 py-8 mx-auto">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
        Chi tiết yêu cầu hoàn tiền
      </h2>
      <p class="mt-1 text-gray-600">ID: #<?= $refund['id'] ?></p>
    </div>

    <div class="flex items-center gap-3">
      <?php if($refund['status'] === 'pending'): ?>
      <button type="button" onclick="processRefund(<?= $refund['id'] ?>, 'completed')"
        class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Chấp nhận hoàn tiền
      </button>

      <button type="button" onclick="processRefund(<?= $refund['id'] ?>, 'rejected')"
        class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        Từ chối
      </button>
      <?php endif; ?>
    </div>
  </div>

  <!-- Alert Messages -->
  <?php if(isset($_SESSION['success'])): ?>
  <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm text-green-700"><?= $_SESSION['success'] ?></p>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['success']); endif; ?>

  <!-- Refund Details -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Refund Information -->
    <div class="md:col-span-2">
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Thông tin yêu cầu hoàn tiền</h3>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
              <?php
              switch($refund['status']) {
                case 'completed':
                  echo 'bg-green-100 text-green-800';
                  break;
                case 'pending':
                  echo 'bg-yellow-100 text-yellow-800';
                  break;
                case 'rejected':
                  echo 'bg-red-100 text-red-800';
                  break;
                default:
                  echo 'bg-gray-100 text-gray-800';
              }
              ?>">
              <?php
              switch($refund['status']) {
                case 'completed':
                  echo 'Đã hoàn tiền';
                  break;
                case 'pending':
                  echo 'Đang xử lý';
                  break;
                case 'rejected':
                  echo 'Đã từ chối';
                  break;
                default:
                  echo ucfirst($refund['status']);
              }
              ?>
            </span>
          </div>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin khách hàng</h4>
              <p class="text-gray-800 font-medium"><?= htmlspecialchars($refund['customer_name']) ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($refund['customer_email']) ?></p>
              <p class="text-gray-600"><?= htmlspecialchars($refund['customer_phone'] ?? 'Không có') ?></p>
            </div>

            <div>
              <h4 class="text-sm font-medium text-gray-500 mb-2">Thông tin hoàn tiền</h4>
              <p class="text-gray-800">Số tiền hoàn: <span
                  class="font-medium"><?= number_format($refund['amount'], 0, ',', '.') ?> đ</span></p>
              <p class="text-gray-800">Giao dịch gốc: <span
                  class="font-medium"><?= htmlspecialchars($refund['transaction_code']) ?></span></p>
              <p class="text-gray-800">Số tiền giao dịch: <span
                  class="font-medium"><?= number_format($refund['transaction_amount'], 0, ',', '.') ?> đ</span></p>
              <p class="text-gray-800">Ngày yêu cầu: <span
                  class="font-medium"><?= date('d/m/Y H:i', strtotime($refund['created_at'])) ?></span></p>
              <?php if(!empty($refund['updated_at']) && $refund['status'] !== 'pending'): ?>
              <p class="text-gray-800">Ngày xử lý: <span
                  class="font-medium"><?= date('d/m/Y H:i', strtotime($refund['updated_at'])) ?></span></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Lý do hoàn tiền</h4>
          <p class="text-gray-800"><?= nl2br(htmlspecialchars($refund['reason'])) ?></p>
        </div>

        <?php if(!empty($refund['notes'])): ?>
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Ghi chú</h4>
          <p class="text-gray-600"><?= nl2br(htmlspecialchars($refund['notes'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if(!empty($refund['refund_data'])): ?>
        <div class="p-6 border-t border-gray-200">
          <h4 class="text-sm font-medium text-gray-500 mb-2">Dữ liệu hoàn tiền</h4>
          <pre
            class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 overflow-x-auto"><?= htmlspecialchars(json_encode(json_decode($refund['refund_data']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar -->
    <div>
      <!-- Status Actions -->
      <?php if($refund['status'] === 'pending'): ?>
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Xử lý yêu cầu</h3>
        </div>

        <div class="p-4">
          <form id="processForm" action="<?= UrlHelper::route('admin/payment/refunds/process/' . $refund['id']) ?>"
            method="POST">
            <?php $this->createCSRFToken(); ?>
            <input type="hidden" id="status" name="status" value="">

            <div class="mb-4">
              <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
              <textarea id="notes" name="notes" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <button type="button" onclick="submitForm('completed')"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
                Chấp nhận
              </button>

              <button type="button" onclick="submitForm('rejected')"
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
                Từ chối
              </button>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Related Transaction -->
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Giao dịch liên quan</h3>
        </div>

        <div class="p-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Mã giao dịch:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= htmlspecialchars($transaction['transaction_code']) ?></span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Số tiền:</span>
            <span class="text-sm font-medium text-gray-800"><?= number_format($transaction['amount'], 0, ',', '.') ?>
              đ</span>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500">Trạng thái:</span>
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
          </div>

          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">Ngày giao dịch:</span>
            <span
              class="text-sm font-medium text-gray-800"><?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?></span>
          </div>

          <a href="<?= UrlHelper::route('admin/payment/transactions/' . $transaction['id']) ?>"
            class="w-full inline-flex items-center justify-center px-4 py-2 border border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors">
            Xem chi tiết giao dịch
          </a>
        </div>
      </div>

      <!-- Activity Log -->
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Lịch sử hoạt động</h3>
        </div>

        <div class="p-4">
          <?php if(!empty($activities)): ?>
          <div class="space-y-4">
            <?php foreach($activities as $activity): ?>
            <div class="flex">
              <div class="flex-shrink-0 mr-3">
                <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-800"><?= htmlspecialchars($activity['description']) ?></p>
                <p class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <p class="text-sm text-gray-500">Chưa có hoạt động nào được ghi lại.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function submitForm(status) {
  document.getElementById('status').value = status;
  document.getElementById('processForm').submit();
}

function processRefund(id, status) {
  const statusText = status === 'completed' ? 'chấp nhận' : 'từ chối';
  if (confirm(`Bạn có chắc chắn muốn ${statusText} yêu cầu hoàn tiền này?`)) {
    fetch(`<?= ADMIN_URL ?>/payment/refunds/process/${id}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          status: status
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.reload();
        } else {
          alert('Có lỗi xảy ra. Vui lòng thử lại.');
        }
      });
  }
}
</script>
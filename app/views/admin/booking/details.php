<?php
// filepath: c:\xampp\htdocs\project\app\views\admin\booking-details.php
use App\Helpers\UrlHelper;
use App\Helpers\FormatHelper;

$title = 'Chi tiết đặt tour';
?>

<div class="content-wrapper">
  <div class="mx-auto py-6 px-4">
    <!-- Breadcrumb + Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
      <div>
        <div class="flex items-center text-sm text-gray-500 mb-2">
          <a href="<?= UrlHelper::route('admin/dashboard') ?>" class="hover:text-teal-600">Dashboard</a>
          <span class="mx-2">/</span>
          <a href="<?= UrlHelper::route('admin/bookings') ?>" class="hover:text-teal-600">Đặt tour</a>
          <span class="mx-2">/</span>
          <span>Chi tiết đặt tour</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
          Chi tiết đặt tour #<?= $booking['booking_number'] ?>
        </h1>
      </div>

      <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
        <?php if ($booking['booking_status'] !== 'cancelled'): ?>
        <button id="btn-change-status" data-id="<?= $booking['id'] ?>"
          data-current-status="<?= $booking['booking_status'] ?>"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm flex items-center">
          <i class="fas fa-exchange-alt mr-2"></i> Đổi trạng thái
        </button>

        <?php if ($booking['payment_status'] !== 'paid'): ?>
        <button id="btn-mark-paid" data-id="<?= $booking['id'] ?>"
          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow-sm flex items-center">
          <i class="fas fa-check-circle mr-2"></i> Đánh dấu đã thanh toán
        </button>
        <?php endif; ?>
        <?php endif; ?>

      </div>
    </div>

    <!-- Booking Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <!-- Card 1: Status -->
      <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500 mb-1">Trạng thái đặt tour</p>
            <div class="text-lg font-semibold">
              <?= renderBookingStatus($booking['booking_status']) ?>
            </div>
          </div>
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-clipboard-check text-xl text-blue-600"></i>
          </div>
        </div>
      </div>

      <!-- Card 2: Payment Status -->
      <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500 mb-1">Trạng thái thanh toán</p>
            <div class="text-lg font-semibold">
              <?= renderPaymentStatus($booking['payment_status']) ?>
            </div>
          </div>
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-money-bill-wave text-xl text-green-600"></i>
          </div>
        </div>
      </div>

      <!-- Card 3: Total Amount -->
      <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500 mb-1">Tổng tiền</p>
            <div class="text-lg font-semibold">
              <?= FormatHelper::formatCurrency($booking['total_price']) ?>
            </div>
          </div>
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-tag text-xl text-purple-600"></i>
          </div>
        </div>
      </div>

      <!-- Card 4: Created Date -->
      <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500 mb-1">Ngày đặt tour</p>
            <div class="text-lg font-semibold">
              <?= FormatHelper::formatDate($booking['created_at']) ?>
            </div>
          </div>
          <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fas fa-calendar-alt text-xl text-yellow-600"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column: Tour Details and Booking Details -->
      <div class="lg:col-span-2 space-y-6">

        <!-- Tour Details -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-800">Thông tin tour</h2>
          </div>

          <div class="px-6 py-4">
            <div class="flex flex-wrap md:flex-nowrap gap-4">
              <!-- Tour Image -->
              <div class="w-full md:w-1/3">
                <img src="<?= UrlHelper::image($tour['thumbnail'] ?? 'placeholder.jpg') ?>" alt="<?= $tour['title'] ?>"
                  class="w-full h-40 object-cover rounded">
              </div>

              <!-- Tour Info -->
              <div class="w-full md:w-2/3">
                <h3 class="text-xl font-semibold mb-2"><?= $tour['title'] ?></h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                  <div>
                    <p class="text-gray-600 flex items-center">
                      <i class="fas fa-calendar-day w-5 text-teal-600"></i>
                      <span class="ml-2">Thời gian: <?= $tour['duration'] ?></span>
                    </p>
                    <p class="text-gray-600 flex items-center mt-1">
                      <i class="fas fa-map-marker-alt w-5 text-teal-600"></i>
                      <span class="ml-2">Điểm đến: <?= $tour['destination'] ?></span>
                    </p>
                    <p class="text-gray-600 flex items-center mt-1">
                      <i class="fas fa-tags w-5 text-teal-600"></i>
                      <span class="ml-2">Loại tour: <?= $tour['category_name'] ?></span>
                    </p>
                  </div>

                  <div>
                    <p class="text-gray-600 flex items-center">
                      <i class="fas fa-calendar-alt w-5 text-teal-600"></i>
                      <span class="ml-2">Ngày khởi hành:
                        <?= FormatHelper::formatDate($booking['tour_start_date']) ?></span>
                    </p>
                    <p class="text-gray-600 flex items-center mt-1">
                      <i class="fas fa-users w-5 text-teal-600"></i>
                      <span class="ml-2">Số người: <?= $booking['adults'] ?> người lớn, <?= $booking['children'] ?> trẻ
                        em</span>
                    </p>
                    <p class="text-gray-600 flex items-center mt-1">
                      <i class="fas fa-money-bill-wave w-5 text-teal-600"></i>
                      <span class="ml-2">Giá: <?= FormatHelper::formatCurrency($tour['price']) ?>/người</span>
                    </p>
                  </div>
                </div>

                <!-- Tour actions -->
                <div class="mt-4">
                  <a href="<?= UrlHelper::route('admin/tours/edit/' . $tour['id']) ?>"
                    class="text-teal-600 hover:text-teal-800 text-sm flex items-center">
                    <i class="fas fa-external-link-alt mr-1"></i> Xem chi tiết tour
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-800">Chi tiết đặt tour</h2>
          </div>

          <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Left Details -->
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">THÔNG TIN ĐẶT TOUR</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Mã đặt tour:</span>
                    <span class="font-medium"><?= $booking['booking_number'] ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Ngày đặt tour:</span>
                    <span><?= FormatHelper::formatDate($booking['created_at']) ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Trạng thái:</span>
                    <span><?= renderBookingStatus($booking['booking_status']) ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Số người:</span>
                    <span><?= $booking['adults'] + $booking['children'] ?>
                      (x<?= FormatHelper::formatCurrency($tour['price']) ?>)</span>
                  </div>
                  <div class="flex justify-between font-semibold">
                    <span>Tổng tiền:</span>
                    <span class="text-teal-600"><?= FormatHelper::formatCurrency($booking['total_price']) ?></span>
                  </div>
                </div>
              </div>

              <!-- Right Details -->
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">THANH TOÁN</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Phương thức thanh toán:</span>
                    <span class="font-medium"><?= $booking['payment_method'] ?? 'Chuyển khoản ngân hàng' ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Trạng thái thanh toán:</span>
                    <span><?= renderPaymentStatus($booking['payment_status']) ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Ngày thanh toán:</span>
                    <span><?= $latest_payment['payment_date'] ? FormatHelper::formatDate($latest_payment['payment_date']) : 'Chưa thanh toán' ?></span>
                  </div>
                  <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Mã giao dịch:</span>
                    <span><?= $booking['transaction_id'] ?? 'N/A' ?></span>
                  </div>

                  <?php if (!empty($booking['notes'])): ?>
                  <div class="mt-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">GHI CHÚ</h3>
                    <div class="bg-gray-50 p-3 rounded text-gray-700 text-sm">
                      <?= nl2br(htmlspecialchars($booking['notes'])) ?>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Customer Info and History -->
      <div class="space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-800">Thông tin khách hàng</h2>
            <?php if (!empty($customer['id'])): ?>
            <a href="<?= UrlHelper::route('admin/customers/view/' . $customer['id']) ?>"
              class="text-teal-600 hover:text-teal-800 text-sm flex items-center">
              <i class="fas fa-external-link-alt mr-1"></i> Xem
            </a>
            <?php endif; ?>
          </div>

          <div class="px-6 py-4">
            <div class="flex items-center space-x-4 mb-4">
              <div class="bg-gray-100 rounded-full p-2">
                <i class="fas fa-user text-xl text-gray-500"></i>
              </div>
              <div>
                <h3 class="font-medium"><?= $customer['full_name'] ?? $booking['customer_name'] ?></h3>
                <p class="text-sm text-gray-500">
                  <?= !empty($customer['id']) ? 'Khách hàng đã đăng ký' : 'Khách hàng chưa đăng ký' ?>
                </p>
              </div>
            </div>

            <div class="space-y-2 text-sm">
              <div class="flex items-center">
                <i class="fas fa-envelope w-5 text-gray-400"></i>
                <span class="ml-2"><?= $customer['email'] ?? $booking['customer_email'] ?></span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-phone w-5 text-gray-400"></i>
                <span class="ml-2"><?= $customer['phone'] ?? $booking['customer_phone'] ?></span>
              </div>
              <?php if (!empty($customer['address']) || !empty($booking['customer_address'])): ?>
              <div class="flex items-center">
                <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                <span class="ml-2"><?= $customer['address'] ?? $booking['customer_address'] ?></span>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Booking History -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-800">Lịch sử đặt tour</h2>
          </div>

          <div class="px-6 py-4">
            <?php if (!empty($bookingHistory)): ?>
            <div class="relative">
              <!-- Vertical timeline line -->
              <div class="absolute left-3 top-0 h-full border-l-2 border-gray-200"></div>

              <!-- Timeline items -->
              <div class="space-y-4">
                <?php foreach ($bookingHistory as $history): ?>
                <div class="flex items-start">
                  <div class="bg-<?= getStatusColor($history['status']) ?>-100 rounded-full p-1 mr-4 z-10">
                    <i class="fas fa-circle text-<?= getStatusColor($history['status']) ?>-500 text-xs"></i>
                  </div>
                  <div class="flex-1">
                    <div class="flex justify-between">
                      <p class="font-medium text-sm">
                        <?= getStatusText($history['status']) ?>
                      </p>
                      <p class="text-xs text-gray-500"><?= FormatHelper::formatDate($history['created_at']) ?></p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1"><?= $history['description'] ?></p>
                    <?php if (!empty($history['admin_name'])): ?>
                    <p class="text-xs text-gray-500 mt-1">Bởi: <?= $history['admin_name'] ?></p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <div class="text-center text-gray-500 py-4">Không có lịch sử đặt tour</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal đổi trạng thái - Tái sử dụng từ trang Bookings -->
<div id="change-status-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
  role="dialog" aria-modal="true">
  <!-- Sử dụng lại modal từ trang bookings.php -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Kết nối nút đổi trạng thái với modal
  const btnChangeStatus = document.getElementById('btn-change-status');
  const modal = document.getElementById('change-status-modal');

  if (btnChangeStatus) {
    btnChangeStatus.addEventListener('click', function() {
      const bookingId = this.dataset.id;
      const currentStatus = this.dataset.currentStatus;

      // Thiết lập các giá trị cho modal
      document.getElementById('hidden-status').value = currentStatus;
      currentBookingId = bookingId;

      // Hiển thị modal
      modal.style.display = 'block';
      modal.classList.remove('hidden');
    });
  }

  // Xử lý nút đánh dấu đã thanh toán
  const btnMarkPaid = document.getElementById('btn-mark-paid');
  if (btnMarkPaid) {
    btnMarkPaid.addEventListener('click', function() {
      const bookingId = this.dataset.id;

      if (confirm('Bạn có chắc chắn muốn đánh dấu đơn hàng này là đã thanh toán?')) {
        fetch(`<?= UrlHelper::route('admin/bookings/updatePaymentStatus') ?>`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              id: bookingId,
              status: 'paid'
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert('Có lỗi xảy ra khi cập nhật trạng thái thanh toán.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật trạng thái thanh toán.');
          });
      }
    });
  }
});
</script>

<?php
// Helper functions for getting status color

function renderBookingStatus($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ xử lý</span>';
    case 'confirmed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Đã xác nhận</span>';
    case 'cancelled':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>';
    case 'completed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã hoàn thành</span>';
    case 'refunded':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Đã hoàn tiền</span>';
    case 'in_progress':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Đang diễn ra</span>';
    default:
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
  }
}

function renderPaymentStatus($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ thanh toán</span>';
    case 'paid':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã thanh toán</span>';
    case 'failed':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Thanh toán thất bại</span>';
    case 'refunded':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Đã hoàn tiền</span>';
    case 'partial':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Thanh toán một phần</span>';
    case 'processing':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Đang xử lý</span>';
    case 'cancelled':
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>';
    default:
      return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
  }
}
function getStatusColor($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return 'yellow';
    case 'confirmed':
      return 'blue';
    case 'cancelled':
      return 'red';
    case 'completed':
      return 'green';
    case 'refunded':
      return 'purple';
    case 'paid':
      return 'green';
    case 'failed':
      return 'red';
    default:
      return 'gray';
  }
}

// Helper function for getting status text
function getStatusText($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return 'Chờ xử lý';
    case 'confirmed':
      return 'Đã xác nhận';
    case 'cancelled':
      return 'Đã hủy';
    case 'completed':
      return 'Hoàn thành';
    case 'refunded':
      return 'Đã hoàn tiền';
    case 'paid':
      return 'Đã thanh toán';
    case 'failed':
      return 'Thất bại';
    default:
      return ucfirst($status);
  }
}
?>
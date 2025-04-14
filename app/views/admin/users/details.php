<?php

use App\Helpers\UrlHelper;

// Helper functions
function getRoleBadgeClass($roleName)
{
  $classes = [
    'admin' => 'bg-red-100 text-red-800',
    'moderator' => 'bg-yellow-100 text-yellow-800',
    'editor' => 'bg-blue-100 text-blue-800',
    'user' => 'bg-green-100 text-green-800'
  ];

  return $classes[strtolower($roleName)] ?? 'bg-gray-100 text-gray-800';
}

function getStatusBadgeClass($status)
{
  $classes = [
    'active' => 'bg-green-100 text-green-800',
    'inactive' => 'bg-gray-100 text-gray-800',
    'banned' => 'bg-red-100 text-red-800'
  ];

  return $classes[$status] ?? 'bg-gray-100 text-gray-800';
}

function getBookingStatusBadge($status)
{
  $classes = [
    'pending' => 'bg-yellow-100 text-yellow-800',
    'confirmed' => 'bg-blue-100 text-blue-800',
    'completed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
  ];

  $labels = [
    'pending' => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'completed' => 'Hoàn thành',
    'cancelled' => 'Đã hủy',
  ];

  $class = $classes[$status] ?? 'bg-gray-100 text-gray-800';
  $label = $labels[$status] ?? ucfirst($status);

  return "<span class=\"px-2 py-1 text-xs font-medium rounded-full $class\">$label</span>";
}

function getPaymentStatusBadge($status)
{
  $classes = [
    'paid' => 'bg-green-100 text-green-800',
    'pending' => 'bg-yellow-100 text-yellow-800',
    'refunded' => 'bg-purple-100 text-purple-800',
    'failed' => 'bg-red-100 text-red-800',
  ];

  $labels = [
    'paid' => 'Đã thanh toán',
    'pending' => 'Chờ thanh toán',
    'refunded' => 'Đã hoàn tiền',
    'failed' => 'Thanh toán thất bại',
  ];

  $class = $classes[$status] ?? 'bg-gray-100 text-gray-800';
  $label = $labels[$status] ?? ucfirst($status);

  return "<span class=\"px-2 py-1 text-xs font-medium rounded-full $class\">$label</span>";
}


// Format user data
$lastLoginDate = $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Chưa đăng nhập';
$createdDate = date('d/m/Y H:i', strtotime($user['created_at']));
$updatedDate = date('d/m/Y H:i', strtotime($user['updated_at']));

$roleBadgeClass = getRoleBadgeClass($user['role_name']);
$statusBadgeClass = getStatusBadgeClass($user['status']);
?>

<div class="container px-6 py-8 mx-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <div class="flex items-center">
      <a href="<?= UrlHelper::route('admin/users') ?>" class="mr-3 text-gray-500 hover:text-gray-700">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h3 class="text-2xl font-bold text-gray-700">Chi tiết người dùng</h3>
    </div>

    <div class="flex space-x-3">
      <a href="<?= UrlHelper::route('admin/users/edit/' . $user['id']) ?>"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-edit mr-2"></i> Chỉnh sửa
      </a>

      <!-- Thay thế nút xóa hiện tại (dòng 90-95) bằng các nút quản lý trạng thái -->
      <?php if ($user['id'] != $_SESSION['user_id']): ?>
      <?php if ($user['status'] === 'active'): ?>
      <div class="flex space-x-2">
        <button id="deactivateUserBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded"
          data-id="<?= $user['id'] ?>" data-name="<?= $user['username'] ?>" data-action="inactive">
          <i class="fas fa-user-slash mr-2"></i> Vô hiệu hóa
        </button>
        <button id="banUserBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
          data-id="<?= $user['id'] ?>" data-name="<?= $user['username'] ?>" data-action="banned">
          <i class="fas fa-ban mr-2"></i> Cấm tài khoản
        </button>
      </div>
      <?php elseif ($user['status'] === 'inactive'): ?>
      <div class="flex space-x-2">
        <button id="activateUserBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
          data-id="<?= $user['id'] ?>" data-name="<?= $user['username'] ?>" data-action="active">
          <i class="fas fa-user-check mr-2"></i> Kích hoạt lại
        </button>
        <button id="banUserBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
          data-id="<?= $user['id'] ?>" data-name="<?= $user['username'] ?>" data-action="banned">
          <i class="fas fa-ban mr-2"></i> Cấm tài khoản
        </button>
      </div>
      <?php elseif ($user['status'] === 'banned'): ?>
      <button id="unbanUserBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
        data-id="<?= $user['id'] ?>" data-name="<?= $user['username'] ?>" data-action="active">
        <i class="fas fa-user-check mr-2"></i> Gỡ cấm
      </button>
      <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Thông tin cơ bản -->
    <div class="md:col-span-1">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex flex-col items-center mb-6">
          <?php if (!empty($user['avatar'])): ?>
          <img src="<?= $user['avatar'] ?>" alt="<?= $user['username'] ?>"
            class="h-32 w-32 rounded-full object-cover mb-4 user-avatar"
            onerror="handleUserAvatarError(this, '<?= htmlspecialchars($user['username'], ENT_QUOTES) ?>');">
          <?php else: ?>
          <div
            class="h-32 w-32 rounded-full bg-teal-500 flex items-center justify-center text-white text-4xl font-bold mb-4">
            <?= strtoupper(substr($user['username'], 0, 1)) ?>
          </div>
          <?php endif; ?>

          <h2 class="text-xl font-bold text-gray-800"><?= $user['full_name'] ?: $user['username'] ?></h2>
          <p class="text-gray-500">@<?= $user['username'] ?></p>

          <div class="flex mt-3">
            <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $roleBadgeClass ?> mr-2">
              <?= $user['role_name'] ?>
            </span>
            <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusBadgeClass ?>">
              <?= $user['status'] === 'active' ? 'Hoạt động' : ($user['status'] === 'inactive' ? 'Không hoạt động' : 'Bị cấm') ?>
            </span>
          </div>
        </div>

        <div class="space-y-4">
          <div class="border-t border-gray-100 pt-4">
            <h3 class="text-sm font-medium text-gray-500 mb-3">THÔNG TIN LIÊN HỆ</h3>

            <div class="space-y-3 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Email:</span>
                <span class="font-medium"><?= $user['email'] ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Điện thoại:</span>
                <span class="font-medium"><?= $user['phone'] ?: 'Chưa cập nhật' ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Địa chỉ:</span>
                <span class="font-medium"><?= $user['address'] ?: 'Chưa cập nhật' ?></span>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-4">
            <h3 class="text-sm font-medium text-gray-500 mb-3">THÔNG TIN TÀI KHOẢN</h3>

            <div class="space-y-3 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Ngày tham gia:</span>
                <span class="font-medium"><?= $createdDate ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Lần cập nhật cuối:</span>
                <span class="font-medium"><?= $updatedDate ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Đăng nhập cuối:</span>
                <span class="font-medium"><?= $lastLoginDate ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Email xác thực:</span>
                <span class="font-medium">
                  <?php if (isset($user['email_verified']) && $user['email_verified']): ?>
                  <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Đã xác thực</span>
                  <?php else: ?>
                  <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i>Chưa xác thực</span>
                  <?php endif; ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Thống kê và thông tin bổ sung -->
    <div class="md:col-span-2">
      <!-- Thống kê hoạt động -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Thống kê hoạt động</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500 text-xs uppercase font-medium">Tổng đặt tour</p>
            <p class="text-2xl font-bold text-teal-600"><?= $user['stats']['total_bookings'] ?></p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500 text-xs uppercase font-medium">Tour hoàn thành</p>
            <p class="text-2xl font-bold text-blue-600"><?= $user['stats']['completed_bookings'] ?></p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500 text-xs uppercase font-medium">Đánh giá</p>
            <p class="text-2xl font-bold text-purple-600"><?= $user['stats']['review_count'] ?></p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500 text-xs uppercase font-medium">Điểm đánh giá TB</p>
            <p class="text-2xl font-bold text-amber-600"><?= number_format($user['stats']['average_rating'], 1) ?></p>
          </div>
        </div>
      </div>

      <!-- Danh sách booking gần đây -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-700">Đơn đặt tour gần đây</h3>
          <a href="<?= UrlHelper::route('admin/bookings') . '?user_id=' . $user['id'] ?>"
            class="text-teal-600 hover:text-teal-800 text-sm font-medium">
            Xem tất cả <i class="fas fa-chevron-right ml-1"></i>
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  ID</th>
                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tour</th>
                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Ngày đặt</th>
                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Trạng thái</th>
                <th scope="col"
                  class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (!empty($user['recent_bookings'])): ?>
              <?php foreach ($user['recent_bookings'] as $booking): ?>
              <tr>
                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                  <?= $booking['booking_number'] ?>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                  <div class="flex items-center">
                    <?php if ($booking['thumbnail']): ?>
                    <div class="relative h-8 w-10 mr-2">
                      <img src="<?= $booking['thumbnail'] ?>"
                        alt="<?= htmlspecialchars($booking['tour_title'], ENT_QUOTES) ?>"
                        class="h-8 w-10 object-cover rounded booking-thumbnail" data-id="<?= $booking['id'] ?>"
                        data-title="<?= htmlspecialchars($booking['tour_title'], ENT_QUOTES) ?>"
                        onerror="handleBookingThumbnailError(this, <?= $booking['id'] ?>, '<?= htmlspecialchars($booking['tour_title'], ENT_QUOTES) ?>')">
                    </div>
                    <?php else: ?>
                    <div id="booking-placeholder-<?= $booking['id'] ?>"
                      class="h-8 w-10 bg-gray-100 rounded flex items-center justify-center mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                      </svg>
                    </div>
                    <?php endif; ?>
                    <div>
                      <div class="text-gray-900"><?= $booking['tour_title'] ?></div>
                      <div class="text-gray-500 text-xs">
                        <?= number_format($booking['total_price'], 0, ',', '.') ?> đ
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                  <?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                  <div class="flex flex-col space-y-1">
                    <?= getBookingStatusBadge($booking['status']) ?>
                    <?= getPaymentStatusBadge($booking['payment_status']) ?>
                  </div>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm text-center">
                  <a href="<?= UrlHelper::route('admin/bookings/' . $booking['id']) ?>"
                    class="text-teal-600 hover:text-teal-900">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="5" class="px-3 py-4 text-sm text-center text-gray-500">
                  Chưa có đơn đặt tour nào
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Đánh giá gần đây -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-700">Đánh giá gần đây</h3>
          <a href="<?= UrlHelper::route('admin/reviews') . '?user_id=' . $user['id'] ?>"
            class="text-teal-600 hover:text-teal-800 text-sm font-medium">
            Xem tất cả <i class="fas fa-chevron-right ml-1"></i>
          </a>
        </div>
        <div class="space-y-4">
          <?php if (!empty($user['recent_reviews'])): ?>
          <?php foreach ($user['recent_reviews'] as $review): ?>
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex justify-between mb-2">
              <div class="flex">
                <div class="mr-3 relative">
                  <?php if ($review['thumbnail']): ?>
                  <img src="<?= $review['thumbnail'] ?>"
                    alt="<?= htmlspecialchars($review['tour_title'], ENT_QUOTES) ?>"
                    class="h-12 w-16 object-cover rounded review-thumbnail" data-id="<?= $review['id'] ?>"
                    data-title="<?= htmlspecialchars($review['tour_title'], ENT_QUOTES) ?>"
                    onerror="handleReviewThumbnailError(this, <?= $review['id'] ?>, '<?= htmlspecialchars($review['tour_title'], ENT_QUOTES) ?>')">
                  <?php else: ?>
                  <div id="review-placeholder-<?= $review['id'] ?>"
                    class="h-12 w-16 bg-gray-200 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24"
                      fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round">
                      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                      <polyline points="14 2 14 8 20 8"></polyline>
                      <line x1="16" y1="13" x2="8" y2="13"></line>
                      <line x1="16" y1="17" x2="8" y2="17"></line>
                      <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                  </div>
                  <?php endif; ?>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900"><?= $review['tour_title'] ?></h4>
                  <div class="flex items-center text-yellow-400 mt-1">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i
                      class="fas fa-star <?= ($i <= $review['rating']) ? 'text-yellow-400' : 'text-gray-300' ?> text-xs"></i>
                    <?php endfor; ?>
                    <span class="ml-1 text-xs text-gray-500">
                      <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                    </span>
                  </div>
                </div>
              </div>

              <div>
                <?php
                    $statusClass = '';
                    $statusText = '';

                    switch ($review['status']) {
                      case 'approved':
                        $statusClass = 'bg-green-100 text-green-800';
                        $statusText = 'Đã duyệt';
                        break;
                      case 'pending':
                        $statusClass = 'bg-yellow-100 text-yellow-800';
                        $statusText = 'Chờ duyệt';
                        break;
                      case 'rejected':
                        $statusClass = 'bg-red-100 text-red-800';
                        $statusText = 'Từ chối';
                        break;
                    }
                    ?>
                <span class="px-2 py-1 text-xs font-medium rounded-full <?= $statusClass ?>">
                  <?= $statusText ?>
                </span>
              </div>
            </div>

            <div class="mt-2">
              <?php if (!empty($review['title'])): ?>
              <h5 class="font-medium text-gray-900 mb-1"><?= $review['title'] ?></h5>
              <?php endif; ?>
              <p class="text-gray-600 text-sm">
                <?= nl2br(htmlspecialchars(mb_substr($review['review'], 0, 150))) ?><?= (mb_strlen($review['review']) > 150) ? '...' : '' ?>
              </p>
            </div>

            <div class="mt-3 text-right">
              <a href="<?= UrlHelper::route('admin/reviews/reviewDetail/' . $review['id']) ?>"
                class="text-sm text-teal-600 hover:text-teal-800">
                Xem chi tiết
              </a>
            </div>
          </div>
          <?php endforeach; ?>
          <?php else: ?>
          <div class="py-4 text-center text-gray-500">Chưa có đánh giá nào</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal xác nhận xóa người dùng -->
<?php if ($user['id'] != $_SESSION['user_id']): ?>
<div id="userStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
    <div class="flex justify-between items-center p-4 border-b">
      <h3 class="text-lg font-semibold text-gray-900">Xác nhận thay đổi trạng thái</h3>
      <button id="closeStatusModal" class="text-gray-400 hover:text-gray-500">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-4">
      <p class="text-gray-700">Bạn có chắc chắn muốn <span id="actionText" class="font-bold"></span> người dùng <span
          id="statusUserName" class="font-bold"><?= $user['username'] ?></span>?</p>
      <p id="statusWarningText" class="text-gray-500 text-sm mt-2"></p>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
      <button type="button" id="cancelStatusBtn"
        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
        Hủy
      </button>
      <button id="confirmStatusBtn"
        class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
        Xác nhận
      </button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Status modal elements
  const userStatusModal = document.getElementById('userStatusModal');
  const closeStatusModal = document.getElementById('closeStatusModal');
  const cancelStatusBtn = document.getElementById('cancelStatusBtn');
  const confirmStatusBtn = document.getElementById('confirmStatusBtn');
  const actionText = document.getElementById('actionText');
  const statusWarningText = document.getElementById('statusWarningText');

  // Status button elements
  const statusButtons = document.querySelectorAll('[data-action]');
  let currentAction = '';
  let userId = '';

  // Add click event for all status buttons
  statusButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      userId = this.getAttribute('data-id');
      currentAction = this.getAttribute('data-action');
      const username = this.getAttribute('data-name');

      // Set appropriate text based on action
      switch (currentAction) {
        case 'active':
          actionText.textContent = 'kích hoạt';
          statusWarningText.textContent =
            'Người dùng sẽ có thể đăng nhập và sử dụng tài khoản sau khi được kích hoạt.';
          break;
        case 'inactive':
          actionText.textContent = 'vô hiệu hóa';
          statusWarningText.textContent =
            'Người dùng sẽ không thể đăng nhập cho đến khi tài khoản được kích hoạt lại.';
          break;
        case 'banned':
          actionText.textContent = 'cấm';
          statusWarningText.textContent =
            'Người dùng sẽ không thể đăng nhập và sử dụng tài khoản cho đến khi được gỡ cấm.';
          break;
      }

      userStatusModal.classList.remove('hidden');
      userStatusModal.classList.add('flex');
    });
  });

  // Close modal events
  [closeStatusModal, cancelStatusBtn].forEach(el => {
    el.addEventListener('click', function() {
      userStatusModal.classList.add('hidden');
      userStatusModal.classList.remove('flex');
    });
  });

  // Confirm status change
  confirmStatusBtn.addEventListener('click', function() {
    // Send AJAX request to update user status
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= UrlHelper::route('admin/users/updateStatus') ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
              // Redirect to refresh the page
              window.location.reload();
            } else {
              alert('Lỗi: ' + response.message);
            }
          } catch (e) {
            alert('Đã xảy ra lỗi khi xử lý phản hồi từ máy chủ');
          }
        } else {
          alert('Đã xảy ra lỗi khi gửi yêu cầu');
        }
      }
    };
    xhr.send(`user_id=${userId}&status=${currentAction}`);
  });
});

// Xử lý lỗi ảnh avatar user
function handleUserAvatarError(img, username) {
  img.style.display = 'none';
  const parent = img.parentElement;

  // Tạo viết tắt từ tên người dùng
  const initials = username.split(' ')
    .map(part => part.charAt(0))
    .join('')
    .substring(0, 2)
    .toUpperCase();

  // Hiển thị chữ cái đầu trong avatar
  parent.innerHTML = `
    <div class="h-32 w-32 rounded-full bg-teal-500 flex items-center justify-center text-white text-4xl font-bold">
      ${initials}
    </div>
  `;
}

// Xử lý lỗi thumbnail booking
function handleBookingThumbnailError(img, bookingId, tourTitle) {
  img.style.display = 'none';
  const placeholderId = `booking-placeholder-${bookingId}`;

  // Tạo placeholder element nếu chưa có
  if (!document.getElementById(placeholderId)) {
    const placeholder = document.createElement('div');
    placeholder.id = placeholderId;
    placeholder.className = 'h-8 w-10 bg-gray-100 rounded flex items-center justify-center';
    img.parentNode.insertBefore(placeholder, img);
  }

  const placeholder = document.getElementById(placeholderId);
  placeholder.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" 
      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
      <circle cx="8.5" cy="8.5" r="1.5"></circle>
      <polyline points="21 15 16 10 5 21"></polyline>
    </svg>
  `;
}

// Xử lý lỗi thumbnail review
function handleReviewThumbnailError(img, reviewId, tourTitle) {
  img.style.display = 'none';
  const placeholderId = `review-placeholder-${reviewId}`;

  // Tạo placeholder element nếu chưa có
  if (!document.getElementById(placeholderId)) {
    const placeholder = document.createElement('div');
    placeholder.id = placeholderId;
    placeholder.className = 'h-12 w-16 bg-gray-200 rounded flex items-center justify-center';
    img.parentNode.insertBefore(placeholder, img);
  }

  const placeholder = document.getElementById(placeholderId);
  placeholder.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" 
      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
      <polyline points="14 2 14 8 20 8"></polyline>
      <line x1="16" y1="13" x2="8" y2="13"></line>
      <line x1="16" y1="17" x2="8" y2="17"></line>
      <polyline points="10 9 9 9 8 9"></polyline>
    </svg>
  `;
}

document.addEventListener('DOMContentLoaded', function() {
  // Khởi tạo xử lý lỗi cho tất cả các ảnh

  // 1. Xử lý ảnh avatar người dùng
  const userAvatar = document.querySelector('.user-avatar');
  if (userAvatar) {
    userAvatar.onerror = function() {
      handleUserAvatarError(this, '<?= $user["username"] ?>');
    };
  }

  // 2. Xử lý các ảnh thumbnail booking
  document.querySelectorAll('.booking-thumbnail').forEach(img => {
    const bookingId = img.dataset.id;
    const tourTitle = img.dataset.title;
    img.onerror = function() {
      handleBookingThumbnailError(this, bookingId, tourTitle);
    };
  });

  // 3. Xử lý các ảnh thumbnail review
  document.querySelectorAll('.review-thumbnail').forEach(img => {
    const reviewId = img.dataset.id;
    const tourTitle = img.dataset.title;
    img.onerror = function() {
      handleReviewThumbnailError(this, reviewId, tourTitle);
    };
  });
});
</script>
<?php endif; ?>
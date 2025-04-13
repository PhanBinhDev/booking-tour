<?php

use App\Helpers\UrlHelper;

$title = $existingReview ? 'Chỉnh sửa đánh giá' : 'Đánh giá tour';
?>

<main class="min-h-screen bg-gray-50 py-8 px-4">
  <div class="max-w-3xl mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-800"><?= $title ?></h1>
      <p class="text-gray-600">Tour: <?= $tour['title'] ?></p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
      <?php if (isset($errors) && !empty($errors)): ?>
      <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-md border border-red-200">
        <ul class="list-disc list-inside">
          <?php foreach ($errors as $error): ?>
          <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="<?= UrlHelper::route('user/review/tour/' . $tour['id']) ?>">
        <!-- Tiêu đề đánh giá -->
        <div class="mb-6">
          <label for="title" class="block text-gray-700 font-medium mb-2">Tiêu đề đánh giá</label>
          <input type="text" id="title" name="title" value="<?= $existingReview['title'] ?? '' ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Nhập tiêu đề ngắn gọn cho đánh giá của bạn">
        </div>

        <!-- Đánh giá sao  -->
        <div class="mb-6">
          <label class="block text-gray-700 font-medium mb-2">Đánh giá của bạn</label>
          <div class="flex items-center star-rating">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
            <div class="star-container">
              <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" class="sr-only"
                <?= (isset($existingReview['rating']) && $existingReview['rating'] == $i) ? 'checked' : '' ?> required>
              <label for="star<?= $i ?>" class="cursor-pointer px-1 star-label">
                <svg
                  class="w-8 h-8 star-icon <?= (isset($existingReview['rating']) && $existingReview['rating'] >= $i) ? 'text-yellow-400' : 'text-gray-300' ?>"
                  fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </label>
            </div>
            <?php } ?>
          </div>
          <div class="mt-1 text-sm text-gray-500">
            <span id="rating-text">Vui lòng chọn đánh giá</span>
          </div>
        </div>

        <!-- Nhận xét -->
        <div class="mb-6">
          <label for="review" class="block text-gray-700 font-medium mb-2">Nhận xét của bạn</label>
          <textarea id="review" name="review" rows="4" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Hãy chia sẻ trải nghiệm của bạn về tour du lịch này..."><?= $existingReview['review'] ?? '' ?></textarea>
          <p class="text-sm text-gray-500 mt-1">Tối thiểu 10 ký tự</p>
        </div>

        <div class="flex justify-end gap-3">
          <a href="<?= UrlHelper::route('user/bookings') ?>"
            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
            Hủy
          </a>
          <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">
            <?= $existingReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<style>
.star-container {
  position: relative;
  display: inline-block;
}

.star-label {
  display: block;
  cursor: pointer;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const stars = document.querySelectorAll('.star-label');
  const ratingText = document.getElementById('rating-text');
  const ratingTexts = ['Rất không hài lòng', 'Không hài lòng', 'Bình thường', 'Hài lòng', 'Rất hài lòng'];

  // Đặt giá trị ban đầu cho văn bản đánh giá
  const checkedInput = document.querySelector('input[name="rating"]:checked');
  if (checkedInput) {
    const rating = parseInt(checkedInput.value) - 1;
    ratingText.textContent = ratingTexts[rating];
  }

  stars.forEach((star, index) => {
    // Xử lý sự kiện click
    star.addEventListener('click', function() {
      const input = document.getElementById('star' + (index + 1));
      input.checked = true;

      // Cập nhật hiển thị sao
      updateStars();

      // Cập nhật văn bản đánh giá
      ratingText.textContent = ratingTexts[index];
    });

    // Xử lý hiệu ứng hover
    star.addEventListener('mouseover', () => {
      for (let i = 0; i <= index; i++) {
        stars[i].querySelector('svg').classList.add('text-yellow-400');
        stars[i].querySelector('svg').classList.remove('text-gray-300');
      }

      for (let i = index + 1; i < stars.length; i++) {
        stars[i].querySelector('svg').classList.remove('text-yellow-400');
        stars[i].querySelector('svg').classList.add('text-gray-300');
      }

      ratingText.textContent = ratingTexts[index];
    });

    star.addEventListener('mouseout', updateStars);
  });

  // Hàm cập nhật hiển thị sao dựa trên input được chọn
  function updateStars() {
    const checkedInput = document.querySelector('input[name="rating"]:checked');
    if (!checkedInput) {
      stars.forEach(star => {
        star.querySelector('svg').classList.remove('text-yellow-400');
        star.querySelector('svg').classList.add('text-gray-300');
      });
      ratingText.textContent = 'Vui lòng chọn đánh giá';
      return;
    }

    const rating = parseInt(checkedInput.value);

    stars.forEach((star, i) => {
      if (i < rating) {
        star.querySelector('svg').classList.add('text-yellow-400');
        star.querySelector('svg').classList.remove('text-gray-300');
      } else {
        star.querySelector('svg').classList.remove('text-yellow-400');
        star.querySelector('svg').classList.add('text-gray-300');
      }
    });

    ratingText.textContent = ratingTexts[rating - 1];
  }

  // Kiểm tra nếu đã có sao được chọn
  updateStars();
});
</script>
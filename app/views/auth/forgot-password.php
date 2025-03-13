<?php

use App\Helpers\UrlHelper;

?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-5">
          <h2 class="text-center mb-4">Quên mật khẩu</h2>

          <p class="text-center mb-4">Nhập email của bạn và chúng tôi sẽ gửi hướng dẫn đặt lại mật khẩu.</p>

          <?php if (isset($_SESSION['flash_message'])): ?>
          <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?> alert-dismissible fade show"
            role="alert">
            <?php echo $_SESSION['flash_message']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['flash_message']); ?>
          <?php endif; ?>

          <form method="post" action="<?php echo UrlHelper::route('auth/forgot-password'); ?>">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                id="email" name="email" value="<?php echo $email ?? ''; ?>" required>
              <?php if (isset($errors['email'])): ?>
              <div class="invalid-feedback">
                <?php echo $errors['email']; ?>
              </div>
              <?php endif; ?>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">Gửi yêu cầu</button>
            </div>

            <div class="mt-3 text-center">
              <a href="<?php echo UrlHelper::route('/login'); ?>" class="text-decoration-none">Quay lại đăng nhập</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
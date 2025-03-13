<?php
use App\Helpers\UrlHelper;
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-5">
          <h2 class="text-center mb-4">Đặt lại mật khẩu</h2>

          <?php if (isset($errors['reset'])): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $errors['reset']; ?>
          </div>
          <?php endif; ?>

          <form method="post" action="<?php echo UrlHelper::route('auth/reset-password?token=' . $token); ?>">
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <div class="mb-3">
              <label for="password" class="form-label">Mật khẩu mới</label>
              <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                id="password" name="password" required>
              <?php if (isset($errors['password'])): ?>
              <div class="invalid-feedback">
                <?php echo $errors['password']; ?>
              </div>
              <?php endif; ?>
              <div class="form-text">Tối thiểu 6 ký tự</div>
            </div>

            <div class="mb-3">
              <label for="password_confirm" class="form-label">Xác nhận mật khẩu mới</label>
              <input type="password"
                class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : ''; ?>"
                id="password_confirm" name="password_confirm" required>
              <?php if (isset($errors['password_confirm'])): ?>
              <div class="invalid-feedback">
                <?php echo $errors['password_confirm']; ?>
              </div>
              <?php endif; ?>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">Đặt lại mật khẩu</button>
            </div>

            <div class="mt-3 text-center">
              <a href="<?php echo UrlHelper::route('auth/login'); ?>" class="text-decoration-none">Quay lại đăng
                nhập</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
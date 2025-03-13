<?php
$title = 'Login';
$activePage = 'login';
?>

<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
  <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to Your Account</h2>

  <?php if(isset($errors['login'])): ?>
  <div class="mb-4 p-4 rounded-md bg-red-100 text-red-700">
    <?= $errors['login'] ?>
  </div>
  <?php endif; ?>

  <form action="/login" method="POST">
    <div class="mb-4">
      <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
      <input type="email" name="email" id="email"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
    </div>

    <div class="mb-6">
      <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
      <input type="password" name="password" id="password"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        required>
    </div>

    <div class="flex items-center justify-between mb-6">
      <div>
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-sm text-gray-700">Remember me</label>
      </div>
      <a href="/forgot-password" class="text-sm text-blue-500 hover:text-blue-700">Forgot password?</a>
    </div>

    <div class="flex items-center justify-center">
      <button type="submit"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
        Login
      </button>
    </div>

    <div class="text-center mt-4">
      <p class="text-sm text-gray-600">
        Don't have an account? <a href="/register" class="text-blue-500 hover:text-blue-700">Register here</a>
      </p>
    </div>
  </form>
</div>
<?php $content = ob_get_clean(); ?>

<?php include 'layout.php'; ?>
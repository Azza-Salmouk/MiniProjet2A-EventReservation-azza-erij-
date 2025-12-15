<?php
$pageTitle = "Admin Login";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="card" style="max-width: 500px; margin: 3rem auto;">
  <div class="text-center mb-lg">
    <img src="<?= $BASE_URL ?>/images/admin.svg" alt="Admin" style="width: 100px; height: auto; margin-bottom: 1rem;">
    <h1 class="mt-0">Admin Login</h1>
    <p class="text-muted">Sign in to access the administration panel</p>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert error">
      <span>⚠️</span>
      <span><?= htmlspecialchars($error) ?></span>
    </div>
  <?php endif; ?>

  <form class="form" method="POST" action="<?= $BASE_URL ?>/admin/login">
    <div class="form-group">
      <label for="username">Username</label>
      <input class="input" id="username" name="username" required placeholder="Enter your username">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input class="input" type="password" id="password" name="password" required placeholder="Enter your password">
    </div>

    <button class="btn" type="submit" style="width: 100%;">Sign In</button>
  </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
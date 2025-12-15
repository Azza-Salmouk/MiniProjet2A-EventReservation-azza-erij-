<?php
$pageTitle = "Admin Login";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="grid grid-cols-1 md:grid-cols-2" style="gap: var(--spacing-xl); margin: 3rem auto; max-width: 1000px;">
  <div class="card" style="display: flex; align-items: center; justify-content: center;">
    <img src="<?= $BASE_URL ?>/images/admin.svg" alt="Admin" style="max-width: 100%; height: auto;">
  </div>
  
  <div class="card">
    <div class="text-center mb-lg">
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
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
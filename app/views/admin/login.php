<?php
$pageTitle = "Admin Login";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="admin-header">
  <div class="admin-banner">
    <img src="<?= $BASE_URL ?>/images/admin.svg" alt="Admin" class="admin-icon">
    <h1>Admin Panel</h1>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 admin-layout" style="gap: var(--spacing-xl); margin: 2rem auto; max-width: 1000px;">
  <!-- Login Form -->
  <div class="admin-card">
    <div class="text-center mb-xl">
      <h2 class="mt-0">Sign In</h2>
      <p class="text-muted">Access the administration panel</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert error">
        <span>⚠️</span>
        <span><?= htmlspecialchars($error) ?></span>
      </div>
    <?php endif; ?>

    <form class="form" method="POST" action="<?= $ADMIN_LOGIN_URL ?>">
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
  
  <!-- Illustration Side -->
  <div class="admin-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white;">
    <img src="<?= $BASE_URL ?>/images/admin.svg" alt="Admin" style="max-width: 70%; height: auto; margin-bottom: 1.5rem;">
    <h3 style="color: white; margin-bottom: 1rem;">Event Management</h3>
    <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 80%;">Manage your events, reservations, and attendees with our intuitive admin panel.</p>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
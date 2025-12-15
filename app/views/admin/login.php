<?php
$pageTitle = "Admin Login";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<h1>Admin Login</h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form class="card form" method="POST" action="<?= $BASE_URL ?>/admin/login">
  <div>
    <label>Username</label>
    <input class="input" name="username" required>
  </div>

  <div>
    <label>Password</label>
    <input class="input" type="password" name="password" required>
  </div>

  <button class="btn" type="submit">Login</button>
</form>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<?php
$pageTitle = "Reservations";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<h1>Reservations</h1>

<?php if (!empty($event)): ?>
  <div class="alert">
    Event: <strong><?= htmlspecialchars($event['title'] ?? '') ?></strong>
  </div>
<?php endif; ?>

<?php if (empty($reservations)): ?>
  <div class="card">No reservations.</div>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Created</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reservations as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
          <td><?= htmlspecialchars($r['email'] ?? '') ?></td>
          <td><?= htmlspecialchars($r['phone'] ?? '') ?></td>
          <td><?= htmlspecialchars($r['created_at'] ?? '') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<div style="margin-top:12px;">
  <a class="btn secondary" href="<?= $BASE_URL ?>/admin">Back to dashboard</a>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

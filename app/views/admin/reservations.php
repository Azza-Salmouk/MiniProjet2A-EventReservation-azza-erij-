<?php
$pageTitle = "Reservations";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<h1 class="text-center">Event Reservations</h1>

<?php if (!empty($event)): ?>
  <div class="card mb-lg">
    <h3 class="mt-0">Event: <?= htmlspecialchars($event['title'] ?? '') ?></h3>
    <p class="text-muted"><?= htmlspecialchars($event['location'] ?? '') ?> • <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></p>
  </div>
<?php endif; ?>

<?php if (empty($reservations)): ?>
  <div class="card text-center py-lg">
    <h3>No reservations yet</h3>
    <p class="text-muted">No one has reserved a seat for this event.</p>
    <a href="<?= $BASE_URL ?>/admin" class="btn">Back to Dashboard</a>
  </div>
<?php else: ?>
  <div class="card">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Reserved On</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reservations as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
              <td><?= htmlspecialchars($r['email'] ?? '') ?></td>
              <td><?= htmlspecialchars($r['phone'] ?? '') ?></td>
              <td><?= !empty($r['created_at']) ? date('d/m/Y H:i', strtotime($r['created_at'])) : '' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="row mt-lg">
    <a class="btn secondary" href="<?= $BASE_URL ?>/admin">Back to Dashboard</a>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
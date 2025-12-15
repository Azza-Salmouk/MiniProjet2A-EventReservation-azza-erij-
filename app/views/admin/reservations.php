<?php
$pageTitle = "Reservations";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="admin-page">
  <h1 class="text-center">Event Reservations</h1>

  <?php if (!empty($event)): ?>
    <div class="admin-card mb-lg">
      <h3 class="mt-0">Event: <?= htmlspecialchars($event['title'] ?? '') ?></h3>
      <p class="text-muted"><?= htmlspecialchars($event['location'] ?? '') ?> • <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></p>
    </div>
  <?php endif; ?>

  <!-- Search and Pagination (visual only) -->
  <div class="admin-card mb-lg">
    <div class="row space-between">
      <div class="form-group" style="flex: 1; max-width: 300px;">
        <input class="input" type="text" placeholder="Search reservations...">
      </div>
      <div>
        <span class="badge">Page 1 of 3</span>
      </div>
    </div>
  </div>

  <?php if (empty($reservations)): ?>
    <div class="admin-card text-center py-lg">
      <h3>No reservations yet</h3>
      <p class="text-muted">No one has reserved a seat for this event.</p>
      <a href="<?= $BASE_URL ?>/preview_admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
  <?php else: ?>
    <div class="admin-card">
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Reserved On</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservations as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['phone'] ?? '') ?></td>
                <td><?= !empty($r['created_at']) ? date('d/m/Y H:i', strtotime($r['created_at'])) : '' ?></td>
                <td>
                  <?php if (($r['status'] ?? '') === 'CONFIRMED'): ?>
                    <span class="badge success">CONFIRMED</span>
                  <?php elseif (($r['status'] ?? '') === 'PENDING'): ?>
                    <span class="badge warning">PENDING</span>
                  <?php else: ?>
                    <span class="badge muted">UNKNOWN</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Pagination (visual only) -->
    <div class="admin-card mt-lg">
      <div class="row space-between">
        <button class="btn secondary small">Previous</button>
        <div>
          <span class="badge">1</span>
          <span class="badge secondary">2</span>
          <span class="badge secondary">3</span>
        </div>
        <button class="btn secondary small">Next</button>
      </div>
    </div>
  <?php endif; ?>
  
  <div class="row mt-lg">
    <a class="btn secondary" href="<?= $BASE_URL ?>/preview_admin_dashboard.php">Back to Dashboard</a>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
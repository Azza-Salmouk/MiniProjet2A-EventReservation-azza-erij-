<?php
$pageTitle = "Admin Dashboard";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>
<h1 class="text-center">Dashboard Overview</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 mb-lg">
  <div class="admin-card stats-card">
    <div class="stat-number" style="color: var(--primary);"><?= $totalEvents ?></div>
    <div class="stat-label">Total Events</div>
  </div>
  
  <div class="admin-card stats-card">
    <div class="stat-number" style="color: var(--secondary);"><?= $totalReservations ?></div>
    <div class="stat-label">Total Reservations</div>
  </div>
  
  <div class="admin-card stats-card">
    <div class="stat-number" style="color: var(--accent);"><?= max(0, $seatsRemaining) ?></div>
    <div class="stat-label">Seats Remaining</div>
  </div>
</div>

<?php if (empty($events)): ?>
  <div class="admin-card text-center py-lg">
    <h3>No events yet</h3>
    <p class="text-muted">Create your first event to get started.</p>
  </div>
<?php else: ?>
  <div class="admin-card">
    <h2 class="mt-0 mb-lg">Recent Events</h2>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Location</th>
            <th>Seats</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $e): ?>
            <tr>
              <td><?= htmlspecialchars($e['title'] ?? '') ?></td>
              <td><?= !empty($e['event_date']) ? date('d/m/Y H:i', strtotime($e['event_date'])) : '' ?></td>
              <td><?= htmlspecialchars($e['location'] ?? '') ?></td>
              <td><?= htmlspecialchars((string)($e['seats'] ?? '')) ?></td>
              <td class="row" style="gap: var(--spacing-sm);">
                <a class="btn secondary small" href="/admin/events/edit/<?= (int)$e['id'] ?>">Edit</a>
                <a class="btn secondary small" href="<?= $ADMIN_RESERVATIONS_URL ?>?event_id=<?= (int)$e['id'] ?>">Reservations</a>
                
                <form class="delete-form" method="POST" action="/admin/events/<?= (int)$e['id'] ?>/delete" style="margin: 0;">
                  <button class="btn danger small" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
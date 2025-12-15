<?php
$pageTitle = "Admin Dashboard";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="admin-page">
  <div class="text-center mb-xl">
    <h1 class="mt-0">Admin Dashboard</h1>
    <p class="text-muted">Manage your events and reservations</p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 mb-xl">
    <div class="admin-card text-center">
      <h3 class="mt-0" style="font-size: 2.5rem; color: var(--primary);">12</h3>
      <p class="text-muted">Total Events</p>
    </div>
    
    <div class="admin-card text-center">
      <h3 class="mt-0" style="font-size: 2.5rem; color: var(--secondary);">142</h3>
      <p class="text-muted">Total Reservations</p>
    </div>
    
    <div class="admin-card text-center">
      <h3 class="mt-0" style="font-size: 2.5rem; color: var(--accent);">867</h3>
      <p class="text-muted">Seats Remaining</p>
    </div>
  </div>

  <!-- Actions -->
  <div class="row mb-lg">
    <a class="btn" href="<?= $BASE_URL ?>/preview_admin_form_event.php">+ New Event</a>
  </div>

  <?php if (empty($events)): ?>
    <div class="admin-card text-center py-lg">
      <h3>No events yet</h3>
      <p class="text-muted">Create your first event to get started.</p>
      <a href="<?= $BASE_URL ?>/preview_admin_form_event.php" class="btn">Create Event</a>
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
                  <a class="btn secondary small" href="<?= $BASE_URL ?>/preview_admin_form_event.php?id=<?= (int)$e['id'] ?>">Edit</a>
                  <a class="btn secondary small" href="<?= $BASE_URL ?>/preview_admin_reservations.php?event_id=<?= (int)$e['id'] ?>">Reservations</a>
                  
                  <form class="delete-form" method="POST" action="<?= $BASE_URL ?>/admin/event/delete" style="margin: 0;">
                    <input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
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
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
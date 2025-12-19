<?php
$pageTitle = "All Events - Reservations";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>
<h1 class="text-center">Select Event to View Reservations</h1>

<?php if (empty($events)): ?>
  <div class="admin-card text-center py-lg">
    <h3>No events available</h3>
    <p class="text-muted">Create your first event to get started.</p>
    <a href="<?= $ADMIN_FORM_EVENT_URL ?>" class="btn">Create Event</a>
  </div>
<?php else: ?>
  <div class="admin-card">
    <h2 class="mt-0 mb-lg">Events</h2>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Location</th>
            <th>Seats</th>
            <th>Reservations</th>
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
              <td>
                <?php
                // Get reservation count for this event
                $stmt = db()->prepare("SELECT COUNT(*) as count FROM reservations WHERE event_id = ?");
                $stmt->execute([$e['id']]);
                $reservationCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                ?>
                <span class="badge"><?= $reservationCount ?></span>
              </td>
              <td>
                <a class="btn secondary small" href="<?= $ADMIN_RESERVATIONS_URL ?>?event_id=<?= (int)$e['id'] ?>">View Reservations</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<div class="row mt-lg">
  <a class="btn secondary" href="<?= $ADMIN_DASHBOARD_URL ?>">Back to Dashboard</a>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
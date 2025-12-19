<?php
$pageTitle = "Reservations";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';

// Get parameters
$event_id = $_GET['event_id'] ?? null;
$searchTerm = $_GET['q'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 10;
$totalPages = $totalPages ?? 1;
$totalCount = $totalCount ?? 0;
?>
<h1 class="text-center">Event Reservations</h1>

<?php if (!empty($event)): ?>
  <div class="admin-card mb-lg">
    <h3 class="mt-0">Event: <?= htmlspecialchars($event['title'] ?? '') ?></h3>
    <p class="text-muted"><?= htmlspecialchars($event['location'] ?? '') ?> • <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></p>
  </div>
<?php endif; ?>

<!-- Search and Pagination -->
<div class="admin-card mb-lg">
  <div class="row space-between">
    <div style="flex: 1; max-width: 300px;">
      <form method="GET" action="<?= $ADMIN_RESERVATIONS_URL ?>">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($event_id) ?>">
        <div class="form-group">
          <input class="search-input" type="text" name="q" placeholder="Search reservations..." value="<?= htmlspecialchars($searchTerm) ?>">
        </div>
      </form>
    </div>
    <?php if (!empty($event)): ?>
    <div>
      <span class="badge">Page <?= $page ?> of <?= max(1, $totalPages) ?></span>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php if (empty($reservations)): ?>
  <div class="admin-card text-center py-lg">
    <h3>No reservations yet</h3>
    <p class="text-muted">
      <?php if (!empty($event)): ?>
        No one has reserved a seat for this event.
      <?php else: ?>
        No reservations found.
      <?php endif; ?>
    </p>
    <a href="<?= $ADMIN_DASHBOARD_URL ?>" class="btn">Back to Dashboard</a>
  </div>
<?php else: ?>
  <div class="admin-card">
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <?php if (empty($event)): ?>
              <th>Event</th>
            <?php endif; ?>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Reserved On</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reservations as $r): ?>
            <tr>
              <?php if (empty($event)): ?>
                <td><?= htmlspecialchars($r['event_title'] ?? 'Unknown Event') ?></td>
              <?php endif; ?>
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
  
  <?php if (!empty($event)): ?>
  <!-- Pagination -->
  <div class="admin-card mt-lg">
    <div class="row space-between">
      <?php if ($page > 1): ?>
        <a class="btn secondary small" href="<?= $ADMIN_RESERVATIONS_URL ?>?event_id=<?= urlencode($event_id) ?>&q=<?= urlencode($searchTerm) ?>&page=<?= $page - 1 ?>">Previous</a>
      <?php else: ?>
        <button class="btn secondary small" disabled>Previous</button>
      <?php endif; ?>
      
      <div>
        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
          <?php if ($i == $page): ?>
            <span class="badge"><?= $i ?></span>
          <?php else: ?>
            <a class="badge secondary" href="<?= $ADMIN_RESERVATIONS_URL ?>?event_id=<?= urlencode($event_id) ?>&q=<?= urlencode($searchTerm) ?>&page=<?= $i ?>"><?= $i ?></a>
          <?php endif; ?>
        <?php endfor; ?>
      </div>
      
      <?php if ($page < $totalPages): ?>
        <a class="btn secondary small" href="<?= $ADMIN_RESERVATIONS_URL ?>?event_id=<?= urlencode($event_id) ?>&q=<?= urlencode($searchTerm) ?>&page=<?= $page + 1 ?>">Next</a>
      <?php else: ?>
        <button class="btn secondary small" disabled>Next</button>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
<?php endif; ?>

<div class="row mt-lg">
  <a class="btn secondary" href="<?= $ADMIN_DASHBOARD_URL ?>">Back to Dashboard</a>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
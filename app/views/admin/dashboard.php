<?php
$pageTitle = "Admin Dashboard";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<h1>Dashboard</h1>

<div class="row" style="margin-bottom:12px;">
  <a class="btn" href="<?= $BASE_URL ?>/admin/event/new">+ New event</a>
</div>

<?php if (empty($events)): ?>
  <div class="card">No events yet.</div>
<?php else: ?>
  <table class="table">
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
          <td class="row">
            <a class="btn secondary" href="<?= $BASE_URL ?>/admin/event/edit?id=<?= (int)$e['id'] ?>">Edit</a>
            <a class="btn secondary" href="<?= $BASE_URL ?>/admin/reservations?event_id=<?= (int)$e['id'] ?>">Reservations</a>

            <form method="POST" action="<?= $BASE_URL ?>/admin/event/delete" onsubmit="return confirm('Delete this event?');">
              <input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
              <button class="btn danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>

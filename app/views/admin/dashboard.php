<?php
$pageTitle = "Admin Dashboard";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';
?>

<div class="text-center mb-xl">
  <img src="<?= $BASE_URL ?>/images/admin.svg" alt="Admin" style="width: 80px; height: auto; margin-bottom: 1rem;">
  <h1 class="mt-0">Admin Dashboard</h1>
  <p class="text-muted">Manage your events and reservations</p>
</div>

<div class="row mb-lg">
  <a class="btn" href="<?= $BASE_URL ?>/admin/event/new">+ New Event</a>
</div>

<?php if (empty($events)): ?>
  <div class="card text-center py-lg">
    <h3>No events yet</h3>
    <p class="text-muted">Create your first event to get started.</p>
    <a href="<?= $BASE_URL ?>/admin/event/new" class="btn">Create Event</a>
  </div>
<?php else: ?>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($events as $e): ?>
      <div class="card">
        <?php if (!empty($e['image'])): ?>
          <img src="<?= $BASE_URL ?>/uploads/<?= htmlspecialchars($e['image']) ?>" alt="<?= htmlspecialchars($e['title'] ?? '') ?>">
        <?php else: ?>
          <img src="<?= $BASE_URL ?>/images/event-placeholder.svg" alt="Event placeholder">
        <?php endif; ?>
        
        <h3 class="mt-0 mb-sm"><?= htmlspecialchars($e['title'] ?? '') ?></h3>
        
        <div class="row mb-md">
          <span class="badge">📍 <?= htmlspecialchars($e['location'] ?? '') ?></span>
          <span class="badge">🗓️ <?= !empty($e['event_date']) ? date('d/m/Y H:i', strtotime($e['event_date'])) : '' ?></span>
          <span class="badge">🎟️ <?= htmlspecialchars((string)($e['seats'] ?? '')) ?> seats</span>
        </div>
        
        <div class="row" style="gap: var(--spacing-sm);">
          <a class="btn secondary" href="<?= $BASE_URL ?>/admin/event/edit?id=<?= (int)$e['id'] ?>" style="flex: 1; text-align: center;">Edit</a>
          <a class="btn secondary" href="<?= $BASE_URL ?>/admin/reservations?event_id=<?= (int)$e['id'] ?>" style="flex: 1; text-align: center;">Reservations</a>
          
          <form class="delete-form" method="POST" action="<?= $BASE_URL ?>/admin/event/delete" style="flex: 1; margin: 0;">
            <input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
            <button class="btn danger" type="submit" style="width: 100%;">Delete</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
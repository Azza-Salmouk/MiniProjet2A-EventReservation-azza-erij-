<?php
$pageTitle = "Events";
$isAdminPage = false;
require __DIR__ . '/../partials/header.php';
?>

<h1>Upcoming Events</h1>

<?php if (empty($events)): ?>
  <div class="card">No events found.</div>
<?php else: ?>
  <div class="grid">
    <?php foreach ($events as $event): ?>
      <div class="card">
        <?php if (!empty($event['image'])): ?>
          <img class="event-img" src="<?= $BASE_URL ?>/uploads/<?= htmlspecialchars($event['image']) ?>" alt="event">
        <?php else: ?>
          <div class="event-img"></div>
        <?php endif; ?>

        <h3><?= htmlspecialchars($event['title'] ?? '') ?></h3>

        <div class="row">
          <span class="badge">📍 <?= htmlspecialchars($event['location'] ?? '') ?></span>
          <span class="badge">🗓️ <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></span>
          <span class="badge">🎟️ Seats: <?= htmlspecialchars((string)($event['seats'] ?? '')) ?></span>
        </div>

        <p><?= htmlspecialchars(mb_strimwidth($event['description'] ?? '', 0, 120, '...')) ?></p>

        <a class="btn" href="<?= $BASE_URL ?>/event?id=<?= (int)$event['id'] ?>">View details</a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>

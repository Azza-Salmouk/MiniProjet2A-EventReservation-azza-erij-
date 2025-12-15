<?php
$pageTitle = "Event details";
$isAdminPage = false;
require __DIR__ . '/../partials/header.php';
?>

<?php if (empty($event)): ?>
  <div class="card text-center py-lg">
    <h3>Event not found</h3>
    <p class="text-muted">The event you're looking for doesn't exist or has been removed.</p>
    <a href="<?= $BASE_URL ?>/" class="btn">Browse Events</a>
  </div>
<?php else: ?>
  <div class="card">
    <?php if (!empty($event['image'])): ?>
      <img class="event-img" src="<?= $BASE_URL ?>/uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title'] ?? '') ?>">
    <?php else: ?>
      <img class="event-img" src="<?= $BASE_URL ?>/images/event-placeholder.svg" alt="Event placeholder">
    <?php endif; ?>

    <h1 class="mt-0"><?= htmlspecialchars($event['title'] ?? '') ?></h1>

    <div class="row mb-lg">
      <span class="badge primary">📍 <?= htmlspecialchars($event['location'] ?? '') ?></span>
      <span class="badge primary">🗓️ <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></span>
      <span class="badge primary">🎟️ <?= htmlspecialchars((string)($event['seats'] ?? '')) ?> seats available</span>
    </div>

    <p><?= nl2br(htmlspecialchars($event['description'] ?? '')) ?></p>
  </div>

  <h2 class="mt-xl mb-md">Reserve your seat</h2>

  <?php if (!empty($error)): ?>
    <div class="alert error">
      <span>⚠️</span>
      <span><?= htmlspecialchars($error) ?></span>
    </div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div class="alert success">
      <span>✅</span>
      <span><?= htmlspecialchars($success) ?></span>
    </div>
  <?php endif; ?>

  <form class="card form js-reserve-form" method="POST" action="<?= $BASE_URL ?>/reserve">
    <div class="form-group">
      <label for="name">Full Name</label>
      <input class="input" id="name" name="name" required minlength="2" maxlength="60" placeholder="Your full name">
    </div>

    <div class="form-group">
      <label for="email">Email Address</label>
      <input class="input" type="email" id="email" name="email" required placeholder="your.email@example.com">
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input class="input" type="tel" id="phone" name="phone" required minlength="6" maxlength="20" placeholder="+1 (555) 123-4567">
    </div>

    <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">

    <div class="row space-between mt-lg">
      <button class="btn" type="submit">Confirm Reservation</button>
      <a class="btn secondary" href="<?= $BASE_URL ?>/">Back to Events</a>
    </div>
  </form>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
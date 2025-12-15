<?php
$pageTitle = "Event details";
$isAdminPage = false;
require __DIR__ . '/../partials/header.php';
?>

<?php if (empty($event)): ?>
  <div class="alert error">Event not found.</div>
<?php else: ?>
  <div class="card">
    <?php if (!empty($event['image'])): ?>
      <img class="event-img" src="<?= $BASE_URL ?>/uploads/<?= htmlspecialchars($event['image']) ?>" alt="event">
    <?php endif; ?>

    <h1><?= htmlspecialchars($event['title'] ?? '') ?></h1>

    <div class="row">
      <span class="badge">📍 <?= htmlspecialchars($event['location'] ?? '') ?></span>
      <span class="badge">🗓️ <?= !empty($event['event_date']) ? date('d/m/Y H:i', strtotime($event['event_date'])) : '' ?></span>
      <span class="badge">🎟️ Seats: <?= htmlspecialchars((string)($event['seats'] ?? '')) ?></span>
    </div>

    <p><?= nl2br(htmlspecialchars($event['description'] ?? '')) ?></p>
  </div>

  <h2 style="margin-top:16px;">Reserve your seat</h2>

  <?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div class="alert success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form class="card form" method="POST" action="<?= $BASE_URL ?>/reserve">
    <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">

    <div>
      <label>Your name</label>
      <input class="input" name="name" required>
    </div>

    <div>
      <label>Email</label>
      <input class="input" type="email" name="email" required>
    </div>

    <div>
      <label>Phone</label>
      <input class="input" name="phone" required>
    </div>

    <button class="btn" type="submit">Confirm reservation</button>
    <a class="btn secondary" href="<?= $BASE_URL ?>/">Back</a>
  </form>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>

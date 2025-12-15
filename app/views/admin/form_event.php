<?php
$isEdit = !empty($event);
$pageTitle = $isEdit ? "Edit Event" : "New Event";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';

$action = $isEdit ? ($BASE_URL . "/admin/event/update") : ($BASE_URL . "/admin/event/create");
?>

<h1><?= $isEdit ? "Edit Event" : "Create Event" ?></h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form class="card form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$event['id'] ?>">
  <?php endif; ?>

  <div>
    <label>Title</label>
    <input class="input" name="title" required value="<?= htmlspecialchars($event['title'] ?? '') ?>" placeholder="Event title">
  </div>

  <div>
    <label>Description</label>
    <textarea class="input" name="description" rows="5" required placeholder="Event description"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
  </div>

  <div>
    <label>Date (YYYY-MM-DD HH:MM:SS)</label>
    <input class="input" name="event_date" required value="<?= htmlspecialchars($event['event_date'] ?? '') ?>" placeholder="YYYY-MM-DD HH:MM:SS">
  </div>

  <div>
    <label>Location</label>
    <input class="input" name="location" required value="<?= htmlspecialchars($event['location'] ?? '') ?>" placeholder="Event location">
  </div>

  <div>
    <label>Seats</label>
    <input class="input" type="number" min="0" name="seats" required value="<?= htmlspecialchars((string)($event['seats'] ?? '')) ?>" placeholder="Number of seats">
  </div>

  <div>
    <label>Image (optional)</label>
    <input class="input" type="file" name="image" accept="image/*">
    <?php if ($isEdit && !empty($event['image'])): ?>
      <small>Current: <?= htmlspecialchars($event['image']) ?></small>
    <?php endif; ?>
  </div>

  <button class="btn" type="submit"><?= $isEdit ? "Update" : "Create" ?></button>
  <a class="btn secondary" href="<?= $BASE_URL ?>/admin">Back</a>
</form>

<?php require __DIR__ . '/../partials/footer.php'; ?>
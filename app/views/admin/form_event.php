<?php
$isEdit = !empty($event);
$pageTitle = $isEdit ? "Edit Event" : "New Event";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';

$action = $isEdit ? ($BASE_URL . "/admin/event/update") : ($BASE_URL . "/admin/event/create");
?>

<div class="admin-page">
  <h1 class="text-center"><?= $isEdit ? "Edit Event" : "Create New Event" ?></h1>

  <?php if (!empty($error)): ?>
    <div class="alert error">
      <span>⚠️</span>
      <span><?= htmlspecialchars($error) ?></span>
    </div>
  <?php endif; ?>

  <div class="admin-card">
    <form class="form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">
      <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$event['id'] ?>">
      <?php endif; ?>

      <div class="grid grid-cols-1 md:grid-cols-2" style="gap: var(--spacing-lg);">
        <div class="form-group">
          <label for="title">Event Title</label>
          <input class="input" id="title" name="title" required value="<?= htmlspecialchars($event['title'] ?? '') ?>" placeholder="Summer Music Festival">
        </div>

        <div class="form-group">
          <label for="location">Location</label>
          <input class="input" id="location" name="location" required value="<?= htmlspecialchars($event['location'] ?? '') ?>" placeholder="Central Park, New York">
        </div>

        <div class="form-group">
          <label for="event_date">Date & Time</label>
          <input class="input" id="event_date" name="event_date" required value="<?= htmlspecialchars($event['event_date'] ?? '') ?>" placeholder="YYYY-MM-DD HH:MM:SS">
        </div>

        <div class="form-group">
          <label for="seats">Available Seats</label>
          <input class="input" type="number" min="0" id="seats" name="seats" required value="<?= htmlspecialchars((string)($event['seats'] ?? '')) ?>" placeholder="100">
        </div>
      </div>

      <div class="form-group mt-lg">
        <label for="description">Description</label>
        <textarea class="input" id="description" name="description" rows="5" required placeholder="Describe your event in detail..."><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group mt-lg">
        <label for="image">Event Image (optional)</label>
        <input class="input" type="file" id="image" name="image" accept="image/*">
        <?php if ($isEdit && !empty($event['image'])): ?>
          <small class="text-muted">Current image: <?= htmlspecialchars($event['image']) ?></small>
        <?php endif; ?>
      </div>

      <div class="row space-between mt-xl">
        <button class="btn" type="submit"><?= $isEdit ? "Update Event" : "Create Event" ?></button>
        <a class="btn secondary" href="<?= $BASE_URL ?>/preview_admin_dashboard.php">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
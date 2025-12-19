<?php
$isEdit = !empty($event);
$pageTitle = $isEdit ? "Edit Event" : "New Event";
$isAdminPage = true;
require __DIR__ . '/../partials/header.php';

// Use standardized routes
if ($isEdit) {
    $action = "/admin/events/" . (int)$event['id']; // POST to /admin/events/{id}
} else {
    $action = "/admin/events"; // POST to /admin/events
}

// Format date for datetime-local input (if editing)
$formattedDate = '';
if ($isEdit && !empty($event['event_date'])) {
    // Convert MySQL datetime to datetime-local format (YYYY-MM-DDTHH:MM)
    $dateTime = new DateTime($event['event_date']);
    $formattedDate = $dateTime->format('Y-m-d\TH:i');
}
?>
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
      <!-- No hidden ID field needed since ID is in the URL -->
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2" style="gap: var(--spacing-lg);">
      <div class="form-group">
        <label for="title">
          Event Title
          <span class="helper-text">Enter a compelling event title</span>
        </label>
        <input class="input" id="title" name="title" required value="<?= htmlspecialchars($event['title'] ?? '') ?>" placeholder="Summer Music Festival">
      </div>

      <div class="form-group">
        <label for="location">
          Location
          <span class="helper-text">Full address of the event venue</span>
        </label>
        <input class="input" id="location" name="location" required value="<?= htmlspecialchars($event['location'] ?? '') ?>" placeholder="Central Park, New York">
      </div>

      <div class="form-group">
        <label for="event_date">
          Date & Time
          <span class="helper-text">Select date and time</span>
        </label>
        <input class="input" type="datetime-local" id="event_date" name="event_date" required value="<?= $formattedDate ?>">
      </div>

      <div class="form-group">
        <label for="seats">
          Available Seats
          <span class="helper-text">Maximum number of attendees</span>
        </label>
        <input class="input" type="number" min="0" id="seats" name="seats" required value="<?= htmlspecialchars((string)($event['seats'] ?? '')) ?>" placeholder="100">
      </div>
    </div>

    <div class="form-group mt-lg">
      <label for="description">
        Description
        <span class="helper-text">Detailed event description</span>
      </label>
      <textarea class="input" id="description" name="description" rows="5" required placeholder="Describe your event in detail..."><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group mt-lg">
      <label for="image">
        Event Image (optional)
        <span class="helper-text">Upload a representative image (JPG, PNG, GIF, WEBP, SVG)</span>
      </label>
      <input class="input" type="file" id="image" name="image" accept="*/*">
      <?php if ($isEdit && !empty($event['image'])): ?>
        <small class="text-muted">Current image: <?= htmlspecialchars($event['image']) ?></small>
      <?php endif; ?>
    </div>

    <div class="row space-between mt-xl">
      <button class="btn" type="submit"><?= $isEdit ? "Update Event" : "Create Event" ?></button>
      <a class="btn secondary" href="<?= $ADMIN_DASHBOARD_URL ?>">Cancel</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
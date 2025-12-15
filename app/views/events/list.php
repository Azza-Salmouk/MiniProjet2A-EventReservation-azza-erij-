<?php
$pageTitle = "Events";
$isAdminPage = false;
require __DIR__ . '/../partials/header.php';
?>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1 class="mt-0">Discover Amazing Events</h1>
    <p>Find and book your spot at the most exciting events happening near you. From conferences to concerts, we've got you covered.</p>
    <a href="#events" class="btn">Browse Events</a>
  </div>
</section>

<?php if (empty($events)): ?>
  <div class="card text-center py-lg">
    <h3>No events available</h3>
    <p class="text-muted">Check back later for upcoming events.</p>
  </div>
<?php else: ?>
  <section id="events">
    <h2 class="mb-lg">Upcoming Events</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($events as $e): ?>
        <div class="card">
          <?php if (!empty($e['image'])): ?>
            <img src="<?= $BASE_URL ?>/uploads/<?= htmlspecialchars($e['image']) ?>" alt="<?= htmlspecialchars($e['title'] ?? '') ?>">
          <?php else: ?>
            <?php
            // Map images based on event title
            $eventTitle = $e['title'] ?? '';
            $imageMap = [
                'Tech Conference 2023' => $BASE_URL . '/images/tech.jpg',
                'Art Exhibition Opening' => $BASE_URL . '/images/art.jpg',
                'Music Festival' => $BASE_URL . '/images/music.jpg'
            ];
            $imageUrl = $imageMap[$eventTitle] ?? $BASE_URL . '/images/event-placeholder.svg';
            ?>
            <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($eventTitle) ?>">
          <?php endif; ?>
          
          <h3 class="mt-0 mb-sm"><?= htmlspecialchars($e['title'] ?? '') ?></h3>
          
          <div class="row mb-md">
            <span class="badge">📍 <?= htmlspecialchars($e['location'] ?? '') ?></span>
            <span class="badge">🗓️ <?= !empty($e['event_date']) ? date('d/m/Y H:i', strtotime($e['event_date'])) : '' ?></span>
            <span class="badge">🎟️ <?= htmlspecialchars((string)($e['seats'] ?? '')) ?> seats</span>
          </div>
          
          <p class="text-muted small mb-lg"><?= htmlspecialchars(substr($e['description'] ?? '', 0, 100)) ?><?= strlen($e['description'] ?? '') > 100 ? '...' : '' ?></p>
          
          <a href="<?= $BASE_URL ?>/event/<?= (int)$e['id'] ?>" class="btn secondary">View Details</a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
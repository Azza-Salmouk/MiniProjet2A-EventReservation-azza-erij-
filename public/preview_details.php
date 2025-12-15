<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing event details UI without backend

// Fake data for preview
$event = [
    'id' => 1,
    'title' => 'Tech Conference 2023',
    'description' => 'Annual technology conference featuring keynote speakers and workshops. This year\'s edition will cover topics such as artificial intelligence, blockchain, and cybersecurity. Join us for three days of learning, networking, and innovation.',
    'event_date' => '2023-12-15 09:00:00',
    'location' => 'Convention Center, Paris',
    'seats' => 200,
    'image' => ''
];

$pageTitle = "Event Details";
$isAdminPage = false;

include __DIR__ . '/../app/views/events/details.php';
<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing event list UI without backend

// Fake data for preview
$events = [
    [
        'id' => 1,
        'title' => 'Tech Conference 2023',
        'description' => 'Annual technology conference featuring keynote speakers and workshops.',
        'event_date' => '2023-12-15 09:00:00',
        'location' => 'Convention Center, Paris',
        'seats' => 200,
        'image' => ''
    ],
    [
        'id' => 2,
        'title' => 'Art Exhibition Opening',
        'description' => 'Inauguration of the new contemporary art exhibition.',
        'event_date' => '2023-12-20 18:00:00',
        'location' => 'Modern Art Museum',
        'seats' => 150,
        'image' => ''
    ],
    [
        'id' => 3,
        'title' => 'Music Festival',
        'description' => 'Three-day outdoor music festival with international artists.',
        'event_date' => '2024-01-10 12:00:00',
        'location' => 'Central Park',
        'seats' => 5000,
        'image' => ''
    ]
];

$pageTitle = "Events";
$isAdminPage = false;

include __DIR__ . '/../app/views/events/list.php';
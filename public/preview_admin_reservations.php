<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing admin reservations UI without backend

$BASE_URL = "";
$pageTitle = "Event Reservations";
$isAdminPage = true;
$layout = "admin";

// URL overrides for preview
$ADMIN_DASHBOARD_URL = "/preview_admin_dashboard.php";
$ADMIN_RESERVATIONS_URL = "/preview_admin_reservations.php";

// Mock data for event
$event = [
    'id' => 1,
    'title' => 'Tech Conference 2023',
    'description' => 'Annual technology conference featuring keynote speakers and workshops.',
    'event_date' => '2023-12-15 09:00:00',
    'location' => 'Convention Center, Paris',
    'seats' => 200,
    'image' => ''
];

// Mock data for reservations
$reservations = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1234567890',
        'created_at' => '2023-12-10 14:30:00',
        'status' => 'CONFIRMED'
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '+0987654321',
        'created_at' => '2023-12-11 16:45:00',
        'status' => 'PENDING'
    ],
    [
        'id' => 3,
        'name' => 'Robert Johnson',
        'email' => 'robert.j@example.com',
        'phone' => '+1122334455',
        'created_at' => '2023-12-12 09:15:00',
        'status' => 'CONFIRMED'
    ]
];

// Load the view directly
include __DIR__ . '/../app/views/admin/reservations.php';
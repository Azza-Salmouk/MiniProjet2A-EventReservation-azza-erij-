<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing admin event form UI without backend

$BASE_URL = "";
$pageTitle = "New Event";
$isAdminPage = true;
$isEdit = false;
$event = []; // Empty for new event
$error = ""; // Set to a message to test error display

include __DIR__ . '/../app/views/partials/header.php';
include __DIR__ . '/../app/views/admin/form_event.php';
include __DIR__ . '/../app/views/partials/footer.php';
<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing admin event form UI without backend

$BASE_URL = "";
$pageTitle = "New Event";
$isAdminPage = true;
$layout = "admin";
$isEdit = false;
$event = []; // Empty for new event
$error = ""; // Set to a message to test error display

// URL overrides for preview
$ADMIN_DASHBOARD_URL = "/preview_admin_dashboard.php";
$ADMIN_FORM_EVENT_URL = "/preview_admin_form_event.php";

include __DIR__ . '/../app/views/partials/header.php';
include __DIR__ . '/../app/views/admin/form_event.php';
include __DIR__ . '/../app/views/partials/footer.php';
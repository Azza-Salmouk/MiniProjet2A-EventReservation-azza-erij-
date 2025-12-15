<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing admin login UI without backend

$BASE_URL = "";
$pageTitle = "Admin Login";
$isAdminPage = true;
$error = ""; // Set to a message to test error display

include __DIR__ . '/../app/views/partials/header.php';
include __DIR__ . '/../app/views/admin/login.php';
include __DIR__ . '/../app/views/partials/footer.php';
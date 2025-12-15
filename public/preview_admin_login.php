<?php
// DEV ONLY (can be deleted before submission)
// Preview file for testing admin login UI without backend

$BASE_URL = "";
$pageTitle = "Admin Login";
$isAdminPage = true;
$layout = "admin";
$error = ""; // Set to a message to test error display

// URL overrides for preview
$ADMIN_LOGIN_URL = "/preview_admin_login.php";
$EVENTS_LIST_URL = "/preview_list.php";

include __DIR__ . '/../app/views/partials/header.php';
include __DIR__ . '/../app/views/admin/login.php';
include __DIR__ . '/../app/views/partials/footer.php';
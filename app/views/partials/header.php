<?php
// Base URL (pour que les liens et css marchent même si le projet est dans /.../public)
// More robust BASE_URL calculation for Windows and preview files
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$baseUrl = str_replace('\\', '/', dirname($scriptName));
// For preview files in public directory, we need to go up one level
if (strpos($scriptName, '/preview_') !== false) {
    $BASE_URL = rtrim($baseUrl, '/');
} else {
    $BASE_URL = rtrim($baseUrl, '/');
}
// Ensure we don't have '.' or '/' as base URL
if ($BASE_URL === '.' || $BASE_URL === '/') {
    $BASE_URL = '';
}

// URL fallbacks for flexible routing
$EVENTS_LIST_URL = $EVENTS_LIST_URL ?? "/";
$EVENT_DETAILS_URL = $EVENT_DETAILS_URL ?? "/event";
$ADMIN_LOGIN_URL = $ADMIN_LOGIN_URL ?? "/admin/login";
$ADMIN_DASHBOARD_URL = $ADMIN_DASHBOARD_URL ?? "/admin";
$ADMIN_RESERVATIONS_URL = $ADMIN_RESERVATIONS_URL ?? "/admin/reservations";
$ADMIN_FORM_EVENT_URL = $ADMIN_FORM_EVENT_URL ?? "/admin/event/new";
$ADMIN_LOGOUT_URL = $ADMIN_LOGOUT_URL ?? "/admin/logout";

// Determine current page for active link highlighting
$currentScript = basename($_SERVER['SCRIPT_NAME']);
$currentPage = str_replace('.php', '', $currentScript);

$pageTitle = $pageTitle ?? "MiniEvent";
$isAdminPage = $isAdminPage ?? false;
$layout = $layout ?? "public"; // "public" or "admin"
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $BASE_URL ?>/css/style.css?v=<?= filemtime(__DIR__ . '/../../../public/css/style.css') ?>">
</head>
<body>
  <header class="topbar">
    <div class="container topbar-inner">
      <a class="brand" href="<?= $EVENTS_LIST_URL ?>">MiniEvent</a>
      <nav class="nav">
        <?php if ($layout === "admin"): ?>
          <a href="<?= $ADMIN_DASHBOARD_URL ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'admin') !== false && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false || $_SERVER['REQUEST_URI'] === '/admin' || $_SERVER['REQUEST_URI'] === '/admin/' ? 'active' : '' ?>">Dashboard</a>
          <a href="<?= $ADMIN_RESERVATIONS_URL ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'reservations') !== false ? 'active' : '' ?>">Reservations</a>
          <a href="<?= $ADMIN_FORM_EVENT_URL ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'new') !== false || strpos($_SERVER['REQUEST_URI'], 'edit') !== false ? 'active' : '' ?>">New Event</a>
          <a href="<?= $ADMIN_LOGOUT_URL ?>" class="danger">Logout</a>
        <?php else: ?>
          <a href="<?= $EVENTS_LIST_URL ?>" class="<?= $_SERVER['REQUEST_URI'] === '/' || $currentPage === 'preview_list' || $currentPage === 'list' ? 'active' : '' ?>">Events</a>
          <a href="<?= $ADMIN_LOGIN_URL ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'login') !== false ? 'active' : '' ?>">Admin</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container">
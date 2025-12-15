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

$pageTitle = $pageTitle ?? "MiniEvent";
$isAdminPage = $isAdminPage ?? false;
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
      <a class="brand" href="<?= $BASE_URL ?>/">MiniEvent</a>
      <nav class="nav">
        <?php if ($isAdminPage): ?>
          <a href="<?= $BASE_URL ?>/admin">Dashboard</a>
          <a href="<?= $BASE_URL ?>/admin/logout" class="danger">Logout</a>
        <?php else: ?>
          <a href="<?= $BASE_URL ?>/">Events</a>
          <a href="<?= $BASE_URL ?>/admin/login">Admin</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container">
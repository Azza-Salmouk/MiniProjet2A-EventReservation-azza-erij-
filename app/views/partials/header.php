<?php
// Base URL (pour que les liens et css marchent même si le projet est dans /.../public)
$BASE_URL = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
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
  <link rel="stylesheet" href="<?= $BASE_URL ?>/css/style.css?v=1">
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
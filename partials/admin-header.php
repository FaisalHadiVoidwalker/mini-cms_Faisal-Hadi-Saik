<?php
if (!isset($title)) $title = "Admin Panel";
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

  <div class="overlay" id="overlay"></div>

  <div class="container-fluid">
    <div class="row">

      <!-- SIDEBAR -->
      <div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-2 px-3 py-3">
          <img src="/assets/images/MC_Logo__1_-removebg-preview.png" alt="Logo" width="50" height="50">
          <span class="fw-semibold">Mini CMS Admin</span>
        </div>

        <a href="admin.php" class="<?= ($_GET['page'] ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>">
          📊 Dashboard
        </a>

        <a href="admin.php?page=tambah" class="<?= ($_GET['page'] ?? '') === 'tambah' ? 'active' : '' ?>">
          ➕ Tambah Artikel
        </a>

        <a href="index.php">🌐 Lihat Website</a>
        <a href="auth/logout.php" class="logout">🚪 Logout</a>
      </div>

      <!-- CONTENT -->
      <div class="col-md-9 col-lg-10 content">

        <div class="d-flex justify-content-between align-items-center mb-4">

          <button class="btn btn-dark d-md-none" id="menuToggle">
            ☰
          </button>

          <h2 class="page-title mb-0"><?= htmlspecialchars($title) ?></h2>

          <span class="text-muted">
            Halo, <?= htmlspecialchars($_SESSION['username']) ?> 👋
          </span>
        </div>
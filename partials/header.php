<?php if (!isset($title)) $title = "Mini CMS"; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/public.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php">
        <img src="/assets/images/MC_Logo__1_-removebg-preview.png" alt="Logo" width="50" height="50">
        <span>Mini CMS</span>
      </a>

      <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="/auth/login.php" class="nav-link">
              🔐 Login Admin
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="main-content">
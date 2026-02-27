<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: /admin.php");
  exit;
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$title = "Login Admin";
require __DIR__ . '/../partials/header.php';
?>

<div class="d-flex flex-grow-1 justify-content-center align-items-center">

  <div class="card p-4" style="width:100%; max-width:400px;">
    <h4 class="text-center mb-3">🔐 Login Admin</h4>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">
        Username atau password salah.
      </div>
    <?php endif; ?>

    <form method="POST" action="/auth/login_process.php">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>

      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

      <button type="submit" class="btn btn-primary w-100">
        Login
      </button>
    </form>
  </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
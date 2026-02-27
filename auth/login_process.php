<?php
session_start();

require_once __DIR__ . "/../config/connectDB.php";

/* ===== CSRF VALIDATION ===== */
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    session_destroy();
    header("Location: login.php?error=1");
    exit;
}

/* ===== INPUT ===== */
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: login.php?error=1");
    exit;
}

/* ===== QUERY USER ===== */
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* ===== VERIFY PASSWORD ===== */
if ($user && password_verify($password, $user['password'])) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header("Location: ../admin.php");
    exit;
}

/* ===== LOGIN FAILED ===== */
header("Location: login.php?error=1");
exit;

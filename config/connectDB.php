<?php
$host = 'localhost';
$dbname = 'mini_cms';
$username = 'remoteFai';
$password = 'pass123';
try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$dbname",
    $username,
    $password
  );
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi Database Gagal: " . $e->getMessage());
}

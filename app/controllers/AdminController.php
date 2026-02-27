<?php

require_once __DIR__ . '/../models/Artikel.php';

class AdminController
{
  private $artikelModel;

  public function __construct($pdo)
  {
    $this->artikelModel = new Artikel($pdo);
  }

  /* =====================================
       AUTH CHECK
    ====================================== */
  private function authCheck()
  {
    if (!isset($_SESSION['user_id'])) {
      header("Location: auth/login.php");
      exit;
    }
  }

  /* =====================================
       DASHBOARD
    ====================================== */
  public function dashboard()
  {
    $this->authCheck();

    $artikels = $this->artikelModel->getAll();
    $totalArtikel = count($artikels);

    $title = "Dashboard";
    require __DIR__ . "/../views/admin/dashboard.php";
  }

  /* =====================================
       FORM TAMBAH
    ====================================== */
  public function tambah()
  {
    $this->authCheck();

    $title = "Tambah Artikel";
    require __DIR__ . "/../views/admin/tambah.php";
  }

  /* =====================================
       STORE (INSERT)
    ====================================== */
  public function store()
  {
    $this->authCheck();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: admin.php");
      exit;
    }

    $judul = trim($_POST['judul'] ?? '');
    $isi   = trim($_POST['isi'] ?? '');

    if (empty($judul) || empty($isi)) {
      header("Location: admin.php?page=tambah");
      exit;
    }

    $gambarName = null;

    // HANDLE UPLOAD
    if (!empty($_FILES['gambar']['name'])) {

      $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      $maxSize = 2 * 1024 * 1024; // 2MB

      if (
        in_array($_FILES['gambar']['type'], $allowedTypes) &&
        $_FILES['gambar']['size'] <= $maxSize
      ) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambarName = time() . '_' . uniqid() . '.' . $ext;

        move_uploaded_file(
          $_FILES['gambar']['tmp_name'],
          __DIR__ . '/../../uploads/' . $gambarName
        );
      }
    }

    $this->artikelModel->insert([
      'judul' => $judul,
      'isi' => $isi,
      'gambar' => $gambarName
    ]);

    header("Location: admin.php");
    exit;
  }

  /* =====================================
       FORM EDIT
    ====================================== */
  public function edit($id)
  {
    $this->authCheck();

    if (!$id || !is_numeric($id)) {
      header("Location: admin.php");
      exit;
    }

    $artikel = $this->artikelModel->getById($id);

    if (!$artikel) {
      header("Location: admin.php");
      exit;
    }

    $title = "Edit Artikel";
    require __DIR__ . "/../views/admin/edit.php";
  }

  /* =====================================
       UPDATE
    ====================================== */
  public function update($id)
  {
    $this->authCheck();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
      header("Location: admin.php");
      exit;
    }

    $artikel = $this->artikelModel->getById($id);

    if (!$artikel) {
      header("Location: admin.php");
      exit;
    }

    $judul = trim($_POST['judul'] ?? '');
    $isi   = trim($_POST['isi'] ?? '');

    if (empty($judul) || empty($isi)) {
      header("Location: admin.php?page=edit&id=" . $id);
      exit;
    }

    $gambarName = $artikel['gambar'];

    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {

      $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      $maxSize = 2 * 1024 * 1024;

      if (
        in_array($_FILES['gambar']['type'], $allowedTypes) &&
        $_FILES['gambar']['size'] <= $maxSize
      ) {
        // Hapus gambar lama
        if (!empty($artikel['gambar'])) {
          $oldPath = __DIR__ . '/../../uploads/' . $artikel['gambar'];
          if (file_exists($oldPath)) {
            unlink($oldPath);
          }
        }

        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambarName = time() . '_' . uniqid() . '.' . $ext;

        move_uploaded_file(
          $_FILES['gambar']['tmp_name'],
          __DIR__ . '/../../uploads/' . $gambarName
        );
      }
    }

    $this->artikelModel->update($id, [
      'judul' => $judul,
      'isi' => $isi,
      'gambar' => $gambarName
    ]);

    header("Location: admin.php");
    exit;
  }

  /* =====================================
       DELETE
    ====================================== */
  public function hapus($id)
  {
    $this->authCheck();

    if (!$id || !is_numeric($id)) {
      header("Location: admin.php");
      exit;
    }

    $artikel = $this->artikelModel->getById($id);

    if ($artikel) {

      if (!empty($artikel['gambar'])) {
        $filePath = __DIR__ . "/../../uploads/" . $artikel['gambar'];

        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }

      $this->artikelModel->delete($id);
    }

    header("Location: admin.php");
    exit;
  }
}

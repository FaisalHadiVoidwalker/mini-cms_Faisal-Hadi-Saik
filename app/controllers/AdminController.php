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
      $_SESSION['error'] = "Judul dan isi wajib diisi.";
      header("Location: admin.php?page=tambah");
      exit;
    }

    $gambarName = null;

    // HANDLE UPLOAD
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {

      $allowedMimeTypes = ['image/jpeg', 'image/png'];
      $fileTmp  = $_FILES['gambar']['tmp_name'];
      $fileSize = $_FILES['gambar']['size'];

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime  = finfo_file($finfo, $fileTmp);
      finfo_close($finfo);

      // Validasi MIME
      if (!in_array($mime, $allowedMimeTypes)) {
        $_SESSION['error'] = "Format file tidak diperbolehkan. Hanya JPG dan PNG.";
        header("Location: admin.php?page=tambah");
        exit;
      }

      // Validasi ukuran (2MB)
      if ($fileSize > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
        header("Location: admin.php?page=tambah");
        exit;
      }

      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $gambarName = time() . "_" . uniqid() . "." . $ext;

      move_uploaded_file(
        $fileTmp,
        __DIR__ . '/../../uploads/' . $gambarName
      );
    }

    $this->artikelModel->insert([
      'judul'  => $judul,
      'isi'    => $isi,
      'gambar' => $gambarName
    ]);

    $_SESSION['success'] = "Artikel berhasil ditambahkan.";
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
  public function update()
  {
    $this->authCheck();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: admin.php");
      exit;
    }

    $id    = $_POST['id'] ?? '';
    $judul = trim($_POST['judul'] ?? '');
    $isi   = trim($_POST['isi'] ?? '');

    // Ambil data lama
    $artikelLama = $this->artikelModel->getById($id);

    $gambarName = $artikelLama['gambar']; // default pakai gambar lama

    // HANDLE UPLOAD BARU (jika ada)
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {

      $allowedMimeTypes = ['image/jpeg', 'image/png'];
      $fileTmp  = $_FILES['gambar']['tmp_name'];
      $fileSize = $_FILES['gambar']['size'];

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime  = finfo_file($finfo, $fileTmp);
      finfo_close($finfo);

      // Validasi MIME
      if (!in_array($mime, $allowedMimeTypes)) {
        $_SESSION['error'] = "Format file tidak diperbolehkan. Hanya JPG dan PNG.";
        header("Location: admin.php?page=edit&id=" . $id);
        exit;
      }

      // Validasi ukuran 2MB
      if ($fileSize > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
        header("Location: admin.php?page=edit&id=" . $id);
        exit;
      }

      // Hapus gambar lama jika ada
      if ($gambarName && file_exists(__DIR__ . '/../../uploads/' . $gambarName)) {
        unlink(__DIR__ . '/../../uploads/' . $gambarName);
      }

      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $gambarName = time() . "_" . uniqid() . "." . $ext;

      move_uploaded_file(
        $fileTmp,
        __DIR__ . '/../../uploads/' . $gambarName
      );
    }

    // Update database
    $this->artikelModel->update($id, [
      'judul'  => $judul,
      'isi'    => $isi,
      'gambar' => $gambarName
    ]);

    $_SESSION['success'] = "Artikel berhasil diperbarui.";
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

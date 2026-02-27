<?php

require_once __DIR__ . '/../models/Artikel.php';
class HomeController
{
  private $artikelModel;

  public function __construct($pdo)
  {
    $this->artikelModel = new Artikel($pdo);
  }

  public function home()
  {
    $artikels = $this->artikelModel->getAll();
    $title = "Beranda";

    require __DIR__ . "/../views/home.php";
  }

  public function detail($id)
  {
    if (!$id || !is_numeric($id)) {
      header("Location: index.php");
      exit;
    }

    $artikel = $this->artikelModel->getById($id);

    if (!$artikel) {
      header("Location: index.php");
      exit;
    }

    $title = $artikel['judul'];
    require __DIR__ . "/../views/detail.php";
  }
}

<?php

class Artikel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  /* =============================
       GET ALL ARTIKEL
    ============================== */
  public function getAll()
  {
    $stmt = $this->pdo->query("SELECT * FROM artikel ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /* =============================
       GET ARTIKEL BY ID
    ============================== */
  public function getById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM artikel WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /* =============================
       DELETE ARTIKEL
    ============================== */
  public function delete($id)
  {
    $stmt = $this->pdo->prepare("DELETE FROM artikel WHERE id = :id");
    return $stmt->execute(['id' => $id]);
  }

  /* =============================
       INSERT ARTIKEL
    ============================== */
  public function insert($data)
  {
    $stmt = $this->pdo->prepare("
            INSERT INTO artikel (judul, isi, gambar, created_at)
            VALUES (:judul, :isi, :gambar, NOW())
        ");

    return $stmt->execute([
      'judul' => $data['judul'],
      'isi' => $data['isi'],
      'gambar' => $data['gambar']
    ]);
  }

  /* =============================
       UPDATE ARTIKEL
    ============================== */
  public function update($id, $data)
  {
    $stmt = $this->pdo->prepare("
            UPDATE artikel
            SET judul = :judul,
                isi = :isi,
                gambar = :gambar
            WHERE id = :id
        ");

    return $stmt->execute([
      'judul' => $data['judul'],
      'isi' => $data['isi'],
      'gambar' => $data['gambar'],
      'id' => $id
    ]);
  }
}

<?php $title = "Edit Artikel"; ?>
<?php require __DIR__ . '/../../../partials/admin-header.php'; ?>

<div class="card shadow-sm border-0">
  <div class="card-body">

    <form method="POST"
      action="admin.php?page=update&id=<?= $artikel['id'] ?>"
      enctype="multipart/form-data">

      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text"
          name="judul"
          class="form-control"
          value="<?= htmlspecialchars($artikel['judul']) ?>"
          required>
      </div>

      <div class="mb-3">
        <label class="form-label">Isi Artikel</label>
        <textarea name="isi" rows="6" class="form-control" required><?= htmlspecialchars($artikel['isi']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar Saat Ini</label><br>
        <?php if (!empty($artikel['gambar'])): ?>
          <img src="uploads/<?= htmlspecialchars($artikel['gambar']) ?>"
            width="150" class="mb-2">
        <?php else: ?>
          <p class="text-muted">Tidak ada gambar</p>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Ganti Gambar</label>
        <input type="file" name="gambar" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">
        Update
      </button>

      <a href="admin.php" class="btn btn-secondary">
        Batal
      </a>

    </form>

  </div>
</div>

<?php require __DIR__ . '/../../../partials/admin-footer.php'; ?>
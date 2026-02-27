<?php $title = "Dashboard"; ?>
<?php require __DIR__ . '/../../../partials/admin-header.php'; ?>

<div class="card shadow-sm border-0">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Daftar Artikel</h5>
      <a href="admin.php?page=tambah" class="btn btn-primary btn-sm">
        ➕ Tambah Artikel
      </a>
    </div>

    <?php if ($totalArtikel === 0): ?>
      <div class="alert alert-info text-center">
        Belum ada artikel.
      </div>
    <?php else: ?>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Judul</th>
              <th>Tanggal</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($artikels as $a): ?>
              <tr>
                <td><?= htmlspecialchars($a['judul']) ?></td>
                <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                <td>
                  <a href="admin.php?page=edit&id=<?= $a['id'] ?>"
                    class="btn btn-warning btn-sm">Edit</a>

                  <a href="admin.php?page=hapus&id=<?= $a['id'] ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                    Hapus
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php endif; ?>

  </div>
</div>

<?php require __DIR__ . '/../../../partials/admin-footer.php'; ?>
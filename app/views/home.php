<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="container mt-5 mb-5">

  <div class="text-center page-header">
    <h2>Daftar Artikel</h2>
    <p class="text-muted">
      <?= count($artikels) ?> artikel tersedia
    </p>
  </div>

  <?php if (count($artikels) === 0): ?>
    <div class="alert alert-info text-center">
      Belum ada artikel yang dipublikasikan.
    </div>
  <?php endif; ?>

  <div class="row">
    <?php foreach ($artikels as $a): ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card article-card shadow-sm h-100">

          <?php if (!empty($a['gambar'])): ?>
            <img src="uploads/<?= htmlspecialchars($a['gambar']) ?>" class="card-img-top">
          <?php endif; ?>

          <div class="card-body d-flex flex-column">

            <h5 class="fw-bold">
              <?= htmlspecialchars($a['judul']) ?>
            </h5>

            <p class="text-muted small mb-2">
              <?= date('d M Y', strtotime($a['created_at'])) ?>
            </p>

            <p class="text-muted">
              <?= substr(strip_tags($a['isi']), 0, 120) ?>...
            </p>

            <div class="mt-auto">
              <a href="index.php?page=detail&id=<?= $a['id'] ?>"
                class="btn btn-primary btn-sm w-100">
                Baca Selengkapnya →
              </a>
            </div>

          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="container mt-5 mb-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card article-detail-card shadow-sm">

                <?php if (!empty($artikel['gambar'])): ?>
                    <img src="uploads/<?= htmlspecialchars($artikel['gambar']) ?>" class="card-img-top">
                <?php endif; ?>

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-2">
                        <?= htmlspecialchars($artikel['judul']) ?>
                    </h2>

                    <p class="text-muted small mb-4">
                        Dipublikasikan pada
                        <?= date('d F Y', strtotime($artikel['created_at'])) ?>
                    </p>

                    <div class="article-content">
                        <?= nl2br(htmlspecialchars($artikel['isi'])) ?>
                    </div>

                    <hr class="my-4">

                    <a href="index.php" class="btn btn-secondary">
                        ← Kembali ke Beranda
                    </a>

                </div>

            </div>

        </div>
    </div>

</div>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
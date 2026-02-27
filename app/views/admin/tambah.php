<?php $title = "Tambah Artikel"; ?>
<?php require __DIR__ . '/../../../partials/admin-header.php'; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST"
            action="admin.php?page=store"
            enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Artikel</label>
                <textarea name="isi" rows="6" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">
                Simpan
            </button>

            <a href="admin.php" class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>
</div>

<?php require __DIR__ . '/../../../partials/admin-footer.php'; ?>
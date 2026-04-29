<?php
$isEdit = !empty($galeri);
$pageTitle = $isEdit ? 'Edit Galeri' : 'Tambah Galeri';
$formAction = $isEdit
    ? BASE_URL . '/admin/aksi_edit_galeri.php?id=' . $galeri['id']
    : BASE_URL . '/admin/aksi_tambah_galeri.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= BASE_URL ?>/admin/galeri.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-white fw-bold mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted mb-0"><?= $isEdit ? 'Perbarui foto galeri' : 'Tambahkan foto baru ke galeri' ?></p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mk-admin-card">
            <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Judul Foto *</label>
                    <input type="text" name="judul" class="form-control mk-input" required
                           value="<?= e($galeri['judul'] ?? '') ?>"
                           placeholder="Contoh: Lorong Cahaya">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Kategori *</label>
                    <select name="kategori" class="form-select mk-input" required>
                        <?php
                        $kategoriList = ['Wahana & Permainan', 'Pemandangan', 'Bersantai', 'Pertunjukan'];
                        foreach ($kategoriList as $kat):
                        ?>
                        <option value="<?= e($kat) ?>" <?= ($galeri['kategori'] ?? '') === $kat ? 'selected' : '' ?>>
                            <?= e($kat) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Status</label>
                    <select name="status" class="form-select mk-input">
                        <option value="aktif" <?= ($galeri['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= ($galeri['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <?php if ($isEdit && !empty($galeri['foto'])): ?>
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Foto Saat Ini</label>
                    <div>
                        <img src="<?= BASE_URL ?>/public/uploads/galeri/<?= e($galeri['foto']) ?>"
                             alt="<?= e($galeri['judul']) ?>"
                             style="width:100%;max-height:280px;object-fit:cover;border-radius:1rem">
                    </div>
                </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">
                        Foto <?= $isEdit ? '(kosongkan jika tidak diganti)' : '*' ?>
                    </label>
                    <input type="file" name="foto" class="form-control mk-input"
                           accept="image/jpeg,image/png,image/webp"
                           <?= $isEdit ? '' : 'required' ?>>
                    <small class="text-muted">Format JPG, PNG, WEBP. Maksimal 3MB.</small>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-floppy2 me-2"></i>Simpan
                    </button>
                    <a href="<?= BASE_URL ?>/admin/galeri.php" class="btn btn-outline-secondary px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $pageTitle = 'Data Galeri'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="text-white fw-bold mb-1">Data Galeri</h2>
        <p class="text-muted mb-0"><?= count($galeriList) ?> foto galeri terdaftar</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/tambah_galeri.php" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-circle me-2"></i>Tambah Galeri
    </a>
</div>

<div class="mk-admin-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead class="border-bottom border-secondary">
                <tr>
                    <th class="px-4 py-3 text-muted small fw-semibold">#</th>
                    <th class="px-4 py-3 text-muted small fw-semibold">Foto</th>
                    <th class="px-4 py-3 text-muted small fw-semibold">Judul</th>
                    <th class="px-4 py-3 text-muted small fw-semibold">Kategori</th>
                    <th class="px-4 py-3 text-muted small fw-semibold">Status</th>
                    <th class="px-4 py-3 text-muted small fw-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($galeriList)): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-images text-warning" style="font-size:2.5rem"></i>
                        <p class="mt-3 mb-0">Belum ada data galeri.</p>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($galeriList as $i => $g): ?>
                <tr>
                    <td class="px-4 py-3 text-muted"><?= $i + 1 ?></td>
                    <td class="px-4 py-3">
                        <img src="<?= BASE_URL ?>/public/uploads/galeri/<?= e($g['foto']) ?>"
                             alt="<?= e($g['judul']) ?>"
                             style="width:90px;height:60px;object-fit:cover;border-radius:.75rem">
                    </td>
                    <td class="px-4 py-3 text-white fw-semibold"><?= e($g['judul']) ?></td>
                    <td class="px-4 py-3">
                        <span class="badge mk-badge-kategori"><?= e($g['kategori']) ?></span>
                    </td>
                    <td class="px-4 py-3">
                        <?= badgeStatus($g['status']) ?>
                    </td>
                    <td class="px-4 py-3">
                        <div class="d-flex gap-2">
                            <a href="<?= BASE_URL ?>/admin/edit_galeri.php?id=<?= $g['id'] ?>"
                               class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                onclick="konfirmasiHapus('<?= BASE_URL ?>/admin/aksi_hapus_galeri.php?id=<?= $g['id'] ?>', '<?= e(addslashes($g['judul'])) ?>')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border border-danger">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-muted">
                Apakah kamu yakin ingin menghapus foto <strong class="text-white" id="namaHapus"></strong>?
                <div class="alert alert-danger mt-3 mb-0 py-2 small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong> dan file foto akan ikut terhapus.
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="btnHapusKonfirm" href="#" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function konfirmasiHapus(url, nama) {
    document.getElementById('namaHapus').textContent = nama;
    document.getElementById('btnHapusKonfirm').href = url;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
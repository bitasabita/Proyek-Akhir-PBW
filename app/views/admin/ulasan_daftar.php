<?php $pageTitle = 'Kelola Ulasan'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="text-white fw-bold mb-1">Kelola Ulasan</h2>
        <p class="text-muted mb-0"><?= count($ulasan) ?> ulasan ditemukan</p>
    </div>
</div>

<div id="ulasanApp">
    <div class="mb-4">
        <div class="input-group" style="max-width:400px">
            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
            <input v-model="search" type="text" class="form-control mk-input" placeholder="Cari nama atau isi ulasan...">
        </div>
    </div>

    <?php if (empty($ulasan)): ?>
    <div class="mk-admin-card text-center py-5">
        <i class="bi bi-chat-dots text-warning" style="font-size:3rem"></i>
        <h5 class="text-white mt-3">Tidak ada ulasan</h5>
        <p class="text-muted">Belum ada ulasan.</p>
    </div>
    <?php else: ?>

    <div class="vstack gap-3">
        <?php foreach ($ulasan as $ul): ?>
        <div class="mk-admin-card mk-ulasan-row"
            data-search="<?= strtolower(e($ul['nama_pengunjung'] . ' ' . $ul['isi_ulasan'])) ?>">
            <div class="row g-3 align-items-start">

                <div class="col-md-3">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="mk-avatar flex-shrink-0">
                            <?= strtoupper(substr($ul['nama_pengunjung'], 0, 2)) ?>
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-white fw-semibold text-truncate"><?= e($ul['nama_pengunjung']) ?></div>
                            <?php if ($ul['email']): ?>
                            <div class="text-muted small text-truncate"><?= e($ul['email']) ?></div>
                            <?php endif; ?>
                            <div class="text-muted" style="font-size:.7rem">
                                <?= date('d M Y', strtotime($ul['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex gap-1 mb-1">
                        <?php for($i=1;$i<=5;$i++): ?>
                        <i class="bi bi-star<?= $i<=$ul['rating']?'-fill':'' ?> text-warning" style="font-size:.75rem"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="text-muted small mb-1">
                        <i class="bi bi-geo-alt me-1 text-warning"></i>
                        <?= e($ul['nama_wisata'] ?? 'Ulasan Umum') ?>
                    </div>
                    <?php if ($ul['judul']): ?>
                    <strong class="text-white d-block small"><?= e($ul['judul']) ?></strong>
                    <?php endif; ?>
                    <p class="text-muted small mb-0" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                        <?= e($ul['isi_ulasan']) ?>
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-md-end gap-2">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus"
                                onclick="konfirmasiHapus('<?= BASE_URL ?>/admin/aksi_hapus_ulasan.php?id=<?= $ul['id'] ?>', '<?= e(addslashes($ul['nama_pengunjung'])) ?>')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
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
                Apakah kamu yakin ingin menghapus ulasan dari <strong class="text-white" id="namaHapus"></strong>?
                <div class="alert alert-danger mt-3 mb-0 py-2 small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>.
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

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;
createApp({
    data() { return { search: '' }; },
    watch: {
        search(val) {
            document.querySelectorAll('.mk-ulasan-row').forEach(row => {
                const text = row.dataset.search || '';
                row.style.display = !val || text.includes(val.toLowerCase()) ? '' : 'none';
            });
        }
    }
}).mount('#ulasanApp');

function konfirmasiHapus(url, nama) {
    document.getElementById('namaHapus').textContent = nama;
    document.getElementById('btnHapusKonfirm').href = url;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
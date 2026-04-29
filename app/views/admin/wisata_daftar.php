<?php $pageTitle = 'Data Wisata'; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="text-white fw-bold mb-1">Data Wisata</h2>
        <p class="text-muted mb-0"><?= count($wisataList) ?> destinasi terdaftar</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/tambah_wisata.php" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-circle me-2"></i>Tambah Wisata
    </a>
</div>

<div id="wisataTableApp">
    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
                <input v-model="search" type="text" class="form-control mk-input" placeholder="Cari nama wisata...">
            </div>
        </div>
        <div class="col-md-4">
            <select v-model="filterKat" class="form-select mk-input">
                <option value="">Semua Kategori</option>
                <option value="alam">Alam</option>
                <option value="budaya">Budaya</option>
                <option value="wahana">Wahana</option>
                <option value="kuliner">Kuliner</option>
            </select>
        </div>
        <div class="col-md-3">
            <select v-model="filterStatus" class="form-select mk-input">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Non-aktif</option>
            </select>
        </div>
    </div>

    <div class="mk-admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead class="border-bottom border-secondary">
                    <tr>
                        <th class="px-4 py-3 text-muted small fw-semibold">#</th>
                        <th class="px-4 py-3 text-muted small fw-semibold">Nama Wisata</th>
                        <th class="px-4 py-3 text-muted small fw-semibold d-none d-md-table-cell">Kategori</th>
                        <th class="px-4 py-3 text-muted small fw-semibold d-none d-lg-table-cell">Harga Weekday</th>
                        <th class="px-4 py-3 text-muted small fw-semibold">Status</th>
                        <th class="px-4 py-3 text-muted small fw-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($wisataList)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem"></i>
                            <p class="mt-2 mb-0">Belum ada data wisata.</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($wisataList as $i => $w): ?>
                    <tr class="mk-table-row" data-nama="<?= strtolower(e($w['nama'])) ?>"
                        data-kategori="<?= e($w['kategori']) ?>"
                        data-status="<?= e($w['status']) ?>">
                        <td class="px-4 py-3 text-muted"><?= $i + 1 ?></td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="mk-table-thumb">
                                    <img src="<?= fotoWisata($w['foto_utama']) ?>"
                                         alt="" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div>
                                    <div class="text-white fw-semibold"><?= e($w['nama']) ?></div>
                                    <?php if ($w['is_featured']): ?>
                                    <span class="badge bg-warning text-dark" style="font-size:.6rem">
                                        <i class="bi bi-star-fill"></i> Unggulan
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 d-none d-md-table-cell">
                            <span class="badge mk-badge-kategori"><?= ucfirst(e($w['kategori'])) ?></span>
                        </td>
                        <td class="px-4 py-3 text-warning d-none d-lg-table-cell">
                            <?= formatRupiah($w['harga_weekday']) ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= badgeStatus($w['status']) ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex gap-2">
                                <a href="<?= BASE_URL ?>/wisata/detail.php?slug=<?= e($w['slug']) ?>"
                                   target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/admin/edit_wisata.php?id=<?= $w['id'] ?>"
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                    onclick="konfirmasiHapus('<?= BASE_URL ?>/admin/aksi_hapus_wisata.php?id=<?= $w['id'] ?>', '<?= e(addslashes($w['nama'])) ?>')">
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
</div>

<!-- Modal Konfirmasi Hapus -->
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
                Apakah kamu yakin ingin menghapus wisata <strong class="text-white" id="namaHapus"></strong>?
                <div class="alert alert-danger mt-3 mb-0 py-2 small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong> dan akan menghapus semua data terkait.
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
    data() {
        return { search: '', filterKat: '', filterStatus: '' };
    },
    watch: {
        search() { this.filterRows(); },
        filterKat() { this.filterRows(); },
        filterStatus() { this.filterRows(); }
    },
    methods: {
        filterRows() {
            const rows = document.querySelectorAll('.mk-table-row');
            rows.forEach(row => {
                const nama    = row.dataset.nama || '';
                const kat     = row.dataset.kategori || '';
                const status  = row.dataset.status || '';
                const matchSearch = !this.search || nama.includes(this.search.toLowerCase());
                const matchKat    = !this.filterKat || kat === this.filterKat;
                const matchStatus = !this.filterStatus || status === this.filterStatus;
                row.style.display = (matchSearch && matchKat && matchStatus) ? '' : 'none';
            });
        }
    }
}).mount('#wisataTableApp');

function konfirmasiHapus(url, nama) {
    document.getElementById('namaHapus').textContent = nama;
    document.getElementById('btnHapusKonfirm').href = url;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
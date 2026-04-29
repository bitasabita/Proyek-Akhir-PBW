<?php $pageTitle = 'Dashboard'; ?>
<div class="mk-page-title mb-4">
    <h2 class="text-white fw-bold mb-1">Dashboard</h2>
    <p class="text-muted mb-0">Selamat datang, <strong class="text-warning"><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></strong></p>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="mk-stat-admin-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Total Wisata</p>
                            <h2 class="text-white fw-bold mb-0"><?= $totalWisata ?></h2>
                        </div>
                        <div class="mk-stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-15 text-success"><?= $totalWisataAktif ?> Aktif</span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="mk-stat-admin-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Total Ulasan</p>
                            <h2 class="text-white fw-bold mb-0"><?= $totalUlasan ?></h2>
                        </div>
                        <div class="mk-stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-chat-quote-fill"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-15 text-success">Ditampilkan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mk-admin-card">
            <h5 class="text-white mb-4"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
            <div class="vstack gap-3">
                <a href="<?= BASE_URL ?>/admin/tambah_wisata.php" class="btn btn-warning d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Wisata Baru
                </a>
                <a href="<?= BASE_URL ?>/admin/wisata.php" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-list-ul"></i> Kelola Data Wisata
                </a>
                <a href="<?= BASE_URL ?>/admin/ulasan.php" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-chat-quote"></i> Kelola Ulasan
                </a>
                <a href="<?= BASE_URL ?>/index.php" target="_blank" class="btn btn-outline-warning d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="mk-admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white mb-0"><i class="bi bi-chat-quote-fill text-warning me-2"></i>Ulasan Terbaru</h5>
                <a href="<?= BASE_URL ?>/admin/ulasan.php" class="btn btn-sm btn-outline-warning">Lihat Semua</a>
            </div>
            <?php if (empty($recentUlasan)): ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-chat-dots text-warning" style="font-size:2.5rem"></i>
                <p class="mt-2 mb-0">Belum ada ulasan masuk.</p>
            </div>
            <?php else: ?>
            <div class="vstack gap-3">
                <?php foreach (array_slice($recentUlasan, 0, 5) as $ul): ?>
                <div class="d-flex gap-3 p-3 rounded-3 bg-dark">
                    <div class="mk-avatar">
                        <?= strtoupper(substr($ul['nama_pengunjung'], 0, 2)) ?>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <strong class="text-white small"><?= e($ul['nama_pengunjung']) ?></strong>
                            <div class="d-flex gap-1 flex-shrink-0">
                                <?php for($i=1;$i<=5;$i++): ?>
                                <i class="bi bi-star<?= $i<=$ul['rating']?'-fill':'' ?> text-warning" style="font-size:.65rem"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="text-muted small"><?= e($ul['nama_wisata'] ?? 'Ulasan Umum') ?></div>
                        <p class="text-muted small mb-0 text-truncate"><?= e($ul['isi_ulasan']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<div class="mk-page-header py-5">
    <div class="container pt-5 text-center">
        <h1 style="font-family:'Cormorant SC',serif; font-weight:700; letter-spacing:.05em;" class="display-4 text-white">Jelajahi 
            <em class="text-warning" style="font-style:normal;">Wisata</em></h1>
        <p class="text-muted lead">Temukan semua destinasi menakjubkan di Mahakam Lampion Garden</p>

        <div class="mt-4">
            <p class="mk-body-text mb-0">
                Temukan berbagai destinasi terbaik di Mahakam Lampion Garden
            </p>
        </div>
    </div>
</div>

<div class="container py-5" id="daftarWisataApp">

    <?php if (!empty($_GET['search'])): ?>
    <div class="alert alert-dark border-secondary mb-4">
        <i class="bi bi-search me-2 text-warning"></i>
        Menampilkan hasil untuk: <strong>"<?= e($_GET['search']) ?>"</strong>
        &ndash; <?= count($wisataList) ?> destinasi ditemukan
    </div>
    <?php endif; ?>

    <?php if (empty($wisataList)): ?>
    <div class="text-center py-5">
        <i class="bi bi-binoculars text-warning" style="font-size:4rem"></i>
        <h4 class="text-white mt-3">Tidak ada wisata ditemukan</h4>
        <p class="text-muted">Saat ini belum ada destinasi yang tersedia.</p>
        <a href="<?= BASE_URL ?>/daftar_wisata.php" class="btn btn-warning">Muat Ulang</a>
    </div>
    <?php else: ?>
    <div class="row g-4 justify-content-center">
        <?php foreach ($wisataList as $w): ?>
        <div class="col-md-6 col-lg-4">
            <div class="mk-wisata-card h-100">
                <div class="mk-wisata-img position-relative overflow-hidden" style="height:220px">
                    <img src="<?= fotoWisata($w['foto_utama']) ?>"
                         alt="<?= e($w['nama']) ?>"
                         class="w-100 h-100 object-fit-cover" loading="lazy">
                    <div class="mk-wisata-overlay"></div>

                    <span class="badge mk-badge-kategori position-absolute top-0 start-0 m-3">
                        <?= ucfirst(e($w['kategori'])) ?>
                    </span>

                    <?php if ($w['is_featured']): ?>
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">
                        <i class="bi bi-star-fill me-1"></i>Unggulan
                    </span>
                    <?php endif; ?>
                </div>

                <div class="mk-wisata-body p-4 flex-grow-1 d-flex flex-column">
                    <h5 class="text-white fw-bold mb-2"><?= e($w['nama']) ?></h5>
                    <p class="text-muted small mb-3 flex-grow-1"><?= e(truncate($w['deskripsi_singkat'], 110)) ?></p>

                    <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                        <i class="bi bi-clock text-warning"></i>
                        <?= e($w['jam_buka']) ?> &ndash; <?= e($w['jam_tutup']) ?> WITA
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning fw-bold small"><?= formatRupiah($w['harga_weekday']) ?></div>
                            <small class="text-muted">Weekday</small>
                        </div>
                        <a href="<?= BASE_URL ?>/wisata/detail.php?slug=<?= e($w['slug']) ?>"
                           class="btn btn-warning btn-sm px-4">
                            Detail <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4 text-muted small">
        Menampilkan <?= count($wisataList) ?> destinasi
    </div>
    <?php endif; ?>
</div>
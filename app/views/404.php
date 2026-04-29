<?php $pageTitle = '404 - Halaman Tidak Ditemukan'; ?>
<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container d-flex align-items-center justify-content-center" style="min-height:80vh;padding-top:80px">
    <div class="text-center">
        <div class="text-warning mb-4" style="font-size:6rem;opacity:.3">
            <i class="bi bi-stars"></i>
        </div>
        <h1 class="display-1 fw-bold text-warning">404</h1>
        <h3 class="text-white mb-3">Halaman Tidak Ditemukan</h3>
        <p class="text-muted mb-5">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <a href="<?= BASE_URL ?>/index.php" class="btn btn-warning btn-lg px-5">
            <i class="bi bi-house me-2"></i>Kembali ke Beranda
        </a>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>

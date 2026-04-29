<footer class="mk-footer mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="mk-brand fs-4 mb-1"><i class="bi bi-stars"></i> Mahakam Lampion Garden</h5>
                <p class="text-muted small">Taman rekreasi bertema lampion di tepi Sungai Mahakam, Samarinda. Destinasi wisata malam keluarga ikonik di Kalimantan Timur.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="https://www.instagram.com/mahakamlampiongarden/" target="_blank" class="mk-social-icon" title="Instagram MLG">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/mahakamlampiongardensamarinda/" target="_blank" class="mk-social-icon" title="Facebook MLG">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://maps.google.com/?q=Mahakam+Lampion+Garden+Samarinda" target="_blank" class="mk-social-icon" title="Google Maps">
                        <i class="bi bi-geo-alt"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <h6 class="text-warning mb-3">Jelajahi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= BASE_URL ?>/daftar_wisata.php" class="mk-footer-link">Semua Wisata</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/daftar_wisata.php?kategori=wahana" class="mk-footer-link">Wahana</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/galeri.php" class="mk-footer-link">Galeri</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/ulasan.php" class="mk-footer-link">Ulasan</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>/index.php#tentang" class="mk-footer-link">Tentang MLG</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h6 class="text-warning mb-3">Informasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2 text-muted">
                        <i class="bi bi-clock me-2 text-warning"></i>Buka 16:00 – 23:00 WITA
                    </li>
                    <li class="mb-2 text-muted">
                        <i class="bi bi-calendar-check me-2 text-warning"></i>Buka Setiap Hari
                    </li>
                    <li class="mb-2 text-muted">
                        <i class="bi bi-geo-alt me-2 text-warning"></i>Jl. Slamet Riyadi No. 75, Karang Asam Ilir, Sungai Kunjang, Samarinda
                    </li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="text-warning mb-3">Harga</h6>
                <div class="small">
                    <div class="d-flex justify-content-between text-muted mb-2 pb-2 border-bottom border-secondary">
                        <span><i class="bi bi-ticket me-1"></i>Tiket Masuk</span>
                        <strong class="text-warning">Rp 10.000</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted mb-2 pb-2 border-bottom border-secondary">
                        <span><i class="bi bi-controller me-1"></i>Wahana & Permainan</span>
                        <strong class="text-warning">Rp 10–40rb</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted mb-3">
                        <span><i class="bi bi-p-circle me-1"></i>Parkir</span>
                        <strong class="text-warning">Rp 2000</strong>
                    </div>
                    <a href="https://maps.google.com/?q=Mahakam+Lampion+Garden+Samarinda"
                        target="_blank" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-geo-alt me-1"></i>Lihat di Google Maps
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-secondary mt-5">
        <div class="text-center text-muted small">
            <p class="mb-0">© <?= date('Y') ?> Mahakam Lampion Garden · Jl. Slamet Riyadi No. 75, Samarinda · Kalimantan Timur</p>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script src="<?= BASE_URL ?>/public/js/app.js"></script>

<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>

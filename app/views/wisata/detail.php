<div class="mk-detail-hero position-relative overflow-hidden">
    <img src="<?= fotoWisata($wisata['foto_utama']) ?>"
        alt="<?= e($wisata['nama']) ?>"
        class="w-100 h-100 object-fit-cover">
    <div class="mk-detail-hero-overlay"></div>
    <div class="container position-relative" style="z-index:2;padding-top:120px;padding-bottom:60px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php" class="text-warning">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/daftar_wisata.php" class="text-warning">Wisata</a></li>
                <li class="breadcrumb-item active text-white"><?= e($wisata['nama']) ?></li>
            </ol>
        </nav>
        <span class="badge mk-badge-kategori mb-3 fs-6"><?= ucfirst(e($wisata['kategori'])) ?></span>
        <h1 class="display-3 fw-bold text-white"><?= e($wisata['nama']) ?></h1>
        <div class="d-flex flex-wrap gap-4 mt-3">
            <span class="text-white-50"><i class="bi bi-geo-alt me-1 text-warning"></i><?= e($wisata['lokasi']) ?></span>
            <span class="text-white-50"><i class="bi bi-clock me-1 text-warning"></i><?= e($wisata['jam_buka']) ?> – <?= e($wisata['jam_tutup']) ?> WITA</span>
            <?php if ($totalUlasan > 0): ?>
            <span class="text-white-50">
                <?php for($i=1;$i<=5;$i++): ?>
                    <i class="bi bi-star<?= $i <= $avgRating ? '-fill' : '' ?> text-warning" style="font-size:.85rem"></i>
                <?php endfor; ?>
                <?= $avgRating ?> (<?= $totalUlasan ?> ulasan)
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="mk-content-card mb-4">
                <h3 class="text-warning mb-4"><i class="bi bi-info-circle me-2"></i>Tentang Destinasi Ini</h3>
                <div class="text-muted lh-lg">
                    <?= nl2br(e($wisata['deskripsi_lengkap'])) ?>
                </div>
            </div>

            <?php if (!empty($fasilitas)): ?>
            <div class="mk-content-card mb-4">
                <h3 class="text-warning mb-4"><i class="bi bi-check2-circle me-2"></i>Fasilitas</h3>
                <div class="row g-3">
                    <?php foreach ($fasilitas as $f): ?>
                    <div class="col-6 col-md-4">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-check-circle-fill text-warning"></i>
                            <span><?= e($f) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="mk-content-card mb-4">
                <h3 class="text-warning mb-4"><i class="bi bi-map me-2"></i>Lokasi</h3>
                <p class="text-muted mb-3"><i class="bi bi-geo-alt me-2"></i><?= e($wisata['lokasi']) ?></p>
                <div class="rounded-3 overflow-hidden" style="height:300px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="bi bi-geo-alt-fill text-warning" style="font-size:3rem"></i>
                        <p class="mt-2"><?= e($wisata['nama']) ?></p>
                        <p class="small">Samarinda, Kalimantan Timur</p>
                        <a href="https://maps.google.com/?q=<?= urlencode($wisata['lokasi']) ?>"
                           target="_blank" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <div class="mk-content-card mb-4" id="ulasan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-warning mb-0"><i class="bi bi-chat-quote me-2"></i>Ulasan Pengunjung</h3>
                    <span class="badge bg-dark text-warning border border-warning"><?= $totalUlasan ?> Ulasan</span>
                </div>

                <div class="d-flex align-items-center gap-4 mb-5 p-4 mk-rating-summary rounded-3">
                    <div class="text-center">
                        <div class="display-4 fw-bold text-warning"><?= $avgRating ?: '-' ?></div>
                        <div class="d-flex gap-1">
                            <?php for($i=1;$i<=5;$i++): ?>
                                <i class="bi bi-star<?= $i <= $avgRating ? '-fill' : '' ?> text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <small class="text-muted"><?= $totalUlasan ?> ulasan</small>
                    </div>
                    <div class="flex-grow-1">
                        <?php for($star=5;$star>=1;$star--): ?>
                        <?php $cnt = array_reduce($ulasan, fn($c,$u) => $c + ($u['rating']==$star ? 1 : 0), 0); ?>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <small class="text-muted" style="width:20px"><?= $star ?></small>
                            <div class="progress flex-grow-1" style="height:6px">
                                <div class="progress-bar bg-warning" style="width:<?= $totalUlasan ? ($cnt/$totalUlasan*100) : 0 ?>%"></div>
                            </div>
                            <small class="text-muted" style="width:20px"><?= $cnt ?></small>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div v-scope id="filterUlasanApp" class="mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        <button @click="filterRating=0" :class="['btn btn-sm rounded-pill', filterRating===0?'btn-warning':'btn-outline-secondary']">Semua</button>
                        <button v-for="r in [5,4,3,2,1]" :key="r" @click="filterRating=r"
                                :class="['btn btn-sm rounded-pill', filterRating===r?'btn-warning':'btn-outline-secondary']">
                            {{ r }} <i class="bi bi-star-fill"></i>
                        </button>
                    </div>
                </div>

                <?php if (empty($ulasan)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-chat-dots" style="font-size:3rem"></i>
                    <p class="mt-3">Belum ada ulasan. Jadilah yang pertama!</p>
                </div>
                <?php else: ?>
                <div class="vstack gap-4 mb-5" id="ulasanList">
                    <?php foreach ($ulasan as $ul): ?>
                    <div class="mk-ulasan-card" data-rating="<?= $ul['rating'] ?>">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="mk-avatar flex-shrink-0">
                                <?= strtoupper(substr($ul['nama_pengunjung'], 0, 2)) ?>
                            </div>

                            <div class="flex-grow-1 w-100" style="min-width:0;">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div>
                                        <strong class="text-white"><?= e($ul['nama_pengunjung']) ?></strong>
                                        <div class="text-muted small"><?= date('d M Y', strtotime($ul['created_at'])) ?></div>
                                    </div>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <?php for($i=1;$i<=5;$i++): ?>
                                        <i class="bi bi-star<?= $i<=$ul['rating']?'-fill':'' ?> text-warning" style="font-size:.8rem"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <?php if ($ul['judul']): ?>
                                <p class="fw-bold text-white mt-2 mb-1"
                                   style="overflow-wrap:anywhere; word-break:break-word;">
                                    <?= e($ul['judul']) ?>
                                </p>
                                <?php endif; ?>

                                <p class="text-muted mb-0"
                                   style="overflow-wrap:anywhere; word-break:break-word; white-space:normal; line-height:1.8;">
                                    <?= nl2br(e($ul['isi_ulasan'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Form Tulis Ulasan -->
                <div class="mk-form-ulasan rounded-3 p-4">
                    <h5 class="text-white mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Tulis Ulasan Anda</h5>
                    <form action="<?= BASE_URL ?>/aksi_ulasan.php" method="POST" id="formUlasan">
                        <input type="hidden" name="wisata_id" value="<?= $wisata['id'] ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Nama Lengkap *</label>
                                <input type="text" name="nama_pengunjung" class="form-control mk-input" required placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email (opsional)</label>
                                <input type="email" name="email" class="form-control mk-input" placeholder="email@contoh.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Rating *</label>
                                <div class="mk-star-rating d-flex gap-2">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="d-none" <?= $i==5?'checked':'' ?>>
                                    <label for="star<?= $i ?>" class="mk-star-label fs-4">
                                        <i class="bi bi-star<?= $i==5?'-fill':'' ?>"></i>
                                    </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Judul Ulasan</label>
                                <input type="text" name="judul" class="form-control mk-input" placeholder="Ringkasan pengalaman Anda">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Ceritakan Pengalaman Anda *</label>
                                <textarea name="isi_ulasan" class="form-control mk-input" rows="4" required
                                          placeholder="Bagikan momen berkesan Anda di sini..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning px-4 fw-bold">
                                    <i class="bi bi-send me-2"></i>Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="position-sticky" style="top:90px">
                <div class="mk-content-card mb-4">
                    <h5 class="text-warning mb-4"><i class="bi bi-ticket-perforated me-2"></i>Harga Tiket</h5>
                    <div class="vstack gap-3">
                        <div class="d-flex justify-content-between p-3 rounded-3 bg-dark">
                            <div>
                                <div class="text-muted small">Senin – Kamis</div>
                                <div class="fw-bold text-white">Weekday</div>
                            </div>
                            <div class="text-warning fw-bold fs-5"><?= formatRupiah($wisata['harga_weekday']) ?></div>
                        </div>
                        <div class="d-flex justify-content-between p-3 rounded-3 bg-dark border border-warning">
                            <div>
                                <div class="text-muted small">Jumat – Minggu</div>
                                <div class="fw-bold text-white">Weekend</div>
                            </div>
                            <div class="text-warning fw-bold fs-5"><?= formatRupiah($wisata['harga_weekend']) ?></div>
                        </div>
                    </div>
                </div>

                <div class="mk-content-card mb-4">
                    <h5 class="text-warning mb-3"><i class="bi bi-clock me-2"></i>Jam Operasional</h5>
                    <div class="d-flex align-items-center gap-3 text-muted">
                        <i class="bi bi-circle-fill text-success" style="font-size:.6rem"></i>
                        <span>Buka Setiap Hari</span>
                    </div>
                    <div class="mt-2 p-3 rounded-3 bg-dark text-center">
                        <span class="text-warning fw-bold fs-5"><?= e($wisata['jam_buka']) ?> – <?= e($wisata['jam_tutup']) ?></span>
                        <div class="text-muted small">WITA</div>
                    </div>
                </div>

                <div class="mk-content-card">
                    <h5 class="text-warning mb-3"><i class="bi bi-share me-2"></i>Bagikan</h5>
                    <div class="d-flex gap-2">
                        <a href="https://wa.me/?text=<?= urlencode($wisata['nama'] . ' - ' . BASE_URL . '/wisata/detail.php?slug=' . $wisata['slug']) ?>"
                           target="_blank" class="btn btn-outline-success btn-sm flex-fill">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . '/wisata/detail.php?slug=' . $wisata['slug']) ?>"
                           target="_blank" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const starLabels = document.querySelectorAll('.mk-star-label');
const starInputs = document.querySelectorAll('input[name="rating"]');

starLabels.forEach((label, idx) => {
    label.addEventListener('click', () => {
        starInputs[idx].checked = true;
        starLabels.forEach((l, i) => {
            const icon = l.querySelector('i');
            icon.className = i <= idx ? 'bi bi-star-fill' : 'bi bi-star';
            l.classList.toggle('text-warning', i <= idx);
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const filterBtns = document.querySelectorAll('#filterUlasanApp button');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.className = b.className.replace('btn-warning','btn-outline-secondary');
            });
            btn.className = btn.className.replace('btn-outline-secondary','btn-warning');
        });
    });
});
</script>
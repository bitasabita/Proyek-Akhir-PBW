<?php $pageTitle = 'Ulasan Pengunjung | ' . APP_NAME; ?>

<div class="mk-page-header py-5 text-center">
    <div class="container" style="padding-top:4rem">
        <span class="mk-section-label">Kata Mereka</span>
        <h1 class="mk-section-title display-5">Ulasan Pengunjung</h1>
        <p class="mk-body-text mx-auto" style="max-width:500px">Setiap cerita adalah kenangan berharga dari Mahakam Lampion Garden</p>
    </div>
</div>

<div class="container pb-6">

    <div class="mk-rating-hero text-center mb-6">
        <div class="mk-rating-big"><?= number_format($avgRating, 1) ?></div>
        <div class="mk-stars-big mb-2">
            <?php for($i=1;$i<=5;$i++): ?>
            <i class="bi bi-star<?= $i <= round($avgRating) ? '-fill' : '' ?> text-warning"></i>
            <?php endfor; ?>
        </div>
        <p class="mk-body-text">Berdasarkan <strong style="color:var(--mk-gold)"><?= $totalUlasan ?></strong> ulasan pengunjung</p>
    </div>

    <?php $ulasanBintang5 = array_filter($ulasan, fn($u) => $u['rating'] >= 4); ?>
    <?php if (!empty($ulasanBintang5)): ?>
    <div class="mb-6">
        <h4 class="mk-section-title text-center mb-5" style="font-size:1.5rem">Ulasan Pengunjung</h4>
        <div class="mk-swiper-wrap">
            <div class="mk-swiper" id="ulasanSwiper">
                <?php foreach (array_values($ulasanBintang5) as $ul): ?>
                <div class="mk-swiper-slide">
                    <div class="mk-review-slide">
                        <div class="mk-review-quote"><i class="bi bi-quote"></i></div>
                        <p class="mk-review-text" style="overflow-wrap:anywhere; word-break:break-word; white-space:normal;">
                            "<?= nl2br(e(mb_substr($ul['isi_ulasan'], 0, 200))) ?><?= mb_strlen($ul['isi_ulasan']) > 200 ? '…' : '' ?>"
                        </p>
                        <?php if ($ul['judul']): ?>
                        <p class="mk-review-title" style="overflow-wrap:anywhere; word-break:break-word;">
                            <?= e($ul['judul']) ?>
                        </p>
                        <?php endif; ?>
                        <div class="mk-review-stars mb-3">
                            <?php for($i=1;$i<=5;$i++): ?>
                            <i class="bi bi-star<?= $i<=$ul['rating'] ? '-fill' : '' ?> text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="mk-review-author">
                            <div class="mk-avatar">
                                <?= strtoupper(substr($ul['nama_pengunjung'],0,2)) ?>
                            </div>
                            <div style="min-width:0;">
                                <strong style="overflow-wrap:anywhere; word-break:break-word; display:block;"><?= e($ul['nama_pengunjung']) ?></strong>
                                <small class="d-block" style="color:var(--mk-text-muted)"><?= date('d M Y', strtotime($ul['created_at'])) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="mk-swiper-btn mk-swiper-prev" onclick="swiperNav(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="mk-swiper-btn mk-swiper-next" onclick="swiperNav(1)">
                <i class="bi bi-chevron-right"></i>
            </button>

            <div class="mk-swiper-dots" id="swiperDots"></div>
        </div>
    </div>
    <?php endif; ?>

    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="mk-section-title mb-0" style="font-size:1.4rem">Semua Ulasan</h4>
            <div class="d-flex gap-2" id="ratingFilter">
                <button class="btn btn-sm btn-warning rounded-pill" onclick="filterRating(this, 0)">Semua</button>
                <?php for($r=5;$r>=1;$r--): ?>
                <button class="btn btn-sm btn-outline-secondary rounded-pill" onclick="filterRating(this, <?= $r ?>)">
                    <?= $r ?><i class="bi bi-star-fill ms-1 text-warning" style="font-size:.6rem"></i>
                </button>
                <?php endfor; ?>
            </div>
        </div>

        <?php if (empty($ulasan)): ?>
        <div class="text-center py-5" style="color:var(--mk-text-muted)">
            <i class="bi bi-chat-dots" style="font-size:3rem"></i>
            <p class="mt-3">Belum ada ulasan. Jadilah yang pertama!</p>
        </div>
        <?php else: ?>
        <div class="row g-4" id="ulasanGrid">
            <?php foreach ($ulasan as $ul): ?>
            <div class="col-md-6 col-lg-4 mk-ulasan-wrap" data-rating="<?= $ul['rating'] ?>">
                <div class="mk-ulasan-card-publik h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3 gap-3">
                        <div class="d-flex gap-3 align-items-center" style="min-width:0;">
                            <div class="mk-avatar flex-shrink-0"><?= strtoupper(substr($ul['nama_pengunjung'],0,2)) ?></div>
                            <div style="min-width:0;">
                                <strong style="font-family:'Cormorant SC',serif;font-size:.9rem;color:var(--mk-text); display:block; overflow-wrap:anywhere; word-break:break-word;">
                                    <?= e($ul['nama_pengunjung']) ?>
                                </strong>
                                <small class="d-block" style="color:var(--mk-text-muted);font-size:.7rem"><?= date('d M Y', strtotime($ul['created_at'])) ?></small>
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <?php for($i=1;$i<=5;$i++): ?>
                            <i class="bi bi-star<?= $i<=$ul['rating']?'-fill':'' ?> text-warning" style="font-size:.75rem"></i>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php if ($ul['judul']): ?>
                    <p style="font-family:'Cormorant SC',serif;color:var(--mk-gold);font-size:.9rem;margin-bottom:.5rem;letter-spacing:.04em; overflow-wrap:anywhere; word-break:break-word;">
                        <?= e($ul['judul']) ?>
                    </p>
                    <?php endif; ?>

                    <p style="font-family:'Cormorant Garamond',serif;font-size:1.05rem;color:var(--mk-text-soft);line-height:1.75;margin:0; overflow-wrap:anywhere; word-break:break-word; white-space:normal;">
                        <?= nl2br(e(mb_substr($ul['isi_ulasan'], 0, 300))) ?><?= mb_strlen($ul['isi_ulasan']) > 300 ? '…' : '' ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="mk-form-ulasan-publik p-4 p-md-5 rounded-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-4">
                <span class="mk-section-label">Punya Pengalaman?</span>
                <h3 class="mk-section-title mb-3" style="font-size:1.6rem">Bagikan Ceritamu</h3>
                <p class="mk-body-text">Ulasanmu membantu pengunjung lain merencanakan kunjungan yang sempurna ke Mahakam Lampion Garden.</p>
            </div>
            <div class="col-lg-8">
                <form action="<?= BASE_URL ?>/aksi_ulasan.php" method="POST" id="formUlasan" novalidate>
                    <input type="hidden" name="wisata_id" value="1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="nama_pengunjung" id="inputNama" class="form-control mk-input" placeholder="Nama Lengkap *" maxlength="60">
                            <div class="mk-field-error" id="errNama">Nama lengkap wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" id="inputEmail" class="form-control mk-input" placeholder="Email (opsional)">
                            <div class="mk-field-error" id="errEmail">Format email tidak valid.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:var(--mk-text-soft);font-size:.8rem;letter-spacing:.08em">RATING *</label>
                            <div class="mk-star-picker" id="starPicker">
                                <?php for($i=1;$i<=5;$i++): ?>
                                <i class="bi bi-star mk-star-pick" data-val="<?= $i ?>" onclick="pickStar(<?= $i ?>)"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="5">
                            <div class="mk-field-error" id="errRating">Pilih rating terlebih dahulu.</div>
                        </div>
                        <div class="col-12">
                            <input type="text" name="judul" id="inputJudul" class="form-control mk-input" placeholder="Judul ulasan singkat" maxlength="60">
                            <div class="d-flex justify-content-end">
                                <small class="mk-char-count" id="countJudul">0/60</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <textarea name="isi_ulasan" id="inputIsi" class="form-control mk-input" rows="4"
                                      placeholder="Ceritakan pengalaman tak terlupakan Anda di MLG..." maxlength="300"></textarea>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mk-field-error" id="errIsi" style="position:static;margin-top:4px;">Ulasan wajib diisi.</div>
                                <small class="mk-char-count" id="countIsi">0/300</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning px-5 fw-bold">
                                <i class="bi bi-send me-2"></i>Kirim Ulasan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let swiperCurrent = 0;
const slides = document.querySelectorAll('.mk-swiper-slide');
const dotsEl  = document.getElementById('swiperDots');

if (dotsEl) {
    slides.forEach((_,i) => {
        const d = document.createElement('button');
        d.className = 'mk-swiper-dot' + (i===0?' active':'');
        d.onclick = () => goToSlide(i);
        dotsEl.appendChild(d);
    });
}

function goToSlide(idx) {
    if (!slides.length) return;
    slides[swiperCurrent]?.classList.remove('active');
    document.querySelectorAll('.mk-swiper-dot')[swiperCurrent]?.classList.remove('active');
    swiperCurrent = (idx + slides.length) % slides.length;
    slides[swiperCurrent]?.classList.add('active');
    document.querySelectorAll('.mk-swiper-dot')[swiperCurrent]?.classList.add('active');
    const swiper = document.getElementById('ulasanSwiper');
    if (swiper) swiper.style.transform = `translateX(-${swiperCurrent * 100}%)`;
}

function swiperNav(dir) {
    if (!slides.length) return;
    goToSlide(swiperCurrent + dir);
}

if (slides.length > 1) {
    slides[0].classList.add('active');
    setInterval(() => swiperNav(1), 5000);
}

function filterRating(btn, r) {
    document.querySelectorAll('#ratingFilter button').forEach(b =>
        b.className = b.className.replace('btn-warning','btn-outline-secondary'));
    btn.className = btn.className.replace('btn-outline-secondary','btn-warning');
    document.querySelectorAll('.mk-ulasan-wrap').forEach(el => {
        el.style.display = (!r || parseInt(el.dataset.rating) === r) ? '' : 'none';
    });
}

function pickStar(val) {
    document.getElementById('ratingInput').value = val;
    document.getElementById('errRating').style.display = 'none';
    document.querySelectorAll('.mk-star-pick').forEach((s,i) => {
        s.className = 'bi mk-star-pick ' + (i < val ? 'bi-star-fill text-warning' : 'bi-star');
        s.style.color = i < val ? '' : 'var(--mk-text-muted)';
    });
}
pickStar(5);

function setupCounter(inputId, countId, max) {
    const el = document.getElementById(inputId);
    const ct = document.getElementById(countId);
    if (!el || !ct) return;
    el.addEventListener('input', () => {
        const len = el.value.length;
        ct.textContent = len + '/' + max;
        ct.style.color = len >= max ? '#e74c3c' : 'var(--mk-text-muted)';
    });
}
setupCounter('inputJudul', 'countJudul', 60);
setupCounter('inputIsi',   'countIsi',   300);

function showErr(id, show) {
    const el = document.getElementById(id);
    if (el) el.style.display = show ? 'block' : 'none';
}
function markInput(id, isErr) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle('mk-input-error', isErr);
}

document.getElementById('formUlasan').addEventListener('submit', function(e) {
    e.preventDefault();

    let valid = true;

    const nama = document.getElementById('inputNama').value.trim();
    const namaErr = !nama;
    showErr('errNama', namaErr); markInput('inputNama', namaErr);
    if (namaErr) valid = false;

    const email = document.getElementById('inputEmail').value.trim();
    const emailErr = email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    showErr('errEmail', emailErr); markInput('inputEmail', emailErr);
    if (emailErr) valid = false;

    const rating = parseInt(document.getElementById('ratingInput').value);
    const ratingErr = !rating || rating < 1 || rating > 5;
    showErr('errRating', ratingErr);
    if (ratingErr) valid = false;

    const isi = document.getElementById('inputIsi').value.trim();
    const isiErr = !isi;
    showErr('errIsi', isiErr); markInput('inputIsi', isiErr);
    if (isiErr) valid = false;

    if (!valid) {
        const firstErr = document.querySelector('.mk-input-error');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    this.submit();
});

['inputNama','inputEmail','inputIsi'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('input', () => {
        el.classList.remove('mk-input-error');
        const errMap = { inputNama:'errNama', inputEmail:'errEmail', inputIsi:'errIsi' };
        showErr(errMap[id], false);
    });
});
</script>
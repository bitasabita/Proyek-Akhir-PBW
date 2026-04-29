<?php
$pageTitle = 'Galeri Foto | ' . APP_NAME;

if (!isset($photos) || empty($photos)) {
    if (isset($pdo)) {
        $stmt = $pdo->query("
            SELECT id, judul, kategori, foto, status
            FROM galeri
            ORDER BY id DESC
        ");
        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $photos = [];
    }
}
?>

<div class="mk-page-header py-5 text-center">
    <div class="container" style="padding-top:4rem">
        <span class="mk-section-label">Momen Bercahaya</span>
        <h1 class="mk-section-title display-5">Galeri Foto</h1>
        <p class="mk-body-text mx-auto" style="max-width:500px">
            Setiap foto menyimpan cerita cahaya malam di tepi Mahakam
        </p>
    </div>
</div>

<div class="container py-4">
    <?php
    $kategoriGaleri = ['Semua'];
    foreach ($photos as $p) {
        if (!empty($p['kategori']) && !in_array($p['kategori'], $kategoriGaleri, true)) {
            $kategoriGaleri[] = $p['kategori'];
        }
    }
    ?>

    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" id="galeriFilter">
        <?php foreach ($kategoriGaleri as $kat): ?>
        <button class="btn btn-sm rounded-pill <?= $kat === 'Semua' ? 'btn-warning' : 'btn-outline-secondary' ?>"
                type="button"
                onclick="filterGaleri(this, '<?= e($kat) ?>')">
            <?= e($kat) ?>
        </button>
        <?php endforeach; ?>
    </div>

    <?php if (empty($photos)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-images text-warning" style="font-size:4rem"></i>
        <h4 class="text-white mt-3">Belum ada foto galeri</h4>
        <p>Data galeri belum ditemukan di database.</p>
    </div>
    <?php else: ?>
    <div class="mk-galeri-masonry" id="galeriGrid">
        <?php foreach ($photos as $i => $p): ?>
        <?php
            $src = BASE_URL . '/public/uploads/galeri/' . ($p['foto'] ?? '');
            $judul = $p['judul'] ?? 'Foto Galeri';
            $kategori = $p['kategori'] ?? 'Galeri';
        ?>
        <div class="mk-galeri-item"
             data-kat="<?= e($kategori) ?>"
             data-index="<?= $i ?>"
             data-src="<?= e($src) ?>"
             data-caption="<?= e($judul) ?>"
             onclick="openLightboxByIndex(<?= $i ?>)">
            <img src="<?= e($src) ?>"
                 alt="<?= e($judul) ?>"
                 loading="lazy">
            <div class="mk-galeri-hover">
                <i class="bi bi-zoom-in"></i>
                <span><?= e($judul) ?></span>
                <small><?= e($kategori) ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<div id="mkLightbox" class="mk-lightbox" onclick="closeLightbox()">
    <button class="mk-lightbox-close" type="button" onclick="closeLightbox()">
        <i class="bi bi-x-lg"></i>
    </button>

    <button class="mk-lightbox-nav mk-lightbox-prev" type="button" onclick="event.stopPropagation();navLightbox(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>

    <div class="mk-lightbox-inner" onclick="event.stopPropagation()">
        <img id="mkLightboxImg" src="" alt="">
        <p id="mkLightboxCaption" class="mk-lightbox-caption"></p>
    </div>

    <button class="mk-lightbox-nav mk-lightbox-next" type="button" onclick="event.stopPropagation();navLightbox(1)">
        <i class="bi bi-chevron-right"></i>
    </button>
</div>

<script>
const galeriData = <?= json_encode(array_map(function($p) {
    return [
        'src' => BASE_URL . '/public/uploads/galeri/' . ($p['foto'] ?? ''),
        'caption' => $p['judul'] ?? 'Foto Galeri',
        'kategori' => $p['kategori'] ?? 'Galeri'
    ];
}, $photos), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

let currentIdx = 0;
let visibleIndexes = galeriData.map((_, i) => i);

function updateVisibleIndexes() {
    const items = document.querySelectorAll('.mk-galeri-item');
    visibleIndexes = [];

    items.forEach(item => {
        const hidden = window.getComputedStyle(item).display === 'none';
        if (!hidden) {
            visibleIndexes.push(parseInt(item.dataset.index, 10));
        }
    });
}

function filterGaleri(btn, kat) {
    document.querySelectorAll('#galeriFilter button').forEach(b => {
        b.classList.remove('btn-warning');
        b.classList.add('btn-outline-secondary');
    });

    btn.classList.remove('btn-outline-secondary');
    btn.classList.add('btn-warning');

    document.querySelectorAll('.mk-galeri-item').forEach(item => {
        const match = kat === 'Semua' || item.dataset.kat === kat;
        item.style.display = match ? '' : 'none';
    });

    updateVisibleIndexes();
}

function openLightboxByIndex(index) {
    updateVisibleIndexes();
    if (!visibleIndexes.includes(index)) return;

    currentIdx = index;
    showCurrentLightboxItem();

    document.getElementById('mkLightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function showCurrentLightboxItem() {
    if (!galeriData[currentIdx]) return;

    const current = galeriData[currentIdx];
    document.getElementById('mkLightboxImg').src = current.src;
    document.getElementById('mkLightboxImg').alt = current.caption;
    document.getElementById('mkLightboxCaption').textContent = current.caption;
}

function navLightbox(dir) {
    updateVisibleIndexes();
    if (!visibleIndexes.length) return;

    let visiblePos = visibleIndexes.indexOf(currentIdx);
    if (visiblePos === -1) visiblePos = 0;

    visiblePos = (visiblePos + dir + visibleIndexes.length) % visibleIndexes.length;
    currentIdx = visibleIndexes[visiblePos];

    showCurrentLightboxItem();
}

function closeLightbox() {
    document.getElementById('mkLightbox').classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    const lightbox = document.getElementById('mkLightbox');
    if (!lightbox || !lightbox.classList.contains('active')) return;

    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') navLightbox(1);
    if (e.key === 'ArrowLeft') navLightbox(-1);
});

updateVisibleIndexes();
</script>
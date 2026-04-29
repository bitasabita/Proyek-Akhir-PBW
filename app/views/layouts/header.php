<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? APP_NAME) ?></title>
    <meta name="description" content="<?= e($pageDesc ?? 'Destinasi cahaya terbesar di Kalimantan - Mahakam Lampion Garden, Samarinda') ?>">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/img/logomlgtransparant.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&family=Cormorant+SC:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=IM+Fell+English:ital@0;1&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/style.css?v=5" rel="stylesheet">
</head>
<body>

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isTentang   = ($currentPage === 'index.php' && isset($_GET['section']) && $_GET['section'] === 'tentang');
?>

<nav class="navbar navbar-expand-lg navbar-dark mk-navbar fixed-top">
    <div class="container">
        <div class="mk-brand">
            <div class="mk-brand-badge">
                <img src="<?= BASE_URL ?>/public/img/logomlgtransparant.png?v=2"
                    class="mk-navbar-logo"
                    alt="Logo MLG">
            </div>

            <div class="mk-brand-text">
                <span class="mk-brand-title">MLG</span>
                <small class="mk-brand-sub">Mahakam Lampion Garden</small>
            </div>
        </div>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="mx-auto d-none d-lg-block mk-navbar-ornament">
    <svg width="280" height="30" viewBox="0 0 280 30" xmlns="http://www.w3.org/2000/svg">
        <line x1="0" y1="15" x2="85" y2="15" stroke="rgba(245,200,66,.35)" stroke-width="0.7"/>
        <path d="M88,15 Q93,8 98,15 Q93,22 88,15Z" fill="rgba(245,200,66,.45)"/>
        <path d="M100,15 Q105,9 110,15 Q105,21 100,15Z" fill="rgba(245,200,66,.55)"/>
        <circle cx="140" cy="15" r="4" fill="none" stroke="rgba(245,200,66,.7)" stroke-width="0.8"/>
        <circle cx="140" cy="15" r="1.5" fill="rgba(245,200,66,.8)"/>
        <path d="M140,9 Q142,12 140,15 Q138,12 140,9Z" fill="rgba(245,200,66,.6)"/>
        <path d="M140,15 Q142,18 140,21 Q138,18 140,15Z" fill="rgba(245,200,66,.6)"/>
        <path d="M134,15 Q137,13 140,15 Q137,17 134,15Z" fill="rgba(245,200,66,.6)"/>
        <path d="M140,15 Q143,13 146,15 Q143,17 140,15Z" fill="rgba(245,200,66,.6)"/>
        <path d="M170,15 Q175,9 180,15 Q175,21 170,15Z" fill="rgba(245,200,66,.55)"/>
        <path d="M182,15 Q187,8 192,15 Q187,22 182,15Z" fill="rgba(245,200,66,.45)"/>
        <line x1="195" y1="15" x2="280" y2="15" stroke="rgba(245,200,66,.35)" stroke-width="0.7"/>
        <circle cx="75" cy="15" r="1.5" fill="rgba(245,200,66,.5)"/>
        <circle cx="65" cy="15" r="1" fill="rgba(245,200,66,.3)"/>
        <circle cx="205" cy="15" r="1.5" fill="rgba(245,200,66,.5)"/>
        <circle cx="215" cy="15" r="1" fill="rgba(245,200,66,.3)"/>
    </svg>
</div>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'index.php' && !$isTentang) ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'daftar_wisata.php' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/daftar_wisata.php">Wisata</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'galeri.php' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/galeri.php">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'ulasan.php' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/ulasan.php">Ulasan</a>
                
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php $flash = getFlash(); if ($flash): ?>
<div class="mk-flash-wrapper">
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show mb-0 rounded-0" role="alert">
        <div class="container">
            <?= $flash['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
<?php endif; ?>
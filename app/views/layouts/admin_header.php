<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin Panel') ?> | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/admin.css?v=2" rel="stylesheet">
</head>
<body class="mk-admin-body">

<div class="mk-sidebar" id="mkSidebar">
    <div class="mk-sidebar-brand p-4 border-bottom border-secondary">
        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-decoration-none">
            <h5 class="mk-brand mb-0"><i class="bi bi-stars text-warning"></i> Mahakam</h5>
            <small class="text-muted">Admin Panel</small>
        </a>
    </div>
    <nav class="p-3">
        <small class="text-muted text-uppercase fw-bold ps-2 d-block mb-2">Menu Utama</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/dashboard.php"
                    class="nav-link mk-nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/wisata.php"
                    class="nav-link mk-nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ['wisata.php','tambah_wisata.php','edit_wisata.php']) ? 'active' : '' ?>">
                    <i class="bi bi-geo-alt-fill me-2"></i> Data Wisata
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/galeri.php"
                    class="nav-link mk-nav-link <?= basename($_SERVER['PHP_SELF']) == 'galeri.php' || basename($_SERVER['PHP_SELF']) == 'tambah_galeri.php' || basename($_SERVER['PHP_SELF']) == 'edit_galeri.php' ? 'active' : '' ?>">
                    <i class="bi bi-images me-2"></i> Galeri
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/ulasan.php"
                    class="nav-link mk-nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ['ulasan.php','edit_ulasan.php']) ? 'active' : '' ?>">
                    <i class="bi bi-chat-quote-fill me-2"></i> Ulasan
                </a>
            </li>
        </ul>

        <hr class="border-secondary">
        <small class="text-muted text-uppercase fw-bold ps-2 d-block mb-2">Akun</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/index.php" target="_blank" class="nav-link mk-nav-link">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Lihat Website
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/logout.php" class="nav-link mk-nav-link text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="mk-main-content">
    <div class="mk-topbar d-flex justify-content-between align-items-center px-4 py-3">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-flex align-items-center gap-2">
            <div class="mk-avatar-sm">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <div class="fw-semibold small"><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></div>
                <div class="text-muted" style="font-size:.7rem">Administrator</div>
            </div>
        </div>
    </div>

    <?php $flash = getFlash(); if ($flash): ?>
    <div class="px-4 pt-3">
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <?= $flash['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <div class="p-4">
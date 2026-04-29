<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

requireLogin();

$galeriModel = new GaleriModel($pdo);
$galeriList = $galeriModel->getAll();

require BASE_PATH . '/app/views/layouts/admin_header.php';
require BASE_PATH . '/app/views/admin/galeri_daftar.php';
require BASE_PATH . '/app/views/layouts/admin_footer.php';
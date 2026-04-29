<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

$pageTitle = 'Galeri Foto | ' . APP_NAME;

require BASE_PATH . '/app/views/layouts/header.php';
require BASE_PATH . '/app/views/galeri_publik.php';
require BASE_PATH . '/app/views/layouts/footer.php';

<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

$slug = trim($_GET['slug'] ?? '');
if (empty($slug)) {
    redirect('daftar_wisata.php');
}

$controller = new WisataController($pdo);
$controller->detailWisata($slug);

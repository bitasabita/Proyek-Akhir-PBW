<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

$ulasanModel = new UlasanModel($pdo);
$ulasan      = $ulasanModel->getAll(['status' => 'disetujui']);
$avgRating   = $ulasanModel->avgRating(0);
$totalUlasan = count($ulasan);

$stmt = $pdo->query("SELECT AVG(rating) FROM ulasan WHERE status='disetujui'");
$avgRating = round((float)$stmt->fetchColumn(), 1);

$pageTitle = 'Ulasan Pengunjung | ' . APP_NAME;

require BASE_PATH . '/app/views/layouts/header.php';
require BASE_PATH . '/app/views/ulasan_publik.php';
require BASE_PATH . '/app/views/layouts/footer.php';

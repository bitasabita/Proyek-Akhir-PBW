<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

$pageTitle = 'Jelajahi Wisata | ' . APP_NAME;

$controller = new WisataController($pdo);
$controller->daftarWisata();

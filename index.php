<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

$pageTitle = 'Beranda | ' . APP_NAME;
$pageDesc  = 'Destinasi cahaya terbesar di Kalimantan - Mahakam Lampion Garden, Samarinda.';

$controller = new WisataController($pdo);
$controller->index();

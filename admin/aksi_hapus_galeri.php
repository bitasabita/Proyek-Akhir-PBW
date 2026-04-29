<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

requireLogin();

$id = (int) ($_GET['id'] ?? 0);

$galeriModel = new GaleriModel($pdo);
$galeri = $galeriModel->getById($id);

if (!$galeri) {
    setFlash('danger', 'Data galeri tidak ditemukan.');
    redirect('admin/galeri.php');
}

$fotoPath = BASE_PATH . '/public/uploads/galeri/' . $galeri['foto'];
if (!empty($galeri['foto']) && file_exists($fotoPath)) {
    unlink($fotoPath);
}

$galeriModel->delete($id);

setFlash('success', 'Foto galeri berhasil dihapus.');
redirect('admin/galeri.php');
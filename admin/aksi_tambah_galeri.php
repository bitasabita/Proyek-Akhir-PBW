<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/galeri.php');
}

$judul = clean($_POST['judul'] ?? '');
$kategori = clean($_POST['kategori'] ?? '');
$status = $_POST['status'] ?? 'aktif';

if ($judul === '' || $kategori === '') {
    setFlash('danger', 'Judul dan kategori wajib diisi.');
    redirect('admin/tambah_galeri.php');
}

if (empty($_FILES['foto']['name'])) {
    setFlash('danger', 'Foto galeri wajib diupload.');
    redirect('admin/tambah_galeri.php');
}

$uploadDir = BASE_PATH . '/public/uploads/galeri/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$file = $_FILES['foto'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$maxSize = 3 * 1024 * 1024;

if (!in_array($file['type'], $allowedTypes)) {
    setFlash('danger', 'Format foto harus JPG, PNG, atau WEBP.');
    redirect('admin/tambah_galeri.php');
}

if ($file['size'] > $maxSize) {
    setFlash('danger', 'Ukuran foto maksimal 3MB.');
    redirect('admin/tambah_galeri.php');
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$fotoName = 'galeri_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;

if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fotoName)) {
    setFlash('danger', 'Gagal upload foto.');
    redirect('admin/tambah_galeri.php');
}

$galeriModel = new GaleriModel($pdo);
$galeriModel->create([
    ':judul' => $judul,
    ':kategori' => $kategori,
    ':foto' => $fotoName,
    ':status' => $status
]);

setFlash('success', 'Foto galeri berhasil ditambahkan.');
redirect('admin/galeri.php');
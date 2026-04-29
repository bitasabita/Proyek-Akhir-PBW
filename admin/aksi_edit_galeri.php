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

$judul = clean($_POST['judul'] ?? '');
$kategori = clean($_POST['kategori'] ?? '');
$status = $_POST['status'] ?? 'aktif';
$fotoName = $galeri['foto'];

if ($judul === '' || $kategori === '') {
    setFlash('danger', 'Judul dan kategori wajib diisi.');
    redirect('admin/edit_galeri.php?id=' . $id);
}

if (!empty($_FILES['foto']['name'])) {
    $uploadDir = BASE_PATH . '/public/uploads/galeri/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $file = $_FILES['foto'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 3 * 1024 * 1024;

    if (!in_array($file['type'], $allowedTypes)) {
        setFlash('danger', 'Format foto harus JPG, PNG, atau WEBP.');
        redirect('admin/edit_galeri.php?id=' . $id);
    }

    if ($file['size'] > $maxSize) {
        setFlash('danger', 'Ukuran foto maksimal 3MB.');
        redirect('admin/edit_galeri.php?id=' . $id);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fotoName = 'galeri_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fotoName)) {
        setFlash('danger', 'Gagal upload foto baru.');
        redirect('admin/edit_galeri.php?id=' . $id);
    }

    $fotoLama = $uploadDir . $galeri['foto'];
    if (!empty($galeri['foto']) && file_exists($fotoLama)) {
        unlink($fotoLama);
    }
}

$galeriModel->update($id, [
    ':judul' => $judul,
    ':kategori' => $kategori,
    ':foto' => $fotoName,
    ':status' => $status
]);

setFlash('success', 'Data galeri berhasil diperbarui.');
redirect('admin/galeri.php');
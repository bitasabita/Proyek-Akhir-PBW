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

$pageTitle = 'Edit Galeri';

require BASE_PATH . '/app/views/layouts/admin_header.php';
require BASE_PATH . '/app/views/admin/galeri_form.php';
require BASE_PATH . '/app/views/layouts/admin_footer.php';
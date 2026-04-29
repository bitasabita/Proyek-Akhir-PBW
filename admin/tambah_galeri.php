<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

requireLogin();

$galeri = null;
$pageTitle = 'Tambah Galeri';

require BASE_PATH . '/app/views/layouts/admin_header.php';
require BASE_PATH . '/app/views/admin/galeri_form.php';
require BASE_PATH . '/app/views/layouts/admin_footer.php';
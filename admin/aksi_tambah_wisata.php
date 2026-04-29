<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/koneksi.php';

$controller = new AdminController($pdo);
$controller->tambahWisataProses();

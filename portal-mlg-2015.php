<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

$controller = new AdminController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->loginProses();
} else {
    $controller->loginForm();
}
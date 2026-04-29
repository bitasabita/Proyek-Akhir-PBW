<?php
http_response_code(404);
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';
require BASE_PATH . '/app/views/404.php';
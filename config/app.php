<?php
define('BASE_URL', 'http://localhost/mahakam');
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . '/public/uploads/');
define('APP_NAME', 'Mahakam Lampion Garden');
define('APP_VERSION', '1.0.0');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/models/' . $class . '.php',
        BASE_PATH . '/app/controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

function redirect(string $url): void
{
    header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
    exit;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['admin_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        setFlash('warning', 'Silakan login terlebih dahulu.');
        redirect('portal-mlg-2015.php');
    }
}

function clean(string $input): string
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function formatRupiah(float $amount): string
{
    if ($amount == 0) return 'Gratis';
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function starRating(int $rating): string
{
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= $rating ? 'text-warning' : 'text-muted';
        $html .= "<i class='bi bi-star-fill {$filled}'></i>";
    }
    return $html;
}

function fotoWisata(string $foto): string
{
    $path = UPLOAD_PATH . $foto;
    if (!empty($foto) && file_exists($path)) {
        return UPLOAD_URL . $foto;
    }
    return BASE_URL . '/public/img/placeholder.jpg';
}

function truncate(string $text, int $length = 120): string
{
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

function badgeStatus(string $status): string
{
    $map = [
        'aktif'     => 'success',
        'nonaktif'  => 'secondary',
        'disetujui' => 'success',
    ];
    $color = $map[$status] ?? 'secondary';
    return "<span class='badge bg-{$color}'>" . ucfirst($status) . "</span>";
}
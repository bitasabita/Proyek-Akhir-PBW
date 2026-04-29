<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('ulasan.php');
}

$wisataId = (int) ($_POST['wisata_id'] ?? 0);
$nama     = mb_substr(clean($_POST['nama_pengunjung'] ?? ''), 0, 60);
$email    = clean($_POST['email'] ?? '');
$rating   = (int) ($_POST['rating'] ?? 5);
$judul    = mb_substr(clean($_POST['judul'] ?? ''), 0, 60);
$isi      = mb_substr(clean($_POST['isi_ulasan'] ?? ''), 0, 300);

if (empty($nama) || empty($isi) || $rating < 1 || $rating > 5) {
    setFlash('danger', 'Mohon lengkapi semua field yang wajib diisi.');
    redirect('ulasan.php');
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO ulasan (wisata_id, nama_pengunjung, email, rating, judul, isi_ulasan, foto, status)
        VALUES (:wisata_id, :nama_pengunjung, :email, :rating, :judul, :isi_ulasan, :foto, :status)"
    );
    $result = $stmt->execute([
        ':wisata_id'       => $wisataId ?: null,
        ':nama_pengunjung' => $nama,
        ':email'           => $email,
        ':rating'          => $rating,
        ':judul'           => $judul,
        ':isi_ulasan'      => $isi,
        ':foto'            => '',
        ':status'          => 'disetujui',
    ]);

    if ($result) {
        setFlash('success', 'Ulasan kamu berhasil dikirim, terima kasih!');
    } else {
        setFlash('danger', 'Gagal mengirim ulasan, coba lagi.');
    }
} catch (Exception $e) {
    setFlash('danger', 'Terjadi kesalahan: ' . $e->getMessage());
}

redirect('ulasan.php');
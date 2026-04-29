<?php

class WisataController
{
    private WisataModel $wisataModel;
    private UlasanModel $ulasanModel;

    public function __construct(PDO $pdo)
    {
        $this->wisataModel = new WisataModel($pdo);
        $this->ulasanModel = new UlasanModel($pdo);
    }

    public function index(): void
    {
        $featuredWisata = $this->wisataModel->getFeatured(4);

        if (empty($featuredWisata)) {
            $featuredWisata = $this->wisataModel->getPublik();
        }

        $allWisata   = $this->wisataModel->getPublik();
        $totalWisata = $this->wisataModel->count(['status' => 'aktif']);

        $galeriModel = new GaleriModel($GLOBALS['pdo']);
        $galeriHome  = array_slice($galeriModel->getAktif(), 0, 6);

        require BASE_PATH . '/app/views/layouts/header.php';
        require BASE_PATH . '/app/views/index.php';
        require BASE_PATH . '/app/views/layouts/footer.php';
    }

    public function daftarWisata(): void
    {
        $kategori = $_GET['kategori'] ?? '';
        $search   = $_GET['search'] ?? '';

        $wisataList = $this->wisataModel->getPublik($kategori);

        if ($search) {
            $wisataList = $this->wisataModel->getAll([
                'status' => 'aktif',
                'search' => $search
            ]);
        }

        require BASE_PATH . '/app/views/layouts/header.php';
        require BASE_PATH . '/app/views/wisata/daftar.php';
        require BASE_PATH . '/app/views/layouts/footer.php';
    }

    public function detailWisata(string $slug): void
    {
        $wisata = $this->wisataModel->getBySlug($slug);

        if (!$wisata) {
            http_response_code(404);
            require BASE_PATH . '/app/views/404.php';
            exit;
        }

        $ulasan      = $this->ulasanModel->getPublik($wisata['id']);
        $avgRating   = $this->ulasanModel->avgRating($wisata['id']);
        $totalUlasan = $this->ulasanModel->countByWisata($wisata['id']);
        $fasilitas   = json_decode($wisata['fasilitas'] ?? '[]', true);

        require BASE_PATH . '/app/views/layouts/header.php';
        require BASE_PATH . '/app/views/wisata/detail.php';
        require BASE_PATH . '/app/views/layouts/footer.php';
    }

    public function kirimUlasan(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php');
        }

        $wisataId = (int) ($_POST['wisata_id'] ?? 0);
        $wisata   = $this->wisataModel->getById($wisataId);

        if (!$wisata) {
            setFlash('danger', 'Wisata tidak ditemukan.');
            redirect('index.php');
        }

        $errors = [];
        $nama   = trim($_POST['nama_pengunjung'] ?? '');
        $email  = trim($_POST['email'] ?? '');
        $rating = (int) ($_POST['rating'] ?? 0);
        $judul  = trim($_POST['judul'] ?? '');
        $isi    = trim($_POST['isi_ulasan'] ?? '');

        if (empty($nama)) {
            $errors[] = 'Nama wajib diisi.';
        }

        if ($rating < 1 || $rating > 5) {
            $errors[] = 'Rating tidak valid.';
        }

        if (empty($isi)) {
            $errors[] = 'Isi ulasan wajib diisi.';
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        if ($errors) {
            setFlash('danger', implode('<br>', $errors));
            redirect('wisata/detail.php?slug=' . $wisata['slug'] . '#ulasan');
        }

        $this->ulasanModel->create([
            ':wisata_id'       => $wisataId,
            ':nama_pengunjung' => clean($nama),
            ':email'           => clean($email),
            ':rating'          => $rating,
            ':judul'           => clean($judul),
            ':isi_ulasan'      => clean($isi),
            ':foto'            => '',
            ':status'          => 'disetujui',
        ]);

        setFlash('success', 'Ulasan Anda berhasil dikirim dan langsung ditampilkan. Terima kasih!');
        redirect('wisata/detail.php?slug=' . $wisata['slug'] . '#ulasan');
    }
}
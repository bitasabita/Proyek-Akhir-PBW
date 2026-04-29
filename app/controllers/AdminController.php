<?php

class AdminController
{
    private WisataModel $wisataModel;
    private UlasanModel $ulasanModel;
    private AdminModel  $adminModel;

    public function __construct(PDO $pdo)
    {
        $this->wisataModel = new WisataModel($pdo);
        $this->ulasanModel = new UlasanModel($pdo);
        $this->adminModel  = new AdminModel($pdo);
    }


    public function loginForm(): void
    {
        if (isLoggedIn()) redirect('admin/dashboard.php');
        require BASE_PATH . '/app/views/admin/login.php';
    }

    public function loginProses(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('portal-mlg-2015.php');

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            setFlash('danger', 'Username dan password wajib diisi.');
            redirect('portal-mlg-2015.php');
        }

        $admin = $this->adminModel->findByUsername($username);

        if (!$admin || !$this->adminModel->verifyPassword($password, $admin['password'])) {
            setFlash('danger', 'Username atau password salah.');
            redirect('portal-mlg-2015.php');
        }

        $this->adminModel->createSession($admin);
        setFlash('success', 'Selamat datang, ' . $admin['nama_lengkap'] . '!');
        redirect('admin/dashboard.php');
    }

    public function logout(): void
    {
        $this->adminModel->destroySession();
        setFlash('success', 'Anda berhasil logout.');
        redirect('portal-mlg-2015.php');
    }


    public function dashboard(): void
    {
        requireLogin();
        $totalWisata      = $this->wisataModel->count();
        $totalWisataAktif = $this->wisataModel->count(['status' => 'aktif']);
        $totalUlasan      = $this->ulasanModel->count();
        $ulasanMenunggu   = 0;
        $recentUlasan     = $this->ulasanModel->getAll();

        require BASE_PATH . '/app/views/layouts/admin_header.php';
        require BASE_PATH . '/app/views/admin/dashboard.php';
        require BASE_PATH . '/app/views/layouts/admin_footer.php';
    }


    public function daftarWisata(): void
    {
        requireLogin();
        $wisataList = $this->wisataModel->getAll();
        require BASE_PATH . '/app/views/layouts/admin_header.php';
        require BASE_PATH . '/app/views/admin/wisata_daftar.php';
        require BASE_PATH . '/app/views/layouts/admin_footer.php';
    }

    public function tambahWisataForm(): void
    {
        requireLogin();
        require BASE_PATH . '/app/views/layouts/admin_header.php';
        require BASE_PATH . '/app/views/admin/wisata_form.php';
        require BASE_PATH . '/app/views/layouts/admin_footer.php';
    }

    public function tambahWisataProses(): void
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/wisata.php');

        $data   = $this->ambilDataWisataDariPost();
        $errors = $this->validasiWisata($data);

        // Handle upload foto
        $fotoNama = $this->uploadFoto();
        if ($fotoNama === false) {
            $errors[] = 'Gagal mengupload foto. Format harus JPG/PNG/WEBP, maks 2MB.';
        }
        $data[':foto_utama'] = $fotoNama ?: '';

        if ($errors) {
            setFlash('danger', implode('<br>', $errors));
            redirect('admin/aksi_tambah.php');
        }

        // Pastikan slug unik
        $slug = slugify($data[':nama']);
        if ($this->wisataModel->slugExists($slug)) {
            $slug .= '-' . time();
        }
        $data[':slug'] = $slug;

        if ($this->wisataModel->create($data)) {
            setFlash('success', 'Wisata "' . $data[':nama'] . '" berhasil ditambahkan!');
        } else {
            setFlash('danger', 'Gagal menyimpan data wisata.');
        }
        redirect('admin/wisata.php');
    }

    public function editWisataForm(int $id): void
    {
        requireLogin();
        $wisata = $this->wisataModel->getById($id);
        if (!$wisata) {
            setFlash('danger', 'Wisata tidak ditemukan.');
            redirect('admin/wisata.php');
        }
        require BASE_PATH . '/app/views/layouts/admin_header.php';
        require BASE_PATH . '/app/views/admin/wisata_form.php';
        require BASE_PATH . '/app/views/layouts/admin_footer.php';
    }

    public function editWisataProses(int $id): void
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/wisata.php');

        $wisata = $this->wisataModel->getById($id);
        if (!$wisata) {
            setFlash('danger', 'Wisata tidak ditemukan.');
            redirect('admin/wisata.php');
        }

        $data   = $this->ambilDataWisataDariPost();
        $errors = $this->validasiWisata($data);

        // Handle foto (opsional saat edit)
        $fotoNama = $this->uploadFoto();
        if ($fotoNama === false) {
            $errors[] = 'Gagal mengupload foto.';
        }
        $data[':foto_utama'] = $fotoNama ?: $wisata['foto_utama'];

        if ($errors) {
            setFlash('danger', implode('<br>', $errors));
            redirect('admin/aksi_edit.php?id=' . $id);
        }

        $slug = slugify($data[':nama']);
        if ($this->wisataModel->slugExists($slug, $id)) {
            $slug .= '-' . $id;
        }
        $data[':slug'] = $slug;

        if ($this->wisataModel->update($id, $data)) {
            setFlash('success', 'Wisata berhasil diperbarui!');
        } else {
            setFlash('danger', 'Gagal memperbarui wisata.');
        }
        redirect('admin/wisata.php');
    }

    public function hapusWisata(int $id): void
    {
        requireLogin();
        $wisata = $this->wisataModel->getById($id);
        if (!$wisata) {
            setFlash('danger', 'Wisata tidak ditemukan.');
            redirect('admin/wisata.php');
        }

        // Hapus foto jika ada
        if (!empty($wisata['foto_utama'])) {
            $fotoPath = UPLOAD_PATH . $wisata['foto_utama'];
            if (file_exists($fotoPath)) unlink($fotoPath);
        }

        if ($this->wisataModel->delete($id)) {
            setFlash('success', 'Wisata berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus wisata.');
        }
        redirect('admin/wisata.php');
    }


    public function daftarUlasan(): void
    {
        requireLogin();
        $filter = $_GET['status'] ?? '';
        $ulasan = $this->ulasanModel->getAll($filter ? ['status' => $filter] : []);
        require BASE_PATH . '/app/views/layouts/admin_header.php';
        require BASE_PATH . '/app/views/admin/ulasan_daftar.php';
        require BASE_PATH . '/app/views/layouts/admin_footer.php';
    }

    public function setujuiUlasan(int $id): void
    {
        requireLogin();
        $this->ulasanModel->updateStatus($id, 'disetujui');
        setFlash('success', 'Ulasan disetujui.');
        redirect('admin/ulasan.php');
    }

    public function tolakUlasan(int $id): void
    {
        requireLogin();
        $this->ulasanModel->updateStatus($id, 'ditolak');
        setFlash('success', 'Ulasan ditolak.');
        redirect('admin/ulasan.php');
    }

    public function hapusUlasan(int $id): void
    {
        requireLogin();
        if ($this->ulasanModel->delete($id)) {
            setFlash('success', 'Ulasan berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus ulasan.');
        }
        redirect('admin/ulasan.php');
    }


    private function ambilDataWisataDariPost(): array
    {
        $fasilitas = $_POST['fasilitas'] ?? [];
        return [
            ':nama'              => clean($_POST['nama'] ?? ''),
            ':slug'              => '',
            ':kategori'          => $_POST['kategori'] ?? 'alam',
            ':deskripsi_singkat' => clean($_POST['deskripsi_singkat'] ?? ''),
            ':deskripsi_lengkap' => clean($_POST['deskripsi_lengkap'] ?? ''),
            ':fasilitas'         => json_encode(array_map('clean', (array) $fasilitas)),
            ':harga_weekday'     => (float) str_replace(['.', ','], ['', '.'], $_POST['harga_weekday'] ?? '0'),
            ':harga_weekend'     => (float) str_replace(['.', ','], ['', '.'], $_POST['harga_weekend'] ?? '0'),
            ':jam_buka'          => $_POST['jam_buka'] ?? '18:00',
            ':jam_tutup'         => $_POST['jam_tutup'] ?? '22:00',
            ':lokasi'            => clean($_POST['lokasi'] ?? ''),
            ':foto_utama'        => '',
            ':is_featured'       => isset($_POST['is_featured']) ? 1 : 0,
            ':status'            => $_POST['status'] ?? 'aktif',
        ];
    }


    private function validasiWisata(array $data): array
    {
        $errors = [];
        if (empty($data[':nama'])) $errors[] = 'Nama wisata wajib diisi.';
        if (empty($data[':deskripsi_singkat'])) $errors[] = 'Deskripsi singkat wajib diisi.';
        if (!in_array($data[':kategori'], ['alam', 'budaya', 'kuliner', 'wahana'])) {
            $errors[] = 'Kategori tidak valid.';
        }
        return $errors;
    }

    private function uploadFoto(): string|false|null
    {
        if (empty($_FILES['foto_utama']['name'])) return null;

        $file         = $_FILES['foto_utama'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize      = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > $maxSize) return false;
        if ($file['error'] !== UPLOAD_ERR_OK) return false;

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'wisata_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
        $target   = UPLOAD_PATH . $filename;

        if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);
        if (!move_uploaded_file($file['tmp_name'], $target)) return false;

        return $filename;
    }
}
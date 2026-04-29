<?php

class WisataModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getAll(array $filter = []): array
    {
        $sql    = "SELECT * FROM wisata WHERE 1=1";
        $params = [];

        if (!empty($filter['kategori'])) {
            $sql .= " AND kategori = :kategori";
            $params[':kategori'] = $filter['kategori'];
        }
        if (!empty($filter['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filter['status'];
        }
        if (!empty($filter['search'])) {
            $sql .= " AND (nama LIKE :search OR deskripsi_singkat LIKE :search)";
            $params[':search'] = '%' . $filter['search'] . '%';
        }

        $sql .= " ORDER BY is_featured DESC, created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public function getPublik(string $kategori = ''): array
    {
        $filter = ['status' => 'aktif'];
        if ($kategori) $filter['kategori'] = $kategori;
        return $this->getAll($filter);
    }


    public function getFeatured(int $limit = 4): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM wisata WHERE status = 'aktif' AND is_featured = 1
             ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM wisata WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }


    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM wisata WHERE slug = :slug AND status = 'aktif'");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }


    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO wisata
             (nama, slug, kategori, deskripsi_singkat, deskripsi_lengkap, fasilitas,
              harga_weekday, harga_weekend, jam_buka, jam_tutup, lokasi, foto_utama, is_featured, status)
             VALUES
             (:nama, :slug, :kategori, :deskripsi_singkat, :deskripsi_lengkap, :fasilitas,
              :harga_weekday, :harga_weekend, :jam_buka, :jam_tutup, :lokasi, :foto_utama, :is_featured, :status)"
        );
        return $stmt->execute($data);
    }


    public function update(int $id, array $data): bool
    {
        $data[':id'] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE wisata SET
             nama=:nama, slug=:slug, kategori=:kategori,
             deskripsi_singkat=:deskripsi_singkat, deskripsi_lengkap=:deskripsi_lengkap,
             fasilitas=:fasilitas, harga_weekday=:harga_weekday, harga_weekend=:harga_weekend,
             jam_buka=:jam_buka, jam_tutup=:jam_tutup, lokasi=:lokasi,
             foto_utama=:foto_utama, is_featured=:is_featured, status=:status
             WHERE id=:id"
        );
        return $stmt->execute($data);
    }


    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM wisata WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }


    public function count(array $filter = []): int
    {
        $sql    = "SELECT COUNT(*) FROM wisata WHERE 1=1";
        $params = [];
        if (!empty($filter['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filter['status'];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }


    public function slugExists(string $slug, int $excludeId = 0): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM wisata WHERE slug = :slug AND id != :id"
        );
        $stmt->execute([':slug' => $slug, ':id' => $excludeId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}

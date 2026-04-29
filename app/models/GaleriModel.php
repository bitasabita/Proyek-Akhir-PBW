<?php

class GaleriModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM galeri ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getAktif(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM galeri WHERE status = 'aktif' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM galeri WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return $data ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO galeri (judul, kategori, foto, status)
            VALUES (:judul, :kategori, :foto, :status)
        ");

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data[':id'] = $id;

        $stmt = $this->pdo->prepare("
            UPDATE galeri
            SET judul = :judul,
                kategori = :kategori,
                foto = :foto,
                status = :status
            WHERE id = :id
        ");

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM galeri WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
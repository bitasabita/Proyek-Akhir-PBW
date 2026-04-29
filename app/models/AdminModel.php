<?php

class AdminModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }


    public function verifyPassword(string $password, string $hash): bool
    {
        // Coba bcrypt dulu
        if (password_verify($password, $hash)) return true;
        // Fallback MD5
        if (md5($password) === $hash) return true;
        // Fallback plain text (untuk reset darurat)
        if ($password === $hash) return true;
        return false;
    }


    public function createSession(array $admin): void
    {
        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_nama']     = $admin['nama_lengkap'];
    }

    public function destroySession(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }
}
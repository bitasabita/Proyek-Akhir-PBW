<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/css/admin.css" rel="stylesheet">
    <style>
        .mk-login-body {
            background: #111127;
            background-image: radial-gradient(circle at 20% 30%, rgba(44,62,163,.15) 0%,transparent 40%),
                        radial-gradient(circle at 80% 70%, rgba(255,184,0,.05) 0%,transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
        }
        .mk-login-card {
            background: linear-gradient(135deg, rgba(29,29,52,.9) 0%, rgba(17,17,39,.95) 100%);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,.06);
            border-radius: 1.5rem;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
        }
    </style>
</head>
<body class="mk-login-body">

<?php $flash = getFlash(); if ($flash): ?>
<div style="position:fixed;top:1rem;right:1rem;z-index:9999;min-width:300px">
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
        <?= $flash['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<div class="mk-login-card shadow-lg">
    <div class="text-center mb-4">
        <div class="mb-3">
            <i class="bi bi-stars text-warning" style="font-size:3rem;filter:drop-shadow(0 0 10px rgba(255,184,0,.5))"></i>
        </div>
        <h2 class="text-warning fw-bold" style="font-family:'Cinzel Decorative',serif;letter-spacing:.1em">MAHAKAM</h2>
        <p class="text-muted small">Sanctuary Admin Portal</p>
    </div>

    <form action="<?= BASE_URL ?>/portal-mlg-2015.php" method="POST">
        <div class="mb-4">
            <label class="form-label text-muted small fw-semibold text-uppercase tracking-wider">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" name="username" class="form-control mk-input"
                        placeholder="admin" required autocomplete="username"
                        value="<?= e($_POST['username'] ?? '') ?>">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label text-muted small fw-semibold text-uppercase">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" name="password" id="passwordField"
                        class="form-control mk-input" placeholder="••••••••" required autocomplete="current-password">
                <button type="button" class="btn btn-dark border-secondary text-muted"
                        onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-dark mt-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/index.php" class="text-muted small text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Website
        </a>
    </div>

    <hr class="border-secondary mt-4">
    <p class="text-muted text-center" style="font-size:.65rem;letter-spacing:.15em">
        Masuk Untuk Mengelola Konten Mahakam Lampion Garden
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const f = document.getElementById('passwordField');
    const i = document.getElementById('eyeIcon');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SurfSchool Manager | Aloha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --surf-bg: #FDF5F0;
            --surf-accent: #19C3B1;
            --surf-text: #0A2540;
        }

        body { background-color: var(--surf-bg); color: var(--surf-text); font-family: 'Inter', sans-serif; }

        .navbar { 
            background: rgba(255, 255, 255, 0.8) !important; 
            backdrop-filter: blur(10px);
            padding: 15px 0;
        }
        .navbar-brand { font-weight: 800; letter-spacing: -1px; font-size: 1.5rem; color: var(--surf-text) !important; }
        .navbar-brand span { color: var(--surf-accent); }
        
.btn-nav-logout {
    background: #F8F9FA;
    color: #64748B;
    border: 1px solid #E2E8F0;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 10px;
    padding: 6px 14px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-nav-logout:hover { 
    background: #FFF5F5;
    color: #EF4444 !important;
    border-color: #FEE2E2;
}

.btn-nav-login {
    color: var(--surf-text);
    font-weight: 700;
    font-size: 0.85rem;
    text-decoration: none;
    transition: color 0.2s;
}

.btn-nav-login:hover {
    color: var(--surf-accent);
}
        
        .btn-nav-register {
            background: var(--surf-accent);
            color: white;
            border-radius: 12px;
            padding: 8px 25px;
            font-weight: 700;
            border: none;
            text-decoration: none;
        }
        .btn-nav-register:hover { color: white; opacity: 0.9; }
  
.brand-text-main {
    font-size: 1.2rem;
    line-height: 1;
    font-weight: 800;
    color: var(--surf-text);
}

.brand-text-sub {
    font-size: 0.9rem;
    line-height: 1;
    font-weight: 700;
    color: var(--surf-accent);
    letter-spacing: 1px;
}

.navbar-brand img {
    width: auto;
    max-height: 40px;
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="">
    <img src="assets/logo.png" alt="Taghazout Surf Expo" height="50" class="me-2">
    <div class="d-flex flex-column">
        <span class="brand-text-main">TAGHAZOUT</span>
        <span class="brand-text-sub">SURF EXPO</span>
    </div>
        </a>
        
       <div class="ms-auto d-flex align-items-center gap-3">
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="d-none d-md-block text-end" style="line-height: 1.1;">
            <span class="d-block small text-muted" style="font-size: 0.6rem; text-transform: uppercase; letter-spacing: 1px;">Session</span>
            <span class="small fw-bold text-accent"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
        </div>
        
        <a class="btn-nav-logout text-decoration-none" href="/Simplon-Bootcamp/PixelCraft_SurfProject/Controllers/AuthController.php?action=logout">
            <i class="bi bi-power"></i> <span>QUITTER</span>
        </a>

    <?php else: ?>
        <a class="btn-nav-login me-2" href="index.php?page=login">Connexion</a>
        <a class="btn-nav-register" href="index.php?page=register">REJOINDRE</a>
    <?php endif; ?>
</div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
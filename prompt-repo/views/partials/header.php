<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_auth = ($current_page === 'login.php' || $current_page === 'register.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevGenius</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-blue: #0a192f;
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
            color: #334155;
            margin: 0;
        }

        body.auth-bg {
            background: linear-gradient(135deg, rgb(40, 74, 125) 0%, #0d6efd 100%);
            background-attachment: fixed;
        }

        .navbar {
            background: var(--dark-blue) !important;
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(to right, #fff, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-icon {
            color: #3b82f6;
            filter: drop-shadow(0 0 5px rgba(59, 130, 246, 0.5));
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 5px 15px 5px 6px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* --- NOUVEAU BOUTON LOGOUT STYLE PRO --- */
        .btn-logout-pro {
            color: #ef4444;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 6px 15px;
            border: 1px solid #ef4444; /* Bordure rouge fine */
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            text-decoration: none;
        }

        .btn-logout-pro:hover {
            color: #fff !important;
            background: #ef4444; /* Devient plein au survol */
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        .navbar-brand i {
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover i {
            transform: rotate(15deg) scale(1.1);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 <?= $is_auth ? 'auth-bg' : '' ?>">

<?php if (!$is_auth): ?>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="">
            <i class="bi bi-cpu-fill brand-icon"></i>
            <span>DevGenius <small class="fw-light" style="font-size: 0.8rem;">PROMPTS</small></span>
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="user-badge d-flex align-items-center gap-2 text-white">
                    <div class="avatar text-uppercase">
                        <?= substr($_SESSION['user_name'], 0, 1) ?>
                    </div>
                    <span class="small fw-medium d-none d-sm-inline"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </div>
                
                <a href="../controllers/AuthController.php?logout=1" class="btn-logout-pro">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="flex-grow-1 <?= $is_auth ? 'd-flex align-items-center' : 'mt-4' ?>">
    <div class="container">
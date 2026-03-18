<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>GearLog - Connexion</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 50%, #8b0000 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-danger:hover {
            background-color: #a71d2a;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25 row rgba(220, 53, 69, 0.25);
        }
    </style>
</head>
<body>

<div class="card shadow-lg border-0" style="width: 380px;">
    <div class="card-header bg-dark text-white border-bottom border-danger border-4 text-center py-4">
        <h3 class="mb-0 fw-bold text-uppercase italic" style="letter-spacing: 2px;">
            <span class="text-danger">G</span>earLog
        </h3>
        <small class="text-secondary">Gestion d'actifs IT</small>
    </div>
    
    <div class="card-body p-4">
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 small text-center border-0" style="background-color: #f8d7da; color: #842029;">
                Identifiants incorrects
            </div>
        <?php endif; ?>

        <form action="../backend/process_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Utilisateur</label>
                <input type="text" name="username" class="form-control border-danger bg-light" placeholder="Ex: admin" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted text-uppercase">Mot de passe</label>
                <input type="password" name="password" class="form-control border-danger bg-light" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-danger w-100 fw-bold py-2 mb-2">SE CONNECTER</button>
        </form>
    </div>
    
    <div class="card-footer bg-transparent text-center py-3">
         © <?= date('Y') ?> <span class="text-danger fw-bold">G</span>earLog
    </div>
</div>

</body>
</html>
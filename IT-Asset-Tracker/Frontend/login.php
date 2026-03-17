<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>GearLog - Connexion</title>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-sm border-0" style="width: 350px;">
    <div class="card-header bg-dark text-white border-bottom border-danger border-3 text-center py-3">
        <h4 class="mb-0 fw-bold"><span class="text-danger">G</span>earLog Login</h4>
    </div>
    <div class="card-body p-4">
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 small">Identifiants incorrects</div>
        <?php endif; ?>

        <form action="../backend/process_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control border-danger" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Mot de passe</label>
                <input type="password" name="password" class="form-control border-danger" required>
            </div>
            <button type="submit" class="btn btn-danger w-100 fw-bold">Se connecter</button>
        </form>
    </div>
</div>

</body>
</html>
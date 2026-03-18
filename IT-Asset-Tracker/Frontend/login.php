<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>GearLog - Connexion</title>
    <style>
        body {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #ffebee 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: #ffffff !important;
            border-bottom: 3px solid #dc3545 !important;
            padding: 35px 0 25px 0;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            background-color: #fdfdfd;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }
    </style>
</head>
<body>

<div class="card border-0" style="width: 400px;">
    <div class="card-header text-center">
        <h2 class="mb-0 fw-bold" style="letter-spacing: -1px;">
            <span class="text-danger">G</span>earLog
        </h2>
        <p class="text-muted small mb-0 mt-1 fw-medium text-uppercase">Portail d'administration</p>
    </div>
    
    <div class="card-body p-4">
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 small text-center border-0 mb-4" style="border-radius: 10px;">
                <i class="fas fa-exclamation-triangle me-2"></i>Identifiants incorrects
            </div>
        <?php endif; ?>

        <form action="../backend/process_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary text-uppercase">Utilisateur</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 text-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control border-start-0" placeholder="admin" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary text-uppercase">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-danger w-100 py-2">
                SE CONNECTER <i class="fas fa-right-to-bracket ms-2"></i>
            </button>
        </form>
    </div>
    
    <div class="card-footer bg-white border-0 text-center pb-4">
        <span class="text-muted small">© <?= date('Y') ?> GearLog </span>
    </div>
</div>

</body>
</html>
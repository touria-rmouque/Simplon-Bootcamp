<?php session_start(); ?>
<?php include "partials/header.php"; ?>

<div class="login-container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="col-md-4">
        <div class="card border-0 shadow-lg auth-card">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                <div class="brand-logo mb-2">
                    <i class="fas fa-code-branch fa-2x text-primary"></i>
                </div>
                <h3 class="fw-bold text-dark">DevGenius <span class="text-primary text-gradient">Prompts</span></h3>
                <p class="text-muted small">Connectez-vous à la base de connaissances</p>
            </div>

            <div class="card-body p-4">
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        Identifiants invalides. Veuillez réessayer.
                    </div>
                <?php endif; ?>

                <form action="../controllers/AuthController.php" method="POST">
                    <input type="hidden" name="login" value="1">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email de l'agence</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="far fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nom@devgenius.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                        Se connecter <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                </form>
            </div>
            
            <div class="card-footer bg-light border-0 text-center py-3">
                <p class="mb-0 small">Nouveau développeur ? <a href="register.php" class="text-primary text-decoration-none fw-bold">Créer un compte</a></p>
            </div>
        </div>
    </div>
</div>


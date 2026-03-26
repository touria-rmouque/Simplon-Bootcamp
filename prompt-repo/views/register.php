<?php session_start(); ?>
<?php include "partials/header.php"; ?>

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span id="toastMessage">Cet email est déjà utilisé.</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="login-container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="col-md-4">
        <div class="card border-0 shadow-lg auth-card">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                <h3 class="fw-bold text-dark">Créer un <span class="text-primary text-gradient">Compte</span></h3>
                <p class="text-muted small">Rejoignez la communauté DevGenius</p>
            </div>

            <div class="card-body p-4">
                <form action="../controllers/AuthController.php" method="POST">
                    <input type="hidden" name="register" value="1">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nom complet</label>
                        <div class="input-group shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" class="form-control border-start-0" placeholder="Ex: Touria" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email de l'agence</label>
                        <div class="input-group shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control border-start-0" placeholder="nom@devgenius.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Mot de passe</label>
                        <div class="input-group shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                        S'inscrire 
                    </button>
                </form>
            </div>
            
            <div class="card-footer bg-light border-0 text-center py-3">
                <p class="mb-0 small">Déjà un compte ? <a href="login.php" class="text-primary text-decoration-none fw-bold">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('error') === 'email_exists') {
        const toastLiveExample = document.getElementById('errorToast');
        if (toastLiveExample) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
        }
    }
});
</script>

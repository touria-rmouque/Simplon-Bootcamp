<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include __DIR__ . '/../includes/header.php'; 
?>

<style>
    body { background-color: #FDF5F0 !important; color: #0A2540; font-family: 'Inter', sans-serif; }
    .auth-card { background: #FFFFFF; border: none; border-radius: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.03); padding: 40px; }
    .auth-title { font-weight: 800; font-size: 1.8rem; letter-spacing: -1px; margin-bottom: 30px; text-align: center; }
    .auth-title span { color: #19C3B1; }
    .form-label { font-weight: 700; font-size: 0.75rem; color: #888; text-transform: uppercase; margin-left: 15px; }
    .form-control { background-color: #F8F9FA; border: none; border-radius: 15px; padding: 12px 20px; font-weight: 600; }
    .form-control:focus { background-color: #fff; box-shadow: 0 0 0 4px rgba(25, 195, 177, 0.1); border: 1px solid #19C3B1; }
    .btn-surf { background: #0A2540; color: white; border-radius: 15px; padding: 15px; font-weight: 700; border: none; width: 100%; transition: all 0.3s; }
    .btn-surf:hover { background: #19C3B1; transform: translateY(-2px); color: white; }
</style>

<div class="container d-flex py-5 align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="col-md-6">
        <div class="auth-card">
           <div class="text-center mb-5">
    <p class="text-uppercase fw-bold tracking-widest mb-1" style="color: #19C3B1; font-size: 0.7rem; letter-spacing: 2px;">Accès Portail</p>
    <h1 class="auth-title mb-0">Connexion <span>Espace Membre</span></h1>
    <p class="text-muted small mt-2">Gérez vos sessions et votre profil Taghazout Surf Expo</p>
</div>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger border-0 rounded-4 small py-2 text-center">Identifiants invalides.</div>
            <?php endif; ?>

            <form action="/Simplon-Bootcamp/PixelCraft_SurfProject/Controllers/AuthController.php?action=login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nom@exemple.com" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn-surf shadow-sm">SE CONNECTER</button>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0 small text-muted">
                    Pas encore membre ? <a href="index.php?page=register" class="fw-bold" style="color: #19C3B1; text-decoration: none;">Inscrivez-vous</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
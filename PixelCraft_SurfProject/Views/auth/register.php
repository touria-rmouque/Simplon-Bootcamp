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
    .form-control, .form-select { background-color: #F8F9FA; border: none; border-radius: 15px; padding: 12px 20px; font-weight: 600; }
    .form-control:focus, .form-select:focus { background-color: #fff; box-shadow: 0 0 0 4px rgba(25, 195, 177, 0.1); border: 1px solid #19C3B1; }
    .btn-surf { background: #19C3B1; color: white; border-radius: 15px; padding: 15px; font-weight: 700; border: none; width: 100%; transition: all 0.3s; }
    .btn-surf:hover { background: #0A2540; transform: translateY(-2px); color: white; }
</style>

<div class="container py-5 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="auth-card">
            <h1 class="auth-title">Devenir <span>Membre</span></h1>
            
            <form action="/Simplon-Bootcamp/PixelCraft_SurfProject/Controllers/AuthController.php?action=register" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="fullName" class="form-control" placeholder="Prénom Nom" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Pays</label>
                        <input type="text" name="country" class="form-control" placeholder="Maroc" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Niveau</label>
                        <select name="level" class="form-select">
                            <option value="Beginner">Débutant</option>
                            <option value="Intermediate">Intermédiaire</option>
                            <option value="Advanced">Avancé</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-surf shadow-sm">CRÉER MON COMPTE</button>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0 small text-muted">
                    Déjà inscrit ? <a href="index.php?page=login" class="fw-bold" style="color: #19C3B1; text-decoration: none;">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if ($_SESSION['user_role'] !== 'admin') { header("Location: index.php"); exit(); }

include __DIR__ . '/../includes/header.php'; 
?>

<style>
    :root {
        --surf-bg: #FDF5F0;
        --surf-card: #FFFFFF;
        --surf-accent: #19C3B1;
        --surf-text: #0A2540;
        --surf-orange: #FFD9C0;
    }

    body { background-color: var(--surf-bg) !important; color: var(--surf-text); font-family: 'Inter', sans-serif; }
    
    .admin-container { max-width: 900px; margin-top: 40px; padding-bottom: 50px; }
    
    .admin-title { font-weight: 800; font-size: 2.2rem; letter-spacing: -1px; }
    .admin-title span { color: var(--surf-accent); }
    
    .card-custom { 
        background: var(--surf-card); 
        border: none; 
        border-radius: 25px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        padding: 40px;
    }

    .form-control-surf {
        background-color: #F8F9FA !important;
        border: none !important;
        border-radius: 15px !important;
        padding: 12px 20px !important;
        font-weight: 500;
        color: var(--surf-text);
    }
    .form-control-surf:focus {
        box-shadow: 0 0 0 3px rgba(25, 195, 177, 0.1) !important;
        background-color: #fff !important;
    }

    .btn-create {
        background: var(--surf-text);
        color: white;
        border-radius: 15px;
        padding: 12px 30px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
    }
    .btn-create:hover { background: var(--surf-accent); color: white; transform: translateY(-2px); }

    .btn-back {
        background: white;
        color: var(--surf-text);
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 700;
        border: 1px solid #eee;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back:hover { background: #f8f9fa; color: var(--surf-accent); }
</style>

<div class="container admin-container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <p class="text-muted mb-1 text-uppercase fw-bold small tracking-widest">Configuration</p>
            <h1 class="admin-title">Nouvelle <span>Session</span></h1>
        </div>
        <a href="index.php?page=admin_dashboard" class="btn-back mt-3 mt-md-0">
            <i class="bi bi-arrow-left me-2"></i> RETOUR
        </a>
    </div>

    <div class="card-custom">
        <form action="index.php?page=admin_dashboard&action=createLesson" method="POST">
            
            <div class="mb-4">
                <label class="small fw-bold text-muted mb-2 text-uppercase">Titre du cours</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;"><i class="bi bi-tag text-muted"></i></span>
                    <input type="text" name="title" class="form-control form-control-surf" 
                           style="border-radius: 0 15px 15px 0 !important;"
                           placeholder="Ex: Initiation Surf Taghazout" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="small fw-bold text-muted mb-2 text-uppercase">Date & Heure</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;"><i class="bi bi-calendar-event text-muted"></i></span>
                        <input type="datetime-local" name="lesson_date" class="form-control form-control-surf" 
                               style="border-radius: 0 15px 15px 0 !important;" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="small fw-bold text-muted mb-2 text-uppercase">Nom du Coach</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;"><i class="bi bi-person-badge text-muted"></i></span>
                        <input type="text" name="coach_name" class="form-control form-control-surf" 
                               style="border-radius: 0 15px 15px 0 !important;"
                               placeholder="Nom du moniteur" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="small fw-bold text-muted mb-2 text-uppercase">Capacité Max (Places)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;"><i class="bi bi-people text-muted"></i></span>
                        <input type="number" name="max_students" class="form-control form-control-surf" 
                               style="border-radius: 0 15px 15px 0 !important;"
                               value="8" min="1" required>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="small fw-bold text-muted mb-2 text-uppercase">Prix de la session (DH)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;"><i class="bi bi-cash-stack text-muted"></i></span>
                        <input type="number" step="0.01" name="price" class="form-control form-control-surf" 
                               style="border-radius: 0 15px 15px 0 !important;"
                               placeholder="0.00" required>
                    </div>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn-create shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> PUBLIER LA SESSION
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
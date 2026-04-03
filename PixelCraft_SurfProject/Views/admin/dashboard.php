<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include __DIR__ . '/../includes/header.php'; 
?>

<style>
    :root {
        --surf-bg: #FDF5F0; 
        --surf-card: #FFFFFF;
        --surf-accent: #19C3B1;
        --surf-dark: #0A2540;
        --surf-border: #E2E8F0;
        --surf-text-muted: #64748B;
    }

    body { 
        background-color: var(--surf-bg) !important; 
        color: var(--surf-dark); 
        font-family: 'Inter', sans-serif; 
        letter-spacing: -0.01em; 
    }
    
    .admin-container { max-width: 1240px; margin-top: 50px; padding-bottom: 60px; }
    
    .admin-title { font-weight: 800; font-size: 2.6rem; letter-spacing: -1.5px; line-height: 1; }
    .admin-title span { color: var(--surf-accent); }
    
    .btn-create {
        background: var(--surf-dark);
        color: white;
        border-radius: 14px;
        padding: 12px 28px;
        font-weight: 700;
        font-size: 0.85rem;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        box-shadow: 0 10px 20px rgba(10, 37, 64, 0.1);
    }
    .btn-create:hover { background: var(--surf-accent); transform: translateY(-2px); color: white; box-shadow: 0 15px 25px rgba(25, 195, 177, 0.2); }

    .nav-segmented {
        background: #F1F5F9; 
        padding: 5px; 
        border-radius: 16px; 
        display: inline-flex; 
        border: 1px solid var(--surf-border);
    }
    .nav-segmented .nav-link {
        color: var(--surf-text-muted) !important;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 12px;
        padding: 8px 22px;
        transition: all 0.2s ease;
        border: none;
    }
    .nav-segmented .nav-link.active {
        background-color: white !important;
        color: var(--surf-dark) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .card-custom { 
        background: var(--surf-card); 
        border: 1px solid var(--surf-border); 
        border-radius: 24px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        padding: 30px;
    }

    .table-custom thead th { 
        border-bottom: 2px solid var(--surf-bg);
        color: #94A3B8;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 15px 20px;
    }
    .table-custom tbody td { border-bottom: 1px solid #F1F5F9; padding: 18px 20px; vertical-align: middle; }
    .table-custom tbody tr:hover { background-color: #FAFBFC; }
    
    .badge-status { 
        padding: 5px 12px; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 0.7rem; 
        text-transform: uppercase;
    }

    .price-tag {
        color: var(--surf-dark);
        font-weight: 800;
        font-size: 0.9rem;
    }

    .action-icon {
        width: 36px; height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #F1F5F9;
        color: #64748B;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .action-icon:hover { border-color: var(--surf-accent); color: var(--surf-accent); background: white; }
    .action-icon.text-danger:hover { background: #FEF2F2; color: #EF4444 !important; border-color: #FEE2E2; }
</style>

<div class="container admin-container">
    <div class="row align-items-end mb-5">
        <div class="col-md-7">
            <div class="d-flex align-items-center mb-2">
                <div style="width: 20px; height: 3px; background: var(--surf-accent); border-radius: 10px;" class="me-2"></div>
                <span class="text-uppercase fw-800 text-muted" style="font-size: 0.65rem; letter-spacing: 2px;">Management Panel</span>
            </div>
            <h1 class="admin-title mb-0">Pilotage <span>Global</span></h1>
        </div>
        <div class="col-md-5 text-md-end mt-4 mt-md-0">
            <a href="index.php?page=add_lesson" class="btn-create text-decoration-none">
                <i class="bi bi-plus-circle-fill me-2 fs-6"></i> CRÉER UNE SESSION
            </a>
        </div>
    </div>

    <div class="nav-segmented mb-5">
        <ul class="nav nav-pills border-0" id="adminTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="lessons-tab" data-bs-toggle="tab" data-bs-target="#lessons" type="button">
                    <i class="bi bi-calendar3 me-2"></i>Sessions
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button">
                    <i class="bi bi-people me-2"></i>Membres
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="adminTabContent">
        <div class="tab-pane fade show active" id="lessons" role="tabpanel">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">Planning des activités</h5>
                    <span class="text-muted fw-bold small" style="font-size: 0.7rem;"><?= count($lessons ?? []) ?> SESSIONS ACTIVES</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Discipline</th>
                                <th>Coach</th>
                                <th>Date & Heure</th>
                                <th>Prix</th> <th>Occupation</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lessons)): foreach ($lessons as $l): ?>
                                <tr>
                                    <td class="fw-bold fs-6"><?= htmlspecialchars($l['title']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width:30px; height:30px;">
                                                <i class="bi bi-person text-muted"></i>
                                            </div>
                                            <span class="small fw-bold"><?= htmlspecialchars($l['coach_name']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold" style="color: var(--surf-accent);"><?= date('d M Y', strtotime($l['lesson_date'])) ?></div>
                                        <div class="small text-muted fw-bold"><?= date('H:i', strtotime($l['lesson_date'])) ?></div>
                                    </td>
                                    <td>
                                        <span class="price-tag"><?= number_format($l['price'], 2) ?> DH</span>
                                    </td>
                                    <td>
                                        <?php $percent = ($l['max_students'] > 0) ? ($l['current_students'] / $l['max_students']) * 100 : 0; ?>
                                        <div class="progress mb-1" style="height: 6px; width: 100px; border-radius: 10px; background: #EDF2F7;">
                                            <div class="progress-bar" style="width: <?= $percent ?>%; background: var(--surf-accent); border-radius: 10px;"></div>
                                        </div>
                                        <span class="fw-bold text-muted" style="font-size: 0.7rem;"><?= $l['current_students'] ?? 0 ?> / <?= $l['max_students'] ?></span>
                                    </td>
                                    <td class="text-end">
                                        <a href="index.php?page=manage_enrollments&id=<?= $l['id'] ?>" class="btn btn-sm btn-light border fw-bold px-3 rounded-pill me-2" style="font-size: 0.7rem;">Gérer</a>
                                        <a href="index.php?page=edit_lesson&id=<?= $l['id'] ?>" class="action-icon" title="Modifier"><i class="bi bi-pencil"></i></a>
                                        <a href="index.php?page=admin_dashboard&action=softDelete&id=<?= $l['id'] ?>" class="action-icon text-danger" onclick="return confirm('Archiver cette session ?')"><i class="bi bi-trash3"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">Aucune session active.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="students" role="tabpanel">
            <div class="card-custom">
                <h5 class="fw-bold mb-4">Membres de l'académie</h5>
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Élève</th>
                                <th>Provenance</th>
                                <th>Niveau</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($all_students)): foreach ($all_students as $student): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                                <?= strtoupper(substr($student['full_name'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($student['full_name']) ?></div>
                                                <div class="small text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($student['email']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-bold text-muted"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($student['country'] ?? 'N/A') ?></td>
                                    <td>
                                        <?php 
                                            $lvl = $student['level'];
                                            $style = ($lvl == 'Advanced') ? 'background:#DFFFEF; color:#27AE60;' : 
                                                    (($lvl == 'Intermediate') ? 'background:#FFF4E5; color:#E67E22;' : 'background:#E3F2F1; color:#19C3B1;');
                                        ?>
                                        <span class="badge-status" style="<?= $style ?>"><?= $lvl ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="action-icon border-0" data-bs-toggle="modal" data-bs-target="#editStudentModal" 
                                                data-id="<?= $student['id'] ?>" data-name="<?= htmlspecialchars($student['full_name']) ?>"
                                                data-email="<?= htmlspecialchars($student['email']) ?>" data-country="<?= htmlspecialchars($student['country'] ?? '') ?>"
                                                data-level="<?= $student['level'] ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="../../Controllers/AdminController.php?action=deleteStudent&id=<?= $student['id'] ?>" class="action-icon text-danger" onclick="return confirm('Archiver cet élève ?')">
                                            <i class="bi bi-person-x-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Aucun membre enregistré.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none; box-shadow: 0 25px 50px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold m-0">Modifier le profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=admin_dashboard&action=updateFullStudent" method="POST">
                <div class="modal-body px-4">
                    <input type="hidden" name="student_id" id="modal_id">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-1 text-uppercase ls-wide">Nom Complet</label>
                        <input type="text" name="full_name" id="modal_name" class="form-control rounded-pill bg-light border-0 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-1 text-uppercase ls-wide">Email</label>
                        <input type="email" name="email" id="modal_email" class="form-control rounded-pill bg-light border-0 py-2" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase ls-wide">Pays</label>
                            <input type="text" name="country" id="modal_country" class="form-control rounded-pill bg-light border-0 py-2">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase ls-wide">Niveau</label>
                            <select name="level" id="modal_level" class="form-select rounded-pill bg-light border-0 py-2">
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal" style="font-size: 0.8rem;">Annuler</button>
                    <button type="submit" class="btn-create py-2 px-4 shadow-sm" style="font-size: 0.8rem;">ENREGISTRER</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('editStudentModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; 
    document.getElementById('modal_id').value = button.getAttribute('data-id');
    document.getElementById('modal_name').value = button.getAttribute('data-name');
    document.getElementById('modal_email').value = button.getAttribute('data-email');
    document.getElementById('modal_country').value = button.getAttribute('data-country');
    document.getElementById('modal_level').value = button.getAttribute('data-level');
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
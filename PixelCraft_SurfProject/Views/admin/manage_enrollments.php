<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include __DIR__ . '/../includes/header.php'; 
?>

<style>
    :root { --surf-accent: #19C3B1; --surf-bg: #FDF5F0; --surf-text: #0A2540; }
    body { background-color: var(--surf-bg) !important; }
    .manage-card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    .lesson-info-box { background: #F8F9FA; border-left: 5px solid var(--surf-accent); border-radius: 15px; padding: 20px; }
    .btn-remove { color: #FF4B4B; background: #FFEBEB; border: none; width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
    .payment-select { border: none; border-radius: 10px; padding: 5px 12px; font-weight: 700; font-size: 0.75rem; cursor: pointer; outline: none; }
</style>

<div class="container py-5">
    <a href="index.php?page=admin_dashboard" class="text-decoration-none text-muted small fw-bold mb-4 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> RETOUR AU DASHBOARD
    </a>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="manage-card">
                <h4 class="fw-bold mb-4">Détails <span style="color: var(--surf-accent);">Session</span></h4>
                <div class="lesson-info-box mb-4">
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($lesson['title']) ?></h5>
                    <p class="text-muted small mb-0">Coach: <?= htmlspecialchars($lesson['coach_name']) ?></p>
                </div>
                <h2 class="fw-bold text-center"><?= count($enrolled_students) ?> / <?= $lesson['max_students'] ?></h2>
                <p class="text-center text-muted small text-uppercase">Occupation</p>

                <form action="index.php?page=admin_dashboard&action=enrollStudent" method="POST" class="mt-4">
                    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                    <select name="student_id" class="form-select rounded-pill bg-light border-0 mb-2" required>
                        <option value="" disabled selected>Inscrire un élève...</option>
                        <?php foreach ($available_students as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-dark w-100 rounded-pill fw-bold" type="submit">AJOUTER</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="manage-card">
                <h5 class="fw-bold mb-4">Élèves Inscrits & Statut Paiement</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-muted small text-uppercase">
                            <tr><th>Élève</th><th>Paiement Session</th><th class="text-end">Action</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enrolled_students as $student): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($student['full_name']) ?></div>
                                    <div class="small text-muted"><?= $student['level'] ?></div>
                                </td>
                                <td>
                                    <form action="index.php?page=admin_dashboard&action=updatePayment" method="POST">
                                        <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                        <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">
                                        <select name="payment_status" onchange="this.form.submit()" class="payment-select" 
                                                style="background: <?= ($student['payment_status'] == 'Paid') ? '#DFFFEF' : '#FFE5E5' ?>; 
                                                       color: <?= ($student['payment_status'] == 'Paid') ? '#27AE60' : '#EB5757' ?>;">
                                            <option value="Pending" <?= ($student['payment_status'] == 'Pending') ? 'selected' : '' ?>>ATTENTE</option>
                                            <option value="Paid" <?= ($student['payment_status'] == 'Paid') ? 'selected' : '' ?>>PAYÉ</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <a href="index.php?page=admin_dashboard&action=cancelEnrollment&lesson_id=<?= $lesson['id'] ?>&student_id=<?= $student['student_id'] ?>" 
                                       class="btn-remove" onclick="return confirm('Désinscrire ?')"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
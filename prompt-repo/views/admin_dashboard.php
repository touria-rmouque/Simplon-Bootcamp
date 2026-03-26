<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Prompt.php";
require_once "../models/Category.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = (new Database())->connect();
$promptModel = new Prompt($db);
$categoryModel = new Category($db);

$categories = $categoryModel->getAll();
$allPrompts = $promptModel->getAll();
$userName = $_SESSION['user_name'] ?? 'Admin';

$stats = [];
foreach ($allPrompts as $p) {
    $author = $p['author'];
    $stats[$author] = ($stats[$author] ?? 0) + 1;
}
arsort($stats); 
$topContributors = array_slice($stats, 0, 5); 

include "partials/header.php";
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; }
    .admin-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); }
    .card { border: none; transition: transform 0.2s; }
    .table thead { background-color: #f8fafc; }
    .avatar-sm { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: bold; font-size: 0.8rem; }
    .hidden-row { display: none !important; }
    .swal2-popup { border-radius: 15px !important; font-family: 'Inter', sans-serif !important; }
</style>

<div class="container">
    <div class="p-4 text-white rounded-4 shadow-lg mb-5 border-0 admin-gradient">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white p-2 rounded-3 text-primary shadow">
                <i class="bi bi-person-badge-fill fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0">Espace d'Administration</h3>
                <p class="opacity-75 mb-0">Bienvenue, <strong><?= htmlspecialchars($userName) ?></strong>.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 mb-4 bg-white border-start border-primary border-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3"><i class="bi bi-search me-2"></i>Recherche Filtre</h6>
                    <div class="mb-3">
                        <input type="text" id="searchTitle" class="form-control border-0 bg-light" placeholder="Chercher par titre...">
                    </div>
                    <div>
                        <select id="searchCategory" class="form-select border-0 bg-light">
                            <option value="">Toutes les catégories</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= htmlspecialchars($c['name']) ?>"><?= htmlspecialchars($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-4"><i class="bi bi-graph-up-arrow me-2"></i>Top Contributeurs</h6>
                    <?php foreach ($topContributors as $name => $count): ?>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-primary text-white"><?= strtoupper(substr($name, 0, 1)) ?></div>
                            <span class="fw-semibold text-dark small"><?= htmlspecialchars($name) ?></span>
                        </div>
                        <span class="badge bg-light text-primary rounded-pill"><?= $count ?> prompts</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card shadow-sm rounded-4 border-start border-primary border-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-dark">Catégories</h5>
                    <form action="../controllers/CategoryController.php" method="POST" class="mb-4">
                        <input type="hidden" name="create_category" value="1">
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control border-0 bg-light" placeholder="Nom..." required>
                            <button class="btn btn-primary px-3 shadow-sm"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </form>

                    <div class="overflow-auto" style="max-height: 300px;">
                        <?php foreach ($categories as $c): ?>
                        <div class="d-flex justify-content-between align-items-center p-2 mb-2 bg-light rounded-3 px-2">
                            <span class="small fw-medium"><?= htmlspecialchars($c['name']) ?></span>
                            <div class="d-flex gap-2">
                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editCat<?= $c['id'] ?>">
                                    <i class="bi bi-pencil-square small"></i>
                                </a>
                                <a href="javascript:void(0)" class="text-danger" onclick="confirmDeleteCategory(<?= $c['id'] ?>)">
                                    <i class="bi bi-trash small"></i>
                                </a>
                            </div>
                        </div>

                        <div class="modal fade" id="editCat<?= $c['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <form action="../controllers/CategoryController.php" method="POST">
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="update_category" value="1">
                                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                            <label class="form-label small fw-bold text-muted">RENOMMER</label>
                                            <input type="text" name="name" class="form-control bg-light border-0 mb-3" value="<?= htmlspecialchars($c['name']) ?>" required>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">OK</button>
                                                <button type="button" class="btn btn-light btn-sm w-100" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm rounded-4 overflow-hidden border-0">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Flux Global des Prompts</h5>
                    <span class="badge bg-primary text-white py-2 px-3 rounded-pill" id="itemCount"><?= count($allPrompts) ?> Items</span>
                </div>
                
                <div class="table-responsive" style="max-height: 830px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="promptsTable">
                        <thead class="sticky-top bg-light" style="z-index: 1;">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small">PROJET / THEME</th>
                                <th class="py-3 border-0 text-muted small">CONTRIBUTEUR</th>
                                <th class="py-3 border-0 text-end pe-4 text-muted small">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allPrompts as $p): ?>
                            <tr class="prompt-row" data-title="<?= strtolower(htmlspecialchars($p['title'])) ?>" data-category="<?= htmlspecialchars($p['category']) ?>">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark mb-0 small"><?= htmlspecialchars($p['title']) ?></div>
                                    <span class="text-primary small" style="font-size: 0.75rem;">#<?= htmlspecialchars($p['category']) ?></span>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-secondary">@<?= htmlspecialchars($p['author']) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm rounded-pill text-primary fw-bold px-3 border" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal<?= $p['id'] ?>">
                                        <i class="bi bi-eye-fill me-1"></i> Voir
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($p['title']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                       <div class="mb-3 d-flex gap-3">
                                         <span class="small text-muted"><i class="bi bi-person"></i> <?= htmlspecialchars($p['author']) ?></span>
                                         <span class="small text-muted"><i class="bi bi-tag"></i> <?= htmlspecialchars($p['category']) ?></span>
                                          </div>

                                           <div class="bg-light p-4 rounded-3 border text-dark fs-6" 
                                            style="white-space: pre-wrap; font-family: monospace;" 
                                             id="content<?= $p['id'] ?>"><?= htmlspecialchars($p['content']) ?></div>
                                          </div>

                                           <div class="modal-footer border-0 p-4 pt-0">
                                           <button class="btn btn-primary  py-2 shadow-sm fw-bold" 
                                            onclick="copyToClipboard('content<?= $p['id'] ?>')">
                                            <i class="bi bi-clipboard me-2"></i> Copier
                                             </button>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function copyToClipboard(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        Toast.fire({
            icon: 'success',
            title: 'Copié dans le presse-papier !'
        });
    });
}

function confirmDeleteCategory(id) {
    Swal.fire({
        title: 'Supprimer cette catégorie ?',
        text: "Les prompts liés ne seront pas supprimés mais n'auront plus de catégorie.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        customClass: { popup: 'rounded-4 shadow' }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../controllers/CategoryController.php?delete_category=${id}`;
        }
    });
}

const searchTitle = document.getElementById('searchTitle');
const searchCategory = document.getElementById('searchCategory');
const rows = document.querySelectorAll('.prompt-row');
const itemCount = document.getElementById('itemCount');

function filterPrompts() {
    const titleValue = searchTitle.value.toLowerCase();
    const catValue = searchCategory.value;
    let visibleCount = 0;

    rows.forEach(row => {
        const title = row.getAttribute('data-title');
        const category = row.getAttribute('data-category');
        const matchesTitle = title.includes(titleValue);
        const matchesCategory = catValue === "" || category === catValue;

        if (matchesTitle && matchesCategory) {
            row.style.display = ""; 
            visibleCount++;
        } else {
            row.style.display = "none";
        }
    });
    itemCount.innerText = visibleCount + " Items";
}
searchTitle.addEventListener('input', filterPrompts);
searchCategory.addEventListener('change', filterPrompts);

const urlParams = new URLSearchParams(window.location.search);

if (urlParams.has('success')) {
    let msg = "Opération réussie !";
    if(urlParams.get('success') === 'updated') msg = "Catégorie mise à jour !";
    if(urlParams.get('success') === 'created') msg = "Nouvelle catégorie ajoutée !";
    if(urlParams.get('success') === 'deleted') msg = "Catégorie supprimée !";

    Toast.fire({
        icon: 'success',
        title: msg
    });
    window.history.replaceState({}, document.title, window.location.pathname);
}

if (urlParams.has('error')) {
    Toast.fire({
        icon: 'error',
        title: 'Une erreur est survenue'
    });
    window.history.replaceState({}, document.title, window.location.pathname);
}
</script>

<?php include "partials/footer.php"; ?>
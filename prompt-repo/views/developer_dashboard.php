<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Prompt.php";
require_once "../models/Category.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = (new Database())->connect();
$promptModel = new Prompt($db);
$categoryModel = new Category($db);

$user_id = $_SESSION['user_id'];
$categories = $categoryModel->getAll();
$userName = $_SESSION['user_name'] ?? 'Développeur';

$myPrompts = $promptModel->getByUser($user_id);
$allPrompts = $promptModel->getAll();

include "partials/header.php";
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <div class="p-4 text-white rounded-4 shadow-sm mb-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%)">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary p-2 rounded-3"><i class="bi bi-terminal-fill fs-3"></i></div>
                <div>
                    <h3 class="fw-bold mb-0">Espace Développeur</h3>
                    <p class="opacity-75 mb-0">Bienvenue, <strong><?= htmlspecialchars($userName) ?></strong>.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4 bg-white border-start border-primary border-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3"><i class="bi bi-search me-2"></i>Recherche rapide</h6>
                    <div class="mb-3">
                        <input type="text" id="devSearchTitle" class="form-control border-0 bg-light" placeholder="Chercher par titre...">
                    </div>
                    <select id="devSearchCategory" class="form-select border-0 bg-light">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= htmlspecialchars($c['name']) ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 border-start border-primary border-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Nouveau Prompt</h5>
                    <form action="../controllers/PromptController.php" method="POST">
                        <input type="hidden" name="create" value="1">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">TITRE DU PROJET</label>
                            <input type="text" name="title" class="form-control border-0 bg-light" placeholder="Nom du prompt..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CATÉGORIE</label>
                            <select name="category_id" class="form-select border-0 bg-light">
                                <?php foreach ($categories as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">CONTENU</label>
                            <textarea name="content" class="form-control border-0 bg-light" rows="5" required></textarea>
                        </div>
                        <button class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-3">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-0">
                    <ul class="nav nav-tabs card-header-tabs border-0 gap-2" id="promptTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold border-0 rounded-3" id="my-tab" data-bs-toggle="tab" data-bs-target="#my-prompts" type="button">Mes Prompts</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold border-0 rounded-3 text-muted" id="all-tab" data-bs-toggle="tab" data-bs-target="#others-prompts" type="button">Bibliothèque Publique</button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="my-prompts" role="tabpanel" style="max-height: 600px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody id="myPromptsBody">
                                        <?php foreach ($myPrompts as $p): ?>
                                        <tr class="prompt-item" data-title="<?= strtolower(htmlspecialchars($p['title'])) ?>" data-category="<?= htmlspecialchars($p['category']) ?>">
                                            <td class="ps-4 py-3">
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($p['title']) ?></div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary mt-1"><?= htmlspecialchars($p['category']) ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group shadow-sm">
                                                    <button type="button" class="btn btn-white btn-sm border" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">
                                                        <i class="bi bi-pencil-square text-primary"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-white btn-sm border" onclick="confirmDelete(<?= $p['id'] ?>)">
                                                        <i class="bi bi-trash3 text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <form action="../controllers/PromptController.php" method="POST">
                                                        <input type="hidden" name="update" value="1">
                                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                        <div class="modal-header border-0 bg-light p-4">
                                                            <h5 class="fw-bold mb-0">Modifier mon Prompt</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold text-muted">TITRE</label>
                                                                <input type="text" name="title" class="form-control border-0 bg-light py-2" value="<?= htmlspecialchars($p['title']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold text-muted">CATÉGORIE</label>
                                                                <select name="category_id" class="form-select border-0 bg-light py-2">
                                                                    <?php foreach ($categories as $c): ?>
                                                                        <option value="<?= $c['id'] ?>" <?= ($c['name'] == $p['category']) ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($c['name']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-0">
                                                                <label class="form-label small fw-bold text-muted">CONTENU</label>
                                                                <textarea name="content" class="form-control border-0 bg-light py-2" rows="6" required><?= htmlspecialchars($p['content']) ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 p-4 pt-0">
                                                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">Mettre à jour</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="others-prompts" role="tabpanel" style="max-height: 600px; overflow-y: auto;">
                            <div class="p-4">
                                <div class="row g-3" id="publicPromptsBody">
                                    <?php foreach ($allPrompts as $p): ?>
                                        <?php if($p['user_id'] != $user_id): ?>
                                        <div class="col-md-6 prompt-item" data-title="<?= strtolower(htmlspecialchars($p['title'])) ?>" data-category="<?= htmlspecialchars($p['category']) ?>">
                                            <div class="card border border-light shadow-sm rounded-4 h-100 p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($p['title']) ?></h6>
                                                    <span class="badge bg-light text-muted border small"><?= htmlspecialchars($p['author'] ?? 'Anonyme') ?></span>
                                                </div>
                                                <p class="text-muted small text-truncate-2 mb-3"><?= htmlspecialchars($p['content']) ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary mt-1"><?= htmlspecialchars($p['category']) ?></span>
                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewModal<?= $p['id'] ?>">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="viewModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-0 bg-light p-4">
                                                        <h5 class="fw-bold mb-0"><?= htmlspecialchars($p['title']) ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <small class="text-muted d-block mb-3">Catégorie : <?= htmlspecialchars($p['category']) ?> | Auteur : <?= htmlspecialchars($p['author'] ?? 'Anonyme') ?></small>
                                                        <div class="bg-light p-3 rounded-3 border text-dark" style="white-space: pre-wrap; font-family: monospace;"><?= htmlspecialchars($p['content']) ?></div>
                                                    </div>
                                                    <div class="modal-footer border-0 p-4 pt-0">
                                                        <button type="button" class="btn btn-primary fw-bold" onclick="copyToClipboard(`<?= addslashes($p['content']) ?>`)">
                                                            <i class="bi bi-clipboard me-1"></i> Copier
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

const searchInput = document.getElementById('devSearchTitle');
const categorySelect = document.getElementById('devSearchCategory');
const allItems = document.querySelectorAll('.prompt-item');

function performFilter() {
    const text = searchInput.value.toLowerCase();
    const cat = categorySelect.value;

    allItems.forEach(item => {
        const title = item.getAttribute('data-title');
        const category = item.getAttribute('data-category');
        const matchesText = title.includes(text);
        const matchesCat = (cat === "" || category === cat);
        item.style.display = (matchesText && matchesCat) ? "" : "none";
    });
}
searchInput.addEventListener('input', performFilter);
categorySelect.addEventListener('change', performFilter);

function confirmDelete(id) {
    Swal.fire({
        title: 'Supprimer ce prompt ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        customClass: { popup: 'rounded-4 shadow' }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../controllers/PromptController.php?delete=${id}`;
        }
    })
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Toast.fire({
            icon: 'success',
            title: 'Contenu copié !'
        });
    });
}

<?php if(isset($_SESSION['flash_success'])): ?>
    Toast.fire({
        icon: 'success',
        title: '<?= $_SESSION['flash_success'] ?>'
    });
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    Toast.fire({
        icon: 'error',
        title: 'Une erreur est survenue'
    });
<?php endif; ?>
</script>

<style>
    .nav-tabs .nav-link.active { background-color: #f8f9fa !important; border-bottom: 3px solid #1e40af !important; color: #1e40af !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .btn-white { background: white; }
    .btn-white:hover { background: #f8f9fa; }
    .swal2-popup { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important; }
</style>

<?php include "partials/footer.php"; ?>
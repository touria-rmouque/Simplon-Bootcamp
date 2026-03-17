<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';

$database = new Database();
$db = $database->getConnection();
$assetManager = new Asset($db);

$limit = 6; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $limit;

$totalAssets = $assetManager->countAll();
$totalPages = ceil($totalAssets / $limit);

$all_assets = $assetManager->getPaginated($start, $limit);

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold border-start border-danger border-4 ps-3">Inventaire</h2>
        <div class="flex-grow-1 mx-4">
            <input type="text" id="searchInput" class="form-control border-danger" placeholder="Rechercher...">
        </div>
        <a href="add_form.php" class="btn btn-danger">+ Ajouter</a>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded" >
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>S/N</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_assets)): ?>
                    <?php foreach ($all_assets as $row): ?>
                        <tr>
                            <td class="fw-bold"><?= $row['serial_number'] ?></td>
                            <td><?= $row['device_name'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td class="text-nowrap"><?= number_format($row['price'], 2) ?> DH</td>
                            <td>
                                <?php 
                                    $status = $row['status'];
                                    $color = ($status == 'Deployed') ? 'bg-success' : (($status == 'Under Repair') ? 'bg-danger' : 'bg-dark');
                                ?>
                                <span class="badge <?= $color ?>"><?= $status ?></span>
                            </td>
                            <td class="text-center">
                                <a href="edit_form.php?sn=<?= $row['serial_number'] ?>" class="btn btn-sm btn-outline-dark">Modifier</a>
                                <a href="../backend/process_delete.php?sn=<?= $row['serial_number'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Aucun matériel sur cette page.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="?page=<?= $page - 1 ?>">Précédent</a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link <?= ($page == $i) ? 'bg-danger border-danger text-white' : 'text-dark' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="?page=<?= $page + 1 ?>">Suivant</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<script>

document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?php include 'includes/footer.php'; ?>
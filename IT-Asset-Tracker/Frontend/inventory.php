<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';

$database = new Database();
$db = $database->getConnection();
$assetManager = new Asset($db);
$all_assets = $assetManager->getAll();

include 'includes/header.php';
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold border-start border-danger border-4 ps-3">Inventaire</h2>
        <div class="flex-grow-1 mx-4">
       <input type="text" id="searchInput" class="form-control border-danger" placeholder="Rechercher (Nom, S/N, Catégorie...)">
       </div>
        <a href="add_form.php" class="btn btn-danger">+ Ajouter</a>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
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
                                    $color = 'bg-dark'; 
                                    if ($status == 'Deployed') $color = 'bg-success';
                                    if ($status == 'Under Repair') $color = 'bg-danger';
                                ?>
                                <span class="badge <?= $color ?>"><?= $status ?></span>
                            </td>
                            <td class="text-center">
                                <a href="edit_form.php?sn=<?= $row['serial_number'] ?>" class="btn btn-sm btn-outline-dark">Modifier</a>
                                <a href="../backend/process_delete.php?sn=<?= $row['serial_number'] ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">L'inventaire est vide.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
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
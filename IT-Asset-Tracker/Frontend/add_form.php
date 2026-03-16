<?php
require_once '../classes/Database.php';
require_once '../classes/Category.php';

$database = new Database();
$db = $database->getConnection();

$categoryManager = new Category($db);
$categories = $categoryManager->getAll();

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white border-bottom border-danger border-3">
            <h4 class="mb-0">Ajouter un matériel</h4>
        </div>
        
        <div class="card-body p-4">
            <form action="../backend/process_add.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Numéro de Série (S/N)</label>
                        <input type="text" name="serial_number" class="form-control" placeholder="Ex: SN-12345" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nom du matériel</label>
                        <input type="text" name="device_name" class="form-control" placeholder="Ex: MacBook Pro" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Prix (DH)</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Choisir...</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <select name="status" class="form-select" required>
                            <option value="Storage">En Stock (Storage)</option>
                            <option value="Deployed">Déployé</option>
                            <option value="Under Repair">En Réparation</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-danger px-4">Enregistrer</button>
                    <a href="inventory.php" class="btn btn-outline-dark px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
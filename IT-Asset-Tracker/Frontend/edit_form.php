<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';
require_once '../classes/Category.php';

$database = new Database();
$db = $database->getConnection();


$sn = $_GET['sn'] ?? '';
$query = "SELECT * FROM assets WHERE serial_number = :sn";
$stmt = $db->prepare($query);
$stmt->bindParam(':sn', $sn);
$stmt->execute();
$asset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$asset) { die("Matériel introuvable."); }

$catManager = new Category($db);
$categories = $catManager->getAll();

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white border-bottom border-danger border-3">
            <h4 class="mb-0">Modifier : <span class=""><?= htmlspecialchars($asset['serial_number']) ?></span></h4>
        </div>
        
        <div class="card-body p-4">
            <form action="../backend/process_update.php" method="POST">
                <input type="hidden" name="serial_number" value="<?= $asset['serial_number'] ?>">

                <div class="mb-4">
                    <label class="form-label fw-bold">Nom du matériel</label>
                    <input type="text" name="device_name" class="form-control" value="<?= htmlspecialchars($asset['device_name']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Prix (DH)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= $asset['price'] ?>" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $asset['category_id']) ? 'selected' : '' ?>>
                                    <?= $cat['type'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <select name="status" class="form-select">
                            <option value="Storage" <?= ($asset['status'] == 'Storage') ? 'selected' : '' ?>>En Stock (Storage)</option>
                            <option value="Deployed" <?= ($asset['status'] == 'Deployed') ? 'selected' : '' ?>>Déployé</option>
                            <option value="Under Repair" <?= ($asset['status'] == 'Under Repair') ? 'selected' : '' ?>>En Réparation</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-danger px-4">Mettre à jour</button>
                    <a href="inventory.php" class="btn btn-outline-dark px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
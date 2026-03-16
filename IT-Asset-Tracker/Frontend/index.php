<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';

$database = new Database();
$db = $database->getConnection();
$assetManager = new Asset($db);

$totalValue = $assetManager->getTotalValue();
$allAssets = $assetManager->getAll();
$countTotal = count($allAssets);

$countRepair = 0;
foreach ($allAssets as $asset) {
    if ($asset['status'] == 'Under Repair') {
        $countRepair++;
    }
}
$countStorage = 0;
foreach($allAssets as $assets){
    if($assets['status']=='Storage'){
        $countStorage++;
    }
}

$countDeployed = 0;
foreach($allAssets as $assets){
    if($assets['status']=='Deployed'){
        $countDeployed++;
    }
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold border-start border-danger border-4 ps-3 mb-4">Dashboard</h2>

    <div class="row ">
        <div class="col">
            <div class="card shadow-sm border-0 border-top border-danger border-4">
                <div class="card-body text-center">
                    <h5 class="text-muted small uppercase fw-bold">Valeur Totale</h5>
                    <h2 class="display-6 fw-bold text-dark"><?= number_format($totalValue, 2) ?> <small>DH</small></h2>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm border-0 border-top border-dark border-4">
                <div class="card-body text-center">
                    <h5 class="text-muted small uppercase fw-bold">Total Matériels</h5>
                    <h2 class="display-6 fw-bold text-dark"><?= $countTotal ?></h2>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row g-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-warning border-4">
                <div class="card-body text-center">
                    <h5 class="text-muted small uppercase fw-bold">En Réparation</h5>
                    <h2 class="display-6 fw-bold text-danger"><?= $countRepair ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-secondary border-4">
                <div class="card-body text-center">
                    <h5 class="text-muted small uppercase fw-bold">En Stockage</h5>
                    <h2 class="display-6 fw-bold text-danger"><?= $countStorage ?></h2>
                </div>
            </div>
        </div>

            <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-success border-4">
                <div class="card-body text-center">
                    <h5 class="text-muted small uppercase fw-bold">Déployé</h5>
                    <h2 class="display-6 fw-bold text-danger"><?= $countDeployed ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
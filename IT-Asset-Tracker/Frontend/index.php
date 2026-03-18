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
$countStorage = 0;
$countDeployed = 0;

foreach ($allAssets as $asset) {
    if ($asset['status'] == 'Under Repair') $countRepair++;
    if ($asset['status'] == 'Storage') $countStorage++;
    if ($asset['status'] == 'Deployed') $countDeployed++;
}

include 'includes/header.php';
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeInUp 0.6s ease-out forwards;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0; 
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    .row:nth-of-type(1) .col:nth-child(1) .card { animation-delay: 0.1s; }
    .row:nth-of-type(1) .col:nth-child(2) .card { animation-delay: 0.2s; }
    .row:nth-of-type(2) .col-md-4:nth-child(1) .card { animation-delay: 0.3s; }
    .row:nth-of-type(2) .col-md-4:nth-child(2) .card { animation-delay: 0.4s; }
    .row:nth-of-type(2) .col-md-4:nth-child(3) .card { animation-delay: 0.5s; }
</style>

<div class="container mt-4">
    <h2 class="fw-bold border-start border-danger border-4 ps-3 mb-4">Dashboard</h2>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 border-top border-danger border-4">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted small text-uppercase fw-bold">Valeur Totale</h5>
                    <h2 class="display-6 fw-bold text-dark mb-0">
                        <span class="counter" data-target="<?= $totalValue ?>"><?= $totalValue ?></span> <small class="fs-4">DH</small>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 border-top border-dark border-4">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted small text-uppercase fw-bold">Total Matériels</h5>
                    <h2 class="display-6 fw-bold text-dark mb-0">
                        <span class="counter" data-target="<?= $countTotal ?>"><?= $countTotal ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-warning border-4">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted small text-uppercase fw-bold">En Réparation</h5>
                    <h2 class="display-6 fw-bold text-danger mb-0">
                        <span class="counter" data-target="<?= $countRepair ?>"><?= $countRepair ?></span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-secondary border-4">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted small text-uppercase fw-bold">En Stockage</h5>
                    <h2 class="display-6 fw-bold text-danger mb-0">
                        <span class="counter" data-target="<?= $countStorage ?>"><?= $countStorage ?></span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-success border-4">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted small text-uppercase fw-bold">Déployé</h5>
                    <h2 class="display-6 fw-bold text-danger mb-0">
                        <span class="counter" data-target="<?= $countDeployed ?>"><?= $countDeployed ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.counter');
    const speed = 100; 

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText.replace(/\s/g, '');
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc).toLocaleString();
                setTimeout(updateCount, 15);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        counter.innerText = '0'; 
        updateCount();
    });
});
</script>

<?php include 'includes/footer.php'; ?>
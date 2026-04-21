<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-6">
        <div class="flex-1">
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Catalogue des Jeux</h1>
            <p class="text-slate-500 mt-2 text-lg flex items-center gap-2">
                <i data-lucide="sparkles" class="w-5 h-5 text-amber-500"></i>
                Découvrez notre collection soigneusement sélectionnée pour vos soirées.
            </p>
        </div>

        <form action="/games" method="GET" class="shrink-0 w-full md:w-auto">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </div>
                <select name="category" onchange="this.form.submit()" class="appearance-none bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 block w-full pl-10 pr-10 py-3 shadow-sm transition-all outline-none cursor-pointer">
                    <option value="">Toutes les catégories</option>
                    <?php 
                    $categories = ['Stratégie', 'Ambiance', 'Famille', 'Experts'];
                    foreach($categories as $cat): 
                    ?>
                        <option value="<?= $cat ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat) ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php foreach($games as $game): 
            // Vérification de la disponibilité (suppose que votre SQL récupère is_available)
            $isAvailable = $game['is_available'] ?? true;
        ?>
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden relative">
                
                <div class="h-2 <?= $isAvailable ? 'bg-indigo-500' : 'bg-rose-500' ?>"></div>
                
                <div class="p-6 flex-grow <?= !$isAvailable ? 'opacity-75' : '' ?>">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex flex-col gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                                <?= htmlspecialchars($game['category']) ?>
                            </span>
                            
                            <?php if(!$isAvailable): ?>
                                <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase text-rose-600">
                                    <i data-lucide="play-circle" class="w-3 h-3"></i>
                                    En cours d'utilisation
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if($game['average_rating']): ?>
                            <div class="flex items-center gap-1 text-amber-500 font-bold text-sm">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <?= number_format($game['average_rating'], 1) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight mb-3 group-hover:text-indigo-600 transition-colors">
                        <?= htmlspecialchars($game['name']) ?>
                    </h2>
                    
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        <?= htmlspecialchars($game['description']) ?>
                    </p>

                    <div class="flex items-center gap-4 py-3 border-t border-slate-50 text-slate-600 text-sm">
                        <div class="flex items-center gap-1.5 font-medium">
                            <i data-lucide="users" class="w-4 h-4 text-slate-400"></i>
                            <?= $game['min_players'] ?>-<?= $game['max_players'] ?>
                        </div>
                        <div class="flex items-center gap-1.5 font-medium">
                            <i data-lucide="hourglass" class="w-4 h-4 text-slate-400"></i>
                            <?= $game['duration'] ?>'
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-slate-50/50">
                    <?php if($isAvailable): ?>
                        <a href="/games/<?= $game['id'] ?>" class="flex items-center justify-center gap-2 w-full bg-white border border-slate-200 text-slate-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 font-bold py-3 px-4 rounded-2xl transition-all shadow-sm">
                            <span>Détails du jeu</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    <?php else: ?>
                        <div class="flex items-center justify-center gap-2 w-full bg-slate-100 border border-slate-200 text-slate-400 font-bold py-3 px-4 rounded-2xl cursor-not-allowed">
                            <span>Jeu occupé</span>
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
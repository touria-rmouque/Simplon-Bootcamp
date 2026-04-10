<?php 
$pageTitle = "Découvrir l'Héritage - Marrakech Food Lovers";
require_once 'Views/layout/header.php'; 
?>

<div class="mb-12">
    <h2 class="text-4xl font-black uppercase tracking-tighter text-white">
        L'Héritage <span class="text-[#d4af37] drop-shadow-[0_0_8px_rgba(212,175,55,0.4)]">Culinaire</span>
    </h2>
    <div class="h-1 w-20 bg-[#d4af37] mt-2 rounded-full"></div>
    <p class="text-slate-400 mt-4 max-w-xl leading-relaxed">
        Explorez les saveurs authentiques de Marrakech, un voyage sensoriel numérisé pour préserver notre patrimoine.
    </p>
</div>

<div class="mb-10 flex flex-col md:flex-row gap-6 items-center justify-between bg-slate-900/40 p-6 rounded-2xl border border-slate-800 backdrop-blur-md">
    <div class="relative w-full md:w-80">
        <span class="absolute inset-y-0 left-4 flex items-center text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="searchInput" placeholder="Chercher un plat..." 
               class="w-full bg-slate-800/50 border border-slate-700 py-3 pl-12 pr-4 rounded-xl text-white focus:outline-none focus:border-[#d4af37] transition-all placeholder:text-slate-600">
    </div>

    <div class="flex flex-wrap gap-2 justify-center" id="filterButtons">
        <button class="filter-btn active px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-[#d4af37] text-slate-950 transition-all shadow-lg shadow-[#d4af37]/20" data-category="all">Tous</button>
        <button class="filter-btn px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 hover:bg-slate-700 transition-all" data-category="Entrées">Entrées</button>
        <button class="filter-btn px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 hover:bg-slate-700 transition-all" data-category="Plats de résistance">Plats</button>
        <button class="filter-btn px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 hover:bg-slate-700 transition-all" data-category="Desserts">Desserts</button>
        <button class="filter-btn px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 hover:bg-slate-700 transition-all" data-category="Pâtisserie Marocaine">Pâtisserie</button>
        <button class="filter-btn px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 hover:bg-slate-700 transition-all" data-category="Boissons & Thés">Boissons</button>
    </div>
</div>

<div id="recipeGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php if (empty($recipes)): ?>
        <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-800 rounded-3xl">
            <p class="text-slate-500 italic text-lg">Aucune recette n'a encore été ajoutée à l'héritage.</p>
        </div>
    <?php else: ?>
        <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card bg-slate-900/40 backdrop-blur-sm rounded-2xl overflow-hidden border border-slate-800/50 hover:border-[#d4af37]/50 transition-all duration-500 group shadow-2xl flex flex-col"
             data-title="<?php echo strtolower(htmlspecialchars($recipe['titre'] ?? '')); ?>"
             data-category="<?php echo htmlspecialchars($recipe['category_name'] ?? 'Tradition'); ?>"
             data-ingredients="<?php echo strtolower(htmlspecialchars($recipe['ingredients'] ?? '')); ?>">
            
            <div class="h-64 relative overflow-hidden">
                <?php $image = !empty($recipe['image_url']) ? $recipe['image_url'] : 'default_food.jpg'; ?>
                <img src="/Simplon-Bootcamp/marrakech_food/assets/img/<?php echo $image; ?>" 
                     alt="<?php echo htmlspecialchars($recipe['titre'] ?? 'Recette'); ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                
                <div class="absolute top-4 left-4 bg-black/70 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold text-[#d4af37] uppercase tracking-widest border border-[#d4af37]/20">
                    <?php echo htmlspecialchars($recipe['category_name'] ?? 'Tradition'); ?>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 to-transparent opacity-60"></div>
            </div>

            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-extrabold text-white mb-2 group-hover:text-[#d4af37] transition-colors duration-300">
                    <?php echo htmlspecialchars($recipe['titre'] ?? 'Sans titre'); ?>
                </h3>
                
                <p class="text-slate-400 text-sm line-clamp-2 mb-6 flex-grow leading-relaxed">
                    <?php echo htmlspecialchars($recipe['description'] ?? 'Découvrez les secrets de cette préparation ancestrale...'); ?>
                </p>
                
                <div class="flex justify-between items-center pt-4 border-t border-slate-800/50">
                    <a href="/Simplon-Bootcamp/marrakech_food/recipe/show?id=<?php echo $recipe['id']; ?>" 
                       class="text-[11px] font-black uppercase tracking-[0.2em] text-[#d4af37] hover:brightness-125 transition-all">
                        Détails
                    </a>

                    <div class="flex items-center gap-4">
                        <a href="/Simplon-Bootcamp/marrakech_food/favorite/toggle?id=<?php echo $recipe['id']; ?>" 
                           class="group/fav transition-transform active:scale-90">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5 <?php echo (isset($recipe['is_favorite']) && $recipe['is_favorite'] == 1) ? 'text-red-500 fill-red-500' : 'text-slate-500 group-hover/fav:text-red-500'; ?> transition-colors" 
                                 fill="<?php echo (isset($recipe['is_favorite']) && $recipe['is_favorite'] == 1) ? 'currentColor' : 'none'; ?>" 
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $recipe['user_id']): ?>
                            <div class="h-4 w-[1px] bg-slate-800 mx-1"></div>
                            <a href="/Simplon-Bootcamp/marrakech_food/recipe/edit?id=<?php echo $recipe['id']; ?>" class="text-slate-500 hover:text-blue-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12 18.5H8.5V15l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="/Simplon-Bootcamp/marrakech_food/recipe/delete?id=<?php echo $recipe['id']; ?>" 
                               onclick="return confirm('Supprimer cette recette ?')"
                               class="text-slate-500 hover:text-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="noResults" class="hidden py-20 text-center border-2 border-dashed border-slate-800 rounded-3xl">
    <p class="text-slate-500 italic text-lg">Aucun délice ne correspond à votre recherche.</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.recipe-card');
    const noResults = document.getElementById('noResults');

    function performFiltering() {
        const query = searchInput.value.toLowerCase().trim();
        const activeCat = document.querySelector('.filter-btn.active').getAttribute('data-category');
        let count = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            const ingredients = card.getAttribute('data-ingredients');
            const category = card.getAttribute('data-category');

            const matchesSearch = title.includes(query) || ingredients.includes(query);
            const matchesCategory = (activeCat === 'all' || category === activeCat);

            if (matchesSearch && matchesCategory) {
                card.style.display = 'flex';
                count++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.classList.toggle('hidden', count > 0);
    }

    searchInput.addEventListener('input', performFiltering);

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => {
                b.classList.remove('active', 'bg-[#d4af37]', 'text-slate-950', 'shadow-lg', 'shadow-[#d4af37]/20');
                b.classList.add('bg-slate-800', 'text-slate-400');
            });
            this.classList.add('active', 'bg-[#d4af37]', 'text-slate-950', 'shadow-lg', 'shadow-[#d4af37]/20');
            this.classList.remove('bg-slate-800', 'text-slate-400');
            performFiltering();
        });
    });
});
</script>

<?php require_once 'Views/layout/footer.php'; ?>
<?php 
$pageTitle = htmlspecialchars($recipe['titre'] ?? 'Recette') . " - Marrakech Food Lovers";
require_once 'Views/layout/header.php'; 
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    <div class="lg:col-span-5 space-y-8">
        <div class="rounded-2xl overflow-hidden border-4 gold-border shadow-2xl">
            <?php $image = !empty($recipe['image_url']) ? $recipe['image_url'] : 'default_food.jpg'; ?>
            <img src="/Simplon-Bootcamp/marrakech_food/assets/img/<?php echo $image; ?>" class="w-full h-auto object-cover">
        </div>

        <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
            <h3 class="text-xl font-bold mb-6 flex justify-between items-center">
                <span>Avis des Lovers</span>
                <span class="gold-accent"><?php echo number_format($averageRating, 1); ?>/5 ★</span>
            </h3>

            <div class="space-y-6 max-h-96 overflow-y-auto pr-2">
                <?php if (empty($reviews)): ?>
                    <p class="text-slate-500 text-sm italic">Aucun avis pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $rev): ?>
                        <div class="bg-slate-800/30 p-4 rounded-lg border-l-2 gold-border">
                            <div class="flex justify-between mb-2">
                                <span class="font-bold text-sm">@<?php echo htmlspecialchars($rev['username'] ?? 'Anonyme'); ?></span>
                                <span class="gold-accent text-xs"><?php echo $rev['rating']; ?>/5 ★</span>
                            </div>
                            <p class="text-slate-400 text-sm italic">"<?php echo htmlspecialchars($rev['comment']); ?>"</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="lg:col-span-7">
        <h1 class="text-5xl font-black uppercase tracking-tighter mb-6 leading-none">
            <?php echo htmlspecialchars($recipe['titre'] ?? 'Sans titre'); ?>
        </h1>
        
        <div class="flex items-center space-x-4 mb-8">
            <span class="bg-gold-accent/10 gold-accent border border-gold-accent/20 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">
                <?php echo htmlspecialchars($recipe['category_name'] ?? 'Recette Authentique'); ?>
            </span>
        </div>

        <div class="prose prose-invert max-w-none mb-12">
            <h4 class="text-slate-400 uppercase text-xs tracking-widest font-bold mb-4 italic">L'histoire du plat</h4>
            <p class="text-xl text-slate-300 mb-10 leading-relaxed">
                <?php echo nl2br(htmlspecialchars($recipe['description'] ?? 'Aucune description disponible.')); ?>
            </p>

            <h4 class="text-slate-400 uppercase text-xs tracking-widest font-bold mb-4">Ingrédients nécessaires</h4>
            <div class="bg-slate-800/20 p-6 rounded-xl border border-slate-800 mb-10">
                <div class="text-slate-200 leading-relaxed">
                    <?php if (!empty($recipe['ingredients'])): ?>
                        <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?>
                    <?php else: ?>
                        <span class="text-slate-500 italic">Liste des ingrédients non renseignée.</span>
                    <?php endif; ?>
                </div>
            </div>

            <h4 class="text-slate-400 uppercase text-xs tracking-widest font-bold mb-4">Secrets de préparation</h4>
            <div class="bg-slate-900/80 p-8 rounded-2xl border border-slate-800 leading-loose text-slate-200 mb-10 shadow-inner">
                <?php echo nl2br(htmlspecialchars($recipe['instructions'] ?? 'Les secrets sont bien gardés...')); ?>
            </div>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="bg-slate-900/50 p-8 rounded-2xl border border-[#d4af37]/30 shadow-xl">
                <h3 class="text-xl font-bold mb-4 gold-accent uppercase tracking-wider">Laisser une note</h3>
                <form action="/Simplon-Bootcamp/marrakech_food/review/add" method="POST" class="space-y-4">
                    <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                    
                    <div class="flex flex-col space-y-2">
                        <label class="text-xs font-bold uppercase text-slate-400">Votre Note</label>
                        <select name="rating" class="bg-slate-800 border border-slate-700 p-3 rounded-lg gold-accent outline-none focus:border-gold-accent">
                            <option value="5">5/5 - Exceptionnel ★★★★★</option>
                            <option value="4">4/5 - Très bon ★★★★</option>
                            <option value="3">3/5 - Bon ★★★</option>
                            <option value="2">2/5 - Moyen ★★</option>
                            <option value="1">1/5 - Décevant ★</option>
                        </select>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <label class="text-xs font-bold uppercase text-slate-400">Votre Commentaire</label>
                        <textarea name="comment" rows="3" required placeholder="Dites-nous ce que vous en pensez..." class="bg-slate-800 border border-slate-700 p-4 rounded-lg outline-none focus:border-gold-accent text-white"></textarea>
                    </div>

                    <button type="submit" class="w-full gold-bg text-slate-900 font-black py-4 rounded-lg uppercase text-sm tracking-widest hover:bg-yellow-600 transition transform hover:-translate-y-1 shadow-lg shadow-yellow-900/20">
                        Publier mon avis
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="bg-slate-900/30 p-6 rounded-xl border border-dashed border-slate-700 text-center">
                <p class="text-slate-400 text-sm">
                    Vous devez être <a href="/Simplon-Bootcamp/marrakech_food/login" class="gold-accent underline hover:text-yellow-500">connecté</a> pour laisser un avis.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>
<?php 
$pageTitle = "Modifier l'Héritage - Marrakech Food Lovers";
require_once 'Views/layout/header.php'; 
?>

<div class="max-w-3xl mx-auto py-10">
    <div class="bg-slate-900/80 p-8 rounded-2xl border border-slate-800 shadow-2xl">
        <div class="mb-8">
            <h2 class="text-2xl font-black uppercase gold-accent">Modifier l'Héritage</h2>
            <p class="text-slate-400 text-sm">Ajustez les détails pour préserver la perfection de cette recette.</p>
        </div>

        <form action="/Simplon-Bootcamp/marrakech_food/recipe/update" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Titre de la recette</label>
                    <input type="text" name="titre" value="<?php echo htmlspecialchars($recipe['titre']); ?>" required 
                           class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg focus:border-[#d4af37] outline-none text-white">
                </div>
                
                <div>
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Catégorie</label>
                    <select name="category_id" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none appearance-none focus:border-[#d4af37] text-white">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $recipe['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nom'] ?? $cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Image du plat</label>
                    <div class="flex items-center gap-4 bg-slate-800/30 p-2 rounded-lg border border-slate-700">
                        <img src="/Simplon-Bootcamp/marrakech_food/assets/img/<?php echo $recipe['image_url']; ?>" 
                             class="w-12 h-12 object-cover rounded border border-slate-600">
                        <input type="file" name="image" accept="image/*" 
                               class="text-[10px] text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-slate-700 file:text-[#d4af37]">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Description courte</label>
                <textarea name="description" rows="2" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"><?php echo htmlspecialchars($recipe['description']); ?></textarea>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Ingrédients</label>
                <textarea name="ingredients" rows="3" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"><?php echo htmlspecialchars($recipe['ingredients'] ?? ''); ?></textarea>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Instructions de préparation</label>
                <textarea name="instructions" rows="6" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"><?php echo htmlspecialchars($recipe['instructions'] ?? ''); ?></textarea>
            </div>

            <div class="flex gap-4">
                <a href="/Simplon-Bootcamp/marrakech_food/recipes" class="flex-1 text-center py-4 text-slate-500 text-xs uppercase font-bold hover:text-white transition">
                    Annuler
                </a>
                <button type="submit" class="flex-[2] gold-bg text-slate-900 font-black py-4 rounded-lg uppercase tracking-[0.2em] hover:bg-yellow-600 transition shadow-lg shadow-yellow-900/20">
                    Mettre à jour l'Héritage
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>
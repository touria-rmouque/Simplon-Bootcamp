<?php 
$pageTitle = "Numériser un Plat - Marrakech Food Lovers";
require_once 'Views/layout/header.php'; 
?>

<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/80 p-8 rounded-2xl border border-slate-800 shadow-2xl">
        <div class="mb-8">
            <h2 class="text-2xl font-black uppercase gold-accent">Ajouter à l'Héritage</h2>
            <p class="text-slate-400 text-sm">Remplissez les détails pour immortaliser cette recette.</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded mb-6 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/Simplon-Bootcamp/marrakech_food/recipe/add" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Titre de la recette</label>
                    <input type="text" name="title" required placeholder="Ex: Tajine d'agneau aux pruneaux" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg focus:border-[#d4af37] outline-none text-white">
                </div>
                
                <div>
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Catégorie</label>
                    <select name="category_id" class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none appearance-none focus:border-[#d4af37]">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Image du plat (Fichier)</label>
                    <input type="file" name="image_file" accept="image/*"  class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gold-accent file:text-slate-900 hover:file:bg-yellow-600">
                </div>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Description courte</label>
                <textarea name="description" rows="2" placeholder="Une brève introduction..." class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"></textarea>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Ingrédients</label>
                <textarea name="ingredients" rows="3" placeholder="Listez les ingrédients..." class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"></textarea>
            </div>

            <div>
                <label class="block text-slate-400 text-xs uppercase font-bold mb-2">Instructions de préparation</label>
                <textarea name="instructions" rows="6" placeholder="Décrivez les étapes..." class="w-full bg-slate-800/50 border border-slate-700 p-4 rounded-lg outline-none focus:border-[#d4af37] text-white"></textarea>
            </div>
            <div class="flex gap-4">
                <a href="/Simplon-Bootcamp/marrakech_food/recipes" class="flex-1 text-center py-4 text-slate-500 text-xs uppercase font-bold hover:text-white transition">
                    Annuler
                </a>
                <button type="submit" class="flex-[2] gold-bg text-slate-900 font-black py-4 rounded-lg uppercase tracking-[0.2em] hover:bg-yellow-600 transition shadow-lg shadow-yellow-900/20">
                Enregistrer la Recette
            </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>
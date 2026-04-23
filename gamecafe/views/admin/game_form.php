<?php ob_start(); 
$isEdit = isset($game);
?>

<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="/admin/games" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            <?= $isEdit ? "Modifier le jeu" : "Nouveau Jeu" ?>
        </h1>
    </div>

    <form method="POST" class="space-y-6">
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nom du jeu</label>
                <input type="text" name="name" required 
                    value="<?= $isEdit ? htmlspecialchars($game['name']) : '' ?>"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none"
                    placeholder="Ex: Les Aventuriers du Rail">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Catégorie</label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500">
                        <?php $cats = ['Stratégie', 'Ambiance', 'Famille', 'Expert']; 
                        foreach($cats as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($isEdit && $game['category'] == $cat) ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Difficulté (1 à 5)</label>
                    <input type="number" name="difficulty" min="1" max="5" required
                        value="<?= $isEdit ? $game['difficulty'] : '1' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Joueurs Min</label>
                    <input type="number" name="min_players" min="1" required
                        value="<?= $isEdit ? $game['min_players'] : '2' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Joueurs Max</label>
                    <input type="number" name="max_players" min="1" required
                        value="<?= $isEdit ? $game['max_players'] : '4' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Durée (min)</label>
                    <input type="number" name="duration" min="5" step="5" required
                        value="<?= $isEdit ? $game['duration'] : '30' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 placeholder:text-slate-300"
                    placeholder="Décrivez brièvement le jeu..."><?= $isEdit ? htmlspecialchars($game['description']) : '' ?></textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="/admin/games" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-all">Annuler</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-indigo-100 transition-all transform active:scale-95 flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                <?= $isEdit ? "Enregistrer les modifications" : "Créer le jeu" ?>
            </button>
        </div>
    </form>
</div>

<script>lucide.createIcons();</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
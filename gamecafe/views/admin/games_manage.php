<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto">
<div class="flex items-center justify-between mb-10 gap-6">
    <div class="flex-1">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Gestion du Catalogue
        </h1>
        <p class="text-slate-500 mt-1 flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4 text-indigo-500"></i>
            Pilotez la liste des jeux disponibles dans votre établissement.
        </p>
    </div>

    <div class="shrink-0">
        <a href="/admin/games/create" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all transform active:scale-95 whitespace-nowrap">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Ajouter un jeu
        </a>
    </div>
</div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 mb-6 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="bg-emerald-500 p-1 rounded-full text-white">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <span class="font-medium">L'inventaire a été mis à jour avec succès.</span>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider">Jeu</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider">Catégorie</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm text-center uppercase tracking-wider">Configuration</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm text-center uppercase tracking-wider">Difficulté</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm text-right uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($games)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center bg-slate-50/50">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="package-open" class="w-12 h-12 text-slate-300 mb-3"></i>
                                    <p class="text-slate-500 font-medium">Aucun jeu répertorié pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($games as $game): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                        <?= htmlspecialchars($game['name']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        <?= htmlspecialchars($game['category']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-sm font-medium text-slate-600 flex items-center gap-1.5">
                                            <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <?= $game['min_players'] ?>-<?= $game['max_players'] ?> pers.
                                        </span>
                                        <span class="text-xs text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <?= $game['duration'] ?> min
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <div class="w-1.5 h-3 rounded-full <?= $i <= $game['difficulty'] ? 'bg-amber-400' : 'bg-slate-200' ?>"></div>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="/admin/games/edit?id=<?= $game['id'] ?>" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Modifier">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>
                                        
                                        <form action="/admin/games/delete" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression définitive ?');">
                                            <input type="hidden" name="id" value="<?= $game['id'] ?>">
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Supprimer">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
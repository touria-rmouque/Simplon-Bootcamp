<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-2xl mx-auto">
    <a href="/admin/dashboard" class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 mb-4 transition-colors">
        <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
        Retour au suivi des sessions
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-200 p-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="bg-emerald-500 p-2 rounded-lg text-white">
                    <i data-lucide="play-circle" class="w-6 h-6"></i>
                </div>
                Démarrer une Session
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Configurez l'installation des clients à une table pour lancer le décompte.</p>
        </div>

        <?php if (empty($tables) || empty($games)): ?>
            <div class="p-12 text-center">
                <div class="bg-amber-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-amber-600"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Plus de ressources disponibles</h3>
                <p class="text-slate-500 text-sm mt-2">
                    <?= empty($tables) ? "Toutes les tables sont occupées." : "Tous les jeux sont en cours d'utilisation." ?>
                    <br>Terminez une session en cours pour en libérer.
                </p>
                <a href="/admin/dashboard" class="mt-6 inline-block bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-6 rounded-xl transition-colors">
                    Voir le dashboard
                </a>
            </div>
        <?php else: ?>
            <form action="/admin/sessions/start" method="POST" class="p-8 space-y-8">
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                        <i data-lucide="gamepad-2" class="w-4 h-4 text-indigo-500"></i>
                        Quel jeu vont-ils jouer ?
                    </label>
                    <div class="relative">
                        <select name="game_id" class="appearance-none w-full bg-slate-50 border border-slate-200 rounded-xl p-4 pr-10 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all text-slate-700 font-medium" required>
                            <option value="">-- Sélectionner un jeu disponible --</option>
                            <?php foreach($games as $game): ?>
                                <option value="<?= $game['id'] ?>">
                                    <?= htmlspecialchars($game['name']) ?> (<?= $game['min_players'] ?>-<?= $game['max_players'] ?> pers.)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                        <i data-lucide="layout" class="w-4 h-4 text-indigo-500"></i>
                        Quelle table est libre ?
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach($tables as $table): ?>
                            <label class="group relative border border-slate-200 rounded-xl p-4 flex items-center gap-4 cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/50 transition-all">
                                <input type="radio" name="table_id" value="<?= $table['id'] ?>" class="sr-only peer" required>
                                
                                <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center transition-all">
                                    <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 group-hover:text-indigo-900"><?= htmlspecialchars($table['name']) ?></span>
                                    <span class="text-[11px] text-slate-500 font-medium uppercase tracking-wide">Capacité: <?= $table['capacity'] ?> pers.</span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="space-y-3 pt-4 border-t border-slate-100">
                    <label class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                        <i data-lucide="bookmark-check" class="w-4 h-4 text-indigo-500"></i>
                        Réservation correspondante
                    </label>
                    <div class="relative">
                        <select name="reservation_id" class="appearance-none w-full bg-slate-50 border border-slate-200 rounded-xl p-4 pr-10 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all text-slate-700 font-medium">
                            <option value="">Client sans réservation (Passage direct)</option>
                            <?php foreach($reservations as $res): ?>
                                <?php if ($res['status'] == 'confirmée'): ?>
                                    <option value="<?= $res['id'] ?>">
                                        [<?= date('H:i', strtotime($res['reservation_time'])) ?>] <?= htmlspecialchars($res['username']) ?> - <?= $res['guests_count'] ?> pers.
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-100 flex items-center justify-center gap-3 transition-all transform active:scale-[0.98]">
                    <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                    LANCER LA SESSION
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-5xl mx-auto">
    <a href="/games" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-bold mb-8 transition-colors group">
        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
        Retour au catalogue
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 bg-indigo-600 p-10 text-white flex flex-col justify-center items-center text-center">
                <div class="bg-indigo-500/50 p-6 rounded-3xl mb-6 shadow-inner">
                    <i data-lucide="dices" class="w-16 h-16 text-indigo-100"></i>
                </div>
                <h1 class="text-3xl font-black mb-3 leading-tight"><?= htmlspecialchars($game['name']) ?></h1>
                <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-xl text-xs font-black uppercase tracking-widest border border-white/10">
                    <?= htmlspecialchars($game['category']) ?>
                </span>
            </div>
            
            <div class="md:w-2/3 p-10">
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="align-left" class="w-5 h-5 text-indigo-500"></i>
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">À propos du jeu</h2>
                </div>
                <p class="text-slate-600 leading-relaxed text-lg mb-8">
                    <?= nl2br(htmlspecialchars($game['description'])) ?>
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 text-slate-400 mb-1">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            <span class="text-[10px] font-black uppercase tracking-tighter">Joueurs</span>
                        </div>
                        <p class="text-lg font-extrabold text-slate-800"><?= $game['min_players'] ?> à <?= $game['max_players'] ?></p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 text-slate-400 mb-1">
                            <i data-lucide="timer" class="w-4 h-4"></i>
                            <span class="text-[10px] font-black uppercase tracking-tighter">Durée</span>
                        </div>
                        <p class="text-lg font-extrabold text-slate-800"><?= $game['duration'] ?> min</p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 text-slate-400 mb-1">
                            <i data-lucide="brain-circuit" class="w-4 h-4"></i>
                            <span class="text-[10px] font-black uppercase tracking-tighter">Difficulté</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <div class="w-3 h-3 rounded-full <?= $i <= $game['difficulty'] ? 'bg-indigo-500' : 'bg-slate-200' ?>"></div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 text-slate-400 mb-1">
                            <i data-lucide="award" class="w-4 h-4"></i>
                            <span class="text-[10px] font-black uppercase tracking-tighter">Note Moyenne</span>
                        </div>
                        <p class="text-lg font-extrabold text-amber-500 flex items-center gap-1">
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            <?= $averageRating ? number_format((float)$averageRating, 1) : 'N/A' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-slate-50 rounded-3xl p-8 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="max-w-xs">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Vous avez joué ?</h3>
                <p class="text-slate-500 text-sm mt-1">Partagez votre note (1-5) et votre avis avec les autres membres.</p>
            </div>
            
            <form action="/games/rate" method="POST" class="flex-1 max-w-lg">
                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Votre note</span>
                        <div class="flex flex-row-reverse gap-1">
                            <?php for($i=5; $i>=1; $i--): ?>
                                <input type="radio" id="star<?= $i ?>" name="score" value="<?= $i ?>" class="hidden peer" required>
                                <label for="star<?= $i ?>" class="cursor-pointer text-slate-200 peer-hover:text-amber-400 peer-checked:text-amber-400 transition-colors">
                                    <i data-lucide="star" class="w-6 h-6 fill-current"></i>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <textarea name="comment" rows="2" maxlength="255" required
                              placeholder="Qu'avez-vous pensé de votre partie ?"
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-medium"></textarea>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 group">
                        <span>Publier l'avis</span>
                        <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-16">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <i data-lucide="message-square-quote" class="w-6 h-6 text-indigo-500"></i>
                Avis de la communauté
            </h3>
        </div>

        <?php if (empty($reviews)): ?>
            <div class="bg-white border-2 border-dashed border-slate-200 p-12 rounded-3xl text-center">
                <i data-lucide="ghost" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                <p class="text-slate-400 font-medium">Aucun avis pour le moment. Soyez le premier !</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach($reviews as $review): ?>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-black uppercase text-xs border border-indigo-100">
                                    <?= substr(htmlspecialchars($review['username']), 0, 2) ?>
                                </div>
                                <span class="font-bold text-slate-800 tracking-tight"><?= htmlspecialchars($review['username']) ?></span>
                            </div>
                            <div class="flex text-amber-400">
                                <?php for($i=0; $i<$review['score']; $i++): ?>
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p class="text-slate-500 italic text-sm leading-relaxed relative z-10">
                            "<?= htmlspecialchars($review['comment']) ?>"
                        </p>
                        <i data-lucide="quote" class="absolute bottom-4 right-4 w-12 h-12 text-slate-50 opacity-[0.05] group-hover:scale-110 transition-transform"></i>
                    </div>
                <?php endforeach; ?>
            </div>
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
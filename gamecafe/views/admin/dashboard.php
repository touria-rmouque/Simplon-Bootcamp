<?php ob_start(); 
$activeTab = $_GET['tab'] ?? 'active'; 
?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Tableau de Bord</h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2 font-medium">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-500"></i>
                Gestion des sessions et occupation du salon.
            </p>
        </div>
        <div class="shrink-0">
            <a href="/admin/sessions/start" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all transform active:scale-95">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Lancer une Session
            </a>
        </div>
    </div>

    <div class="flex items-center gap-2 border-b border-slate-200 mb-8">
        <a href="?tab=active" class="group pb-4 px-6 text-sm font-bold transition-all relative <?= $activeTab === 'active' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' ?>">
            <div class="flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4 <?= $activeTab === 'active' ? 'fill-indigo-600' : '' ?>"></i>
                Sessions Actives
                <span class="ml-1 px-2 py-0.5 rounded-full bg-slate-100 group-hover:bg-indigo-50 text-[10px]"><?= count($activeSessions) ?></span>
            </div>
            <?php if ($activeTab === 'active'): ?>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-600 rounded-t-full"></div>
            <?php endif; ?>
        </a>
        <a href="?tab=history" class="group pb-4 px-6 text-sm font-bold transition-all relative <?= $activeTab === 'history' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' ?>">
            <div class="flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4"></i>
                Historique des Jeux
            </div>
            <?php if ($activeTab === 'history'): ?>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-600 rounded-t-full"></div>
            <?php endif; ?>
        </a>
    </div>

    <?php if ($activeTab === 'active'): ?>
        <?php if (empty($activeSessions)): ?>
            <div class="bg-white border-2 border-dashed border-slate-200 p-20 rounded-[2.5rem] text-center">
                <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="coffee" class="w-10 h-10 text-slate-300"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Salon inoccupé</h3>
                <p class="text-slate-500 max-w-xs mx-auto">Toutes les tables sont libres. Lancez une session pour commencer le suivi.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($activeSessions as $session): 
                    $percentage = min(100, ($session['total_minutes'] / 120) * 100);
                    $colorClass = 'indigo';
                    if ($session['total_minutes'] > 90) $colorClass = 'amber';
                    if ($session['total_minutes'] > 120) $colorClass = 'rose';
                ?>
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="p-5 bg-slate-50/80 border-b border-slate-100 flex justify-between items-center">
                            <span class="font-black text-slate-700 uppercase tracking-widest text-xs flex items-center gap-2">
                                <i data-lucide="monitor" class="w-4 h-4 text-slate-400"></i>
                                <?= htmlspecialchars($session['table_name']) ?>
                            </span>
                            <span class="text-[11px] font-bold px-3 py-1 bg-white shadow-sm rounded-full text-slate-500">
                                Début : <?= date('H:i', strtotime($session['start_time'])) ?>
                            </span>
                        </div>
                        
                        <div class="p-8">
                            <div class="mb-6">
                                <h3 class="text-2xl font-black text-slate-900 leading-tight mb-1 truncate">
                                    <?= htmlspecialchars($session['game_name']) ?>
                                </h3>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                    <span class="font-bold text-sm">
                                        <?php if (!empty($session['reservation_id'])): ?>
                                            <span class="text-indigo-600"><?= htmlspecialchars($session['client_name'] ?? 'Client') ?></span>
                                        <?php else: ?>
                                            <span class="text-slate-400 italic">Client de passage</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-end justify-between mb-4">
                                <div>
                                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider mb-1">Temps de jeu</p>
                                    <span class="text-4xl font-black text-slate-900 tabular-nums">
                                        <?= $session['elapsed_time'] ?>
                                    </span>
                                </div>
                                <div class="bg-<?= $colorClass ?>-50 p-3 rounded-2xl text-<?= $colorClass ?>-600">
                                    <i data-lucide="timer" class="w-8 h-8"></i>
                                </div>
                            </div>

                            <div class="relative pt-2">
                                <div class="overflow-hidden h-3 flex rounded-full bg-slate-100">
                                    <div style="width:<?= $percentage ?>%" class="bg-<?= $colorClass ?>-500 transition-all duration-1000"></div>
                                </div>
                            </div>

                            <form action="/admin/sessions/<?= $session['id'] ?>/end" method="POST" class="mt-8">
                                <button type="submit" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 font-black py-4 rounded-2xl transition-all group/btn">
                                    <i data-lucide="power" class="w-5 h-5 group-hover/btn:rotate-90 transition-transform"></i>
                                    TERMINER LA SESSION
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Date & Client</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jeu / Table</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Période</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Durée</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($historySessions)): ?>
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-medium italic">
                                    L'historique est encore vide...
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($historySessions as $h): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-slate-900"><?= date('d/m/Y', strtotime($h['start_time'])) ?></div>
                                        <div class="text-xs font-bold flex items-center gap-1 mt-1">
                                            <?php if (!empty($h['reservation_id'])): ?>
                                                <span class="text-indigo-500 flex items-center gap-1">
                                                    <i data-lucide="user" class="w-3 h-3"></i>
                                                    <?= htmlspecialchars($h['client_name'] ?? 'Client') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-slate-400 italic">Client de passage</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="font-black text-slate-800"><?= htmlspecialchars($h['game_name']) ?></div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-tighter"><?= htmlspecialchars($h['table_name']) ?></div>
                                    </td>
                                    <td class="px-8 py-5 text-sm font-medium text-slate-500">
                                        <span class="inline-flex items-center gap-2">
                                            <?= date('H:i', strtotime($h['start_time'])) ?>
                                            <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i>
                                            <?= date('H:i', strtotime($h['end_time'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-black tabular-nums">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            <?= $h['duration_formatted'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    lucide.createIcons();
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
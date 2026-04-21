<?php ob_start(); 
$currentFilter = $_GET['filter'] ?? 'all';
?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Registre des Réservations</h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <i data-lucide="layers" class="w-4 h-4 text-indigo-500"></i>
                Consultez et gérez l'intégralité des demandes clients.
            </p>
        </div>
        
        <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
            <a href="/admin/reservations?filter=all" 
               class="px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 <?= $currentFilter === 'all' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' ?>">
                <i data-lucide="list" class="w-4 h-4"></i>
                Toutes
            </a>
            <a href="/admin/reservations?filter=today" 
               class="px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 <?= $currentFilter === 'today' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' ?>">
                <i data-lucide="calendar-days" class="w-4 h-4"></i>
                Aujourd'hui
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider">Date & Heure</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider">Client & Contact</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider text-center">Groupe</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-sm uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($reservations)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center bg-slate-50/50">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="search-x" class="w-12 h-12 text-slate-300 mb-3"></i>
                                    <p class="text-slate-500 font-medium">Aucune réservation trouvée pour ce filtre.</p>
                                    <a href="/admin/reservations?filter=all" class="mt-4 text-indigo-600 font-bold text-sm hover:underline">Voir toutes les réservations</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($reservations as $res): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <?= date('d/m/Y', strtotime($res['reservation_date'])) ?>
                                        </div>
                                        <div class="text-xs font-bold text-indigo-600 flex items-center gap-1.5 mt-1">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="font-black text-slate-900 uppercase text-xs tracking-tight">
                                            <?= htmlspecialchars($res['customer_name'] ?? $res['username']) ?>
                                        </div>
                                        <?php if(!empty($res['phone'])): ?>
                                            <div class="text-sm font-medium text-indigo-600 flex items-center gap-1">
                                                <i data-lucide="phone" class="w-3 h-3"></i>
                                                <?= htmlspecialchars($res['phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-[10px] text-slate-400 flex items-center gap-1">
                                            <i data-lucide="user" class="w-2.5 h-2.5"></i>
                                            Compte: <?= htmlspecialchars($res['username']) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 text-slate-600 font-medium bg-slate-100 px-2.5 py-1 rounded-lg">
                                        <i data-lucide="users" class="w-4 h-4 text-slate-400"></i>
                                        <?= $res['guests_count'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php 
                                        $statusStyles = [
                                            'confirmée' => 'bg-emerald-50 text-emerald-700 border-emerald-200 icon-check-circle',
                                            'en attente' => 'bg-amber-50 text-amber-700 border-amber-200 icon-help-circle',
                                            'annulée' => 'bg-rose-50 text-rose-700 border-rose-200 icon-x-circle'
                                        ];
                                        $currentStyle = $statusStyles[$res['status']] ?? 'bg-slate-50 text-slate-700 border-slate-200 icon-info';
                                        $icon = explode(' icon-', $currentStyle)[1];
                                        $baseStyle = explode(' icon-', $currentStyle)[0];
                                    ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black border uppercase <?= $baseStyle ?>">
                                        <i data-lucide="<?= $icon ?>" class="w-3 h-3"></i>
                                        <?= $res['status'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <?php if ($res['status'] == 'en attente'): ?>
                                            <a href="/admin/reservations?action=confirm&id=<?= $res['id'] ?>&filter=<?= $currentFilter ?>" 
                                               class="flex items-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all transform active:scale-95">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Confirmer
                                            </a>
                                            <a href="/admin/reservations?action=cancel&id=<?= $res['id'] ?>&filter=<?= $currentFilter ?>" 
                                               class="p-1.5 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 rounded-lg transition-all">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-slate-300"><i data-lucide="lock" class="w-4 h-4"></i></span>
                                        <?php endif; ?>
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
<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mes Réservations</h1>
        <p class="text-slate-500 mt-2">Suivez l'état de vos demandes et l'historique de vos sessions.</p>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="bg-emerald-500 p-1 rounded-full text-white">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <p class="font-bold text-sm">Votre demande de réservation a été enregistrée avec succès !</p>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-sm rounded-3xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Date & Heure</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Joueurs</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($reservations as $res): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-indigo-50 text-indigo-600 p-2.5 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                        <i data-lucide="calendar-days" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800"><?= date('d/m/Y', strtotime($res['reservation_date'])) ?></div>
                                        <div class="text-xs font-bold text-slate-400 flex items-center gap-1 mt-0.5">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2 font-bold text-slate-600">
                                    <i data-lucide="users" class="w-4 h-4 text-slate-300"></i>
                                    <?= $res['guests_count'] ?> <span class="text-xs font-medium text-slate-400">joueurs</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <?php 
                                    $statusConfig = [
                                        'en attente' => ['class' => 'bg-amber-50 text-amber-700 border-amber-100', 'icon' => 'loader-2'],
                                        'confirmée' => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'icon' => 'check-circle'],
                                        'annulée'   => ['class' => 'bg-rose-50 text-rose-700 border-rose-100', 'icon' => 'x-circle']
                                    ][$res['status']];
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider border <?= $statusConfig['class'] ?>">
                                    <i data-lucide="<?= $statusConfig['icon'] ?>" class="w-3 h-3 <?= $res['status'] === 'en attente' ? 'animate-spin' : '' ?>"></i>
                                    <?= $res['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($reservations)): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-slate-50 p-4 rounded-full mb-4 text-slate-200">
                                        <i data-lucide="calendar-x" class="w-10 h-10"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium italic text-sm">Vous n'avez pas encore fait de réservation.</p>
                                    <a href="/reservations/create" class="mt-4 text-indigo-600 font-bold text-sm hover:underline">Faire ma première réservation</a>
                                </div>
                            </td>
                        </tr>
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
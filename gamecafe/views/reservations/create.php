<?php ob_start(); ?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-2xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Réserver une table</h1>
        <p class="text-slate-500 mt-2">Vérifiez la disponibilité et planifiez votre venue.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <?php if (isset($error)): ?>
            <div class="bg-rose-50 border-b border-rose-100 p-4 flex items-center gap-3 text-rose-700">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                <div class="text-sm">
                    <span class="font-bold">Erreur :</span> <?= htmlspecialchars($error) ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="/reservations/create" method="POST" class="p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Nom complet
                    </label>
                    <input type="text" name="customer_name" placeholder="Ex: Jean Dupont" required 
                           class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">
                </div>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Téléphone
                    </label>
                    <input type="tel" name="phone" placeholder="06 00 00 00 00" required 
                           class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="date" class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                        <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i>
                        Date
                    </label>
                    <input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700">
                </div>

                <div class="space-y-2">
                    <label for="time" class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                        <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i>
                        Heure
                    </label>
                    <select id="time" name="time" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700">
                        <?php 
                        for($h=14; $h<=22; $h++) {
                            echo "<option value='$h:00'>$h:00</option>";
                            echo "<option value='$h:30'>$h:30</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="guests" class="flex items-center gap-2 text-sm font-bold text-slate-700 uppercase tracking-wider">
                    <i data-lucide="users" class="w-4 h-4 text-indigo-500"></i>
                    Nombre de personnes
                </label>
                <div class="relative">
                    <input type="number" id="guests" name="guests" min="1" max="15" placeholder="Combien serez-vous ?" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700 text-lg">
                </div>
            </div>

            <div id="availability-status" class="hidden bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-start gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5"></i>
                <p class="text-xs text-emerald-700">
                    Des tables sont disponibles pour ce créneau. Vous pouvez valider votre demande.
                </p>
            </div>

            <button type="submit" class="group w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-100 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3">
                <span>Vérifier & Réserver</span>
                <i data-lucide="send" class="w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
    document.querySelectorAll('#date, #time, #guests').forEach(el => {
        el.addEventListener('change', () => {
            const status = document.getElementById('availability-status');
            status.classList.remove('hidden');
        });
    });
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
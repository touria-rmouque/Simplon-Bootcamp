<?php 
use App\Services\AuthService; 
AuthService::startSession();
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aji L3bo | Game Café Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(67, 56, 202, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-900">

    <header class="glass-nav sticky top-0 z-50 text-white shadow-lg border-b border-white/10">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            
            <a href="/" class="group flex items-center gap-3 no-underline">
                <div class="bg-white p-2 rounded-xl shadow-indigo-900/20 shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <i data-lucide="dices" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight leading-none">Aji L3bo</span>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-indigo-200 font-black italic">
                        <?= (isset($_SESSION['user_id']) && AuthService::isAdmin()) ? 'Management Mode' : 'Game Café' ?>
                    </span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (AuthService::isAdmin()): ?>
                        <a href="/admin/dashboard" class="flex items-center gap-2 hover:bg-white/10 px-4 py-2 rounded-xl font-bold transition-all border border-transparent hover:border-white/20">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Sessions
                        </a>
                        <a href="/admin/reservations" class="flex items-center gap-2 hover:bg-white/10 px-4 py-2 rounded-xl font-bold transition-all border border-transparent hover:border-white/20">
                            <i data-lucide="calendar-check" class="w-4 h-4"></i> Réservations
                        </a>
                        <a href="/admin/games" class="flex items-center gap-2 hover:bg-white/10 px-4 py-2 rounded-xl font-bold transition-all border border-transparent hover:border-white/20">
                            <i data-lucide="library" class="w-4 h-4"></i> Catalogue
                        </a>
                    <?php else: ?>
                        <a href="/games" class="font-bold text-indigo-100 hover:text-white px-4 py-2 transition-colors">Catalogue</a>
                        <a href="/reservations/create" class="font-bold text-indigo-100 hover:text-white px-4 py-2 transition-colors">Réserver</a>
                        <a href="/reservations/history" class="font-bold text-indigo-100 hover:text-white px-4 py-2 transition-colors">Mes Réservations</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/games" class="font-bold text-indigo-100 hover:text-white px-4 py-2 transition-colors">Catalogue</a>
                <?php endif; ?>
            </nav>

            <div class="flex items-center gap-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-4 pl-4 border-l border-white/20">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] uppercase font-black text-indigo-300 leading-none tracking-widest">
                                <?= AuthService::isAdmin() ? 'Administrateur' : 'Joueur' ?>
                            </p>
                            <p class="text-sm font-extrabold"><?= htmlspecialchars($_SESSION['username']) ?></p>
                        </div>
                        <a href="/logout" class="bg-white/10 hover:bg-rose-500 p-2.5 rounded-xl transition-all duration-300 group border border-white/10" title="Déconnexion">
                            <i data-lucide="log-out" class="w-5 h-5 text-indigo-100 group-hover:text-white"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-3">
                        <a href="/login" class="text-sm font-bold hover:text-indigo-200 transition px-2">Connexion</a>
                        <a href="/register" class="bg-white text-indigo-700 hover:scale-105 px-6 py-2.5 rounded-xl font-black text-sm transition-all duration-300 shadow-xl shadow-indigo-900/20">
                            S'inscrire
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-12 flex-grow">
        <?= $content ?? '' ?>
    </main>

    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <i data-lucide="dices" class="w-4 h-4"></i>
                    <span>© <?= date('Y') ?> Aji L3bo Café. Tous droits réservés.</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-indigo-600 transition-colors">Mentions Légales</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Contact</a>
                    <span class="text-slate-200">|</span>
                    <span class="flex items-center gap-1.5">Géré avec <i data-lucide="heart" class="w-4 h-4 text-rose-500 fill-current"></i> par le Trinôme</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
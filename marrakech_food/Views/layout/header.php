<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Marrakech Food Lovers'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap');
        
        body { 
            background-color: #0a1118; 
            color: white; 
            font-family: 'Montserrat', sans-serif;
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
        .gold-accent { color: #d4af37; }
        .gold-bg { background-color: #d4af37; }
        .gold-border { border-color: #d4af37; }
        .nav-link:hover { color: #d4af37; transition: 0.3s; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/Simplon-Bootcamp/marrakech_food/recipes" class="flex items-center space-x-3">
                <div>
                    <span class="block text-lg font-black uppercase tracking-tighter leading-none">Marrakech <span class="gold-accent">Food</span></span>
                    <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400">Culinary Heritage</span>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-8 text-sm font-bold uppercase tracking-widest">
                <a href="/Simplon-Bootcamp/marrakech_food/recipes" class="nav-link">Recettes</a>
                <a href="/Simplon-Bootcamp/marrakech_food/recipe/add" class="nav-link">Ajouter</a>
                
                <?php if(isset($_SESSION['username'])): ?>
                    <div class="flex items-center space-x-4 border-l border-slate-700 pl-8">
                        <span class="text-slate-400 lowercase font-normal">@<?php echo $_SESSION['username']; ?></span>
                        <a href="/Simplon-Bootcamp/marrakech_food/logout" class="bg-red-900/20 text-red-500 px-3 py-1 rounded border border-red-900/50 hover:bg-red-500 hover:text-white transition text-[10px]">Déconnexion</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-6 py-10">
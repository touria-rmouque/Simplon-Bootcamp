<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Marrakech Food Lovers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0a1118; }
        .gold-accent { color: #d4af37; }
        .gold-border { border-color: #d4af37; }
        .gold-bg { background-color: #d4af37; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[url('https://www.transparenttextures.com/patterns/black-paper.png')]">

    <div class="max-w-md w-full bg-slate-900/80 backdrop-blur-md p-8 rounded-lg border border-slate-700 shadow-2xl">
        <div class="text-center mb-8">
            <div class="mb-4">
            <div class="relative inline-block">
             <span class="text-5xl font-serif gold-accent opacity-20 absolute -top-4 -left-2">M</span>
             <span class="relative gold-accent text-3xl font-black italic tracking-widest">FOOD</span>
             </div>
              </div>
            <h1 class="text-white text-2xl font-bold tracking-widest uppercase">Marrakech Food Lovers</h1>
            <p class="text-slate-400 text-sm mt-2">Digitalizing Culinary Heritage</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded mb-6 text-sm text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/Simplon-Bootcamp/marrakech_food/login" method="POST" class="space-y-6">
            <div>
                <label class="block text-slate-300 text-sm mb-2">Nom d'utilisateur</label>
                <input type="text" name="username" required class="w-full bg-slate-800 border border-slate-600 text-white px-4 py-3 rounded focus:outline-none focus:border-[#d4af37] transition" placeholder="Votre pseudo">
            </div>
            <div>
                <label class="block text-slate-300 text-sm mb-2">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-slate-800 border border-slate-600 text-white px-4 py-3 rounded focus:outline-none focus:border-[#d4af37] transition" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full gold-bg text-slate-900 font-bold py-3 rounded hover:bg-yellow-600 transition duration-300 uppercase tracking-widest">
                Se Connecter
            </button>
        </form>

        <p class="text-center text-slate-400 mt-6 text-sm">
            Nouveau ici ? <a href="/Simplon-Bootcamp/marrakech_food/register" class="gold-accent hover:underline">Créer un compte</a>
        </p>
    </div>

</body>
</html>